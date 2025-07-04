<?php

namespace App\Http\Controllers;

use App\Models\FoodPackage;
use App\Models\Product;
use App\Models\FoodPackageProduct;
use App\Models\Customer;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class FoodPackageController extends Controller
{
    /**
     * Toon een paginatie-overzicht van alle voedselpakketten.
     */
    public function index(Request $request)
    {   
        try {
            // Haal alle pakketten op via de stored procedure
            $foodPackages = DB::select('CALL sp_get_all_foodpackages()');
            $foodPackages = json_decode(json_encode($foodPackages), true);

            // Handmatige paginatie
            $perPage = 4;
            $currentPage = $request->input('page', 1);
            $offset = ($currentPage - 1) * $perPage;
            $itemsForCurrentPage = array_slice($foodPackages, $offset, $perPage);

            $paginated = new LengthAwarePaginator(
                $itemsForCurrentPage,
                count($foodPackages),
                $perPage,
                $currentPage,
                ['path' => $request->url(), 'query' => $request->query()]
            );

            return view('foodPackages.index', ['foodPackages' => $paginated]);
        } catch (Exception $e) {
            // Foutafhandeling
            return back()->withErrors('Er is een fout opgetreden bij het ophalen van de voedselpakketten: ' . $e->getMessage());
        }
    }

    /**
     * Toon het formulier om een nieuw voedselpakket aan te maken.
     */
    public function create()
    {
        try {
            // Genereer automatisch pakketnummer en haal benodigde data op
            $last = FoodPackage::orderByDesc('id')->first();
            $packageNumber = 'P-' . str_pad(($last ? $last->id + 1 : 1), 5, '0', STR_PAD_LEFT);
            $dateComposed = now()->toDateString();
            $products = Product::all();
            $customers = Customer::orderBy('family_name')->get();

            return view('foodPackages.create', compact('packageNumber', 'dateComposed', 'products', 'customers'));
        } catch (Exception $e) {
            // Foutafhandeling
            return back()->withErrors('Er is een fout opgetreden bij het laden van het aanmaakformulier: ' . $e->getMessage());
        }
    }

    /**
     * Sla een nieuw voedselpakket op in de database.
     */
    public function store(Request $request)
    {
        try {
            // Valideer de invoer
            $request->validate([
                'customer_id' => 'required|exists:customers,id',
                'package_number' => 'required|unique:food_packages,package_number',
                'date_composed' => 'required|date',
                'products' => 'required|array|min:1',
                'products.*.product_id' => 'required|exists:products,id',
                'products.*.amount' => 'required|integer|min:1|max:50',
            ]);

            // Maak het voedselpakket aan
            $foodPackage = FoodPackage::create([
                'customer_id' => $request->customer_id,
                'package_number' => $request->package_number,
                'date_composed' => $request->date_composed,
                'date_issued' => null,
                'date_created' => now(),
                'date_updated' => now(),
                'is_active' => true,
            ]);

            // Koppel producten aan het pakket
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
        } catch (Exception $e) {
            // Foutafhandeling
            return back()->withErrors('Er is een fout opgetreden bij het aanmaken van het voedselpakket: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Toon het formulier om een bestaand voedselpakket te bewerken.
     */
    public function edit($id)
    {
        try {
            // Haal pakket, klanten, producten en gekoppelde producten op
            $foodPackage = FoodPackage::findOrFail($id);
            $customers = Customer::orderBy('family_name')->get();
            $products = Product::all();
            $selectedProducts = FoodPackageProduct::where('food_package_id', $foodPackage->id)->get();

            return view('foodPackages.edit', compact('foodPackage', 'customers', 'products', 'selectedProducts'));
        } catch (Exception $e) {
            // Foutafhandeling
            return back()->withErrors('Er is een fout opgetreden bij het laden van het bewerkformulier: ' . $e->getMessage());
        }
    }

    /**
     * Werk een bestaand voedselpakket bij in de database.
     */
    public function update(Request $request, $id)
    {
        try {
            $foodPackage = FoodPackage::findOrFail($id);

            // Valideer de invoer
            $request->validate([
                'customer_id' => 'required|exists:customers,id',
                'date_composed' => 'required|date',
                'date_issued' => 'nullable|date',
                'products' => 'required|array|min:1',
                'products.*.product_id' => 'required|exists:products,id',
                'products.*.amount' => 'required|integer|min:1|max:50',
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
        } catch (Exception $e) {
            // Foutafhandeling
            return back()->withErrors('Er is een fout opgetreden bij het bijwerken van het voedselpakket: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Verwijder een voedselpakket uit de database.
     */
    public function destroy($id)
    {
        try {
            // Zoek en verwijder het pakket
            $foodPackage = FoodPackage::findOrFail($id);
            $foodPackage->delete();

            return redirect()->route('foodPackages.index')->with('success', 'Voedselpakket verwijderd!');
        } catch (ModelNotFoundException $e) {
            // Pakket niet gevonden (404)
            abort(404, 'Voedselpakket niet gevonden.');
        } catch (Exception $e) {
            // Foutafhandeling
            return back()->withErrors('Er is een fout opgetreden bij het verwijderen van het voedselpakket: ' . $e->getMessage());
        }
    }

    /**
     * Toon de details van een specifiek voedselpakket.
     */
    public function show($id)
    {
        try {
            $pdo = DB::getPdo();
            $stmt = $pdo->prepare('CALL sp_get_food_package_details_by_id(?)');
            $stmt->execute([$id]);

            $packageDetails = $stmt->fetch(\PDO::FETCH_ASSOC);

            $stmt->nextRowset();
            $products = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            $stmt->closeCursor(); // Cruciaal om fout 2014 te voorkomen

            return view('foodPackages.show', [
                'packageDetails' => $packageDetails,
                'products' => $products,
            ]);
        } catch (Exception $e) {
            return back()->withErrors('Er is een fout opgetreden bij het ophalen van de pakketdetails: ' . $e->getMessage());
        }
    }
}