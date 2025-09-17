<?php

namespace App\Http\Controllers;

use App\Models\PropertyAttribute;
use Illuminate\Http\Request;

class PropertyAttributeController extends Controller
{
    public function index()
    {
        $attributes = PropertyAttribute::latest()->paginate(10);
        return view('dashboard.attributes.index', compact('attributes'));
    }

    public function create()
    {
        return view('dashboard.attributes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255|unique:property_attributes,name',
            'unit' => 'nullable|max:50',
            'active' => 'boolean',
        ]);

        PropertyAttribute::create($request->only(['name', 'unit', 'active']));

        return redirect()->route('attributes.index')->with('success', 'Attribute created successfully.');
    }

    public function edit(PropertyAttribute $attribute)
    {
        return view('dashboard.attributes.edit', compact('attribute'));
    }

    public function update(Request $request, PropertyAttribute $attribute)
    {
        $request->validate([
            'name' => 'required|max:255|unique:property_attributes,name,' . $attribute->id,
            'unit' => 'nullable|max:50',
            'active' => 'boolean',
        ]);

        $attribute->update($request->only(['name', 'unit', 'active']));

        return redirect()->route('attributes.index')->with('success', 'Attribute updated successfully.');
    }

    public function destroy(PropertyAttribute $attribute)
    {
        $attribute->delete();
        return redirect()->route('attributes.index')->with('success', 'Attribute deleted successfully.');
    }
}
