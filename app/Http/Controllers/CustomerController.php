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
        $customers = Customer::orderByDesc('date_created')->get();
        return view('customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $familyContactPersons = \App\Models\FamilyContactPerson::all();
        return view('customers.create', compact('familyContactPersons'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input = $request->all();
        // Truncate address to 255 characters before validation
        if (isset($input['address'])) {
            $input['address'] = mb_substr($input['address'], 0, 255);
        }

        $validated = validator($input, [
            'family_contact_persons_id' => 'required|exists:family_contact_persons,id',
            'amount_adults' => 'required|integer',
            'amount_children' => 'nullable|integer',
            'amount_babies' => 'nullable|integer',
            'special_wishes' => 'nullable|string|max:255',
            'family_name' => 'required|string|max:100',
            'address' => 'required|string|max:255|unique:customers,address',
            'is_active' => 'boolean',
        ], [
            'address.unique' => 'Dit adres is al in gebruik.',
            'address.max' => 'Het adres mag maximaal 255 tekens zijn.'
        ])->validate();

        Customer::create($validated);
        return redirect()->route('customers.index')->with('success', 'Klant succesvol aangemaakt.');
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
        $familyContactPersons = \App\Models\FamilyContactPerson::all();
        return view('customers.edit', compact('customer', 'familyContactPersons'));
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
            'address' => 'required|string|max:255|unique:customers,address,' . $customer->id,
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
