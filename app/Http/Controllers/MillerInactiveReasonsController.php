<?php

namespace App\Http\Controllers;

use App\Models\MillerInactiveReasons;
use Illuminate\Http\Request;
use App\DGFAuth;

class MillerInactiveReasonsController extends Controller
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

        $millerInactiveReasons = MillerInactiveReasons::paginate(5);
        return view('millerInactiveReasons.index', compact('millerInactiveReasons'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');

        return view('millerInactiveReasons.create');
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
  
        MillerInactiveReasons::create($request->all());
   
        return redirect()->route('millerInactiveReasons.index')
                        ->with('success','মিলার ইন্যাক্টিভ রিজনস এন্ট্রি সাক্সেসফুল হয়েছে');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MillerInactiveReasons  $chalType
     * @return \Illuminate\Http\Response
     */
    public function show(MillerInactiveReasons $millerInactiveReason)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MillerInactiveReasons  $chalType
     * @return \Illuminate\Http\Response
     */
    public function edit(MillerInactiveReasons $millerInactiveReason)
    {
       if(!DGFAuth::check($this->menunum)) return view('nopermission');

        return view('millerInactiveReasons.edit', compact('millerInactiveReason'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MillerInactiveReasons  $chalType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MillerInactiveReasons $millerInactiveReason)
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');

        $request->validate([
            'reason_name' => 'required',
        ]);
  
        //dd($request->all());

        $millerInactiveReason->update($request->all());
  
        return redirect()->route('millerInactiveReasons.index')
                        ->with('success','মিলার ইন্যাক্টিভ রিজনস সফলভাবে আপডেট হয়েছে');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MillerInactiveReasons  $chalType
     * @return \Illuminate\Http\Response
     */
    public function destroy(MillerInactiveReasons $millerInactiveReason)
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');
        
        $millerInactiveReason->delete();
  
        return redirect()->route('millerInactiveReasons.index')
                        ->with('success','মিলার ইন্যাক্টিভ রিজনস সফলভাবে বাদ দেওয়া হয়েছে');
    }
}
