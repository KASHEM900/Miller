<?php

namespace App\Http\Controllers;

use App\Models\MillType;
use Illuminate\Http\Request;
use App\DGFAuth;

class MillTypeController extends Controller
{
    private $menunum = 5022;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');

        $millTypes = MillType::orderby('ordering')->paginate(5);
        return view('milltypes.index',compact('millTypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');

        return view('milltypes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');

        $request->validate([
            'mill_type_name' => 'required'
        ]);

        MillType::create($request->all());

        return redirect()->route('milltypes.index')
                        ->with('success','মিলার টাইপ সফলভাবে তৈরি হয়েছে');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MillType  $millType
     * @return \Illuminate\Http\Response
     */
    public function show(MillType $milltype)
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');

        return view('milltypes.show',compact('milltype'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MillType  $millType
     * @return \Illuminate\Http\Response
     */
    public function edit(MillType $milltype)
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');

        return view('milltypes.edit',compact('milltype'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MillType  $millType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MillType $milltype)
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');

        $request->validate([
            'mill_type_name' => 'required',
        ]);

        $milltype->update($request->all());

        return redirect()->route('milltypes.index')
                        ->with('success','মিলার টাইপ সফলভাবে আপডেট করা হয়েছে');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MillType  $millType
     * @return \Illuminate\Http\Response
     */
    public function destroy(MillType $milltype)
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');

        $milltype->delete();

        return redirect()->route('milltypes.index')
                        ->with('success','মিলার টাইপ সফলভাবে বাদ দেওয়া হয়েছে');
    }
}
