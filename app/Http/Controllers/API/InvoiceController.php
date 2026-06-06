<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InvoiceController extends Controller
{
    // Listar faturas arquivadas (GET /api/invoices)
    public function index()
    {
        return response()->json(Invoice::latest()->get(), 200);
    }

    // Arquivar nova fatura com upload de PDF (POST /api/invoices)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'invoice_number' => 'required|string|unique:invoices,invoice_number',
            'customer_nif' => 'required|string|max:20',
            'customer_name' => 'required|string|max:255',
            'total_amount' => 'required|numeric|min:0',
            'emission_date' => 'required|date',
            'pdf' => 'nullable|file|mimes:pdf|max:4096' // Aceita PDF até 4MB
        ]);

        // Trata o upload do PDF se ele existir
        if ($request->hasFile('pdf')) {
            $path = $request->file('pdf')->store('invoices_pdfs', 'public');
            $validated['pdf_path'] = $path;
        }

        $invoice = Invoice::create($validated);

        return response()->json($invoice, 211);
    }
}