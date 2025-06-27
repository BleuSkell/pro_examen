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
        try {
            $validated = $request->only(['company_name', 'product_name', 'categorie', 'amount']);

            $supplier = \App\Models\Supplier::where('company_name', $validated['company_name'])->first();
            if (!$supplier) {
                $supplier = \App\Models\Supplier::create([
                    'company_name' => $validated['company_name'],
                    'contact_person_id' => 1,
                    'address' => '',
                    'next_delivery_date' => now(),
                    'next_delivery_time' => now()->format('H:i:s'),
                    'date_created' => now(),
                    'date_updated' => now(),
                    'is_active' => true,
                ]);
            }

            $category = \App\Models\ProductCategory::find($validated['categorie']);
            if (!$category) {
                abort(400, 'Categorie niet gevonden');
            }

            $productExists = \App\Models\Product::where('product_name', $validated['product_name'])->exists();
            if ($productExists) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['product_name' => 'Maken van product naam mislukt: er bestaat al een product naam.']);
            }

            $product = \App\Models\Product::create([
                'product_name' => $validated['product_name'],
                'supplier_id' => $supplier->id,
                'product_category_id' => $category->id,
                'barcode' => uniqid(),
                'date_created' => now(),
                'date_updated' => now(),
                'is_active' => true,
            ]);

            \App\Models\Stock::create([
                'product_id' => $product->id,
                'amount' => $validated['amount'],
                'date_created' => now(),
                'is_active' => true,
            ]);

            return redirect()->route('stock.index')->with('success', 'Voorraad toegevoegd!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Er is een fout opgetreden: ' . $e->getMessage()]);
        }
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
        $suppliers = \App\Models\Supplier::all();
        $categories = \App\Models\ProductCategory::all();
        return view('stock.update', compact('stock', 'suppliers', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Stock $stock)
    {
        try {
            $validated = $request->only(['company_name', 'product_name', 'categorie', 'amount']);

            $supplier = \App\Models\Supplier::where('company_name', $validated['company_name'])->first();
            if (!$supplier) {
                $supplier = \App\Models\Supplier::create([
                    'company_name' => $validated['company_name'],
                    'contact_person_id' => 1,
                    'address' => '',
                    'next_delivery_date' => now(),
                    'next_delivery_time' => now()->format('H:i:s'),
                    'date_created' => now(),
                    'date_updated' => now(),
                    'is_active' => true,
                ]);
            }

            $category = \App\Models\ProductCategory::find($validated['categorie']);
            if (!$category) {
                abort(400, 'Categorie niet gevonden');
            }

            $productExists = \App\Models\Product::where('product_name', $validated['product_name'])
                ->where('id', '!=', optional($stock->product)->id)
                ->exists();
            if ($productExists) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['product_name' => 'Bewerken van product naam mislukt: er bestaat al een product naam.']);
            }

            $product = \App\Models\Product::where([
                ['product_name', $validated['product_name']],
                ['supplier_id', $supplier->id],
                ['product_category_id', $category->id],
            ])->first();

            if (!$product) {
                $product = \App\Models\Product::create([
                    'product_name' => $validated['product_name'],
                    'supplier_id' => $supplier->id,
                    'product_category_id' => $category->id,
                    'barcode' => uniqid(),
                    'date_created' => now(),
                    'date_updated' => now(),
                    'is_active' => true,
                ]);
            }

            $stock->update([
                'product_id' => $product->id,
                'amount' => $validated['amount'],
                'date_updated' => now(),
            ]);

            return redirect()->route('stock.index')->with('success', 'Gegevens succesvol gewijzigd!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Er is een fout opgetreden: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Stock $stock)
    {
        try {
            if ($stock->amount > 10) {
                return redirect()->route('stock.index')->with('error', 'Te groot voorraad, kan niet worden verwijderd!');
            }
            $stock->delete();
            return redirect()->route('stock.index')->with('success', 'Voorraad verwijderd!');
        } catch (\Exception $e) {
            return redirect()->route('stock.index')->with('error', 'Er is een fout opgetreden: ' . $e->getMessage());
        }
    }
}