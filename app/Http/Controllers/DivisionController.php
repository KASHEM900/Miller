<?php

namespace App\Http\Controllers;

use App\Models\Division;
use Illuminate\Http\Request;
use App\DGFAuth;

use App\Exports\DivisionExport;
use Maatwebsite\Excel\Facades\Excel;

class DivisionController extends Controller
{
    private $menunum = 5011;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');

        $divisions = Division::paginate(5);
        return view('divisions.index',compact('divisions'));
    }

    public function create()
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');

        return view('divisions.create');
    }

    public function store(Request $request)
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');

        $request->validate([
            'divid' => 'required',
            'divname' => 'required',
            'name' => 'required'
        ]);

        Division::create($request->all());

        return redirect()->route('divisions.index')
                        ->with('success','বিভাগ সফলভাবে তৈরি হয়েছে');
    }

    public function show(Division $division)
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');

        return view('divisions.show',compact('division'));
    }


    public function edit(Division $division)
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');

        return view('divisions.edit',compact('division'));
    }

    public function update(Request $request, Division $division)
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');

        $request->validate([
            'divname' => 'required',
        ]);

        $division->update($request->all());

        return redirect()->route('divisions.index')
                        ->with('success','বিভাগ সফলভাবে আপডেট হয়েছে');
    }

    public function destroy(Division $division)
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');

        $division->delete();

        return redirect()->route('divisions.index')
                        ->with('success','বিভাগ সফলভাবে বাদ দেওয়া হয়েছে');
    }
}
