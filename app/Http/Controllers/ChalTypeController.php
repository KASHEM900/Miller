<?php

namespace App\Http\Controllers;

use App\Models\ChalType;
use Illuminate\Http\Request;
use App\DGFAuth;

class ChalTypeController extends Controller
{
    private $menunum = 5021;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');

        $chaltypes = ChalType::paginate(5);
        return view('chaltypes.index', compact('chaltypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');

        return view('chaltypes.create');
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
            'chal_type_name' => 'required'
        ]);
  
        ChalType::create($request->all());
   
        return redirect()->route('chaltypes.index')
                        ->with('success','নতুন চালের ধরন এন্ট্রি সাক্সেসফুল হয়েছে');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ChalType  $chalType
     * @return \Illuminate\Http\Response
     */
    public function show(ChalType $chalType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ChalType  $chalType
     * @return \Illuminate\Http\Response
     */
    public function edit(ChalType $chaltype)
    {
       if(!DGFAuth::check($this->menunum)) return view('nopermission');

        return view('chaltypes.edit', compact('chaltype'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ChalType  $chalType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ChalType $chaltype)
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');

        $request->validate([
            'chal_type_name' => 'required',
        ]);
  
        //dd($request->all());

        $chaltype->update($request->all());
  
        return redirect()->route('chaltypes.index')
                        ->with('success','আপডেট সাক্সেসফুল হয়েছে');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ChalType  $chalType
     * @return \Illuminate\Http\Response
     */
    public function destroy(ChalType $chaltype)
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');
        
        $chaltype->delete();
  
        return redirect()->route('chaltypes.index')
                        ->with('success','চালের ধরন সফলভাবে বাদ দেওয়া হয়েছে');
    }
}
