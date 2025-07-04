<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $reportData = collect();

        // Alleen valideren als gebruiker maand & jaar selecteerde
        if ($request->has(['month', 'year'])) {
            $validated = $request->validate([
                'month' => 'required|integer|between:1,12',
                'year'  => 'required|integer|min:2020|max:' . date('Y'),
            ], [
                'month.required' => 'U bent vergeten de maand te selecteren.',
                'year.required'  => 'U bent vergeten het jaar te selecteren.',
            ]);

            $month = $validated['month'];
            $year  = $validated['year'];

            // Haal rapportagegegevens op
            $reportData = $this->getReportData($month, $year);
        }

        return view('dashboard', compact('reportData'));
    }

    protected function getReportData($month, $year)
    {
        // Dummydata - hier komt je echte logica
        return collect([
            (object)[
                'category' => 'Groente',
                'postcode' => '1234 AB',
                'deliveries' => 15,
                'food_packages' => 30,
            ],
            (object)[
                'category' => 'Fruit',
                'postcode' => '5678 CD',
                'deliveries' => 10,
                'food_packages' => 20,
            ],
        ]);
    }
}
