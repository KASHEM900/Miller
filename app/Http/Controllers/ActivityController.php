<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;
use App\DGFAuth;

use App\Exports\ActivityExport;
use Maatwebsite\Excel\Facades\Excel;

class ActivityController extends Controller
{
    private $menunum = 4070;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');

        $date_from = $request->get('date_from');
        $date_to = $request->get('date_to');
        $action_type = $request->get('action_type');
        //dd($request->all());

        if($date_from != null && $date_to != null)
            $activitys = Activity::whereBetween('created_at',[$date_from, $date_to]);
            
        else
            $activitys = [];
        
        if($date_from != null && $date_to != null && $action_type != null)
            $activitys = $activitys->where('description', $action_type);

        if($activitys != null)
        $activitys = $activitys->paginate(25);
            

        return view('activity.index',compact('activitys', 'date_from', 'date_to','action_type'));
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
    }

    public function show(Activity $activity)
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');

        return view('activitys.show',compact('activity'));
    }


    public function edit(Activity $activity)
    {
    }

    public function update(Request $request, Activity $activity)
    {
    }

    public function destroy(Activity $activity)
    {
    }
}
