<?php

namespace App\Http\Controllers;

use AshAllenDesign\ShortURL\Models\ShortURL;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
        public function index()
        {
            $urls = ShortURL::orderBy("created_at","desc")->paginate(10);
            return view('dashboard.index', compact('urls'));
        }
}
