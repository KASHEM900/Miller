<?php

namespace App\Http\Controllers;

use App\Models\MillingUnitMachinery;
use Illuminate\Http\Request;
use App\DGFAuth;

class MillingUnitMachineryController extends Controller
{
    private $menunum = 5029;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');

        $millingUnitMachineries = MillingUnitMachinery::orderby('ordering')->paginate(5);
        return view('millingunitmachineries.index',compact('millingUnitMachineries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');

        return view('millingunitmachineries.create');
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
            'name' => 'required'
        ]);

        MillingUnitMachinery::create($request->all());

        return redirect()->route('millingunitmachineries.index')
                        ->with('success','মিলিং ইউনিটের যন্ত্রপাতি সফলভাবে তৈরি হয়েছে');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MillingUnitMachinery  $millingunitmachinery
     * @return \Illuminate\Http\Response
     */
    public function show(MillingUnitMachinery $millingunitmachinery)
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');

        return view('millingunitmachineries.show',compact('millingunitmachinery'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MillingUnitMachinery  $millingunitmachinery
     * @return \Illuminate\Http\Response
     */
    public function edit(MillingUnitMachinery $millingunitmachinery)
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');

        return view('millingunitmachineries.edit',compact('millingunitmachinery'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MillingUnitMachinery  $millingunitmachinery
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MillingUnitMachinery $millingunitmachinery)
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');

        $request->validate([
            'name' => 'required',
        ]);

        $millingunitmachinery->update($request->all());

        return redirect()->route('millingunitmachineries.index')
                        ->with('success','মিলিং ইউনিটের যন্ত্রপাতি সফলভাবে আপডেট করা হয়েছে');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MillingUnitMachinery  $millingunitmachinery
     * @return \Illuminate\Http\Response
     */
    public function destroy(MillingUnitMachinery $millingunitmachinery)
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');

        $millingunitmachinery->delete();

        return redirect()->route('millingunitmachineries.index')
                        ->with('success','মিলিং ইউনিটের যন্ত্রপাতি সফলভাবে বাদ দেওয়া হয়েছে');
    }
}
