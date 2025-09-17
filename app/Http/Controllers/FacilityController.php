<?php

namespace App\Http\Controllers;

use App\Models\Facility;
use Illuminate\Http\Request;

class FacilityController extends Controller
{
    public function index()
    {
        $facilities = Facility::latest()->paginate(10);
        return view('dashboard.facility.index', compact('facilities'));
    }

    public function create()
    {
        return view('dashboard.facility.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'   => 'required|string|max:255',
            'icon'   => 'nullable|image|mimes:jpg,jpeg,png,svg|max:2048',
            'status' => 'nullable|boolean',
        ]);

        $iconPath = null;
        if ($request->hasFile('icon')) {
            $iconPath = $request->file('icon')->store('facilities', 'public');
        }

        Facility::create([
            'name'      => $request->name,
            'icon_path' => $iconPath,
            'status'    => $request->boolean('status'),
        ]);

        return redirect()->route('facilities.index')->with('success', 'Facility created successfully.');
    }

    public function edit(Facility $facility)
    {
        return view('dashboard.facility.edit', compact('facility'));
    }

    public function update(Request $request, Facility $facility)
    {
        $request->validate([
            'name'   => 'required|string|max:255',
            'icon'   => 'nullable|image|mimes:jpg,jpeg,png,svg|max:2048',
            'status' => 'nullable|boolean',
        ]);

        $iconPath = $facility->icon_path;
        if ($request->hasFile('icon')) {
            $iconPath = $request->file('icon')->store('facilities', 'public');
        }

        $facility->update([
            'name'      => $request->name,
            'icon_path' => $iconPath,
            'status'    => $request->boolean('status'),
        ]);

        return redirect()->route('facilities.index')->with('success', 'Facility updated successfully.');
    }

    public function destroy(Facility $facility)
    {
        $facility->delete();
        return redirect()->route('facilities.index')->with('success', 'Facility deleted successfully.');
    }
}
