<?php

namespace App\Http\Controllers;

use App\Models\District;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Division;
use App\DGFAuth;
use Illuminate\Support\Facades\Auth;

class DistrictController extends Controller
{
    private $menunum = 5012;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');

        $districts = District::paginate(5);
        return view('districts.index', compact('districts'));
    }

    /**
     * return options for upazilla dropdown.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getDistrictListByDivId(Request $request)
    {     
        $divId = $request->get('divId');
        $query = DB::table('district')
          ->where("divid", $divId);
        
        if(Auth::user()!=null && Auth::user()->district_id>0)
            $query = $query->where("distid", Auth::user()->district_id);
        
        $data = $query->get();

        $output = '<option value="">জেলা</option>';
        foreach($data as $row)
        {
            $output .= '<option value="'.$row->distid.'">'.$row->distname.'</option>';
        }
        echo $output;
    }

    public function getAllDistrict(Request $request)
    {
        //$divId = $request->get('divId');
        $query = DB::table('district');
        
        if(Auth::user()!=null && Auth::user()->district_id>0)
            $query = $query->where("distid", Auth::user()->district_id);
        
        $data = $query->get();

        $output = '<option value="">জেলা</option>';
        foreach($data as $row)
        {
            $output .= '<option value="'.$row->distid.'">'.$row->distname.'</option>';
        }
        echo $output;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');

        $divisions = DGFAuth::filtereddivision();// Division::all();
        return view('districts.create', compact('divisions'));
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
            'divid' => 'required',
            'distname' => 'required',
            'name' => 'required'
        ]);
  
        district::create($request->all());
   
        return redirect()->route('districts.index')
                        ->with('success','জেলা সফলভাবে তৈরি হয়েছে');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\District  $district
     * @return \Illuminate\Http\Response
     */
    public function show(District $district)
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');

        return view('districts.show',compact('district'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\District  $district
     * @return \Illuminate\Http\Response
     */
    public function edit(District $district)
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');

        $divisions = DGFAuth::filtereddivision();// Division::all();
        $divid =  $district->divid;
        return view('districts.edit',compact('district', 'divisions', 'divid'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\District  $district
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, District $district)
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');

        $request->validate([
            'divid' => 'required',
            'distname' => 'required'
        ]); 


        $district->update($request->all());
  
        return redirect()->route('districts.index')
                        ->with('success','জেলা সফলভাবে আপডেট হয়েছে');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\District  $district
     * @return \Illuminate\Http\Response
     */
    public function destroy(District $district)
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');
        
        $district->delete();
  
        return redirect()->route('districts.index')
                        ->with('success','জেলা সফলভাবে বাদ দেওয়া হয়েছে');
    }
}
