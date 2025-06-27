<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

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
                'regex:/^[A-Za-z0-9_@.]+$/',
            ],
            'phone' => [
                'required',
                'string',
                'max:20',
                'unique:contact_persons,phone',
                'regex:/^\+?[0-9]+$/',
            ],
        ], [
            'required' => 'u bent verplicht om dit in te vullen',
            'company_name.regex' => 'De bedrijfsnaam mag alleen letters en spaties bevatten.',
            'email.regex' => 'Het e-mailadres bevat ongeldige tekens.',
            'phone.regex' => 'Het telefoonnummer mag alleen cijfers bevatten en optioneel beginnen met +.',
            'email.email' => 'voer een geldig e-mailadres in',
        ]);

        try {
            // Maak eerst de contactpersoon aan
            $contactPerson = \App\Models\ContactPerson::create([
                'first_name' => 'Onbekend',
                'last_name' => $validated['company_name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
            ]);

            // Parameters voor stored procedure
            $contactPersonId = $contactPerson->id;
            $companyName = $validated['company_name'];
            $address = $validated['address'];
            $nextDeliveryDate = null; // Pas aan indien je dit als input wil
            $nextDeliveryTime = null;

            // Roep stored procedure aan
            DB::statement('CALL InsertSupplier(?, ?, ?, ?, ?, @success, @error_msg)', [
                $contactPersonId,
                $companyName,
                $address,
                $nextDeliveryDate,
                $nextDeliveryTime,
            ]);

            // Lees output parameters uit
            $result = DB::select('SELECT @success as success, @error_msg as error_msg')[0];

            if (!$result->success) {
                // Verwijder contactpersoon om rollback te doen
                $contactPerson->delete();
                return back()->withInput()->withErrors(['db_error' => $result->error_msg ?? 'Onbekende fout bij opslaan leverancier.']);
            }

            return redirect()->route('suppliers.index')->with('success', 'Leverancier succesvol toegevoegd.');

        } catch (\Exception $e) {
            if (isset($contactPerson)) {
                $contactPerson->delete();
            }
            return back()->withInput()->withErrors(['exception' => 'Er is een fout opgetreden: ' . $e->getMessage()]);
        }
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
                // Laravel email rule is voldoende, regex verwijderd
                Rule::unique('contact_persons', 'email')->ignore($supplier->contactPerson->id),
            ],
        ], [
            'email.required' => 'U bent verplicht om dit in te vullen',
            'email.email' => 'Voer een geldig e-mailadres in',
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
        if ($supplier->contactPerson) {
            $supplier->contactPerson->delete();
        }

        $supplier->delete();

        return redirect()->route('suppliers.index')->with('success', 'Leverancier succesvol verwijderd.');
    }
}
