<?php

namespace App\Http\Controllers;

use App\Models\Invite;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InviteController extends Controller
{
    public function acceptInvite($token)
    {
        $invite = Invite::where("token", $token)->first();

        if (!$invite) {
            return redirect()->route('login')->withErrors(['msg' => 'Invalid invite link']);
        }

        // Automatically log in the user
        Auth::loginUsingId($invite->user_id);
        $update = User::where('id', $invite->user_id)->update(['invitation_accepted' => true, 'email_verified_at' => now()]);

        // Delete the invite
        $invite->delete();

        return redirect()->route('urls.index')->with('success', 'Invite accepted successfully');
    }
}
