<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TaxRate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaxRateController extends Controller
{
    public function index()
    {
        return view('admin.taxrates.index', ['taxRates' => TaxRate::all()]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'rate' => 'required|numeric|min:0|max:100'
        ]);
        $request->merge(['user_id' => Auth::id()]);
        TaxRate::create($request->only('name', 'rate', 'description','user_id'));
        return back()->with('success', 'Tax Rate Created');
    }
}
