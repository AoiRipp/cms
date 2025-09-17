<?php

namespace App\Http\Controllers;

use App\Models\Regency;

class LocationController extends Controller
{
    public function getRegencies($province_id)
    {
        $regencies = Regency::where('province_id', $province_id)->get();
        return response()->json($regencies);
    }
}
