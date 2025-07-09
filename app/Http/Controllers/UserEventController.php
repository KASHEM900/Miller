<?php

namespace App\Http\Controllers;

use App\Models\UserEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Models\Division;
use App\Models\Event;
use App\DGFAuth;

class UserEventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserEvent  $userEvent
     * @return \Illuminate\Http\Response
     */
    public function show(UserEvent $userevent)
    {
        //
        dd('2');
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UserEvent  $userEvent
     * @return \Illuminate\Http\Response
     */
    public function edit(UserEvent $userEvent)
    {
        //
        dd('1');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserEvent  $userEvent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserEvent $userevent)
    {
        if(!DGFAuth::check(2021)) return view('nopermission');
        
        $userevent = UserEvent::find($userevent->id);

        $userevent->view_per = $request->has('view_per');
        $userevent->add_per = $request->has('add_per');
        $userevent->delete_per = $request->has('delete_per');
        $userevent->edit_per = $request->has('edit_per');
        $userevent->apr_per = $request->has('apr_per');
        
        $userevent->save();

        $user = User::find($userevent->a_id);
        $user->active_status = $request->has('active_status');
        $user->save();
        
        return redirect()->route('showpermission');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserEvent  $userEvent
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserEvent $userEvent)
    {
        //
    }

    /**
     * return options for upazilla dropdown.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function userpermissionlist(Request $request)
    {
        if(!DGFAuth::check(2021)) return view('nopermission');

        $division_id = $request->get('division_id');//division_id
        $district_id = $request->get('district_id');//district_id
        $event_id = $request->get('event_id');        

        if($district_id==null){
            $userEvents = DB::table('user_event')
                ->select("user_event.*", "users.name", "users.active_status", "event.event_name", 'user_type.name AS user_type', "upazilla.upazillaname")
                ->join('users', 'users.id', '=', 'user_event.a_id')
                ->join('event', 'event.event_id', '=', 'user_event.event_id')
                ->join('user_type', 'user_type.id', '=', 'users.user_type')
                ->leftJoin('upazilla', 'upazilla.upazillaid', '=', 'users.upazila_id')
                ->where("user_event.event_id", $event_id)
                ->where("users.division_id", $division_id)
                ->paginate(10);
        }else{
            $userEvents = DB::table('user_event')
                ->select("user_event.*", "users.name", "users.active_status", "event.event_name", 'user_type.name AS user_type', "upazilla.upazillaname")
                ->join('users', 'users.id', '=', 'user_event.a_id')
                ->join('event', 'event.event_id', '=', 'user_event.event_id')
                ->join('user_type', 'user_type.id', '=', 'users.user_type')
                ->leftJoin('upazilla', 'upazilla.upazillaid', '=', 'users.upazila_id')
                ->where("user_event.event_id", $event_id)
                ->where("users.division_id", $division_id)
                ->where("users.district_id", $district_id)             
                ->paginate(10);
        }

        //dd($userEvents->all());
        $divisions = DGFAuth::filtereddivision();// Division::all();
        $districts = DB::table('district')
        ->where("divid", $division_id)
        ->get();
        $events = Event::all();

        return view('users.userpermission', compact('divisions', 'districts', 'events', 'userEvents','division_id','district_id', 'event_id'));
        
    }


    public function showpermission(Request $request)
    {
        if(!DGFAuth::check(2021)) return view('nopermission');

        $division_id = $request->get('division_id');//division_id
        $district_id = $request->get('district_id');//district_id
        $event_id = $request->get('event_id');        

        if($district_id==null){
            $userEvents = DB::table('user_event')
                ->select("user_event.*", "users.name", "users.active_status", "event.event_name", 'user_type.name AS user_type')
                ->join('users', 'users.id', '=', 'user_event.a_id')
                ->join('event', 'event.event_id', '=', 'user_event.event_id')
                ->join('user_type', 'user_type.id', '=', 'users.user_type')
                ->where("user_event.event_id", $event_id)
                ->where("users.division_id", $division_id)
                ->paginate(10);
        }else{
            $userEvents = DB::table('user_event')
                ->select("user_event.*", "users.name", "users.active_status", "event.event_name", 'user_type.name AS user_type')
                ->join('users', 'users.id', '=', 'user_event.a_id')
                ->join('event', 'event.event_id', '=', 'user_event.event_id')
                ->join('user_type', 'user_type.id', '=', 'users.user_type')
                ->where("user_event.event_id", $event_id)
                ->where("users.division_id", $division_id)
                ->where("users.district_id", $district_id)             
                ->paginate(10);
        }


        $divisions = DGFAuth::filtereddivision();// Division::all();
        $districts = DB::table('district')
        ->where("divid", $division_id)
        ->get();
        $events = Event::all();

        return view('users.userpermission', compact('divisions', 'districts', 'events', 'userEvents','division_id','district_id', 'event_id'));
        
    }
}
