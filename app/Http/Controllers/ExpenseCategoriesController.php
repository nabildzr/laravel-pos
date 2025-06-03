<?php

namespace App\Http\Controllers;

use App\Models\ExpenseCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $expenseCategories = ExpenseCategory::orderBy('created_at', 'desc')->get();

        return view('expense-categories.index')->with([
            'expenseCategories' => $expenseCategories
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('expense-categories.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $fields = $request->validate([
            'name' => 'string|required'
        ]);

        $fields['created_by'] = Auth::user()->id;

        $status = ExpenseCategory::create($fields);


        if ($status) {
            return redirect('expense-categories')->with([
                'success' => 'Expense Category Successfully Created'
            ]);
        } else {
            return back()->with([
                'error' => 'Failed to create Expense Category'
            ]);
        }
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
        $result = ExpenseCategory::findOrFail($id);

        return view('expense-categories.form')->with([
            'result' => $result
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $expenseCategory = ExpenseCategory::findOrFail($id);

        $fields = $request->validate([
            'name' => 'string|required'
        ]);

        $status = $expenseCategory->update($fields);

        if ($status) {
            return redirect('expense-categories')->with([
                'success' => 'Expense Category Successfully Updated'
            ]);
        } else {
            return back()->with([
                'error' => 'Failed to update Expense Category'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $expenseCategory = ExpenseCategory::findOrFail($id);
        $expenseCategory->delete();
        return redirect('expense-categories')->with([
            'success' => 'Expense Category Successfully Deleted'
        ]);
    }
}
