<?php

namespace App\Http\Controllers;

use App\Models\Province;
use Illuminate\Http\Request;

class ProvinceController extends Controller
{
    public function index()
    {
        $provinces = Province::latest()->paginate(10);
        return view('dashboard.province.index', compact('provinces'));
    }

    public function create()
    {
        return view('dashboard.province.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|unique:provinces|max:255']);
        Province::create($request->only(['name', 'status']));
        return redirect()->route('provinces.index')->with('success', 'Province created successfully.');
    }

    public function edit(Province $province)
    {
        return view('dashboard.province.edit', compact('province'));
    }

    public function update(Request $request, Province $province)
    {
        $request->validate(['name' => 'required|max:255|unique:provinces,name,'.$province->id]);
        $province->update($request->only(['name', 'status']));
        return redirect()->route('provinces.index')->with('success', 'Province updated successfully.');
    }

    public function destroy(Province $province)
    {
        $province->delete();
        return redirect()->route('provinces.index')->with('success', 'Province deleted successfully.');
    }
}
