<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use App\DGFAuth;

class EventController extends Controller
{
    private $menunum = 5031;

    public function index()
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');

        $events = Event::paginate(5);
        return view('events.index',compact('events')); 
    }

    public function create()
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');

        return view('events.create');
    }

    public function store(Request $request)
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');

        $request->validate([
            'event_name' => 'required'
        ]);

        Event::create($request->all());
        return redirect()->route('events.index')
                        ->with('success','ইভেন্ট সফলভাবে তৈরি হয়েছে');
    }

    public function show(Event $event)
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');

        return view('events.show',compact('event'));
    }

    public function edit(Event $event)
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');

        return view('events.edit',compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');

        $request->validate([
            'event_name' => 'required',
        ]);
        $event->update($request->all());
        return redirect()->route('events.index')
                        ->with('success','ইভেন্ট সফলভাবে আপডেট হয়েছে');
    }

    public function destroy(Event $event)
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');
        
        $event->delete();
        return redirect()->route('events.index')
                        ->with('success','ইভেন্ট সফলভাবে বাদ দেওয়া হয়েছে');
    }
}
