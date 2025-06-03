<?php

namespace App\Http\Controllers;

use App\Models\DiningTable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DiningTableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tables = DiningTable::orderBy('created_at', 'desc')->get();

        return view('diningtables.index')->with([
            'tables' => $tables
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('diningtables.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|string|in:available,occupied,reserved',
            'capacity' => 'required|integer|min:1',
        ]);

        $fields['created_by'] = Auth::user()->id;

        $status = DiningTable::create($fields);

        if ($status) {
            return redirect('tables')->with(
                [
                    'success' => 'Dining Table Successfully Created'
                ]
            );
        } else {
            return back()->with(
                ['error' => 'Failed to create Dining Table']
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
        $result = DiningTable::findOrFail($id);

        return view('diningtables.form')->with([
            'result' => $result
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $table = DiningTable::findOrFail($id);

        $fields = $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|string|in:available,occupied,reserved',
            'capacity' => 'required|integer|min:1|max:50',
        ]);

        $status = $table->update($fields);

        if ($status) {
            return redirect('tables')->with(
                [
                    'success' => 'Dining Table Successfully Updated'
                ]
            );
        } else {
            return back()->with(
                ['error' => 'Failed to update Dining Table']
            );
        } 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $result = DiningTable::findOrFail($id);
        
        $result->delete();

        return redirect('tables')->with([
            'success' => 'Dining Table Successfully Deleted'
        ]);
    }
}
