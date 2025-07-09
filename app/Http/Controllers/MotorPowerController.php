<?php

namespace App\Http\Controllers;

use App\Models\MotorPower;
use Illuminate\Http\Request;
use App\DGFAuth;

class MotorPowerController extends Controller
{
    private $menunum = 5023;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');

        $motorpowers = MotorPower::paginate(5);
        return view('motorpowers.index',compact('motorpowers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');

        return view('motorpowers.create');
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
            'motor_power' => 'required',
            'holar_num' => 'required',
            'power_per_hour' => 'required'
        ]);
  
        MotorPower::create($request->all());
   
        return redirect()->route('motorpowers.index')
                        ->with('success','মটরের ক্ষমতা সফলভাবে তৈরি হয়েছে');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MotorPower  $motorPower
     * @return \Illuminate\Http\Response
     */
    public function show(MotorPower $motorpower)
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');

        return view('motorpowers.show',compact('motorpower'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MotorPower  $motorPower
     * @return \Illuminate\Http\Response
     */
    public function edit(MotorPower $motorpower)
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');

        return view('motorpowers.edit',compact('motorpower'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MotorPower  $motorPower
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MotorPower $motorpower)
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');

        $request->validate([
            'motor_power' => 'required',
            'holar_num' => 'required',
            'power_per_hour' => 'required'
        ]);
  
        $motorpower->update($request->all());
  
        return redirect()->route('motorpowers.index')
                        ->with('success','মটরের ক্ষমতা সফলভাবে আপডেট হয়েছে');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MotorPower  $motorPower
     * @return \Illuminate\Http\Response
     */
    public function destroy(MotorPower $motorpower)
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');
        
        $motorpower->delete();
  
        return redirect()->route('motorpowers.index')
                        ->with('success','মটরের ক্ষমতা সফলভাবে বাদ দেওয়া হয়েছে');
    }
}
