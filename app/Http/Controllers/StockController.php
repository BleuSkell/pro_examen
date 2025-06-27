<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use Illuminate\Http\Request;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stocks = Stock::with('product')->where('is_active', true)->get();
        return view('stock.index', compact('stocks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Haal suppliers, categories en producten op voor het formulier
        $suppliers = \App\Models\Supplier::all();
        $categories = \App\Models\ProductCategory::all();
        $products = \App\Models\Product::all();
        return view('stock.create', compact('suppliers', 'categories', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'stock_id' => 'required|exists:products,id', // Let op: validatie blijft op products, want je kiest een product
            'amount' => 'required|integer|min:0',
        ]);

        Stock::create([
            'product_id' => $request->stock_id, // Sla op als product_id in de database
            'amount' => $request->amount,
            'date_created' => now(),
            'is_active' => true,
        ]);

        return redirect()->route('stock.index')->with('success', 'Voorraad toegevoegd!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Stock $stock)
    {
        $category = optional($stock->product->productCategory)->category_name;
        $company = optional($stock->product->supplier)->company_name;

        $spResult = \DB::select('CALL spGetStockDetails(?, ?)', [$category, $company]);

        // Zoek het juiste record uit de SP-resultaten op basis van productnaam en amount
        $spStock = collect($spResult)->first(function($item) use ($stock) {
            return $item->Product === optional($stock->product)->product_name && $item->Amount == $stock->amount;
        });

        return view('stock.show', [
            'spStock' => $spStock,
            'stock' => $stock,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Stock $stock)
    {
        return view('stock.edit', compact('stock'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Stock $stock)
    {
        $request->validate([
            'stock_id' => 'required|exists:products,id',
            'amount' => 'required|integer|min:0',
        ]);

        $stock->update([
            'product_id' => $request->stock_id,
            'amount' => $request->amount,
            'date_updated' => now(),
        ]);

        return redirect()->route('stock.index')->with('success', 'Voorraad bijgewerkt!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Stock $stock)
    {
        $stock->delete();
        return redirect()->route('stock.index')->with('success', 'Voorraad verwijderd!');
    }
}