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
        try {
            $customers = Customer::orderByDesc('date_created')->get();
            return view('customers.index', compact('customers'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Er is een fout opgetreden bij het ophalen van de klanten.');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            $familyContactPersons = \App\Models\FamilyContactPerson::all();
            return view('customers.create', compact('familyContactPersons'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Er is een fout opgetreden bij het laden van het formulier.');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
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
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Er is een fout opgetreden bij het aanmaken van de klant.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        try {
            return view('customers.show', compact('customer'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Er is een fout opgetreden bij het tonen van de klant.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        try {
            $familyContactPersons = \App\Models\FamilyContactPerson::all();
            return view('customers.edit', compact('customer', 'familyContactPersons'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Er is een fout opgetreden bij het laden van het bewerkingsformulier.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        try {
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
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Er is een fout opgetreden bij het bijwerken van de klant.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        try {
            $customer->delete();
            return redirect()->route('customers.index')->with('success', 'Customer deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Er is een fout opgetreden bij het verwijderen van de klant.');
        }
    }
}
