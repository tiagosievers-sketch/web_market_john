<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AvailableYearsController extends Controller
{
    public function getAvailableYears()
    {
        $years = config('years.available_years');

        return response()->json([
            'status' => 'success',
            'data' => $years,
        ]);
    }
}
