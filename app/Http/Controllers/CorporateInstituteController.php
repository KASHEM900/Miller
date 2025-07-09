<?php

namespace App\Http\Controllers;

use App\Models\CorporateInstitute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\DGFAuth;

class CorporateInstituteController extends Controller
{
    private $menunum = 5027;

    public function index()
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');

        $corporate_institutes = CorporateInstitute::paginate(5);
        return view('corporate_institutes.index', compact('corporate_institutes'));
    }

    public function create()
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');

        return view('corporate_institutes.create');
    }

    public function store(Request $request)
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');

        $request->validate([
            'name' => 'required'
        ]);

        CorporateInstitute::create($request->all());

        return redirect()->route('corporate_institutes.index')
                        ->with('success','কর্পোরেট প্রতিষ্ঠান সফলভাবে তৈরি হয়েছে');
    }

    public function show(CorporateInstitute $corporate_institute)
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');

        return view('corporate_institutes.show',compact('corporate_institute'));
    }


    public function edit(CorporateInstitute $corporate_institute)
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');

        return view('corporate_institutes.edit',compact('corporate_institute'));
    }

    public function update(Request $request, CorporateInstitute $corporate_institute)
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');

        $request->validate([
            'name' => 'required',
        ]);

        $corporate_institute->update($request->all());

        return redirect()->route('corporate_institutes.index')
                        ->with('success','কর্পোরেট প্রতিষ্ঠান সফলভাবে আপডেট হয়েছে');
    }

    public function destroy(CorporateInstitute $corporate_institute)
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');

        $corporate_institute->delete();

        return redirect()->route('corporate_institutes.index')
                        ->with('success','কর্পোরেট প্রতিষ্ঠান সফলভাবে বাদ দেওয়া হয়েছে');
    }
}
