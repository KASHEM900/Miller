<?php

namespace App\Http\Controllers;

use App\Models\LicenseType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\DGFAuth;

class LicenseTypeController extends Controller
{
    private $menunum = 5027;

    public function index()
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');

        $license_types = LicenseType::paginate(5);
        return view('license_types.index', compact('license_types'));
    }

    public function create()
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');

        return view('license_types.create');
    }

    public function store(Request $request)
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');

        $request->validate([

            'name' => 'required'
        ]);

        LicenseType::create($request->all());

        return redirect()->route('license_types.index')
                        ->with('success','লাইসেন্স টাইপ সফলভাবে তৈরি হয়েছে');
    }

    public function show(LicenseType $license_type)
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');

        return view('license_types.show',compact('license_type'));
    }


    public function edit(LicenseType $license_type)
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');

        return view('license_types.edit',compact('license_type'));
    }

    public function update(Request $request, LicenseType $license_type)
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');

        $request->validate([
            'name' => 'required',
        ]);

        $license_type->update($request->all());

        return redirect()->route('license_types.index')
                        ->with('success','লাইসেন্স টাইপ সফলভাবে আপডেট হয়েছে');
    }

    public function destroy(LicenseType $license_type)
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');

        $license_type->delete();

        return redirect()->route('license_types.index')
                        ->with('success','লাইসেন্স টাইপ সফলভাবে বাদ দেওয়া হয়েছে');
    }
}
