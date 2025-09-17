<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Category;
use App\Models\Promo;
use App\Models\Facility;
use App\Models\PropertyAttribute;
use App\Models\Province;
use App\Models\Regency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['province', 'regency', 'category'])->paginate(10);
        return view('dashboard.products.index', compact('products'));
    }

    public function show($metalink)
    {
        $product = Product::where('metalink', $metalink)
            ->with(['province','regency','category','facilities','attributes','images'])
            ->firstOrFail();

        return view('dashboard.products.show', compact('product'));
    }

    public function create()
    {
        $categories  = Category::all();
        $promos      = Promo::all();
        $facilities  = Facility::all();
        $attributes  = PropertyAttribute::all();
        $provinces   = Province::all();

        return view('dashboard.products.create', compact(
            'categories',
            'promos',
            'facilities',
            'attributes',
            'provinces'
        ));
    }

    public function store(Request $request)
    {
        // clean price before validation
        $request->merge([
            'price' => preg_replace('/\D/', '', $request->price) // only numbers
        ]);

        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'province_id' => 'required|exists:provinces,id',
            'regency_id'  => 'required|exists:regencies,id',
            'category_id' => 'required|exists:categories,id',
            'metalink'    => [
                'required',
                'string',
                'max:255',
                'unique:products,metalink,' . ($product->id ?? 'NULL'),
                'regex:/^[a-z0-9-_]+$/', // only lowercase, numbers, dash, underscore
            ],
        ]);

        DB::transaction(function () use ($request) {
            $product = Product::create($request->only([
                'title',
                'description',
                'metalink',
                'meta_title',
                'meta_description',
                'meta_tags',
                'price',
                'province_id',
                'regency_id',
                'category_id',
                'luas_tanah',
                'luas_bangunan',
                'kamar_mandi',
                'kamar_tidur'
            ]));

            $product->promos()->sync($request->promos ?? []);
            $product->facilities()->sync($request->facilities ?? []);

            if ($request->has('attributes')) {
                $syncData = [];
                foreach ($request->attributes as $attr) {
                    if (!empty($attr['id'])) {
                        $syncData[$attr['id']] = ['value' => $attr['value'] ?? null];
                    }
                }
                $product->attributes()->sync($syncData);
            }

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $file) {
                    $path = $file->store('products', 'public');
                    ProductImage::create([
                        'product_id' => $product->id,
                        'path' => $path,
                    ]);
                }
            }
        });

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        $categories  = Category::all();
        $promos      = Promo::all();
        $facilities  = Facility::all();
        $attributes  = PropertyAttribute::all();
        $provinces   = Province::all();
        $regencies   = Regency::where('province_id', $product->province_id)->get();

        $product->load(['category', 'promos', 'facilities', 'attributes', 'images']);

        return view('dashboard.products.edit', compact(
            'product',
            'categories',
            'promos',
            'facilities',
            'attributes',
            'provinces',
            'regencies'
        ));
    }

    public function update(Request $request, Product $product)
    {
        // clean price before validation
        $request->merge([
            'price' => preg_replace('/\D/', '', $request->price)
        ]);

        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'province_id' => 'required|exists:provinces,id',
            'regency_id'  => 'required|exists:regencies,id',
            'category_id' => 'required|exists:categories,id',
            'metalink'    => [
                'required',
                'string',
                'max:255',
                'unique:products,metalink,' . ($product->id ?? 'NULL'),
                'regex:/^[a-z0-9-_]+$/', // only lowercase, numbers, dash, underscore
            ],
        ]);

        DB::transaction(function () use ($request, $product) {
            $product->update($request->only([
                'title',
                'description',
                'metalink',
                'meta_title',
                'meta_description',
                'meta_tags',
                'price',
                'province_id',
                'regency_id',
                'category_id', 
                'luas_tanah',
                'luas_bangunan',
                'kamar_mandi',
                'kamar_tidur'
            ]));

            $product->promos()->sync($request->promos ?? []);
            $product->facilities()->sync($request->facilities ?? []);

            if ($request->has('attributes')) {
                $syncData = [];
                foreach ($request->attributes as $attr) {
                    if (!empty($attr['id'])) {
                        $syncData[$attr['id']] = ['value' => $attr['value'] ?? null];
                    }
                }
                $product->attributes()->sync($syncData);
            }

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $file) {
                    $path = $file->store('products', 'public');
                    ProductImage::create([
                        'product_id' => $product->id,
                        'path' => $path,
                    ]);
                }
            }
        });


        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
}
