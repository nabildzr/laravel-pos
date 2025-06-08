<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $members = Member::all();

        return view('member.index')->with([
            'members' => $members
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('member.form');
    }

    /** 
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|unique:members,phone_number',
            'email' => 'required|string|unique:members,email',
            'address' => 'required|string',
        ]);


        $rules['created_by'] = Auth::user()->id;

        $input = $rules;


        $status = Member::create($input);

        if ($status) {
            return redirect('member')->with([
                'success' => 'Member Successfully created'
            ]);
        } else {
            return back()->with([
                'error' => 'Failed to add Member'
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
        $member = Member::findOrFail($id);

        return view('member.form')->with([
            'result' =>  $member
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $member = Member::findOrFail($id);

        $rules = $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'required|numeric|unique:members,phone_number,' . $id,
            'email' => 'required|string|unique:members,email,' . $id,
            'address' => 'required|string',
        ]);

        $input = $rules;

        $status = $member->update($input);


        if ($status) {
            return redirect('member')->with([
                'success' => 'Member Successfully Updated'
            ]);
        } else {
            return back()->with([
                'error' => 'Failed to Update Member'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $member = Member::findOrFail($id);


        if ($member->delete()) {
            return redirect('member')->with([
                'success' => 'Member Successfully deleted'
            ]);
        } else {
            return  back()->with([
                'error' => 'Failed to Delete Member'
            ]);
        }
    }
}
