<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function getKPIs()
    {
        // 1. Total em Stock: Soma de todas as colunas 'stock' da tabela products
        $totalStock = (int) Product::sum('stock');

        // 2. Valor do Inventário: Soma de (price * stock) de todos os produtos
        // Usamos o DB::raw para fazer o cálculo direto no MySQL, poupando memória
        $inventoryValue = (float) Product::select(DB::raw('SUM(price * stock) as total'))->first()->total ?? 0;

        // 3. Faturação Mensal: Soma do total_amount das faturas do mês atual (Ano e Mês correntes)
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        
        $monthlyBilling = (float) Invoice::whereMonth('emission_date', $currentMonth)
            ->whereYear('emission_date', $currentYear)
            ->sum('total_amount');

        // 4. Alertas Ativos: Quantos produtos estão com stock igual ou inferior a 5 unidades
        // (Podes ajustar este número 5 para o limite de stock crítico que preferires)
        $activeAlerts = (int) Product::where('stock', '<=', 5)->count();

        return response()->json([
            'total_stock' => $totalStock,
            'inventory_value' => $inventoryValue,
            'monthly_billing' => $monthlyBilling,
            'active_alerts' => $activeAlerts
        ], 200);
    }
}