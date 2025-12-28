<?php

namespace App\Http\Controllers;

use App\Mail\InviteCreated;
use App\Models\Company;
use App\Models\Invite;
use App\Models\User;
use Auth;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('company');
        $is_super_admin = Auth::user()->hasRole('SuperAdmin');

        if (!$is_super_admin) {
            $users = $users->where('company_id', Auth::user()->company_id);
            $role = (!Auth::user()->hasRole('Admin')) ? 'Member' : ['Admin', 'Member'];
            $users = $users->role($role);
        }

        $users = $users->orderBy('name')->paginate(10);

        $companies = ($is_super_admin) ? Company::all() : Company::where('id', Auth::user()->company_id)->get();
        return view('users.index', compact('users', 'companies'));
    }

    public function store(Request $request)
    {
        $user = $request->id ? User::find($request->id) : new User();

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));
        $user->company_id = $request->input('company_id');
        $user->syncRoles($request->input('Role'));
        $user->save();

        if (!$request->id) {
            $token = \Str::random(32);

            Mail::to($user)->send(new InviteCreated($token, $user->load('company')->toArray()));
            Invite::updateOrCreate([
                'email' => $user->email,
            ], [
                'token' => $token,
                'company_id' => $user->company_id,
                'user_id' => $user->id,
            ]);
        }

        return redirect()->route('users.index');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index');
    }
}
