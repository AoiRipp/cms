<?php

namespace App\Http\Controllers;

use App\Models\Regency;
use App\Models\Province;
use Illuminate\Http\Request;

class RegencyController extends Controller
{
    public function index()
    {
        $regencies = Regency::with('province')->latest()->paginate(10);
        return view('dashboard.regency.index', compact('regencies'));
    }

    public function create()
    {
        $provinces = Province::all();
        return view('dashboard.regency.create', compact('provinces'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'province_id' => 'required|exists:provinces,id',
            'name' => 'required|max:255',
        ]);

        Regency::create($request->only(['province_id', 'name', 'status']));
        return redirect()->route('regencies.index')->with('success', 'Regency created successfully.');
    }

    public function edit(Regency $regency)
    {
        $provinces = Province::all();
        return view('dashboard.regency.edit', compact('regency', 'provinces'));
    }

    public function update(Request $request, Regency $regency)
    {
        $request->validate([
            'province_id' => 'required|exists:provinces,id',
            'name' => 'required|max:255',
        ]);

        $regency->update($request->only(['province_id', 'name', 'status']));
        return redirect()->route('regencies.index')->with('success', 'Regency updated successfully.');
    }

    public function destroy(Regency $regency)
    {
        $regency->delete();
        return redirect()->route('regencies.index')->with('success', 'Regency deleted successfully.');
    }
}
