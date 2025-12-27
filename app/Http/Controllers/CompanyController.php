<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = Company::all();
        return view('companies.index', compact('companies'));
    }

    public function store(Request $request)
    {
        $company = $request->id ? Company::find($request->id) : new Company();

        $company->title = $request->input('title');
        $company->save();

        return redirect()->route('companies.index');
    }

    public function delete($id)
    {
        $company = Company::findOrFail($id);
        $company->delete();

        return redirect()->route('companies.index');
    }
}
