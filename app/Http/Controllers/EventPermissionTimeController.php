<?php

namespace App\Http\Controllers;

use App\Models\EventPermissionTime;
use Illuminate\Http\Request;
use App\DGFAuth;
use App\Models\Event;

class EventPermissionTimeController extends Controller
{
    private $menunum = 5034;

    public function index()
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');
        $events = Event::all();
        $eventPermissionTimes = EventPermissionTime::paginate(5);
        return view('eventPermissionTimes.index',compact('eventPermissionTimes','events')); 
    }

    public function create()
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');
        $events = Event::all();
        return view('eventPermissionTimes.create',compact('events')); 
    }

    public function store(Request $request)
    {
        //dd($request->all());
        if(!DGFAuth::check($this->menunum)) return view('nopermission');

        $request->validate([
            'event_id' => 'required',
            'perm_start_time' => 'required',
            'perm_end_time' => 'required'
        ]);

        EventPermissionTime::create($request->all());
        return redirect()->route('eventPermissionTimes.index')
                        ->with('success','ইভেন্টস পারমিশন সময়নিরুপণ সফলভাবে তৈরি হয়েছে');
    }

    public function show(EventPermissionTime $eventPermissionTime)
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');

        return view('eventPermissionTimes.show',compact('eventPermissionTime'));
    }

    public function edit(EventPermissionTime $eventPermissionTime)
    {
       // dd($eventPermissionTime);

        if(!DGFAuth::check($this->menunum)) return view('nopermission');

        $events = Event::all();

        return view('eventPermissionTimes.edit',compact('eventPermissionTime','events'));
    }

    public function update(Request $request, EventPermissionTime $eventPermissionTime)
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');

        $request->validate([
            'event_id' => 'required',
            'perm_start_time' => 'required',
            'perm_end_time' => 'required'
        ]);
        $eventPermissionTime->update($request->all());
        return redirect()->route('eventPermissionTimes.index')
                        ->with('success','ইভেন্টস পারমিশন সময়নিরুপণ সফলভাবে আপডেট হয়েছে');
    }

    public function destroy(EventPermissionTime $eventPermissionTime)
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');
        
        $eventPermissionTime->delete();
        return redirect()->route('eventPermissionTimes.index')
                        ->with('success','ইভেন্টস পারমিশন সময়নিরুপণ সফলভাবে বাদ দেওয়া হয়েছে');
    }
}
