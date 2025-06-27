<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stock;
use App\Models\Product;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stocks = Stock::with('product')->get();
        return view('stock.index', compact('stocks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // eventueel producten ophalen voor dropdown
        $products = Product::all();
        return view('stock.create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validatie en opslaan
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'amount' => 'required|integer|min:0',
        ]);
        $validated['date_created'] = now();
        $validated['is_active'] = true;
        Stock::create($validated);

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
        $products = Product::all();
        return view('stock.update', compact('stock', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Stock $stock)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'amount' => 'required|integer|min:0',
        ]);
        $validated['date_modified'] = now();
        $stock->update($validated);

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
