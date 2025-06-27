<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::all();
        return view('customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('customers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'family_contact_persons_id' => 'required|exists:family_contact_persons,id',
            'amount_adults' => 'required|integer',
            'amount_children' => 'nullable|integer',
            'amount_babies' => 'nullable|integer',
            'special_wishes' => 'nullable|string|max:255',
            'family_name' => 'required|string|max:100',
            'address' => 'required|string|max:255',
            'is_active' => 'boolean',
        ]);
        Customer::create($validated);
        return redirect()->route('customers.index')->with('success', 'Customer created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        return view('customers.show', compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'family_contact_persons_id' => 'required|exists:family_contact_persons,id',
            'amount_adults' => 'required|integer',
            'amount_children' => 'nullable|integer',
            'amount_babies' => 'nullable|integer',
            'special_wishes' => 'nullable|string|max:255',
            'family_name' => 'required|string|max:100',
            'address' => 'required|string|max:255',
            'is_active' => 'boolean',
        ]);
        $customer->update($validated);
        return redirect()->route('customers.index')->with('success', 'Customer updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();
        return redirect()->route('customers.index')->with('success', 'Customer deleted successfully.');
    }
}
