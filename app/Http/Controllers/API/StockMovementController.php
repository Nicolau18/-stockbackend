<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\StockMovement;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockMovementController extends Controller
{
    // Listar histórico com os dados do produto associado (GET /api/movements)
    public function index()
    {
        $movements = StockMovement::with('product')->latest()->get();
        return response()->json($movements, 200);
    }

    // Registar fluxo e atualizar stock (POST /api/movements)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'type' => 'required|in:entrada,saida',
            'quantity' => 'required|integer|min:1',
            'reason' => 'required|string|max:255'
        ]);

        // Usamos uma Transaction para garantir que se a atualização falhar, não cria o histórico (e vice-versa)
        $movement = DB::transaction(function () use ($validated) {
            $product = Product::findOrFail($validated['product_id']);

            if ($validated['type'] === 'entrada') {
                $product->stock += $validated['quantity'];
            } else {
                // Validação para não deixar o stock ficar negativo
                if ($product->stock < $validated['quantity']) {
                    abort(422, 'Stock insuficiente para realizar esta saída.');
                }
                $product->stock -= $validated['quantity'];
            }

            $product->save();
            return StockMovement::create($validated);
        });

        // Carrega o produto para devolver a resposta completa ao React
        return response()->json($movement->load('product'), 211);
    }
}