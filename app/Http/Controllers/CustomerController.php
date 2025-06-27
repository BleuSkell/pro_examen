<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $customers = DB::select('CALL sp_get_customers()');
            return view('customers.index', ['customers' => $customers]);
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

            DB::statement('CALL sp_create_customer(?, ?, ?, ?, ?, ?, ?, ?)', [
                $validated['family_contact_persons_id'],
                $validated['amount_adults'],
                $validated['amount_children'] ?? 0,
                $validated['amount_babies'] ?? 0,
                $validated['special_wishes'] ?? '',
                $validated['family_name'],
                $validated['address'],
                $validated['is_active'] ?? 0
            ]);
            return redirect()->route('custome   rs.index')->with('success', 'Klant succesvol aangemaakt.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Er is een fout opgetreden bij het aanmaken van de klant.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $customer = DB::select('SELECT * FROM customers WHERE id = ?', [$id]);
            if (!$customer) {
                return redirect()->back()->with('error', 'Klant niet gevonden.');
            }
            return view('customers.show', ['customer' => $customer[0]]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Er is een fout opgetreden bij het tonen van de klant.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try {
            $customer = DB::select('SELECT * FROM customers WHERE id = ?', [$id]);
            if (!$customer) {
                return redirect()->back()->with('error', 'Klant niet gevonden.');
            }
            $familyContactPersons = \App\Models\FamilyContactPerson::all();
            return view('customers.edit', ['customer' => $customer[0], 'familyContactPersons' => $familyContactPersons]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Er is een fout opgetreden bij het laden van het bewerkingsformulier.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'family_contact_persons_id' => 'required|exists:family_contact_persons,id',
                'amount_adults' => 'required|integer',
                'amount_children' => 'nullable|integer',
                'amount_babies' => 'nullable|integer',
                'special_wishes' => 'nullable|string|max:255',
                'family_name' => 'required|string|max:100',
                'address' => 'required|string|max:255|unique:customers,address,' . $id,
                'is_active' => 'boolean',
            ]);
            DB::statement('CALL sp_update_customer(?, ?, ?, ?, ?, ?, ?, ?, ?)', [
                $id,
                $validated['family_contact_persons_id'],
                $validated['amount_adults'],
                $validated['amount_children'] ?? 0,
                $validated['amount_babies'] ?? 0,
                $validated['special_wishes'] ?? '',
                $validated['family_name'],
                $validated['address'],
                $validated['is_active'] ?? 0
            ]);
            return redirect()->route('customers.index')->with('success', 'Customer updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Er is een fout opgetreden bij het bijwerken van de klant.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            DB::statement('CALL sp_delete_customer(?)', [$id]);
            return redirect()->route('customers.index')->with('success', 'Customer deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Er is een fout opgetreden bij het verwijderen van de klant.');
        }
    }
}
