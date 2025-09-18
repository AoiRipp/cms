<?php

namespace App\Http\Controllers;

use App\Models\Promo;
use Illuminate\Http\Request;

class PromoController extends Controller
{
    public function index()
    {
        $promos = Promo::latest()->paginate(10);
        return view('dashboard.promo.index', compact('promos'));
    }

    public function create()
    {
        return view('dashboard.promo.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable|string',
            'status' => 'boolean',
        ]);

        Promo::create($request->only(['title', 'description', 'status']));

        return redirect()->route('promos.index')->with('success', 'Promo created successfully.');
    }

    public function edit(Promo $promo)
    {
        return view('dashboard.promo.edit', compact('promo'));
    }

    public function update(Request $request, Promo $promo)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable|string',
            'status' => 'boolean',
        ]);

        $promo->update($request->only(['title', 'description', 'status']));

        return redirect()->route('promos.index')->with('success', 'Promo updated successfully.');
    }

    public function destroy(Promo $promo)
    {
        $promo->delete();
        return redirect()->route('promos.index')->with('success', 'Promo deleted successfully.');
    }
}
