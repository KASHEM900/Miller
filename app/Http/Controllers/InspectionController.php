<?php

namespace App\Http\Controllers;

use App\Models\Inspection;
use App\Models\InspChatalDetail;
use App\Models\InspMotorDetail;
use App\Models\InspGodownDetail;
use App\Models\InspSteepingHouseDetail;
use App\Models\InspBoilerDetail;
use App\Models\InspDryerDetail;
use App\Models\InspMillBoilerMachineries;
use App\Models\InspMillMillingUnitMachineries;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Division;
use App\Models\District;
use App\Models\Upazilla;
use App\Models\Inspection_period;
use App\Models\InactiveReason;
use App\Models\Miller;
use App\DGFAuth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Util\FPSHelper;
use Image;

class InspectionController extends Controller
{
    private $menunum = 4030;
    private $fps;

    public function __construct(FPSHelper $fps)
    {
    	$this->fps = $fps;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');

        $page = $request->get('page');

        $mill_upazila_id = $request->get('mill_upazila_id');
        $division_id = $request->get('division_id');
        $district_id = $request->get('district_id');
        $inspection_period_id = $request->get('inspection_period_id');
        $inactive_reason = $request->get('inactive_reason');
        $owner_type = $request->get('owner_type');

        $inspection_status = $request->get('inspection_status');
        $cause_of_inspection = $request->get('cause_of_inspection');
        $inspection_periods = Inspection_period::all();
        $inactive_reasons = InactiveReason::all()->except(2);

        $divisions = DGFAuth::filtereddivision();
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
        if($mill_upazila_id==0 && Auth::user()->upazila_id>0) {
            $mill_upazila_id = Auth::user()->upazila_id;
            $upazillas = DB::table('upazilla')
            ->where("upazillaid", Auth::user()->upazila_id)
            ->get();
        }else{
            $upazillas = DB::table('upazilla')
            ->where("distId", $district_id)
            ->get();
        }

        $millers = DB::table('miller')
        ->select("miller.*", "miller.mill_name","miller.mill_address","miller.owner_name","owner_address",
        "miller_birth_place","miller_nationality","miller_religion",
        "inspection.id as inspection_id","inspection.inspection_status","inspection.cause_of_inspection","inspection.inspection_date",
        "inspection_period.period_name","inspection.inspection_document","inspection.approval_status")

        ->leftJoin('inspection', 'inspection.miller_id', '=', 'miller.miller_id')
        ->leftJoin('inspection_period', 'inspection_period.id', '=', 'inspection.inspection_period_id');

        if($division_id)
            $millers = $millers->where("miller.division_id", $division_id);
        if($district_id)
            $millers = $millers->where("miller.district_id", $district_id);
        if($mill_upazila_id)
            $millers = $millers->where("miller.mill_upazila_id", $mill_upazila_id);
        if($inspection_status)
            $millers = $millers->where("inspection.inspection_status", $inspection_status);
        if($inactive_reason)
            $millers = $millers->where("inspection.inactive_reason", $inactive_reason);
        if($cause_of_inspection == "new_register")
            $millers = $millers->where("miller.miller_status", "new_register");

            if($owner_type!=null)
            $millers = $millers->where("owner_type", $owner_type);

        $millers = $millers->where(
            function($query)  use ($inspection_period_id) {
                $query->where("inspection_period.id", $inspection_period_id)
                ->orWhere("inspection_period.id", null);
            }
        );

        $millers = $millers->paginate(25);

        if(!$inspection_period_id)
            $millers = [];

        session()->put('pp_page', $page);
        session()->put('pp_division', $division_id);
        session()->put('pp_district', $district_id);
        session()->put('pp_mill_upazila', $mill_upazila_id);
        session()->put('pp_inspection_period', $inspection_period_id);
        session()->put('pp_inspection_status', $inspection_status);
        session()->put('pp_cause_of_inspection', $cause_of_inspection);
        session()->put('pp_owner_type', $owner_type);
        

        return view('inspections.index', compact('millers','divisions','districts','upazillas','inspection_periods',
        'division_id','district_id', 'mill_upazila_id','inspection_period_id', 'inactive_reasons', 'inactive_reason', 'inspection_status','cause_of_inspection','owner_type'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if(!DGFAuth::check2(1,  1)) return view('nopermission');

        $pp_page = session()->get('pp_page');
        $pp_inspection_period = session()->get('pp_inspection_period');
        $pp_inspection_status = session()->get('pp_inspection_status');
        $pp_cause_of_inspection = session()->get('pp_cause_of_inspection');
        $pp_division = session()->get('pp_division');
        $pp_district = session()->get('pp_district');
        $pp_mill_upazila = session()->get('pp_mill_upazila');

        $inspection_period_id = $request->query('inspection_period_id');
        $inspection_period = Inspection_period::find($inspection_period_id);
        $inspection_period_name = $inspection_period ? $inspection_period->period_name : '';

        $miller_id = $request->query('miller_id');

        $miller = Miller::find($miller_id);

        $cause_of_inspection = $miller->miller_status == "new_register" ? "নতুন নিবন্ধন" : "শিডিউল চেক";

        $inspection_periods = Inspection_period::all();
        $inactive_reasons = InactiveReason::all()->except(2);

        return view('inspections.create', compact('inspection_periods', 'inactive_reasons', 'miller','inspection_period_id','inspection_period_name', 'cause_of_inspection','pp_page','pp_inspection_period','pp_inspection_status','pp_cause_of_inspection','pp_division','pp_district','pp_mill_upazila'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!DGFAuth::check2(1,  1)) return view('nopermission');

        $miller_id = $request->get('miller_id');
        $miller = Miller::find($miller_id);

        $inspection = Inspection::create($request->all());

        $inspection->insp_miller()->create($request->all());

        if(isset($request->pro_flowdiagram_status)){
            $inspection->insp_autometic_miller()->create($request->all());
        }

        for ($i = 1; $i <= $miller->chatal_num; $i++ ) {
            $inspection->insp_chatal_details()->create(['chatal_id' => $request->get('chatal_id'.$i), 'chatal_long_status' => $request->get('chatal_long_status'.$i), 'chatal_long_comment' => $request->get('chatal_long_comment'.$i)]);
        }

        for ($i = 1; $i <= $miller->steeping_house_num; $i++ ) {
            $inspection->insp_steeping_house_details()->create(['steeping_house_id' => $request->get('steeping_house_id'.$i), 'steeping_house_long_status' => $request->get('steeping_house_long_status'.$i), 'steeping_house_long_comment' => $request->get('steeping_house_long_comment'.$i)]);
        }

        for ($i = 1; $i <= $miller->godown_num; $i++ ) {
            $inspection->insp_godown_details()->create(['godown_id' => $request->get('godown_id'.$i), 'godown_long_status' => $request->get('godown_long_status'.$i), 'godown_long_comment' => $request->get('godown_long_comment'.$i)]);
        }

        if($miller->chal_type_id!=1)
        for ($i = 1; $i <= $miller->boiler_num; $i++ ) {
            $inspection->insp_boiler_details()->create(['boiler_id' => $request->get('boiler_id'.$i), 'boiler_detail_status' => $request->get('boiler_detail_status'.$i), 'boiler_detail_comment' => $request->get('boiler_detail_comment'.$i)]);
        }

        for ($i = 1; $i <= $miller->dryer_num; $i++ ) {
            $inspection->insp_dryer_details()->create(['dryer_id' => $request->get('dryer_id'.$i), 'dryer_detail_status' => $request->get('dryer_detail_status'.$i), 'dryer_detail_comment' => $request->get('dryer_detail_comment'.$i)]);
        }

        for ($i = 1; $i <= count($miller->mill_boiler_machineries); $i++ ) {
            $inspection->insp_mill_boiler_machineries()->create(['mill_boiler_machinery_id' => $request->get('mill_boiler_machinery_id'.$i), 'mill_boiler_machinery_status' => $request->get('mill_boiler_machinery_status'.$i), 'mill_boiler_machinery_comment' => $request->get('mill_boiler_machinery_comment'.$i)]);
        }

        for ($i = 1; $i <= count($miller->mill_milling_unit_machineries); $i++ ) {
            $inspection->insp_mill_milling_unit_machineries()->create(['mill_milling_unit_machinery_id' => $request->get('mill_milling_unit_machinery_id'.$i), 'mill_milling_unit_machinery_status' => $request->get('mill_milling_unit_machinery_status'.$i), 'mill_milling_unit_machinery_comment' => $request->get('mill_milling_unit_machinery_comment'.$i)]);
        }

        for ($i = 1; $i <= $miller->motor_num; $i++ ) {
            $inspection->insp_motor_details()->create(['motor_id' => $request->get('motor_id'.$i), 'motor_holar_num_status' => $request->get('motor_holar_num_status'.$i), 'motor_holar_num_comment' => $request->get('motor_holar_num_comment'.$i)]);
        }

        if($request->file('inspection_document_file')){
            $request->validate([
                'inspection_document_file' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $imageName = time().'.'.$request->file('inspection_document_file')->extension();

            $img = Image::make($request->file('inspection_document_file')->path());

            $img->resize(config('global.img_large_size'), config('global.img_large_size'), function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('images/inspection_document').'/large/'.$imageName);

            $img->resize(config('global.img_thumb_size'), config('global.img_thumb_size'), function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('images/inspection_document').'/thumb/'.$imageName);

            //$request->file('inspection_document_file')->move(public_path('images/inspection_document'), $imageName);
            $inspection->update(['inspection_document'=>$imageName]);
        }

        $inspection_period_id = $request->inspection_period_id;
        $inspection_period = Inspection_period::find($inspection_period_id);
        $inspection_period_name = $inspection_period ? $inspection_period->period_name : '';

        if($miller->miller_status == 'new_register'){
            $miller->update(['miller_stage'=> 'নতুন নিবন্ধন: ইন্সপেকশন প্রক্ক্রিয়াধীন']);
        }
        else{
            $miller->update(['miller_stage'=> $inspection_period_name.': ইন্সপেকশন প্রক্ক্রিয়াধীন']);
        }

        return redirect()->route('inspections.edit', $inspection->id)
                        ->with('success','চালকল পরিদর্শন তথ্য সফলভাবে তৈরি হয়েছে');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Miller  $miller
     * @return \Illuminate\Http\Response
     */
    public function edit(Inspection $inspection)
    {
        if(!DGFAuth::check2(1,  2)) return view('nopermission');

        $pp_page = session()->get('pp_page');
        $pp_inspection_period = session()->get('pp_inspection_period');
        $pp_inspection_status = session()->get('pp_inspection_status');
        $pp_cause_of_inspection = session()->get('pp_cause_of_inspection');
        $pp_division = session()->get('pp_division');
        $pp_district = session()->get('pp_district');
        $pp_mill_upazila = session()->get('pp_mill_upazila');

        $miller = Miller::find($inspection->miller_id);

        $inspection_period_id = $inspection->inspection_period_id;
        $inspection_period = Inspection_period::find($inspection_period_id);
        $inspection_period_name = $inspection_period ? $inspection_period->period_name : '';

        $inspection_periods = Inspection_period::all();
        $inactive_reasons = InactiveReason::all()->except(2);

        return view('inspections.edit', compact('inspection_periods', 'inactive_reasons', 'miller','inspection','inspection_period_name','pp_page','pp_inspection_period','pp_inspection_status','pp_cause_of_inspection','pp_division','pp_district','pp_mill_upazila'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Miller  $miller
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Inspection $inspection)
    {
        if(!DGFAuth::check2(1,  3)) return view('nopermission');

        $miller_id = $inspection->miller_id;
        $miller = Miller::find($miller_id);

        $inspection->update($request->all());

        if($request->file('inspection_document_file')){
            $request->validate([
                'inspection_document_file' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $imageName = time().'.'.$request->file('inspection_document_file')->extension();

            $img = Image::make($request->file('inspection_document_file')->path());

            $img->resize(config('global.img_large_size'), config('global.img_large_size'), function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('images/inspection_document').'/large/'.$imageName);

            $img->resize(config('global.img_thumb_size'), config('global.img_thumb_size'), function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('images/inspection_document').'/thumb/'.$imageName);

            //$request->file('inspection_document_file')->move(public_path('images/inspection_document'), $imageName);
            $inspection->update(['inspection_document'=>$imageName]);
        }

        $insp_miller = $inspection->insp_miller()->first();
        $insp_miller->update($request->all());

        if(isset($request->pro_flowdiagram_status)){
            $inspection->insp_autometic_miller()->first()->update($request->all());
        }

        for ($i = 1; $i <= $miller->chatal_num; $i++ ) {
            $id = $request->get('insp_chatal_id'.$i);
            $insp_chatal_detail = InspChatalDetail::find($id);
            $insp_chatal_detail->update(['chatal_long_status' => $request->get('chatal_long_status'.$i), 'chatal_long_comment' => $request->get('chatal_long_comment'.$i)]);
        }

        for ($i = 1; $i <= $miller->steeping_house_num; $i++ ) {
            $id = $request->get('insp_steeping_house_id'.$i);
            $insp_steeping_house_detail = InspSteepingHouseDetail::find($id);
            $insp_steeping_house_detail->update(['steeping_house_long_status' => $request->get('steeping_house_long_status'.$i), 'steeping_house_long_comment' => $request->get('steeping_house_long_comment'.$i)]);
        }

        for ($i = 1; $i <= $miller->godown_num; $i++ ) {
            $id = $request->get('insp_godown_id'.$i);
            $insp_godown_detail = InspGodownDetail::find($id);
            $insp_godown_detail->update(['godown_long_status' => $request->get('godown_long_status'.$i), 'godown_long_comment' => $request->get('godown_long_comment'.$i)]);
        }

        if($miller->chal_type_id!=1)
        for ($i = 1; $i <= $miller->boiler_num; $i++ ) {
            $id = $request->get('insp_boiler_id'.$i);
            $insp_boiler_detail = InspBoilerDetail::find($id);
            $insp_boiler_detail->update(['boiler_detail_status' => $request->get('boiler_detail_status'.$i), 'boiler_detail_comment' => $request->get('boiler_detail_comment'.$i)]);
        }

        for ($i = 1; $i <= $miller->dryer_num; $i++ ) {
            $id = $request->get('insp_dryer_id'.$i);
            $insp_dryer_detail = InspDryerDetail::find($id);
            $insp_dryer_detail->update(['dryer_detail_status' => $request->get('dryer_detail_status'.$i), 'dryer_detail_comment' => $request->get('dryer_detail_comment'.$i)]);
        }

        for ($i = 1; $i <= count($miller->mill_milling_unit_machineries); $i++ ) {
            $id = $request->get('insp_mill_milling_unit_machinery_id'.$i);
            $insp_mill_milling_unit_machinery = InspMillMillingUnitMachineries::find($id);
            $insp_mill_milling_unit_machinery->update(['mill_milling_unit_machinery_status' => $request->get('mill_milling_unit_machinery_status'.$i), 'mill_milling_unit_machinery_comment' => $request->get('mill_milling_unit_machinery_comment'.$i)]);
        }

        for ($i = 1; $i <= count($miller->mill_boiler_machineries); $i++ ) {
            $id = $request->get('insp_mill_boiler_machinery_id'.$i);
            $insp_mill_boiler_machinery = InspMillBoilerMachineries::find($id);
            $insp_mill_boiler_machinery->update(['mill_boiler_machinery_status' => $request->get('mill_boiler_machinery_status'.$i), 'mill_boiler_machinery_comment' => $request->get('mill_boiler_machinery_comment'.$i)]);
        }

        for ($i = 1; $i <= $miller->motor_num; $i++ ) {
            $id = $request->get('insp_motor_id'.$i);
            $insp_motor_detail = InspMotorDetail::find($id);
            $insp_motor_detail->update(['motor_holar_num_status' => $request->get('motor_holar_num_status'.$i), 'motor_holar_num_comment' => $request->get('motor_holar_num_comment'.$i)]);
        }

        if($inspection->approval_status=="এপ্র্যুভড"){
            $miller->update([
                'last_inactive_reason'=> $inspection->inactive_reason,
                'miller_stage'=> $inspection->inspection_status == "যোগ্য" ? "সচল চালকল":"বন্ধ চালকল",
                'miller_status' => $inspection->inspection_status == "যোগ্য" ? "active":"inactive"
                ]);

            
            $FPS_ENABLED = env('FPS_ENABLED');
            
            if($FPS_ENABLED == "on"){
                $login_response = $this->fps->login();

                if($login_response != null && $login_response->status == true ){
                    $mo_exists = $this->fps->get_miller([
                        'token' => $login_response->result->token,
                        'NID'=> $miller->nid_no]
                    );

                    $fps_mo_status = "";

                    if($mo_exists->status == true){
                        $mo_response = $this->fps->update_miller([
                            'token' => $login_response->result->token,
                            'NID'=> $miller->nid_no,
                            "Name_Bangla"=> $miller->owner_name,
                            "Name_English"=> $miller->owner_name_english,
                            "Mother_Name"=> "n/a",
                            "Father_Name"=> $miller->father_name,
                            "Gender"=> $miller->gender,
                            "DOB"=> \Carbon\Carbon::parse($miller->birth_date)->format("Y-m-d"),
                            "Permanent_Address"=> $miller->owner_address,
                            "Current_Address"=> $miller->owner_address,
                            "miller_birth_place"=> $miller->miller_birth_place,
                            "miller_nationality"=> $miller->miller_nationality,
                            "miller_religion"=> $miller->miller_religion,
                            "Mobile"=> $miller->mobile_no//,
                            //"Status"=> $inspection->inspection_status == "যোগ্য" ? "active":"inactive"
                            ]
                        );
                        $fps_mo_status = $mo_response != null && $mo_response->status == true ? "update_success":"update_fail";                        
                    }
                    else{
                        $mo_response = $this->fps->add_miller([
                            'token' => $login_response->result->token,
                            'NID'=> $miller->nid_no,
                            "Name_Bangla"=> $miller->owner_name,
                            "Name_English"=> $miller->owner_name_english,
                            "Mother_Name"=> "n/a",
                            "Father_Name"=> $miller->father_name,
                            "Gender"=> $miller->gender,
                            "DOB"=> \Carbon\Carbon::parse($miller->birth_date)->format("Y-m-d"),
                            "Permanent_Address"=> $miller->owner_address,
                            "Current_Address"=> $miller->owner_address,
                            "miller_birth_place"=> $miller->miller_birth_place,
                            "miller_nationality"=> $miller->miller_nationality,
                            "miller_religion"=> $miller->miller_religion,
                            "Mobile"=> $miller->mobile_no,
                            "Status"=> $inspection->inspection_status == "যোগ্য" ? "active":"inactive"]
                        );
                        $fps_mo_status = $mo_response != null && $mo_response->status == true ? "insert_success":"insert_fail";
                    }

                    $fps_mo_last_date = date("Y-m-d H:i:s");

                    $mill_type = "";

                    if($miller->mill_type_id == 1)
                        $mill_type = "Semi-Auto";
                    else if($miller->mill_type_id == 2)
                        $mill_type = "Automatic";
                    else if($miller->mill_type_id == 3)
                        $mill_type = "Husking Without Rubber Polisher";
                    else if($miller->mill_type_id == 4)
                        $mill_type = "Husking With Rubber Polisher";
                    else if($miller->mill_type_id == 5)
                        $mill_type = "New Automatic Rice Mill";

                    $mill_exists = $this->fps->get_mill([
                        'token' => $login_response->result->token,
                        'License' => $miller->license_no]
                    );
    
                    $fps_mill_status = "";
    
                    if($mill_exists->status == true){
                        $mill_response = $this->fps->update_mill([
                            'token' => $login_response->result->token,
                            'NID'=> $miller->nid_no,
                            "Name"=> $miller->mill_name,
                            "Address"=> $miller->mill_address,
                            "District"=> $miller->district != null ? $miller->district->name : "",
                            "Upazila"=> $miller->upazilla != null ? $miller->upazilla->name : "",
                            "Mill_Type"=> $mill_type,
                            "Capacity"=> $miller->millar_p_power_chal,
                            "License"=> $miller->license_no,
                            "Issue_Date"=> $miller->date_license != null ? $miller->date_license->format("Y-m-d") : "",
                            "Renew_Date"=> $miller->date_renewal != null ? $miller->date_renewal->format("Y-m-d") : "",
                            "Status"=> $inspection->inspection_status == "যোগ্য" ? "active":"inactive",
                            "Rice_Type"=> $miller->chal_type_id == 1 ? "white":"parboiled",
                            "Mobile"=> $miller->mobile_no,
                            "Meter"=> $miller->meter_no,
                            "Remark"=> "Ok"]
                        );
        
                        $fps_mill_status = $mill_response != null && $mill_response->status == true ? "update_success":"update_fail";
                    }
                    else{
                        $mill_response = $this->fps->add_mill([
                            'token' => $login_response->result->token,
                            'NID'=> $miller->nid_no,
                            "Name"=> $miller->mill_name,
                            "Address"=> $miller->mill_address,
                            "District"=> $miller->district != null ? $miller->district->name : "",
                            "Upazila"=> $miller->upazilla != null ? $miller->upazilla->name : "",
                            "Mill_Type"=> $mill_type,
                            "Capacity"=> $miller->millar_p_power_chal,
                            "License"=> $miller->license_no,
                            "Issue_Date"=> $miller->date_license != null ? $miller->date_license->format("Y-m-d") : "",
                            "Renew_Date"=> $miller->date_renewal != null ? $miller->date_renewal->format("Y-m-d") : "",
                            "Status"=> $inspection->inspection_status == "যোগ্য" ? "active":"inactive",
                            "Rice_Type"=> $miller->chal_type_id == 1 ? "white":"parboiled",
                            "Mobile"=> $miller->mobile_no,
                            "Meter"=> $miller->meter_no,
                            "Remark"=> "Ok"]
                        );
    
                        $fps_mill_status = $mill_response != null && $mill_response->status == true ? "insert_success":"insert_fail";
                    }

                    $fps_mill_last_date = date("Y-m-d H:i:s");

                    $miller->update([
                        'fps_mo_status'=> $fps_mo_status,
                        'fps_mo_last_date'=> $fps_mo_last_date,
                        'fps_mill_status'=> $fps_mill_status,
                        'fps_mill_last_date'=> $fps_mill_last_date
                        ]);
                }
            }            
        }

        return redirect()->route('inspections.edit',$inspection->id)->with('success','পরিদর্শন তথ্য সফলভাবে পরিবর্তন করা হয়েছে');
    }
}
