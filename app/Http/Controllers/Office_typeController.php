<?php

namespace App\Http\Controllers;

use App\Models\Office_type;
use Illuminate\Http\Request;
use App\DGFAuth;

class Office_typeController extends Controller
{
    private $menunum = 5024;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');

        $office_types = Office_type::paginate(5);
        return view('office_types.index',compact('office_types')); 
    }

    public function create()
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');

        return view('office_types.create');
    }
    
    public function store(Request $request)
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');

        $request->validate([
            'type_name' => 'required'
        ]);
  
        Office_type::create($request->all());
   
        return redirect()->route('office_types.index')
                        ->with('success','অফিস টাইপ সফলভাবে তৈরি হয়েছে');
    }

    public function show(Office_type $office_type)
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');

        return view('office_types.show',compact('office_type'));
    }


    public function edit(Office_type $office_type)
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');

        return view('office_types.edit',compact('office_type'));
    }

    public function update(Request $request, Office_type $office_type)
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');

        $request->validate([
            'type_name' => 'required',
        ]);
  
        $office_type->update($request->all());
  
        return redirect()->route('office_types.index')
                        ->with('success','অফিস টাইপ সফলভাবে আপডেট হয়েছে');
    }

    public function destroy(Office_type $office_type)
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');
        
        $office_type->delete();
  
        return redirect()->route('office_types.index')
                        ->with('success','অফিস টাইপ সফলভাবে বাদ দেওয়া হয়েছে');
    }
    
}
