<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $suppliers = Supplier::with('contactPerson')->paginate(5);

        return view('suppliers.index', compact('suppliers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
          return view('suppliers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'company_name' => [
                'required',
                'string',
                'max:100',
                'regex:/^[A-Za-zÀ-ÿ\s]+$/u' // Alleen letters en spaties
            ],
            'address' => 'required|string|max:255',

            'email' => [
                'required',
                'email',
                'max:255',
                'unique:contact_persons,email',
                'regex:/^[A-Za-z0-9_@.]+$/', // Alleen letters, cijfers, _ en @ en punt
            ],
            'phone' => [
                'required',
                'string',
                'max:20',
                'unique:contact_persons,phone',
                'regex:/^\+?[0-9]+$/', // Alleen cijfers, optioneel beginnend met +
            ],
        ], [
            'required' => 'u bent verplicht om dit in te vullen',
            'company_name.regex' => 'De bedrijfsnaam mag alleen letters en spaties bevatten.',
            'email.regex' => 'Het e-mailadres bevat ongeldige tekens.',
            'phone.regex' => 'Het telefoonnummer mag alleen cijfers bevatten en optioneel beginnen met +.',
            'email.email' => 'voer een geldig e-mailadres in',
        ]);

        // Contactpersoon aanmaken
        $contactPerson = \App\Models\ContactPerson::create([
            'first_name' => 'Onbekend',
            'last_name' => $validated['company_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
        ]);

        // Leverancier aanmaken
        Supplier::create([
            'contact_person_id' => $contactPerson->id,
            'company_name' => $validated['company_name'],
            'address' => $validated['address'],
        ]);

        return redirect()->route('suppliers.index')->with('success', 'Leverancier succesvol toegevoegd.');
        }


        /**
         * Display the specified resource.
         */
        public function show(Supplier $supplier)
        {
            //
        }

        /**
         * Show the form for editing the specified resource.
         */
        public function edit(Supplier $supplier)
        {
            $supplier->load('contactPerson');
            return view('suppliers.edit', compact('supplier'));
        }

        /**
         * Update the specified resource in storage.
         */
        public function update(Request $request, Supplier $supplier)
        {
        $validated = $request->validate([
            'email' => [
                'required',
                'email',
                'max:255',
                'regex:/^[A-Za-z0-9_@.]+$/',
                'unique:contact_persons,email,' . $supplier->contactPerson->id,
            ],
        ], [
            'email.required' => 'u bent verplicht om dit in te vullen',
            'email.regex' => 'Het e-mailadres bevat ongeldige tekens.',
            'email.email' => 'voer een geldig e-mailadres in',
            'email.unique' => 'Dit e-mailadres is al in gebruik.',
        ]);

        $supplier->contactPerson->update([
            'email' => $validated['email'],
        ]);

        return redirect()->route('suppliers.index')->with('success', 'E-mailadres succesvol bijgewerkt.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
    
    {
    // Verwijder eerst de contactpersoon als die bestaat
    if ($supplier->contactPerson) {
        $supplier->contactPerson->delete();
    }

    // Verwijder vervolgens de leverancier
    $supplier->delete();

    return redirect()->route('suppliers.index')->with('success', 'Leverancier succesvol verwijderd.');
    }
}
