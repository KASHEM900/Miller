<?php

namespace App\Http\Controllers;

use App\Models\Registration_permission_time;
use Illuminate\Http\Request;
use App\DGFAuth;
use DateTime;

class Registration_permission_timeController extends Controller
{
    private $menunum = 5035;

    public function index()
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');

        $registration_permission_times = Registration_permission_time::paginate(5);
        return view('registration_permission_times.index',compact('registration_permission_times')); 
    }

    public function create()
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');

        return view('registration_permission_times.create'); 
    }

    public function store(Request $request)
    {
        //dd($request->all());
        $period_end_time = $request->period_end_time;
        $timeSpan = "23:59:59";
        $period_end_time = $period_end_time.$timeSpan ;

        if(!DGFAuth::check($this->menunum)) return view('nopermission');

        $request->validate([
            'perm_start_time' => 'required',
            'period_end_time' => 'required'
        ]);

        Registration_permission_time::create(
            ["perm_start_time"=> $request->perm_start_time, "period_end_time"=> $period_end_time]
        );

        return redirect()->route('registration_permission_times.index')
                        ->with('success','রেজিস্ট্রেশন সময়নিরুপণ সফলভাবে তৈরি হয়েছে');
    }

    public function show(Registration_permission_time $registration_permission_time)
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');

        return view('registration_permission_times.show',compact('registration_permission_time'));
    }

    public function edit(Registration_permission_time $registration_permission_time)
    {
       // dd($registration_permission_time);

        if(!DGFAuth::check($this->menunum)) return view('nopermission');

        return view('registration_permission_times.edit',compact('registration_permission_time'));
    }

    public function update(Request $request, Registration_permission_time $registration_permission_time)
    {
        //dd($request->all());
        if(!DGFAuth::check($this->menunum)) return view('nopermission');

        $period_end_time = $request->period_end_time;
        
        $period_end_time1 = new DateTime($period_end_time);
        $period_end_time2 = $period_end_time1->format("Y-m-d");


        $timeSpan = "23:59:59";
        $period_end_time = $period_end_time2.$timeSpan ;

        $request->validate([
            'perm_start_time' => 'required',
            'period_end_time' => 'required'
        ]);
        $registration_permission_time->update( 
            ["id"=> $request->id,"perm_start_time"=> $request->perm_start_time, "period_end_time"=> $period_end_time]
        );

        return redirect()->route('registration_permission_times.index')
                        ->with('success','রেজিস্ট্রেশন সময়নিরুপণ সফলভাবে আপডেট হয়েছে');
    }

    public function destroy(Registration_permission_time $registration_permission_time)
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');
        
        $registration_permission_time->delete();
        return redirect()->route('registration_permission_times.index')
                        ->with('success','রেজিস্ট্রেশন সময়নিরুপণ সফলভাবে বাদ দেওয়া হয়েছে');
    }
}
