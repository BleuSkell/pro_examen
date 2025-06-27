<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $validated = $request->validate([
            'month' => 'nullable|integer|between:1,12',
            'year' => 'nullable|integer|min:2020|max:' . date('Y'),
        ], [
            'month.required' => 'Selecteer een maand.',
            'year.required' => 'Selecteer een jaar.',
        ]);

        $reportData = [];

        if ($request->has('month') && $request->has('year')) {
            $month = $request->input('month');
            $year = $request->input('year');

            if ($month && $year) {
                $reportData = $this->getReportData($month, $year);
            }
        }

        return view('dashboard', compact('reportData'));
    }

    protected function getReportData($month, $year)
    {
        // Dummy data, vervang met je database logica
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
