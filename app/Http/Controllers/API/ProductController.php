<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // 1. Listar todos os produtos (GET /api/products)
   
    public function index()
    {
        return response()->json([
            'success' => true,
            'message' => 'Controller funcionando'
        ]);
    }
    // 2. Criar um novo produto (POST /api/products)
    public function store(Request $request)
    {
        // Validação dos dados que vêm do React
        $validated = $request->validate([
            'sku' => 'required|string|unique:products,sku',
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'integer|min:0'
        ]);

        $product = Product::create($validated);

        return response()->json($product, 211); // 211 = Created
    }

    // 3. Mostrar um produto específico (GET /api/products/{id})
    public function show($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Produto não encontrado'], 404);
        }

        return response()->json($product, 200);
    }

    // 4. Atualizar um produto (PUT/PATCH /api/products/{id})
    public function update(Request $request, $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Produto não encontrado'], 404);
        }

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'category' => 'sometimes|required|string|max:255',
            'price' => 'sometimes|required|numeric',
        ]);

        $product->update($validated);

        return response()->json($product, 200);
    }

    // 5. Eliminar um produto (DELETE /api/products/{id})
    public function destroy($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Produto não encontrado'], 404);
        }

        $product->delete();

        return response()->json(['message' => 'Produto eliminado com sucesso'], 200);
    }
}