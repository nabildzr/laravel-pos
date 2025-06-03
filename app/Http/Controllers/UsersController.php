<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    public function codeGenerator()
    {
        return view('aiapplication/codeGenerator');
    }

    public function addUser()
    {



        return view('users/addUser');
    }

    public function store(Request $request)
    {
        $field = $request->validate([
            'full_name',
            'email',
            'phone',
            'address',
            'description'
        ]);


        $field['created_by'] = Auth::user()->id;
    }

    public function usersGrid()
    {
        return view('users/usersGrid');
    }

    public function usersList()
    {
        $users = User::orderBy('created_at', 'desc')->get();
        
        return view('users/usersList')->with([
            'users' => $users
        ]);
    }

    public function viewProfile(Request $request)
    {
        $user = Auth::user();

        return view('users/viewProfile')->with(['user' => $user]);
    }
}
