<?php

namespace App\Http\Controllers;

use App\Models\Upazilla;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Division;
use App\Models\District;
use App\DGFAuth;
use Illuminate\Support\Facades\Auth;

class UpazillaController extends Controller
{
    private $menunum = 5013;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');

        $division_id = $request->get('division_id');
        $district_id = $request->get('district_id');
        $searchtext = $request->get('searchtext');
        $page = $request->get('page');

        $divisions = Division::all();
        $districts = DB::table('district')
        ->where("divid", $division_id)
        ->get();       

        $upazillas = Upazilla::sortable();

        if($district_id)
            $upazillas = $upazillas->where("upazilla.distid", $district_id);
        else if($division_id)
            $upazillas = $upazillas->where("district.divid", $division_id);

        if($searchtext!=null){
            $upazillas = $upazillas->where(function ($query)use ($searchtext) {
                $query->orWhere('upazilla.name', 'like', '%'.$searchtext.'%')
                        ->orWhere('upazilla.upazillaname', 'like', '%'.$searchtext.'%');
            });
        }
    
    
        $upazillas = $upazillas->select('upazilla.*')
        ->join('district', 'upazilla.distId', '=', 'district.distid')
        ->orderBy('district.divid')->orderBy('upazilla.distid')->orderBy('upazilla.upazillaid');
        
        $upazillas = $upazillas->paginate(10);

        session()->put('pp_page', $page);
        session()->put('pp_division', $division_id);
        session()->put('pp_district', $district_id);
        session()->put('pp_searchtext', $searchtext);

        return view('upazillas.index', compact('divisions','districts','upazillas','division_id','district_id','searchtext'));
    }

    /**
     * return options for upazilla dropdown.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getUpazillaListByDistId(Request $request)
    {
        $distId = $request->get('distId');
        $query = DB::table('upazilla')
          ->where("distId", $distId);

        if(Auth::user()!=null && Auth::user()->upazila_id>0)
            $query = $query->where("upazillaid", Auth::user()->upazila_id);
        $data = $query->get();

        $output = '<option value="">উপজেলা</option>';
        foreach($data as $row)
        {
            $output .= '<option value="'.$row->upazillaid.'">'.$row->upazillaname.'</option>';
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
        return view('upazillas.create', compact('divisions'));
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
            'upazillaname' => 'required',
            'distid' => 'required',
            'name' => 'required'
        ]);
        //dd($request->all());
        Upazilla::create($request->all());
   
        return redirect()->route('upazillas.index')
                        ->with('success','উপজেলা সফলভাবে তৈরি হয়েছে');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Upazilla  $upazilla
     * @return \Illuminate\Http\Response
     */
    public function show(Upazilla $upazilla)
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');

        return view('upazillas.show',compact('upazilla'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Upazilla  $upazilla
     * @return \Illuminate\Http\Response
     */
    public function edit(Upazilla $upazilla)
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');

        $divisions = DGFAuth::filtereddivision();// Division::all();
        $divid =  $upazilla->district->divid;  
        
        if(Auth::user()->division_id>0)
            $districts = DB::table('district')->where("divid", Auth::user()->division_id)->get();
        else
            $districts = District::all();
        
        $distid = $upazilla->distid;    
        
        $pp_page = session()->get('pp_page');
        $pp_division = session()->get('pp_division');
        $pp_district = session()->get('pp_district');        
        $pp_searchtext = session()->get('pp_searchtext');

        return view('upazillas.edit',compact('upazilla', 'divisions', 'districts', 'divid', 'distid','pp_page','pp_division','pp_district','pp_searchtext'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Upazilla  $upazilla
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Upazilla $upazilla)
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');

        $request->validate([
            'upazillaname' => 'required',
            'distid' => 'required'
        ]);
  
  
        $upazilla->update($request->all());
  
        $pp_page = session()->get('pp_page');
        $pp_division = session()->get('pp_division');
        $pp_district = session()->get('pp_district');        
        $pp_searchtext = session()->get('pp_searchtext');

        return redirect()->route('upazillas.index', ['page'=> $pp_page, 'division_id'=> $pp_division, 'district_id'=> $pp_district, 'searchtext'=> $pp_searchtext])
                        ->with('success','উপজেলা সফলভাবে আপডেট হয়েছে');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Upazilla  $upazilla
     * @return \Illuminate\Http\Response
     */
    public function destroy(Upazilla $upazilla)
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');
        
        $upazilla->delete();
  
        $pp_page = session()->get('pp_page');
        $pp_division = session()->get('pp_division');
        $pp_district = session()->get('pp_district');        
        $pp_searchtext = session()->get('pp_searchtext');

        return redirect()->route('upazillas.index', ['page'=> $pp_page, 'division_id'=> $pp_division, 'district_id'=> $pp_district, 'searchtext'=> $pp_searchtext])
                        ->with('success','উপজেলা সফলভাবে বাদ দেওয়া হয়েছে');
    }
}
