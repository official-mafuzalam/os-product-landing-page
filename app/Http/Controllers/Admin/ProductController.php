<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Attribute;
use App\Models\ProductAttribute;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    protected $perPageProducts = 20;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $products = Product::query()
            ->when($request->search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('sku', 'like', "%{$search}%");
                });
            })
            ->when($request->status, function ($query, $status) {
                if ($status === 'active') {
                    $query->where('is_active', true);
                } elseif ($status === 'inactive') {
                    $query->where('is_active', false);
                }
            })
            ->latest()
            ->paginate($this->perPageProducts)
            ->appends($request->all());

        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {

        $categories = Category::where('is_active', true)->get();
        $allAttributes = Attribute::where('is_active', true)->get();
        $product = new Product();
        return view('admin.products.create', compact('product', 'categories', 'allAttributes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'buy_price' => 'nullable|numeric|min:0',
            'price' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'sku' => 'required|string|unique:products,sku',
            'category_id' => 'required|exists:categories,id',
            'image_gallery.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:400',
            'specifications' => 'nullable|json',
            'is_active' => 'sometimes|boolean',
            'is_featured' => 'sometimes|boolean',
            'product_attributes' => 'nullable|array',
            'product_attributes.*.id' => 'required|exists:attributes,id',
            'product_attributes.*.values' => 'required|array',
            'product_attributes.*.values.*' => 'string|max:255',
        ]);

        try {
            DB::beginTransaction();

            $validated['slug'] = Str::slug($validated['name']);
            $validated['is_active'] = $request->boolean('is_active');
            $validated['is_featured'] = $request->boolean('is_featured');

            if (!empty($validated['specifications'])) {
                $validated['specifications'] = json_decode($validated['specifications'], true);
            }

            // Create product
            $product = Product::create($validated);

            // Handle attributes
            if ($request->filled('product_attributes')) { // Changed from attributes
                foreach ($request->product_attributes as $index => $attributeData) { // Changed from attributes
                    if (!empty($attributeData['id']) && !empty($attributeData['values'])) {
                        foreach ($attributeData['values'] as $valueIndex => $value) {
                            ProductAttribute::create([
                                'product_id' => $product->id,
                                'attribute_id' => $attributeData['id'],
                                'value' => trim($value),
                                'order' => $valueIndex
                            ]);
                        }
                    }
                }
            }

            // Handle gallery images
            if ($request->hasFile('image_gallery')) {
                foreach ($request->file('image_gallery') as $index => $image) {
                    $galleryPath = $image->store('products', 'public');

                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $galleryPath,
                        'is_primary' => $index === 0,
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('admin.products.index')
                ->with('success', 'Product created successfully.');

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Product creation failed: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            return back()
                ->withInput()
                ->withErrors(['error' => 'Something went wrong while creating the product.']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product->load(['category', 'images']);
        $groupedAttributes = $product->attributes
            ->groupBy('id')
            ->map(function ($items) {
                return [
                    'name' => $items->first()->name,
                    'values' => $items->pluck('pivot.value')->unique()->toArray(),
                ];
            });

        return view('admin.products.show', compact('product', 'groupedAttributes'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::where('is_active', true)->get();
        $allAttributes = Attribute::where('is_active', true)->get();

        // Load product attributes with pivot values
        $product->load('attributes');

        // Group attributes by attribute_id and collect values
        $groupedAttributes = $product->attributes
            ->groupBy('id')
            ->map(function ($items) {
                return [
                    'id' => $items->first()->id,
                    'name' => $items->first()->name,
                    'values' => $items->pluck('pivot.value')->toArray()
                ];
            })->values(); // reset keys

        return view('admin.products.edit', compact(
            'product',
            'categories',
            'allAttributes',
            'groupedAttributes'
        ));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'buy_price' => 'nullable|numeric|min:0',
            'price' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'sku' => 'required|string|unique:products,sku,' . $product->id,
            'image_gallery.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:400',
            'specifications' => 'nullable|json',
            'is_active' => 'sometimes|boolean',
            'is_featured' => 'sometimes|boolean',
            'product_attributes' => 'nullable|array', // Changed from attributes
            'product_attributes.*.id' => 'required|exists:attributes,id',
            'product_attributes.*.values' => 'required|array',
            'product_attributes.*.values.*' => 'string|max:255',
        ]);

        try {
            DB::beginTransaction();

            $validated['slug'] = Str::slug($validated['name']);
            $validated['is_active'] = $request->boolean('is_active');
            $validated['is_featured'] = $request->boolean('is_featured');

            // Decode specifications JSON
            if (!empty($validated['specifications'])) {
                $validated['specifications'] = json_decode($validated['specifications'], true);
            }

            // Update product
            $product->update($validated);

            // --- Handle product attributes ---
            // Remove all old attributes
            ProductAttribute::where('product_id', $product->id)->delete();

            if ($request->filled('product_attributes')) { // Changed from attributes
                foreach ($request->product_attributes as $order => $attributeData) { // Changed from attributes
                    $attrId = $attributeData['id'] ?? null;
                    $values = $attributeData['values'] ?? [];

                    if ($attrId && !empty($values)) {
                        foreach ($values as $valueIndex => $value) {
                            ProductAttribute::create([
                                'product_id' => $product->id,
                                'attribute_id' => (int) $attrId,
                                'value' => trim($value),
                                'order' => $valueIndex,
                            ]);
                        }
                    }
                }

                Log::info('Product attributes synced', [
                    'product_id' => $product->id,
                    'product_attributes' => $request->input('product_attributes', []) // Changed from attributes
                ]);
            }

            // Handle gallery images
            if ($request->hasFile('image_gallery')) {
                foreach ($request->file('image_gallery') as $index => $image) {
                    $galleryPath = $image->store('products', 'public');

                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $galleryPath,
                        'is_primary' => $index === 0 && $product->images()->where('is_primary', true)->doesntExist(),
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('admin.products.index')
                ->with('success', 'Product updated successfully.');

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Product update failed: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            return back()
                ->withInput()
                ->withErrors(['error' => 'Something went wrong while updating the product.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // Delete associated images
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        if ($product->image_gallery) {
            foreach ($product->image_gallery as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }

    /**
     * Toggle the active status of the product.
     */
    public function toggleStatus(Product $product)
    {
        $product->update(['is_active' => !$product->is_active]);

        return back()->with('success', 'Product status updated successfully');
    }

    /**
     * Toggle the featured status of the product.
     */
    public function toggleFeatured(Product $product)
    {
        $product->update(['is_featured' => !$product->is_featured]);

        return back()->with('success', 'Product featured status updated successfully');
    }

    /**
     * Set primary image for the product.
     */
    public function setPrimaryImage(Request $request, Product $product)
    {
        $request->validate([
            'image_id' => 'required|exists:product_images,id'
        ]);

        try {
            DB::beginTransaction();

            // Reset all images to non-primary
            ProductImage::where('product_id', $product->id)
                ->update(['is_primary' => false]);

            // Set the selected image as primary
            $image = ProductImage::find($request->image_id);
            $image->is_primary = true;
            $image->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Primary image updated successfully'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Failed to set primary image: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to set primary image'
            ], 500);
        }
    }
}
