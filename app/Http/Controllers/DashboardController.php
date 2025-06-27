<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Valideer maand en jaar met aangepaste foutmeldingen
        $validated = $request->validate([
            'month' => 'required|integer|between:1,12',
            'year'  => 'required|integer|min:2020|max:' . date('Y'),
        ], [
            'month.required' => 'U bent vergeten de maand te selecteren.',
            'year.required'  => 'U bent vergeten het jaar te selecteren.',
        ]);

        $month = $validated['month'];
        $year  = $validated['year'];

        // Dummy data (vervang met echte logica)
        $reportData = $this->getReportData($month, $year);

        return view('dashboard', compact('reportData'));
    }

    protected function getReportData($month, $year)
    {
        // Hier komt je echte data-opvraaglogica
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
