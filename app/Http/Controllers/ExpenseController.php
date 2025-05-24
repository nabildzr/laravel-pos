<?php

namespace App\Http\Controllers;

use App\Exports\ExpenseExport;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $expenses = Expense::orderBy('created_at', 'desc')->get();
        return view('expenses.index')->with([
            'expenses' => $expenses
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('expenses.form');
    }

    public function print(Request $request)
    {
        $ids = $request->input('selected', []);
        $expenses = Expense::whereIn('id', $ids)->get();

        return view('expenses.print',)->with([
            'expenses' => $expenses
        ]);
    }

    public function export(Request $request)
    {
        $ids = $request->input('selected', []);
        return Excel::download(new ExpenseExport($ids), 'expenses.csv', \Maatwebsite\Excel\Excel::CSV);
    }

    // public function import(Request $request)
    // {
    //     $request->validate([
    //         'file' => 'required|mimes:xlsx,csv'
    //     ]);
    //     Excel::import(new ExpensesImport, $request->file('file'));
    //     return back()->with('success', 'Import berhasil!');
    // }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {


        $fields =
            [
                'category' => 'required|string',
                'amount' => 'required|numeric|min:0',
                'date' => 'required|date',
                'proof' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
                'description' => 'required|string|max:255',
            ];

        $input = $request->validate($fields);

        if ($request->hasFile('proof')) {
            $input['proof'] = $request->file('proof')->store('expenses_proof', 'public');
        }


        $input['created_by'] = Auth::user()->id;



        if (Auth::user()->role === 'owner') {
            $input['is_approved'] = true;
        }

        $status = Expense::create($input);

        if ($status) {
            return redirect('expense')->with(
                [
                    'success' => 'Expense note Successfully Created'
                ]
            );
        } else {
            return back()->with(
                ['error' => 'Failed to create Expense']
            );
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
        $result = Expense::findOrFail($id);

        return view('expenses.form')->with([
            'result' => $result
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $expense = Expense::findOrFail($id);

        $fields = [
            'category' => 'required|string',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'proof' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'description' => 'required|string|max:255',
        ];

        $input = $request->validate($fields);

        if ($request->hasFile('proof')) {
            $input['proof'] = $request->file('proof')->store('expenses_proof', 'public');
        }

        $input['updated_at'] = now();

        $status = $expense->update($input);

        if ($status) {
            return redirect('expense')->with([
                'success' => 'Expense note Successfully Updated'
            ]);
        } else {
            return back()->with([
                'error' => 'Failed to update Expense'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $expense = Expense::findOrFail($id);

        $status = $expense->delete();

        if ($status) {
            return redirect('expense')->with([
                'success' => 'Expense note Successfully Deleted'
            ]);
        } else {
            return back()->with([
                'error' => "Failed to delete {{ $expense->id }} Expense"
            ]);
        }
    }
}
