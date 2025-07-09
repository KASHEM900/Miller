<?php

namespace App\Http\Controllers;

use App\Models\Inspection_period;
use Illuminate\Http\Request;
use App\DGFAuth;
use App\Models\Event;
use DB;
class Inspection_periodController extends Controller
{  
    private $menunum = 5034;

    public function index()
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');

        $inspection_periods = Inspection_period::paginate(5);
        return view('inspection_periods.index',compact('inspection_periods')); 
    }

    public function create()
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');
        return view('inspection_periods.create'); 
    }

    public function store(Request $request)
    {
        //dd($request->all());
        if(!DGFAuth::check($this->menunum)) return view('nopermission');

        $request->validate([
            'period_name' => 'required'
        ]);

        $Rperiod_start_time = $request->period_start_time;
        $Rperiod_end_time = $request->period_end_time;
        
        $inspection_periods = Inspection_period::whereBetween(
            'period_start_time',[$Rperiod_start_time, $Rperiod_end_time]) 
         ->orWhereBetween('period_end_time', [$Rperiod_start_time, $Rperiod_end_time] ) 
         ->get();

        // dd($inspection_periods);
       if(count($inspection_periods) == 0){

        if($request->isActive == 1){
            DB::table('inspection_period')->where('isActive',1)->update(['isActive' => 0]);
        }

        Inspection_period::create($request->all());
        return redirect()->route('inspection_periods.index')
           ->with('success','ইন্সপেকশন পিরিয়ড সফলভাবে তৈরি হয়েছে');
       }
       else{
        return redirect()->route('inspection_periods.index')
              ->with('success','এই তারিখটি ইতিমধ্যে বিদ্যমান');
       }
    }

    public function show(Inspection_period $inspection_period)
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');

        return view('inspection_periods.show',compact('inspection_period'));
    }

    public function edit(Inspection_period $inspection_period)
    {
       // dd($inspection_period);

        if(!DGFAuth::check($this->menunum)) return view('nopermission');

        return view('inspection_periods.edit',compact('inspection_period'));
    }

    public function update(Request $request, Inspection_period $inspection_period)
    {
        //dd($request->all());
        if(!DGFAuth::check($this->menunum)) return view('nopermission');

        $request->validate([
            'period_name' => 'required'
        ]);

        if($request->isActive == 1){
            DB::table('inspection_period')->where('isActive',1)->update(['isActive' => 0]);
        }
      
        $inspection_period->update($request->all());
        return redirect()->route('inspection_periods.index')
        ->with('success','ইন্সপেকশন পিরিয়ড সফলভাবে আপডেট হয়েছে');

    }

    public function destroy(Inspection_period $inspection_period)
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');
        
        $inspection_period->delete();
        return redirect()->route('inspection_periods.index')
                        ->with('success','ইন্সপেকশন পিরিয়ড সফলভাবে বাদ দেওয়া হয়েছে');
    }
}
