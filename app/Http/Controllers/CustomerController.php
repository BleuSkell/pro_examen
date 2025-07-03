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
            // Ensure is_active is set to 1 or 0
            $input['is_active'] = $request->has('is_active') ? 1 : 0;
            if (isset($input['address'])) {
                $input['address'] = mb_substr($input['address'], 0, 255);
            }
            $validated = $request->validate([
                'family_contact_persons_id' => 'required|exists:family_contact_persons,id',
                'amount_adults' => 'required|integer|min:0',
                'amount_children' => 'nullable|integer|min:0',
                'amount_babies' => 'nullable|integer|min:0',
                'special_wishes' => 'nullable|string|max:255',
                'family_name' => 'required|string|max:100',
                'address' => 'required|string|max:255|unique:customers,address',
                'is_active' => 'boolean',
            ], [
                'address.unique' => 'Dit adres is al in gebruik.',
                'address.max' => 'Het adres mag maximaal 255 tekens zijn.',
                'family_contact_persons_id.required' => 'Contactpersoon is verplicht.',
                'family_contact_persons_id.exists' => 'De geselecteerde contactpersoon bestaat niet.',
                'amount_adults.required' => 'Aantal volwassenen is verplicht.',
                'amount_adults.min' => 'Aantal volwassenen moet minimaal 0 zijn.',
                'family_name.required' => 'Achternaam gezin is verplicht.',
                'address.required' => 'Adres is verplicht.',
            ]);
            // Call stored procedure for create
            DB::statement('CALL sp_create_customer(?, ?, ?, ?, ?, ?, ?, ?)', [
                $validated['family_contact_persons_id'],
                $validated['amount_adults'],
                $validated['amount_children'] ?? 0,
                $validated['amount_babies'] ?? 0,
                $validated['special_wishes'] ?? '',
                $validated['family_name'],
                $validated['address'],
                $input['is_active'],
            ]);
            return redirect()->route('customers.index')->with('success', 'Klant succesvol aangemaakt.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withInput()->withErrors($e->errors());
        } catch (\Exception $e) {
            \Log::error('Error creating customer: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Er is een fout opgetreden bij het aanmaken van de klant.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        try {
            return view('customers.show', ['customer' => $customer]);
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
            return view('customers.edit', ['customer' => $customer, 'familyContactPersons' => $familyContactPersons]);
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
            $input = $request->all();
            // Ensure is_active is set to 1 or 0
            $input['is_active'] = $request->has('is_active') ? 1 : 0;
            if (isset($input['address'])) {
                $input['address'] = mb_substr($input['address'], 0, 255);
            }
            $validated = $request->validate([
                'family_contact_persons_id' => 'required|exists:family_contact_persons,id',
                'amount_adults' => 'required|integer|min:0',
                'amount_children' => 'nullable|integer|min:0',
                'amount_babies' => 'nullable|integer|min:0',
                'special_wishes' => 'nullable|string|max:255',
                'family_name' => 'required|string|max:100',
                'address' => 'required|string|max:255|unique:customers,address,' . $customer->id,
                'is_active' => 'boolean',
            ], [
                'address.unique' => 'Dit adres is al in gebruik.',
                'address.max' => 'Het adres mag maximaal 255 tekens zijn.',
                'family_contact_persons_id.required' => 'Contactpersoon is verplicht.',
                'family_contact_persons_id.exists' => 'De geselecteerde contactpersoon bestaat niet.',
                'amount_adults.required' => 'Aantal volwassenen is verplicht.',
                'amount_adults.min' => 'Aantal volwassenen moet minimaal 0 zijn.',
                'family_name.required' => 'Achternaam gezin is verplicht.',
                'address.required' => 'Adres is verplicht.',
            ]);
            \Log::debug('Updating customer via sp_update_customer', [
                'id' => $customer->id,
                'params' => [
                    $customer->id,
                    $validated['family_contact_persons_id'],
                    $validated['amount_adults'],
                    $validated['amount_children'] ?? 0,
                    $validated['amount_babies'] ?? 0,
                    $validated['special_wishes'] ?? '',
                    $validated['family_name'],
                    $validated['address'],
                    $input['is_active'],
                ]
            ]);
            DB::statement('CALL sp_update_customer(?, ?, ?, ?, ?, ?, ?, ?, ?)', [
                $customer->id,
                $validated['family_contact_persons_id'],
                $validated['amount_adults'],
                $validated['amount_children'] ?? 0,
                $validated['amount_babies'] ?? 0,
                $validated['special_wishes'] ?? '',
                $validated['family_name'],
                $validated['address'],
                $input['is_active'],
            ]);
            return redirect()->route('customers.index')->with('success', 'Klant succesvol bijgewerkt.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withInput()->withErrors($e->errors());
        } catch (\Exception $e) {
            \Log::error('Error updating customer: ' . $e->getMessage());
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
            return redirect()->route('customers.index')->with('success', 'Klant succesvol verwijderd.');
        } catch (\Exception $e) {
            \Log::error('Error deleting customer: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Er is een fout opgetreden bij het verwijderen van de klant.');
        }
    }
}