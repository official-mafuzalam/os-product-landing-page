<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attribute;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AttributeController extends Controller
{
    /**
     * Display a listing of the attributes.
     */
    public function index()
    {
        $attributes = Attribute::withCount('products')->orderBy('name')->get();

        return view('admin.attributes.index', compact('attributes'));
    }

    /**
     * Show the form for creating a new attribute.
     */
    public function create()
    {
        return view('admin.attributes.create');
    }

    /**
     * Store a newly created attribute in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:attributes,name',
            'description' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $attribute = Attribute::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'is_active' => $request->is_active ?? true
        ]);

        return redirect()->route('admin.attributes.index')
            ->with('success', 'Attribute created successfully.');
    }

    /**
     * Display the specified attribute.
     */
    public function show($id)
    {
        $attribute = Attribute::with([
            'products' => function ($query) {
                $query->select('products.id', 'products.name');
            }
        ])->findOrFail($id);

        return view('admin.attributes.show', compact('attribute'));
    }

    /**
     * Show the form for editing the specified attribute.
     */
    public function edit($id)
    {
        $attribute = Attribute::findOrFail($id);

        return view('admin.attributes.edit', compact('attribute'));
    }

    /**
     * Update the specified attribute in storage.
     */
    public function update(Request $request, $id)
    {
        $attribute = Attribute::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:attributes,name,' . $id,
            'description' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $attribute->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'is_active' => $request->is_active ?? $attribute->is_active
        ]);

        return redirect()->route('admin.attributes.index')
            ->with('success', 'Attribute updated successfully.');
    }

    /**
     * Remove the specified attribute from storage.
     */
    public function destroy($id)
    {
        $attribute = Attribute::findOrFail($id);

        // Check if attribute is used by any products
        if ($attribute->products()->count() > 0) {
            return redirect()->back()
                ->with('error', 'Cannot delete attribute. It is being used by one or more products.');
        }

        $attribute->delete();

        return redirect()->route('admin.attributes.index')
            ->with('success', 'Attribute deleted successfully.');
    }
}
