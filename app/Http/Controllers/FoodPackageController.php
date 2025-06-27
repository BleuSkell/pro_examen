<?php

namespace App\Http\Controllers;

use App\Models\FoodPackage;
use App\Models\Product;
use App\Models\FoodPackageProduct;
use App\Models\Customer;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FoodPackageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {   
        // Haal alle pakketten op via de stored procedure
        $foodPackages = DB::select('CALL sp_get_all_foodpackages()');

        // Zet om naar array (anders werkt array_slice niet)
        $foodPackages = json_decode(json_encode($foodPackages), true);

        // Paginatie parameters
        $perPage = 4;
        $currentPage = $request->input('page', 1);
        $offset = ($currentPage - 1) * $perPage;

        // Slice de array voor de huidige pagina
        $itemsForCurrentPage = array_slice($foodPackages, $offset, $perPage);

        // Maak een paginator
        $paginated = new LengthAwarePaginator(
            $itemsForCurrentPage,
            count($foodPackages),
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('foodPackages.index', ['foodPackages' => $paginated]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Genereer automatisch pakketnummer
        $last = FoodPackage::orderByDesc('id')->first();
        $packageNumber = 'P-' . str_pad(($last ? $last->id + 1 : 1), 5, '0', STR_PAD_LEFT);
        $dateComposed = now()->toDateString();
        $products = Product::all();
        $customers = Customer::orderBy('family_name')->get();

        return view('foodPackages.create', compact('packageNumber', 'dateComposed', 'products', 'customers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'package_number' => 'required|unique:food_packages,package_number',
            'date_composed' => 'required|date',
            'products' => 'required|array|min:1',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.amount' => 'required|integer|min:1',
        ]);

        // Maak het pakket aan
        $foodPackage = FoodPackage::create([
            'customer_id' => $request->customer_id,
            'package_number' => $request->package_number,
            'date_composed' => $request->date_composed,
            'date_issued' => null,
            'date_created' => now(),
            'date_updated' => now(),
            'is_active' => true,
        ]);

        // Voeg producten toe
        foreach ($request->products as $product) {
            FoodPackageProduct::create([
                'food_package_id' => $foodPackage->id,
                'product_id' => $product['product_id'],
                'amount' => $product['amount'],
                'date_created' => now(),
                'date_updated' => now(),
                'is_active' => true,
            ]);
        }

        return redirect()->route('foodPackages.index')->with('success', 'Voedselpakket aangemaakt!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $foodPackage = FoodPackage::findOrFail($id);
        $customers = Customer::orderBy('family_name')->get();
        $products = Product::all();

        // Haal de gekoppelde producten op
        $selectedProducts = FoodPackageProduct::where('food_package_id', $foodPackage->id)->get();

        return view('foodPackages.edit', compact('foodPackage', 'customers', 'products', 'selectedProducts'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $foodPackage = FoodPackage::findOrFail($id);

        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'date_composed' => 'required|date',
            'date_issued' => 'nullable|date',
            'products' => 'required|array|min:1',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.amount' => 'required|integer|min:1',
        ]);

        // Update het pakket
        $foodPackage->update([
            'customer_id' => $request->customer_id,
            'date_composed' => $request->date_composed,
            'date_issued' => $request->date_issued,
            'date_updated' => now(),
        ]);

        // Verwijder oude producten en voeg nieuwe toe
        FoodPackageProduct::where('food_package_id', $foodPackage->id)->delete();
        foreach ($request->products as $product) {
            FoodPackageProduct::create([
                'food_package_id' => $foodPackage->id,
                'product_id' => $product['product_id'],
                'amount' => $product['amount'],
                'date_created' => now(),
                'date_updated' => now(),
                'is_active' => true,
            ]);
        }

        return redirect()->route('foodPackages.show', $foodPackage->id)->with('success', 'Voedselpakket bijgewerkt!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $foodPackage = FoodPackage::findOrFail($id);
        $foodPackage->delete();

        return redirect()->route('foodPackages.index')->with('success', 'Voedselpakket verwijderd!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Call the stored procedure
        $results = DB::select('CALL sp_get_food_package_details_by_id(?)', [$id]);

        // Laravel only returns the first result set, so we need to use the PDO connection for multiple result sets
        $pdo = DB::getPdo();
        $stmt = $pdo->prepare('CALL sp_get_food_package_details_by_id(?)');
        $stmt->execute([$id]);

        // First result set: food package + customer + family contact person
        $packageDetails = $stmt->fetch(\PDO::FETCH_ASSOC);

        // Move to next result set: products in the package
        $stmt->nextRowset();
        $products = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        // Pass to the view
        return view('foodPackages.show', [
            'packageDetails' => $packageDetails,
            'products' => $products,
        ]);
    }
}
