<?php

namespace App\Http\Controllers;

use App\Models\FoodPackage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FoodPackageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   
        // call the sp that retrieves all food packages
        $foodPackages = DB::select('CALL sp_get_all_foodpackages()');

        // return the view with the food packages data
        return view('foodPackages.index', compact('foodPackages'));
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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FoodPackage $foodPackage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FoodPackage $foodPackage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FoodPackage $foodPackage)
    {
        //
    }
}
