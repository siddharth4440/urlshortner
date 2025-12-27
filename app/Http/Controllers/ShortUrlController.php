<?php

namespace App\Http\Controllers;

use AshAllenDesign\ShortURL\Models\ShortURL;
use AshAllenDesign\ShortURL\Facades\ShortURL as ShortUrlBuilder;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;

class ShortUrlController extends Controller
{
    public function index()
    {
        $role = auth()->user()->roles()->pluck('name')->first();

        $query = new ShortURL();
        $query = ($role === 'SuperAdmin')
            ? $query
            : (
                ($role === 'Admin')
                ? $query->where('company_id', auth()->user()->company->id)
                : $query->where('user_id', auth()->user()->id)
            );

        $urls = $query->orderBy("created_at", "desc")->paginate(10);
        return view('urls.index', compact('urls'));
    }

    public function store(Request $request)
    {
        $url = ShortURL::find($request->id);

        if ($url) {
            $url->destination_url = $request->input('url');
            $url->save();

        } else {
            $shortURLObject = ShortUrlBuilder::destinationUrl($request->input('url'))
                ->beforeCreate(function (ShortURL $model) use ($request): void {
                    $model->user_id = $request->user()->id;
                    $model->company_id = $request->user()->company->id;
                })
                ->make();
        }

        return redirect()->route('urls.index');
    }

    public function destroy($id)
    {
        $shortURL = ShortURL::find($id);
        if ($shortURL) {
            $shortURL->delete();
        }
        return redirect()->route('urls.index');
    }
}
