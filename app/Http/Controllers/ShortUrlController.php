<?php

namespace App\Http\Controllers;

use App\Models\Company;
use AshAllenDesign\ShortURL\Classes\Builder;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;

class ShortUrlController extends Controller
{
    public function store(Request $request)
    {
        $shortURLObject = app(Builder::class)
            ->destinationUrl($request->input("url"))
            ->make();

        $shortURL = $shortURLObject->default_short_url;
        return redirect()->route('users.index');
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index');
    }
}
