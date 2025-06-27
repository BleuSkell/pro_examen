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
     * Display the specified resource.
     */
    public function show(FoodPackage $foodPackage)
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
