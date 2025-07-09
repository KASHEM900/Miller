<?php

namespace App\Http\Controllers;

use App\Models\Office;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Division;
use App\Models\District;
use App\Models\Upazilla;
use App\Models\Office_type;
use App\DGFAuth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class OfficeController extends Controller
{
    private $menunum = 5025;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');
        //dd($request->all());

        $division_id = $request->get('division_id');
        $district_id = $request->get('district_id');
        $upazila_id = $request->get('upazila_id');
        $office_type_id = $request->get('office_type_id');

        $office_types = Office_type::all();

        $divisions = DGFAuth::filtereddivision();// Division::all();
        if($division_id==0 && Auth::user()->division_id>0) $division_id = Auth::user()->division_id;
        if($district_id==0 && Auth::user()->district_id>0) {
            $district_id = Auth::user()->district_id;
            $districts = DB::table('district')
            ->where("distid", Auth::user()->district_id)
            ->get();
        }else{
            $districts = DB::table('district')
            ->where("divid", $division_id)
            ->get();
        }  
        if($upazila_id==0 && Auth::user()->upazila_id>0) {
            $upazila_id = Auth::user()->upazila_id;
            $upazillas = DB::table('upazilla')
            ->where("upazillaid", Auth::user()->upazila_id)
            ->get();
        }else{
            $upazillas = DB::table('upazilla')
            ->where("distId", $district_id)
            ->get();
        }    
        $offices = [];

        if($division_id && $district_id & $upazila_id) {
            $offices = Office::where("upazilla_id", $upazila_id)->get();
        }
        else if($division_id && $district_id) {
            $offices = Office::where("district_id", $district_id)->get();
        }
        else if($division_id) {
            $offices = Office::where("division_id", $division_id)->get();
        }
        else if($district_id) {
            $offices = Office::where("district_id", $district_id)->get();
        }
        else if($upazila_id) {
            $offices = Office::where("upazilla_id", $upazila_id)->get();
        }
        
  
        return view('offices.index', compact('offices','office_types','divisions','districts',
        'upazillas','division_id','district_id','upazila_id','office_type_id'));
    }

    public function filterOffices(Request $request)
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');
        //dd($request->all());
        $division_id = $request->get('division_id');
        $district_id = $request->get('district_id');
        $upazila_id = $request->get('upazila_id');
        $office_type_id = $request->get('office_type_id');

        $office_types = Office_type::all();

        $divisions = DGFAuth::filtereddivision();// Division::all();
        if($division_id==0 && Auth::user()->division_id>0) $division_id = Auth::user()->division_id;
        if($district_id==0 && Auth::user()->district_id>0) {
            $district_id = Auth::user()->district_id;
            $districts = DB::table('district')
            ->where("distid", Auth::user()->district_id)
            ->get();
        }else{
            $districts = DB::table('district')
            ->where("divid", $division_id)
            ->get();
        }  
        if($upazila_id==0 && Auth::user()->upazila_id>0) {
            $upazila_id = Auth::user()->upazila_id;
            $upazillas = DB::table('upazilla')
            ->where("upazillaid", Auth::user()->upazila_id)
            ->get();
        }else{
            $upazillas = DB::table('upazilla')
            ->where("distId", $district_id)
            ->get();
        }    
        $offices = [];

       if($office_type_id && $division_id && $district_id && $upazila_id) {
            $offices = Office::where("office_type_id", $office_type_id)
            ->where("division_id", $division_id)
            ->where("district_id", $district_id)
            ->where("upazilla_id", $upazila_id)
            ->get();
        }
        else if($office_type_id && $division_id && $district_id ) {
            $offices = Office::where("office_type_id", $office_type_id)
            ->where("division_id", $division_id)
            ->where("district_id", $district_id)
            ->get();
        }
        else if($office_type_id && $division_id) {
            $offices = Office::where("office_type_id", $office_type_id)
            ->where("division_id", $division_id)
            ->get();
        }
        else if($office_type_id) {
            $offices = Office::where("office_type_id", $office_type_id)->get();
        }

        else if($division_id && $district_id && $upazila_id) {
            $offices = Office::where("upazilla_id", $upazila_id)->get();
        }
        else if($division_id && $district_id) {
            $offices = Office::where("district_id", $district_id)->get();
        }
        else if($division_id) {
            $offices = Office::where("division_id", $division_id)->get();
        }
        else if($district_id) {
            $offices = Office::where("district_id", $district_id)->get();
        }
        else if($upazila_id) {
            $offices = Office::where("upazilla_id", $upazila_id)->get();
        }
                       
        return view('offices.index', compact('offices','office_types','divisions','districts','upazillas',
        'division_id','district_id','upazila_id','office_type_id'));
    }

    /**
     * return options for office dropdown.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function getOfficeListByOfficeTypeId(Request $request)
    {
        $office_type_id = $request->get('office_type_id');
        $data = DB::table('office')->where("office_type_id", $office_type_id)->get();
        $output = '<option value="">অফিস টাইপ</option>';
        foreach($data as $row)
        {
         $output .= '<option value="'.$row->office_type_id.'">'.$row->type_name.'</option>';
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

        $office_types = Office_type::all();
        $divisions = DGFAuth::filtereddivision();// Division::all();
        return view('offices.create', compact('office_types','divisions'));
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
            'office_name' => 'required',
            'office_type_id'=>'required'
            
        ]);
  
        office::create($request->all());
   
        return redirect()->route('offices.index')
                        ->with('success','অফিস সফলভাবে তৈরি হয়েছে');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Office  $office
     * @return \Illuminate\Http\Response
     */
    public function show(Office $office)
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');

        return view('offices.show',compact('office'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Office  $office
     * @return \Illuminate\Http\Response
     */
    public function edit(Office $office)
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');

        $divisions = DGFAuth::filtereddivision();// Division::all();
        //$divid =  $office->district->divid;

        $districts = DB::table('district')
        ->where("divid", $office->division_id)
        ->get();

        $upazillas = DB::table('upazilla')
        ->where("distid", $office->district_id)
        ->get();

        $office_types = Office_type::all();
        //$office_type_id =  $office->office_type_id;

        return view('offices.edit',compact('office', 'office_types','divisions', 'districts','upazillas'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Office  $office
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Office $office)
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');

        $request->validate([
            'office_name' => 'required',
            'office_type_id'=>'required'            
        ]);
  
  
        $office->update($request->all());
  
        return redirect()->route('offices.index')
                        ->with('success','অফিস সফলভাবে আপডেট হয়েছে');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Office  $office
     * @return \Illuminate\Http\Response
     */
    public function destroy(Office $office)
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');
        
        $office->delete();
  
        return redirect()->route('offices.index')
                        ->with('success','অফিস সফলভাবে বাদ দেওয়া হয়েছে');
    }
}
