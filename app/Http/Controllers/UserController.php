<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('company');
        if (!Auth::user()->hasRole('SuperAdmin')) {
            $users = $users->where('company_id', Auth::user()->company_id);
            $role = (!Auth::user()->hasRole('Admin')) ? 'Member' : ['Admin', 'Member'];
            $users = $users->role($role);
        }
        $users = $users->get();

        $companies = Company::all();
        return view('users.index', compact('users', 'companies'));
    }

    public function store(Request $request)
    {
        $user = $request->id ? User::find($request->id) : new User();

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));
        $user->company_id = $request->input('company_id');
        $user->assignRole($request->input('Role'));
        $user->save();

        return redirect()->route('users.index');
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index');
    }
}
