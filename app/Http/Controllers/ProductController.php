<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::orderBy('created_at', 'desc')->get();
        return view('products.index')->with(['products' => $products]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('products.form', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category' => 'required|exists:categories,id',
            'is_discount' => 'required|boolean',
            'discount_type' => 'nullable|string|in:percent,amount',
            'discount' => 'nullable|numeric|min:0',
            'sku' => 'required|string|max:100|unique:products,sku',
            'stock' => 'required|integer|min:0',
            'unit' => 'required|string|max:50',
            'description' => 'nullable|string',
            'is_active' => 'required|boolean',
        ];

        $input = $request->validate($rules);



        if ($input['is_discount']) {
            if ($input['discount_type'] === 'percent' && isset($input['discount'])) {
                $input['after_discount_price'] = $input['price'] - ($input['price'] * ($input['discount'] / 100));
            } elseif ($input['discount_type'] === 'amount' && isset($input['discount'])) {
                $input['after_discount_price'] = $input['price'] - $input['discount'];
            } else {
                $input['after_discount_price'] = $input['price'];
            }
        }

        if ($request->hasFile('image')) {
            // this code is for update later
            // if ($product->image) {
            //     Storage::disk('public')->delete($product->image);
            // }

            $input['image'] = $request->file('image')->store('products', 'public');
        }

        // Map 'category' ke 'category_id'  '
        $input['category_id'] = $input['category'];
        unset($input['category']);

        $input['created_by'] = Auth::user()->id;

        $status = Product::create($input);

        if ($status) {
            return redirect('product')->with(['success' => 'Product successfully created']);
        }

        return back()->with(['error' => 'Failed to add product']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::findOrFail($id);

        if (!$product) {
            return redirect('product')->with('error', 'Product not found');
        }

        $categories = Category::all();

        return view('products.form', [
            'result' => $product,
            'categories' => $categories,
        ]);
    }

    public function addStockProduct(Request $request, string $id)
    {
        $product = Product::findOrFail($id);

        $rules = $request->validate(
            [
                'stock' => 'required|integer|min:0,' . $id
            ]
        );


        $input = $rules;
        $input['stock'] = $input['stock'] + $product->stock;

        if ($product->update($input)) {
            return redirect('product')->with([
                'success' => 'Product Stock Successfully Updated'
            ]);
        };

        return back()->with([
            'error' => 'Failed to update Product Stock'
        ]);
    }

    public function printBarcode($id)
    {
        $product = Product::findOrFail($id);
        return view('products.print-barcode', [
            'sku' => $product->sku,
            'name' => $product->name,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = Product::findOrFail($id);

        $rules = [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category' => 'required|exists:categories,id',
            'sku' => 'required|string|max:100|unique:products,sku,' . $id,
            'stock' => 'required|integer|min:0',
            'is_discount' => 'required|boolean',
            'discount_type' => 'nullable|string|in:percent,amount',
            'discount' => 'nullable|numeric|min:0',
            'unit' => 'required|string|max:50',
            'description' => 'nullable|string',
            'is_active' => 'required|boolean',
        ];

        $input = $request->validate($rules);

        if ($input['is_discount']) {
            if ($input['discount_type'] === 'percent' && isset($input['discount'])) {
                $input['after_discount_price'] = $input['price'] - ($input['price'] * ($input['discount'] / 100));
            } elseif ($input['discount_type'] === 'amount' && isset($input['discount'])) {
                $input['after_discount_price'] = $input['price'] - $input['discount'];
            } else {
                $input['after_discount_price'] = $input['price'];
            }
        }


        if ($request->hasFile('image')) {

            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            $input['image'] = $request->file('image')->store('products', 'public');
        }

        // Map 'category' ke 'category_id'
        $input['category_id'] = $input['category'];
        unset($input['category']);


        $status = $product->update($input);

        if ($status) {
            return redirect('product')->with(['success' => 'Product successfully updated']);
        }

        return back()->with(['error' => 'Failed to update product']);
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);

        if ($product->delete()) {
            return redirect('product')->with('success', 'Product successfully deleted');
        } else {
            return back()->with('error', 'Failed to delete product');
        }
    }
}
