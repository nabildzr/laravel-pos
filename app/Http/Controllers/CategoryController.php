<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::orderBy('created_at', 'desc')->get();

        return view('categories.index')->with(['categories' => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return  view('categories.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = $request->validate([
            'name' => 'required|unique:categories',
            'description' => 'required|max:255'
        ]);

        $rules['created_by'] = Auth::user()->id;

        $input = $rules;

        $status = Category::create($input);

        if ($status) {
            return redirect('category')->with('success', 'Category successfully added');
        } else {
            return back()->with('error', 'Failed to add category');
        }
    }

    public function search(Request $request)
    {
        $query = $request->get('query', '');
        $categories = Category::where('name', 'LIKE', "%{$query}%")->get();

        return response()->json($categories);
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
        $data['result'] = Category::findOrFail($id);

        //redirect ke halaman kategori
        if (!$data['result']) {
            return redirect('category')->with('error', 'Category not found');
        }

        return view('categories.form')->with($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $category = Category::findOrFail($id);


        $rules = $request->validate([
            'name' => 'required|unique:categories,name,' . $id,
            'description' => 'required|max:255'
        ]);

        $input = $rules;

        $status = $category->update($input);

        if ($status) {
            return redirect('category')->with('success', 'Category successfully updated');
        } else {
            return back()->with('error', 'Failed to add category');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);

        if ($category->product()->count() > 0) {
            return redirect()->back()->with('error', 'Cannot delete category because it has related products.');
        }

        if ($category->delete()) {
            return redirect('category')->with('success', 'Category successfully deleted');
        } else {
            return back()->with('error', 'Failed to delete category');
        }
    }
}
