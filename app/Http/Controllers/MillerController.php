<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\AreasAndPower;
use App\Models\Miller;
use App\Models\Division;
use App\Models\District;
use App\Models\Upazilla;
use App\Models\LicenseFee;
use App\Models\InactiveReason;
use App\Models\CorporateInstitute;
use App\Models\ChalType;
use App\Models\BoilerDetail;
use App\Models\DryerDetail;
use App\Models\ChatalDetail;
use App\Models\GodownDetail;
use App\Models\MillType;
use App\Models\MillingUnitMachinery;
use App\Models\MillMillingUnitMachineries;
use App\Models\MillBoilerMachineries;
use App\Models\SteepingHouseDetail;
use App\Models\SiloDetail;
use App\BanglaConverter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\JoinClause;
use App\DGFAuth;
use App\Models\MotorDetail;
use App\Models\MotorPower;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Util\FPSHelper;

use Image;

class MillerController extends Controller
{
    private $fps;
    private $menunum = 4040;

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
        if(!DGFAuth::check2(1,  2)) return view('nopermission');

        $miller = null;
        if(Auth::user()->division_id == 0){
            $miller = Miller::all();
        }else if(Auth::user()->upazila_id > 0){
            $miller = Miller::where('mill_upazila_id', Auth::user()->upazila_id);
        }else if(Auth::user()->district_id > 0){
            $miller = Miller::where('district_id', Auth::user()->district_id);
        }else if(Auth::user()->division_id > 0){
            $miller = Miller::where('division_id', Auth::user()->division_id);
        }

        $millercount = (clone $miller)->count();
        $activemillercount = (clone $miller)->where('cmp_status', 1)->count();
        $inactivemillercount = $millercount - $activemillercount;
        $semiautomillercount = (clone $miller)->where('mill_type_id', 1)->count();
        $automillercount = (clone $miller)->where('mill_type_id', 2)->count();
        $exceptpislerautomillercount = (clone $miller)->where('mill_type_id', 3)->count();
        $withpislersemiautomillercount = (clone $miller)->where('mill_type_id', 4)->count();
        $newautomillercount = (clone $miller)->where('mill_type_id', 5)->count();

        $corporatemillercount = (clone $miller)->where('owner_type', 'corporate')->count();

        return view('miller.index', compact('millercount', 'activemillercount', 'inactivemillercount',
        'newautomillercount', 'semiautomillercount', 'automillercount', 'exceptpislerautomillercount', 'withpislersemiautomillercount', 'corporatemillercount'));
    }

    public function list(Request $request)
    {
        if(!DGFAuth::check2(1,  2)) return view('nopermission');

        $page = $request->get('page');

        $division_id = $request->get('division_id');
        $district_id = $request->get('district_id');
        $mill_upazila_id = $request->get('mill_upazila_id');
        $chal_type_id = $request->get('chal_type_id');
        $mill_type_id = $request->get('mill_type_id');
        $searchtext = $request->get('searchtext');
        $corporate_institute_id = $request->get('corporate_institute_id');

        $miller_status = $request->get('miller_status');
        $cmp_status = $request->get('cmp_status');
        $owner_type = $request->get('owner_type');

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
        $divisions = DGFAuth::filtereddivision();// Division::all();
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

        $millers = Miller::sortable();

        if($division_id)
            $millers = $millers->where("division_id", $division_id);

        if($district_id)
            $millers = $millers->where("district_id", $district_id);

        if($mill_upazila_id)
            $millers = $millers->where("mill_upazila_id", $mill_upazila_id);

        if($mill_type_id)
            $millers = $millers->where("miller.mill_type_id", $mill_type_id);

        if($chal_type_id)
            $millers = $millers->where("chal_type_id", $chal_type_id);

        if($corporate_institute_id)
            $millers = $millers->where("corporate_institute_id", $corporate_institute_id);

        if($miller_status)
            $millers = $millers->where("miller_status", $miller_status);

        if($cmp_status!=null)
            $millers = $millers->where("cmp_status", $cmp_status);

        if($owner_type!=null)
            $millers = $millers->where("owner_type", $owner_type);

        if($searchtext!=null){
            $millers = $millers->where(function ($query)use ($searchtext) {
                $query->orWhere('mill_name', 'like', '%'.$searchtext.'%')
                      ->orWhere('owner_name', 'like', '%'.$searchtext.'%')
                      ->orWhere('nid_no', 'like', '%'.$searchtext.'%')
                      ->orWhere('license_no', 'like', '%'.$searchtext.'%')
                      ->orWhere('form_no', 'like', '%'.BanglaConverter::bn2en($searchtext).'%')
                      ->orWhere('millar_p_power_chal', 'like', '%'.$searchtext.'%');
            });
        }

        $millers = $millers->select('miller.*')
        ->join('mill_type', 'miller.mill_type_id', '=', 'mill_type.mill_type_id')
        ->orderBy('miller.division_id')->orderBy('miller.district_id')->orderBy('miller.mill_upazila_id')->orderBy('miller.division_id')->orderBy('miller.district_id')->orderBy('miller.mill_upazila_id')->orderBy('mill_type.ordering');

        $millers = $millers->paginate(25);

        $chalTypes = ChalType::all();
        $millTypes = MillType::orderBy('ordering')->get();
        $corporate_institutes = CorporateInstitute::all();

        session()->put('pp_page', $page);
        session()->put('pp_division', $division_id);
        session()->put('pp_district', $district_id);
        session()->put('pp_mill_upazila', $mill_upazila_id);

        session()->put('pp_mill_type_id', $mill_type_id);
        session()->put('pp_chal_type_id', $chal_type_id);
        session()->put('pp_corporate_institute_id', $corporate_institute_id);
        session()->put('pp_miller_status', $miller_status);
        session()->put('pp_owner_type', $owner_type);
        session()->put('pp_cmp_status', $cmp_status);
        session()->put('pp_searchtext', $searchtext);

        return view('miller.list', compact('millers','divisions','districts','upazillas','corporate_institutes','chalTypes','millTypes','division_id','district_id','mill_upazila_id','searchtext', 'miller_status', 'cmp_status', 'owner_type', 'chal_type_id', 'mill_type_id', 'corporate_institute_id'));
    }

    public function millerListFPSStatus(Request $request)
    {
        if(!DGFAuth::check2(1,  2)) return view('nopermission');

        $page = $request->get('page');

        $division_id = $request->get('division_id');
        $district_id = $request->get('district_id');
        $mill_upazila_id = $request->get('mill_upazila_id');
        $miller_status = $request->get('miller_status');
        $fps_mo_status = $request->get('fps_mo_status');
        $fps_mill_status = $request->get('fps_mill_status');
        $searchtext = $request->get('searchtext');
        $owner_type = $request->get('owner_type');


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
        $divisions = DGFAuth::filtereddivision();// Division::all();
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

        $millers = Miller::sortable();
        $millers = $millers->where("miller_status", "!=", "new_register");

        if($division_id)
            $millers = $millers->where("division_id", $division_id);

        if($district_id)
            $millers = $millers->where("district_id", $district_id);

        if($owner_type!=null)
            $millers = $millers->where("owner_type", $owner_type);

        if($mill_upazila_id)
            $millers = $millers->where("mill_upazila_id", $mill_upazila_id);

        if($miller_status)
            $millers = $millers->where("miller_status", $miller_status);

        if($fps_mo_status){
            if($fps_mo_status == 'not_sent')
                $millers = $millers->where("fps_mo_status", null);
            else
                $millers = $millers->where("fps_mo_status", $fps_mo_status);
        }

        if($fps_mill_status){
            if($fps_mill_status == 'not_sent')
                $millers = $millers->where("fps_mill_status", null);
            else
                $millers = $millers->where("fps_mill_status", $fps_mill_status);
        }

        if($searchtext!=null){
            $millers = $millers->where(function ($query)use ($searchtext) {
                $query->orWhere('mill_name', 'like', '%'.$searchtext.'%')
                      ->orWhere('owner_name', 'like', '%'.$searchtext.'%')
                      ->orWhere('nid_no', 'like', '%'.$searchtext.'%')
                      ->orWhere('license_no', 'like', '%'.$searchtext.'%')
                      ->orWhere('form_no', 'like', '%'.BanglaConverter::bn2en($searchtext).'%');
            });
        }

        $millers = $millers->select('miller.*')
        ->join('mill_type', 'miller.mill_type_id', '=', 'mill_type.mill_type_id')
        ->orderBy('miller.division_id')->orderBy('miller.district_id')->orderBy('miller.mill_upazila_id')->orderBy('miller.division_id')->orderBy('miller.district_id')->orderBy('miller.mill_upazila_id')->orderBy('mill_type.ordering');

        $millers = $millers->paginate(25);

        $chalTypes = ChalType::all();
        $millTypes = MillType::orderBy('ordering')->get();

        return view('miller.millerListFPSStatus', compact('millers','owner_type','divisions','districts','upazillas','division_id','district_id','mill_upazila_id','searchtext', 'miller_status', 'fps_mo_status', 'fps_mill_status', 'page'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if(!DGFAuth::check2(1,  1)) return view('nopermission');

        $divisions = DGFAuth::filtereddivision();// Division::all();
        if(Auth::user()->division_id>0)
            $division_id = Auth::user()->division_id;
        else
            $division_id=0;
        if(Auth::user()->district_id>0) {
            $district_id = Auth::user()->district_id;
            $districts = DB::table('district')
            ->where("distid", Auth::user()->district_id)
            ->get();
        }else{
            $district_id =0;
            $districts = DB::table('district')
            ->where("divid", $division_id)
            ->get();
        }
        if(Auth::user()->upazila_id>0) {
            $upazila_id = Auth::user()->upazila_id;
            $upazillas = DB::table('upazilla')
            ->where("upazillaid", Auth::user()->upazila_id)
            ->get();
        }else{
            $upazila_id = 0;
            $upazillas = DB::table('upazilla')
            ->where("distId", $district_id)
            ->get();
        }

        $chalTypes = ChalType::all();
        $millTypes = MillType::orderBy('ordering')->get();
        $option = $request->query('option');
        $motor_powers = MotorPower::all();

        $inactive_reasons = InactiveReason::all()->except(2);
        $corporate_institutes = CorporateInstitute::all();
        $miller_birth_places = District::all();

        //$licenseFees = LicenseFee::whereDate("effective_todate",'>', date(''))->get();
          $licenseFees = LicenseFee::whereDate('effective_todate', '>', Carbon::today())->get();
        //dd($licenseFees);
        $nobayonTypes = LicenseFee::where('license_type_id', 2)->whereDate("effective_todate",'>', date(''))->pluck('id')->toArray();

        $milling_unit_machinery = MillingUnitMachinery::all();

        $miller = new Miller;

        // $miller->mill_boiler_machineries->push(new MillMillingUnitMachineries([
        //     'mill_boiler_machinery_id' => 0,
        //     'name' => '',
        //     'brand' => '',
        //     'manufacturer_country' => '',
        //     'import_date' => '',
        //     'num' => 0,
        //     'power' => 0.0,
        //     'topower' => 0.0,
        //     'pressure' => 0.0,
        //     'horse_power' => 0.0
        // ]));

        return view('miller.create', compact('divisions', 'districts', 'miller_birth_places', 'upazillas', 'inactive_reasons', 'corporate_institutes',  'licenseFees', 'nobayonTypes', 'chalTypes','millTypes', 'option','motor_powers','miller', 'milling_unit_machinery', 'division_id','district_id','upazila_id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function fpshotfix(Request $request)
    {
        if(!DGFAuth::check2(1,  2)) return view('nopermission');

        return view('miller.fpshotfix');

        return redirect()->route('millers.fpshotfix')->with('message', 'মিলার এর পাসকোড সফলভাবে জেনারেট করা হয়েছে।');
    }

    public function searchPasscode(Request $request)
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');

        $division_id = $request->get('division_id');
        $district_id = $request->get('district_id');
        $upazila_id = $request->get('upazila_id');
        $mobile_no = $request->get('mobile_no');

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

        $millers = [];
        $millers2 = [];
        $pass_code_message = '';

        if($mobile_no)
        {
            $millers = Miller::where("mobile_no", $mobile_no)->get();

            $miller = Miller::where("mobile_no", $mobile_no)->first();
            if($miller && $miller->pass_code)
                $pass_code_message = 'আপনার পাসকোড:'.$miller->pass_code;
            else
                $pass_code_message = 'পাসকোড পাওয়া যায়নি';
        }
        else if($division_id && $district_id && $upazila_id )
        {
            $millers2 = Miller::where("division_id", $division_id)
            ->where("district_id", $district_id)
            ->where("mill_upazila_id", $upazila_id)
            ->get();
        }
        else if($division_id && $district_id)
        {
            $millers2 = Miller::where("division_id", $division_id)
            ->where("district_id", $district_id)
            ->get();
        }
        else if($division_id)
        {
            $millers2 = Miller::where("division_id", $division_id)->get();
        }

        return view('millerregister.passcode_search', compact('millers','millers2','divisions','districts','upazillas',
        'division_id','district_id','upazila_id','mobile_no','pass_code_message'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function generate_pass_code(Request $request)
    {
        if(!DGFAuth::check2(1,  2)) return view('nopermission');

        $division_id = $request->get('division_id');
        $district_id = $request->get('district_id');
        $upazila_id = $request->get('upazila_id');
        $mobile_no = $request->get('mobile_no');

        $millers = [];

        if($mobile_no)
        {
            $millers = Miller::where("mobile_no", $mobile_no)->get();
        }
        else if($division_id && $district_id && $upazila_id )
        {
            $millers = Miller::where("division_id", $division_id)
            ->where("district_id", $district_id)
            ->where("mill_upazila_id", $upazila_id)
            ->get();
        }
        else if($division_id && $district_id)
        {
            $millers = Miller::where("division_id", $division_id)
            ->where("district_id", $district_id)
            ->get();
        }
        else if($division_id)
        {
            $millers = Miller::where("division_id", $division_id)->get();
        }

        foreach($millers as $miller){
            if(!$miller->pass_code && $miller->mobile_no){
                $pass_code = "";

                $count = Miller::where("mobile_no", $miller->mobile_no)->where("pass_code", '!=', "")->count();
                if($count >= 1){
                    $pass_code_getDB = Miller::where("mobile_no", $miller->mobile_no)->where("pass_code", '!=', "")->first();
                    //$pass_code = $pass_code_getDB->pass_code."_".$count;
                    $pass_code = $pass_code_getDB->pass_code;
                }
                else{
                    $dup = true;
                    while($dup){
                        $pass_code = "";
                        $chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
                        for ($i = 0; $i < 6; $i++) {
                            $pass_code .= $chars[mt_rand(0, strlen($chars)-1)];
                        }

                        $count = Miller::where("pass_code", $pass_code)->count();
                        if($count == 0)
                            $dup = false;
                    }
                }

                $miller->update(['pass_code' => $pass_code]);
            }
        }

        return redirect()->route('searchPasscode')->with('message', 'মিলার এর পাসকোড সফলভাবে জেনারেট করা হয়েছে।');
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

       // if(!DGFAuth::checkregistration())
            //return view('nopermission');

        $request->validate([
            'division_id' => 'required',
            'district_id' => 'required',
            'mill_upazila_id' => 'required',
            'mill_name' => 'required',
            'owner_name' => 'required',
            'nid_no' => 'required',
            'birth_date' => 'required',
            'owner_name_english' => 'required',
            'gender' => 'required',
            'chal_type_id' => 'required',
            'mill_type_id' => 'required'
        ]);

        /*
        //duplicate check
        $duplicates = DB::table('miller')
        ->where("division_id", $request->division_id)
        ->where("district_id", $request->district_id)
        ->where("mill_upazila_id", $request->mill_upazila_id)
        ->where("mill_name", $request->mill_name)
        ->where("owner_name", $request->mill_name)
        ->where("chal_type_id", $request->chal_type_id)
        ->get();

        if(count($duplicates) > 0)
            return redirect()->back()->withInput()
            ->withErrors(['duplicate_miller'=>'Duplicate miller found.']);
        */

        if($request->nid_no){
            $owner_miller = DB::table('miller')
            ->where("owner_name", $request->owner_name)
            ->where("father_name", $request->father_name)
            ->where("mother_name", $request->mother_name)
            ->where("birth_date", $request->birth_date)
            ->first();

            if($owner_miller != null && $owner_miller->nid_no != $request->nid_no ){
                return redirect()->back()->withInput()
                ->withErrors(['millers_nid_no'=>'দয়া করে আগের ব্যবহৃত এনআইডি '. $owner_miller->nid_no .' ব্যভহার করুন।']);
            }

            $millers_nid_no = DB::table('miller')
            ->where("nid_no", $request->nid_no)
            ->get();

            if(count($millers_nid_no) > 0){
                $forms_no = array();
                $is_nid_black_listed = false;

                foreach($millers_nid_no as $miller_nid_no){
                    if($miller_nid_no->last_inactive_reason == 'কালো তালিকাভুক্ত (এনআইডি)')
                        $is_nid_black_listed = true;

                    $forms_no[] = $miller_nid_no->form_no;
                }

                $form_no = implode(", ", $forms_no);

                if($is_nid_black_listed){
                    return redirect()->back()->withInput()
                    ->withErrors(['millers_nid_no'=>'দয়া করে অন্য এনআইডি ব্যভহার করুন। এই এনআইডি টি কালো তালিকাভুক্ত করা হয়েছে। এই এনআইডি এর সংযুক্ত অন্য মিলসমূহঃ '.$form_no]);
                }
            }

            $FPS_NID_VERIFICATION = env('FPS_NID_VERIFICATION');

            if($request->nid_no && $request->birth_date && $FPS_NID_VERIFICATION == "on"){
                $login_response = $this->fps->login();
                if($login_response != null && $login_response->status == true ){
                    $response = $this->fps->nid_verification(['token' => $login_response->result->token,'NID'=>$request->nid_no, 'DOB' => \Carbon\Carbon::parse($request->birth_date)->format("Y-m-d")]);
                    if($response->status != true){
                        return redirect()->back()->withInput()
                        ->withErrors(['millers_nid_no'=>$response->message]);
                    }
                }
            }
        }

        if($request->license_no){
            //duplicate license_no check
            $duplicate_license_no = DB::table('miller')
            ->where("license_no", $request->license_no)
            ->get();

            if(count($duplicate_license_no) > 0)
                return redirect()->back()->withInput()
                ->withErrors(['duplicate_license_no'=>'ডুপ্লিকেট লাইসেন্স নং, দয়া করে পরিবর্তন করুন।']);
        }

        if($request->boiller_num){
            $boiller_num = BanglaConverter::getNumToEn($request->boiller_num);
            $request->merge(['boiller_num' => $boiller_num]);
        }

        if($request->chimney_height){
            $chimney_height = BanglaConverter::getNumToEn($request->chimney_height);
            $request->merge(['chimney_height' => $chimney_height]);
        }

        if($request->sheller_paddy_seperator_output){
            $sheller_paddy_seperator_output = BanglaConverter::getNumToEn($request->sheller_paddy_seperator_output);
            $request->merge(['sheller_paddy_seperator_output' => $sheller_paddy_seperator_output]);
        }

        if($request->whitener_grader_output){
            $whitener_grader_output = BanglaConverter::getNumToEn($request->whitener_grader_output);
            $request->merge(['whitener_grader_output' => $whitener_grader_output]);
        }

        if($request->colour_sorter_output){
            $colour_sorter_output = BanglaConverter::getNumToEn($request->colour_sorter_output);
            $request->merge(['colour_sorter_output' => $colour_sorter_output]);
        }

        if($request->millar_p_power_chal && $request->mill_type_id==2){
            $millar_p_power_chal = BanglaConverter::getNumToEn($request->millar_p_power_chal);
            $request->merge(['millar_p_power' => $millar_p_power_chal / 0.65, 'millar_p_power_chal' => $millar_p_power_chal]);
        }

        if($request->mill_upazila_id){
            //generate form no
            $upazilla = Upazilla::where("upazillaid", $request->mill_upazila_id)
            ->first();
            $form_count = $upazilla->last_miller_sl;
            $request->merge(['form_no' => $request->mill_upazila_id * 10000 + $form_count + 1]);

            $upazilla->update(['last_miller_sl' => $form_count + 1]);
        }

        //dd($request->owner_address);

        $miller = Miller::create($request->all());

        $miller->areas_and_power()->create(['boiler_machineries_steampower' => 0,
        'boiler_machineries_power' => 0, 'boiler_number_total' => 0, 'boiler_volume_total' => 0,
        'boiler_power' => 0,'dryer_volume_total' => 0, 'dryer_power' => 0,'chatal_area_total' => 0,
        'chatal_power' => 0,'godown_area_total' => 0, 'godown_power' => 0,'silo_power'=> 0,
        'silo_area_total'=> 0, 'final_godown_silo_power'=> 0,
        'steping_area_total' => 0, 'steping_power' => 0,'motor_area_total' => 0, 'motor_power' => 0,
        'milling_unit_output' => 0, 'milling_unit_power' => 0]);

        if($request->mill_type_id==2)
        $miller->autometic_miller()->create(['pro_flowdiagram' => $request->pro_flowdiagram, 'origin' => $request->origin, 'visited_date' => $request->visited_date,
        'machineries_a' => $request->machineries_a, 'machineries_b' => $request->machineries_b, 'machineries_c' => $request->machineries_c,
        'machineries_d' => $request->machineries_d, 'machineries_e' => $request->machineries_e, 'machineries_f' => $request->machineries_f,
        'parameter1_name' => $request->parameter1_name, 'parameter1_num' => $request->parameter1_num, 'parameter1_power' => $request->parameter1_power, 'parameter1_topower' => $request->parameter1_topower,
        'parameter2_name' => $request->parameter2_name, 'parameter2_num' => $request->parameter2_num, 'parameter2_power' => $request->parameter2_power, 'parameter2_topower' => $request->parameter2_topower,
        'parameter3_name' => $request->parameter3_name, 'parameter3_num' => $request->parameter3_num, 'parameter3_power' => $request->parameter3_power, 'parameter3_topower' => $request->parameter3_topower,
        'parameter4_name' => $request->parameter4_name, 'parameter4_num' => $request->parameter4_num, 'parameter4_power' => $request->parameter4_power, 'parameter4_topower' => $request->parameter4_topower,
        'parameter5_name' => $request->parameter5_name, 'parameter5_num' => $request->parameter5_num, 'parameter5_power' => $request->parameter5_power, 'parameter5_topower' => $request->parameter5_topower,
        'parameter6_name' => $request->parameter6_name, 'parameter6_num' => $request->parameter6_num, 'parameter6_power' => $request->parameter6_power, 'parameter6_topower' => $request->parameter6_topower,
        'parameter7_name' => $request->parameter7_name, 'parameter7_num' => $request->parameter7_num, 'parameter7_power' => $request->parameter7_power, 'parameter7_topower' => $request->parameter7_topower,
        'parameter8_name' => $request->parameter8_name, 'parameter8_num' => $request->parameter8_num, 'parameter8_power' => $request->parameter8_power, 'parameter8_topower' => $request->parameter8_topower,
        'parameter9_name' => $request->parameter9_name, 'parameter9_num' => $request->parameter9_num, 'parameter9_power' => $request->parameter9_power, 'parameter9_topower' => $request->parameter9_topower,
        'parameter10_name' => $request->parameter10_name, 'parameter10_num' => $request->parameter10_num, 'parameter10_power' => $request->parameter10_power, 'parameter10_topower' => $request->parameter10_topower,
        'parameter11_name' => $request->parameter11_name, 'parameter11_num' => $request->parameter11_num, 'parameter11_power' => $request->parameter11_power, 'parameter11_topower' => $request->parameter11_topower,
        'parameter12_name' => $request->parameter12_name, 'parameter12_num' => $request->parameter12_num, 'parameter12_power' => $request->parameter12_power, 'parameter12_topower' => $request->parameter12_topower,
        'parameter13_name' => $request->parameter13_name, 'parameter13_num' => $request->parameter13_num, 'parameter13_power' => $request->parameter13_power, 'parameter13_topower' => $request->parameter13_topower,
        'parameter14_name' => $request->parameter14_name, 'parameter14_num' => $request->parameter14_num, 'parameter14_power' => $request->parameter14_power, 'parameter14_topower' => $request->parameter14_topower,
        'parameter15_name' => $request->parameter15_name, 'parameter15_num' => $request->parameter15_num, 'parameter15_power' => $request->parameter15_power, 'parameter15_topower' => $request->parameter15_topower,
        'parameter16_name' => $request->parameter16_name, 'parameter16_num' => $request->parameter16_num, 'parameter16_power' => $request->parameter16_power, 'parameter16_topower' => $request->parameter16_topower,
        'parameter17_name' => $request->parameter17_name, 'parameter17_num' => $request->parameter17_num, 'parameter17_power' => $request->parameter17_power, 'parameter17_topower' => $request->parameter17_topower,
        'parameter18_name' => $request->parameter18_name, 'parameter18_num' => $request->parameter18_num, 'parameter18_power' => $request->parameter18_power, 'parameter18_topower' => $request->parameter18_topower,
        'parameter19_name' => $request->parameter19_name, 'parameter19_topower' => $request->parameter19_topower
        ]);

        if($request->mill_type_id==5){
            //dd($request->silo_volume, $request->final_godown_silo_power);

            $miller->autometic_miller_new()->create(['pro_flowdiagram' => $request->pro_flowdiagram, 'origin' => $request->origin, 'milling_parts_manufacturer' => $request->milling_parts_manufacturer, 'milling_parts_manufacturer_type' => $request->milling_parts_manufacturer_type]);

            if($request->file('boiler_certificate_file')){
                $request->validate([
                    'boiler_certificate_file' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                ]);

                $imageName = time().'.'.$request->file('boiler_certificate_file')->extension();

                $img = Image::make($request->file('boiler_certificate_file')->path());

                $img->resize(config('global.img_large_size'), config('global.img_large_size'), function ($constraint) {
                    $constraint->aspectRatio();
                })->save(public_path('images/boiler_certificate_file').'/large/'.$imageName);

                $img->resize(config('global.img_thumb_size'), config('global.img_thumb_size'), function ($constraint) {
                    $constraint->aspectRatio();
                })->save(public_path('images/boiler_certificate_file').'/thumb/'.$imageName);

                //$request->file('boiler_certificate_file')->move(public_path('images/boiler_certificate_file'), $imageName);
                $miller->autometic_miller_new()->update(['boiler_certificate_file'=>$imageName]);
            }

            if($request->milling_unit_machinery_machinery_id){

                foreach ($request->milling_unit_machinery_machinery_id as $key => $value ) {
                    $n = BanglaConverter::getNumToEn($request->milling_unit_machinery_num[$key]);
                    $p = BanglaConverter::getNumToEn($request->milling_unit_machinery_power[$key]);
                    $hp = BanglaConverter::getNumToEn($request->milling_unit_machinery_horse_power[$key]);
                    $tp = $request->milling_unit_machinery_join_type[$key] == "অনুক্রম" ? $p : $n * $p;

                    $miller->mill_milling_unit_machineries()->create([
                        'machinery_id' => $value,
                        'name' => $request->milling_unit_machinery_name[$key],
                        'brand' => $request->milling_unit_machinery_brand[$key],
                        'manufacturer_country' => $request->milling_unit_machinery_manufacturer_country[$key],
                        'import_date' => $request->milling_unit_machinery_import_date[$key],
                        'join_type' => $request->milling_unit_machinery_join_type[$key],
                        'num' => $n,
                        'power' => $p,
                        'topower' => $tp,
                        'horse_power' => $hp
                    ]);
                }
            }

            if($request->boiler_machineries_name){
                $cas = 0;

                foreach ($request->boiler_machineries_name as $key => $value ) {
                    $n = BanglaConverter::getNumToEn($request->boiler_machineries_num[$key]);
                    $p = BanglaConverter::getNumToEn($request->boiler_machineries_power[$key]);
                    $pr = BanglaConverter::getNumToEn($request->boiler_machineries_pressure[$key]);
                    $hp = 0;//BanglaConverter::getNumToEn($request->boiler_machineries_horse_power[$key]);

                    $miller->mill_boiler_machineries()->create([
                        'name' => $value,
                        'brand' => $request->boiler_machineries_brand[$key],
                        'manufacturer_country' => $request->boiler_machineries_manufacturer_country[$key],
                        'import_date' => $request->boiler_machineries_import_date[$key],
                        'pressure' => $pr,
                        'num' => $n,
                        'power' => $p,
                        'topower' => $n * $p,
                        'horse_power' => $hp
                    ]);

                    $cas += $n * $p;
                }

                $power = $cas * 12;

                $miller->areas_and_power()->update(['boiler_machineries_steampower' => $cas, 'boiler_machineries_power' => $power]);
            }

        }

        if($request->boiler_radius && $request->chal_type_id !=1){
            $cas = 0;
            $qty_sum = 0;

            foreach ($request->boiler_radius as $key => $value ) {
                $r = BanglaConverter::getNumToEn($value);
                $h1 = BanglaConverter::getNumToEn($request->cylinder_height[$key]);
                $h2 = BanglaConverter::getNumToEn($request->cone_height[$key]);
                $qty = BanglaConverter::getNumToEn($request->qty[$key]);

                $miller->boiler_details()->create(['boiler_radius' => $r, 'cylinder_height' => $h1, 'cone_height' => $h2, 'boiler_volume' => pi() * $r * $r * ($h1+$h2/3), 'qty' => $qty]);
                $cas += pi() * $r * $r * ($h1+$h2/3) * $qty;
                $qty_sum += $qty;
            }

            $power = $cas * 13 / 1.75;

            $miller->areas_and_power()->update(['boiler_number_total' => $qty_sum, 'boiler_volume_total' => $cas, 'boiler_power' => $power]);
        }

        if($request->dryer_length){
            $cas = 0;

            foreach ($request->dryer_length as $key => $value ) {
                $l = BanglaConverter::getNumToEn($value);
                $w = BanglaConverter::getNumToEn($request->dryer_width[$key]);
                $h1 = BanglaConverter::getNumToEn($request->cube_height[$key]);
                $h2 = BanglaConverter::getNumToEn($request->pyramid_height[$key]);

                $miller->dryer_details()->create(['dryer_length' => $l, 'dryer_width' => $w, 'cube_height' => $h1, 'pyramid_height' => $h2, 'dryer_volume' => $l * $w * ($h1+$h2/3)]);
                $cas += $l * $w * ($h1+$h2/3);
            }

            $power = $cas * 0.65 * 13 / 1.75;

            $miller->areas_and_power()->update(['dryer_volume_total' => $cas, 'dryer_power' => $power]);
        }

        if($request->chatal_long){
            $cas = 0;

            foreach ($request->chatal_long as $key => $value ) {
                $miller->chatal_details()->create(['chatal_long' => BanglaConverter::getNumToEn($value), 'chatal_wide' => BanglaConverter::getNumToEn($request->chatal_wide[$key]), 'chatal_area' => BanglaConverter::getNumToEn($value) * BanglaConverter::getNumToEn($request->chatal_wide[$key])]);
                $cas += BanglaConverter::getNumToEn($value) * BanglaConverter::getNumToEn($request->chatal_wide[$key]);
            }

            $power = $cas * 7 / 125;

            $miller->areas_and_power()->update(['chatal_area_total' => $cas, 'chatal_power' => $power]);
        }

        if($request->steeping_house_long){
            $cas = 0;

            foreach ($request->steeping_house_long as $key => $value ) {
                $miller->steeping_house_details()->create(['steeping_house_long' => BanglaConverter::getNumToEn($value), 'steeping_house_wide' => BanglaConverter::getNumToEn($request->steeping_house_wide[$key]), 'steeping_house_height' => BanglaConverter::getNumToEn($request->steeping_house_height[$key]), 'steeping_house_volume' => BanglaConverter::getNumToEn($value) * BanglaConverter::getNumToEn($request->steeping_house_wide[$key]) * BanglaConverter::getNumToEn($request->steeping_house_height[$key])]);
                $cas += BanglaConverter::getNumToEn($value) * BanglaConverter::getNumToEn($request->steeping_house_wide[$key]) * BanglaConverter::getNumToEn($request->steeping_house_height[$key]);
            }

            $power = $cas * 7 / 1.75;

            $miller->areas_and_power()->update(['steping_area_total' => $cas, 'steping_power' => $power]);
        }

     //godown

        if($request->godown_long){
            $cas = 0;

            foreach ($request->godown_long as $key => $value ) {
                $miller->godown_details()->create(['godown_long' => BanglaConverter::getNumToEn($value), 'godown_wide' => BanglaConverter::getNumToEn($request->godown_wide[$key]), 'godown_height' => BanglaConverter::getNumToEn($request->godown_height[$key]), 'godown_valume' => BanglaConverter::getNumToEn($value) * BanglaConverter::getNumToEn($request->godown_wide[$key]) * BanglaConverter::getNumToEn($request->godown_height[$key])]);
                $cas += BanglaConverter::getNumToEn($value) * BanglaConverter::getNumToEn($request->godown_wide[$key]) * BanglaConverter::getNumToEn($request->godown_height[$key]);
            }

            $power = $cas / 4.077;

            $miller->areas_and_power()->update(['godown_area_total' => $cas, 'godown_power' => $power]);

        }

        // Silo

        if($request->silo_radius){
            $cas = 0;

            foreach ($request->silo_radius as $key => $value ) {

                $miller->silo_details()->create(['silo_radius' => BanglaConverter::getNumToEn($value),
                 'silo_height' => BanglaConverter::getNumToEn($request->silo_height[$key]),
                 'silo_volume' =>M_PI * pow(BanglaConverter::getNumToEn($value), 2) * BanglaConverter::getNumToEn($request->silo_height[$key])]);
                $cas +=  M_PI * pow(BanglaConverter::getNumToEn($value), 2) * BanglaConverter::getNumToEn($request->silo_height[$key]);
            }

            $power_silo = $cas / 1.75 ;
            $miller->areas_and_power()->update(['silo_area_total' => $cas,
            'silo_power' => $power_silo,'final_godown_silo_power' => $power_silo + $power]);
        }

        if($request->motor_power_id){
            $cas = 0;

            foreach ($request->motor_power_id as $key => $value ) {
                $motor_power = MotorPower::find($value);
                $miller->motor_details()->create(['motor_horse_power' => $motor_power->motor_power, 'motor_holar_num' => $motor_power->holar_num, 'motor_filter_power' => $motor_power->power_per_hour]);
                $cas += $motor_power->power_per_hour / 1000;
            }

            $power = $cas * 8 * 11;

            $miller->areas_and_power()->update(['motor_area_total' => $cas, 'motor_power' => $power]);
        }

        if($request->sheller_paddy_seperator_output && $request->whitener_grader_output && $request->colour_sorter_output){

            $cas = min($request->sheller_paddy_seperator_output, $request->whitener_grader_output, $request->colour_sorter_output);
            $power = $cas * 60 * 8 * 13 / 1000;
            $power /= 0.65;

            $miller->areas_and_power()->update(['milling_unit_output' => $cas, 'milling_unit_power' => $power]);
        }

        $miller->update($request->all());

        if($miller->mill_type_id==3 || $miller->mill_type_id==4)
        {
            $millar_p_power = min($miller->areas_and_power->chatal_power, $miller->areas_and_power->steping_power, $miller->areas_and_power->godown_power, $miller->areas_and_power->motor_power);
            $miller->update(['millar_p_power' => $millar_p_power, 'millar_p_power_chal' => $millar_p_power * 0.65]);
        }
        elseif($miller->mill_type_id==1)
        {
            $millar_p_power = min($miller->areas_and_power->chatal_power, $miller->areas_and_power->godown_power, $miller->areas_and_power->motor_power);
            $miller->update(['millar_p_power' => $millar_p_power, 'millar_p_power_chal' => $millar_p_power * 0.65]);
        }
        elseif($miller->mill_type_id==5)
        {
            if($miller->chal_type_id != 1)
                $millar_p_power = min($miller->areas_and_power->boiler_power, $miller->areas_and_power->dryer_power, $miller->areas_and_power->final_godown_silo_power, $miller->areas_and_power->milling_unit_power);
            else
                $millar_p_power = min($miller->areas_and_power->dryer_power, $miller->areas_and_power->final_godown_silo_power, $miller->areas_and_power->milling_unit_power);
            $miller->update(['millar_p_power' => $millar_p_power, 'millar_p_power_chal' => $millar_p_power * 0.65]);
        }

        if($request->file('license_deposit_chalan_file')){
            $request->validate([
                'license_deposit_chalan_file' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $chalanImageName = time().'.'.$request->file('license_deposit_chalan_file')->extension();

            $img = Image::make($request->file('license_deposit_chalan_file')->path());

            $img->resize(config('global.img_large_size'), config('global.img_large_size'), function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('images/license_deposit_chalan_file').'/large/'.$chalanImageName);

            $img->resize(config('global.img_thumb_size'), config('global.img_thumb_size'), function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('images/license_deposit_chalan_file').'/thumb/'.$chalanImageName);

            //$request->file('license_deposit_chalan_file')->move(public_path('images/license_deposit_chalan_file'), $chalanImageName);
            $miller->update(['license_deposit_chalan_image'=>$chalanImageName]);
        }
        else
            $chalanImageName = $miller->license_deposit_chalan_image;

        if($request->file('vat_file')){
            $request->validate([
                'vat_file' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $vatImageName = time().'.'.$request->file('vat_file')->extension();

            $img = Image::make($request->file('vat_file')->path());

            $img->resize(config('global.img_large_size'), config('global.img_large_size'), function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('images/vat_file').'/large/'.$vatImageName);

            $img->resize(config('global.img_thumb_size'), config('global.img_thumb_size'), function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('images/vat_file').'/thumb/'.$vatImageName);

            //$request->file('vat_file')->move(public_path('images/vat_file'), $vatImageName);
            $miller->update(['vat_file'=>$vatImageName]);
        }
        else
            $vatImageName = $miller->vat_file;

        if($request->file('signature_file')){
            $request->validate([
                'signature_file' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $signatureImageName = time().'.'.$request->file('signature_file')->extension();

            $img = Image::make($request->file('signature_file')->path());

            $img->resize(config('global.img_large_size'), config('global.img_large_size'), function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('images/signature_file').'/large/'.$signatureImageName);

            $img->resize(config('global.img_thumb_size'), config('global.img_thumb_size'), function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('images/signature_file').'/thumb/'.$signatureImageName);

            //$request->file('signature_file')->move(public_path('images/signature_file'), $signatureImageName);
            $miller->update(['signature_file'=>$signatureImageName]);
        }
        else
            $signatureImageName = $miller->signature_file;

        if($request->license_fee_id){
            $miller->license_histories()->create([
                'miller_id' => $miller->miller_id,
                'license_no' => $request->license_no,
                'date_license' => $request->date_license,
                'date_renewal' => $request->date_renewal,
                'date_last_renewal' => $request->date_last_renewal,
                'license_fee_id' => $request->license_fee_id,
                'license_deposit_amount' => $request->license_deposit_amount,
                'license_deposit_date' => $request->license_deposit_date,
                'license_deposit_bank' => $request->license_deposit_bank,
                'license_deposit_branch' => $request->license_deposit_branch,
                'license_deposit_chalan_no' => $request->license_deposit_chalan_no,
                'license_deposit_chalan_image' => $chalanImageName,
                'vat_file' => $vatImageName,
                'signature_file' => $signatureImageName
            ]);
        }

        if($request->file('photo_file')){
            $request->validate([
                'photo_file' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $imageName = time().'.'.$request->file('photo_file')->extension();

            $img = Image::make($request->file('photo_file')->path());

            $img->resize(config('global.img_large_size'), config('global.img_large_size'), function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('images/photo_file').'/large/'.$imageName);

            $img->resize(config('global.img_thumb_size'), config('global.img_thumb_size'), function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('images/photo_file').'/thumb/'.$imageName);

            //$request->file('photo_file')->move(public_path('images/photo_file'), $imageName);
            $miller->update(['photo_of_miller'=>$imageName]);
        }

        if($request->file('tax_file')){
            $request->validate([
                'tax_file' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $imageName = time().'.'.$request->file('tax_file')->extension();

            $img = Image::make($request->file('tax_file')->path());

            $img->resize(config('global.img_large_size'), config('global.img_large_size'), function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('images/tax_file').'/large/'.$imageName);

            $img->resize(config('global.img_thumb_size'), config('global.img_thumb_size'), function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('images/tax_file').'/thumb/'.$imageName);

            //$request->file('tax_file')->move(public_path('images/tax_file'), $imageName);
            $miller->update(['tax_file_of_miller'=>$imageName]);
        }

        if($request->file('license_file')){
            $request->validate([
                'license_file' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $imageName = time().'.'.$request->file('license_file')->extension();

            $img = Image::make($request->file('license_file')->path());

            $img->resize(config('global.img_large_size'), config('global.img_large_size'), function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('images/license_file').'/large/'.$imageName);

            $img->resize(config('global.img_thumb_size'), config('global.img_thumb_size'), function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('images/license_file').'/thumb/'.$imageName);

            //$request->file('license_file')->move(public_path('images/license_file'), $imageName);
            $miller->update(['license_file_of_miller'=>$imageName]);
        }

        if($request->file('electricity_file')){
            $request->validate([
                'electricity_file' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $imageName = time().'.'.$request->file('electricity_file')->extension();

            $img = Image::make($request->file('electricity_file')->path());

            $img->resize(config('global.img_large_size'), config('global.img_large_size'), function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('images/electricity_file').'/large/'.$imageName);

            $img->resize(config('global.img_thumb_size'), config('global.img_thumb_size'), function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('images/electricity_file').'/thumb/'.$imageName);

            //$request->file('electricity_file')->move(public_path('images/electricity_file'), $imageName);
            $miller->update(['electricity_file_of_miller'=>$imageName]);
        }

        if($request->file('miller_p_power_approval_file')){
            $request->validate([
                'miller_p_power_approval_file' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $imageName = time().'.'.$request->file('miller_p_power_approval_file')->extension();

            $img = Image::make($request->file('miller_p_power_approval_file')->path());

            $img->resize(config('global.img_large_size'), config('global.img_large_size'), function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('images/miller_p_power_approval_file').'/large/'.$imageName);

            $img->resize(config('global.img_thumb_size'), config('global.img_thumb_size'), function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('images/miller_p_power_approval_file').'/thumb/'.$imageName);

            //$request->file('miller_p_power_approval_file')->move(public_path('images/miller_p_power_approval_file'), $imageName);
            $miller->update(['miller_p_power_approval_file'=>$imageName]);
        }

        $mill_type_id = $request->mill_type_id;

        /*
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
                        "Mobile"=> $miller->mobile_no,
                        "Status"=> $miller->miller_status]
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
                        "Mobile"=> $miller->mobile_no,
                        "Status"=> $miller->miller_status]
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
                        "Status"=> $miller->miller_status,
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
                        "Status"=> $miller->miller_status,
                        "Rice_Type"=> $miller->chal_type_id == 1 ? "white":"parboiled",
                        "Mobile"=> $miller->mobile_no,
                        "Meter"=> $miller->meter_no,
                        "Remark"=> "Ok"]
                    );

                    $fps_mill_status = $mill_response != null && $mill_response->status == true ? "insert_success":"insert_fail";
                }

                $fps_mill_last_date = date("Y-m-d H:i:s");

                DB::table('miller')
                    ->where('miller_id', $miller->miller_id)
                    ->update([
                        'fps_mo_status'=> $fps_mo_status,
                        'fps_mo_last_date'=> $fps_mo_last_date,
                        'fps_mill_status'=> $fps_mill_status,
                        'fps_mill_last_date'=> $fps_mill_last_date
                    ]);
            }
        }
        */

        return redirect()->route('millers.edit', $miller->miller_id)->with('success','মিলার এর তথ্য সফলভাবে তৈরি হয়েছে');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Miller  $miller
     * @return \Illuminate\Http\Response
     */
    public function show(Miller $miller)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Miller  $miller
     * @return \Illuminate\Http\Response
     */
    public function edit(Miller $miller, Request $request)
    {
        //dd($miller->miller_birth_place);
        if(!DGFAuth::check2(1,  2)) return view('nopermission');
        $edit_perm=false;
        if(DGFAuth::check2(1,  3)) $edit_perm=true;

        $divisions = DGFAuth::filtereddivision();// Division::all();

        if(Auth::user()->division_id>0){
            if(Auth::user()->district_id>0) {

                $districts = DB::table('district')
                ->where("distid", Auth::user()->district_id)
                ->get();

                if(Auth::user()->upazila_id>0) {
                    $upazillas = DB::table('upazilla')
                    ->where("upazillaid", Auth::user()->upazila_id)
                    ->get();
                }else{
                    $upazillas = DB::table('upazilla')
                    ->where("distid", Auth::user()->district_id)
                    ->get();
                    }
            }else{
                $districts = DB::table('district')
                ->where("divid", Auth::user()->division_id)
                ->get();
                $upazillas = Upazilla::select('upazilla.*')
                ->where('district.divid', Auth::user()->division_id)
                ->join('district', 'district.distid', '=', 'upazilla.distid')->get();
            }
        }
        else{
            $districts = District::all();
            $upazillas = Upazilla::all();
        }

        $districts = $districts
        ->where("divid", $miller->division_id);

        $upazillas = $upazillas
        ->where("distid", $miller->district_id);


        //$licenseFees = LicenseFee::whereDate("effective_todate",'>', date(''))->get();
        $licenseFees = LicenseFee::whereDate('effective_todate', '>', Carbon::today())->get();

        $nobayonTypes = LicenseFee::where('license_type_id', 2)->whereDate("effective_todate",'>', date(''))->pluck('id')->toArray();

        $chalTypes = ChalType::all();
        $millTypes = MillType::orderBy('ordering')->get();
        $motor_powers = MotorPower::all();
        $miller_birth_places = District::all();

        $milling_unit_machinery = DB::table('milling_unit_machinery')
        ->leftJoin('mill_milling_unit_machineries', function (JoinClause $join) use($miller) {
            $join->on('milling_unit_machinery.machinery_id', '=', 'mill_milling_unit_machineries.machinery_id')
                 ->where('mill_milling_unit_machineries.miller_id', '=', $miller->miller_id);
        })
        ->select('mill_milling_unit_machineries.*', 'milling_unit_machinery.name', 'milling_unit_machinery.machinery_id')
        ->get();

        $inactive_reasons = InactiveReason::all()->except(2);
        $corporate_institutes = CorporateInstitute::all();

        $option = $request->query('option');

        $pp_page = session()->get('pp_page');
        $pp_division = session()->get('pp_division');
        $pp_district = session()->get('pp_district');
        $pp_mill_upazila = session()->get('pp_mill_upazila');

        $pp_mill_type_id = session()->get('pp_mill_type_id');
        $pp_chal_type_id = session()->get('pp_chal_type_id');
        $pp_miller_status = session()->get('pp_miller_status');
        $pp_cmp_status = session()->get('pp_cmp_status');
        $pp_owner_type = session()->get('pp_owner_type');
        $pp_searchtext = session()->get('pp_searchtext');

        // Remove English letters and numbers
        //$miller->owner_address = preg_replace('/[a-zA-Z0-9]+/', '', $miller->owner_address);

        // Remove key-value like patterns (colon and quotes)
        //$miller->owner_address = preg_replace("/'[^']*':\s*/", '', $miller->owner_address);

        // Remove empty values and extra commas
        //$miller->owner_address = preg_replace(["/''/", "/,+/", "/'+/", "/\s+/"], ['', ',', "'", ' '], $miller->owner_address);

        // Trim and remove unnecessary leading/trailing commas and quotes
        //$miller->owner_address = trim($miller->owner_address, ",' ");

        if($option && $option == 'licenseonly')
            return view('miller.renew', compact('divisions', 'districts', 'miller_birth_places','upazillas', 'corporate_institutes', 'licenseFees', 'nobayonTypes', 'chalTypes','millTypes','motor_powers','milling_unit_machinery', 'miller', 'edit_perm','pp_page','pp_division','pp_district','pp_mill_upazila','pp_mill_type_id','pp_chal_type_id','pp_miller_status','pp_cmp_status','pp_owner_type','pp_searchtext'));
        else
            return view('miller.edit', compact('divisions', 'districts', 'miller_birth_places', 'upazillas', 'inactive_reasons', 'corporate_institutes', 'licenseFees', 'nobayonTypes', 'chalTypes','millTypes','motor_powers','milling_unit_machinery','miller', 'edit_perm','pp_page','pp_division','pp_district','pp_mill_upazila','pp_mill_type_id','pp_chal_type_id','pp_miller_status','pp_cmp_status','pp_owner_type','pp_searchtext'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Miller  $miller
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Miller $miller)
    {
        if(!DGFAuth::check2(1,  3)) return view('nopermission');

        $millerCheck = DB::table('miller')
        ->where("miller_id", $miller->miller_id)
        ->first();
        $formMessage = "";

        if($request->division_id != null || $request->district_id != null || $request->mill_upazila_id != null)
        {
            if($millerCheck->division_id != $request->division_id || $millerCheck->district_id != $request->district_id || $millerCheck->mill_upazila_id != $request->mill_upazila_id)
            {
                $upazilla = Upazilla::where("upazillaid", $request->mill_upazila_id)
                ->first();
                $form_count = $upazilla->last_miller_sl;
                $request->merge(['form_no' => $request->mill_upazila_id * 10000 + $form_count + 1]);

                $upazilla->update(['last_miller_sl' => $form_count + 1]);
                $formMessage = " এবং নতুন ফর্ম নম্বর তৈরী হয়েছে।";
            }
        }

        if($request->nid_no){
            $owner_miller = DB::table('miller')
            ->where("miller_id", '!=', $miller->miller_id)
            ->where("owner_name", $request->owner_name)
            ->where("father_name", $request->father_name)
            ->where("mother_name", $request->mother_name)
            ->where("birth_date", $request->birth_date)
            ->first();

            if($owner_miller != null && $owner_miller->nid_no != $request->nid_no ){
                return redirect()->route('millers.edit', $miller->miller_id)
                ->withErrors(['millers_nid_no'=>'দয়া করে আগের ব্যবহৃত এনআইডি '. $owner_miller->nid_no .' ব্যভহার করুন।']);
            }

            $millers_nid_no = DB::table('miller')
            ->where("miller_id", '!=', $miller->miller_id)
            ->where("nid_no", $request->nid_no)
            ->get();

            $forms_no = array();
            $is_nid_black_listed = false;

            foreach($millers_nid_no as $miller_nid_no){
                if($miller_nid_no->last_inactive_reason == 'কালো তালিকাভুক্ত (এনআইডি)')
                    $is_nid_black_listed = true;

                $forms_no[] = $miller_nid_no->form_no;
            }

            $form_no = implode(", ", $forms_no);

            if($is_nid_black_listed){
                return redirect()->route('millers.edit', $miller->miller_id)
                ->withErrors(['millers_nid_no'=>'দয়া করে অন্য এনআইডি ব্যভহার করুন। এই এনআইডি টি কালো তালিকাভুক্ত করা হয়েছে। এই এনআইডি এর সংযুক্ত অন্য মিলসমূহঃ '.$form_no]);
            }

            $FPS_NID_VERIFICATION = env('FPS_NID_VERIFICATION');

            if($request->nid_no && $request->birth_date && $FPS_NID_VERIFICATION == "on"){
                $login_response = $this->fps->login();
                if($login_response != null && $login_response->status == true ){
                    $response = $this->fps->nid_verification(['token' => $login_response->result->token,'NID'=>$request->nid_no, 'DOB' => \Carbon\Carbon::parse($request->birth_date)->format("Y-m-d")]);
                    if($response->status != true){
                        return redirect()->back()->withInput()
                        ->withErrors(['millers_nid_no'=>$response->message]);
                    }
                }
            }
        }

        if($request->license_no){
            //duplicate license_no check
            $duplicate_license_no = DB::table('miller')
            ->where("miller_id", '!=', $miller->miller_id)
            ->where("license_no", $request->license_no)
            ->get();

            if(count($duplicate_license_no) > 0)
                return redirect()->route('millers.edit', $miller->miller_id)
                ->withErrors(['duplicate_license_no'=>'ডুপ্লিকেট লাইসেন্স নং, দয়া করে পরিবর্তন করুন।']);
        }

        if($request->boiller_num){
            $boiller_num = BanglaConverter::getNumToEn($request->boiller_num);
            $request->merge(['boiller_num' => $boiller_num]);
        }

        if($request->chimney_height){
            $chimney_height = BanglaConverter::getNumToEn($request->chimney_height);
            $request->merge(['chimney_height' => $chimney_height]);
        }

        if($request->sheller_paddy_seperator_output){
            $sheller_paddy_seperator_output = BanglaConverter::getNumToEn($request->sheller_paddy_seperator_output);
            $request->merge(['sheller_paddy_seperator_output' => $sheller_paddy_seperator_output]);
        }

        if($request->whitener_grader_output){
            $whitener_grader_output = BanglaConverter::getNumToEn($request->whitener_grader_output);
            $request->merge(['whitener_grader_output' => $whitener_grader_output]);
        }

        if($request->colour_sorter_output){
            $colour_sorter_output = BanglaConverter::getNumToEn($request->colour_sorter_output);
            $request->merge(['colour_sorter_output' => $colour_sorter_output]);
        }

        if($request->millar_p_power_chal && $miller->mill_type_id==2){
            $millar_p_power_chal = BanglaConverter::getNumToEn($request->millar_p_power_chal);
            $request->merge(['millar_p_power' => $millar_p_power_chal / 0.65, 'millar_p_power_chal' => $millar_p_power_chal]);
        }

        $login_user_id = auth()->user()->id;
        $request->request->add(['u_id' => $login_user_id]); //add value in request

        if($miller->mill_type_id==2){
            if($request->license_section){
                $miller->autometic_miller()->update(['pro_flowdiagram' => $request->pro_flowdiagram, 'origin' => $request->origin, 'visited_date' => $request->visited_date]);
            }

            if($request->autometic_mechin_section){
                $miller->autometic_miller()->update(['machineries_a' => $request->machineries_a, 'machineries_b' => $request->machineries_b, 'machineries_c' => $request->machineries_c,
                'machineries_d' => $request->machineries_d, 'machineries_e' => $request->machineries_e, 'machineries_f' => $request->machineries_f]);
            }

            if($request->auto_para_section){
                $miller->autometic_miller()->update(['parameter1_name' => $request->parameter1_name, 'parameter1_num' => $request->parameter1_num, 'parameter1_power' => $request->parameter1_power, 'parameter1_topower' => $request->parameter1_topower,
                'parameter2_name' => $request->parameter2_name, 'parameter2_num' => $request->parameter2_num, 'parameter2_power' => $request->parameter2_power, 'parameter2_topower' => $request->parameter2_topower,
                'parameter3_name' => $request->parameter3_name, 'parameter3_num' => $request->parameter3_num, 'parameter3_power' => $request->parameter3_power, 'parameter3_topower' => $request->parameter3_topower,
                'parameter4_name' => $request->parameter4_name, 'parameter4_num' => $request->parameter4_num, 'parameter4_power' => $request->parameter4_power, 'parameter4_topower' => $request->parameter4_topower,
                'parameter5_name' => $request->parameter5_name, 'parameter5_num' => $request->parameter5_num, 'parameter5_power' => $request->parameter5_power, 'parameter5_topower' => $request->parameter5_topower,
                'parameter6_name' => $request->parameter6_name, 'parameter6_num' => $request->parameter6_num, 'parameter6_power' => $request->parameter6_power, 'parameter6_topower' => $request->parameter6_topower,
                'parameter7_name' => $request->parameter7_name, 'parameter7_num' => $request->parameter7_num, 'parameter7_power' => $request->parameter7_power, 'parameter7_topower' => $request->parameter7_topower,
                'parameter8_name' => $request->parameter8_name, 'parameter8_num' => $request->parameter8_num, 'parameter8_power' => $request->parameter8_power, 'parameter8_topower' => $request->parameter8_topower,
                'parameter9_name' => $request->parameter9_name, 'parameter9_num' => $request->parameter9_num, 'parameter9_power' => $request->parameter9_power, 'parameter9_topower' => $request->parameter9_topower,
                'parameter10_name' => $request->parameter10_name, 'parameter10_num' => $request->parameter10_num, 'parameter10_power' => $request->parameter10_power, 'parameter10_topower' => $request->parameter10_topower,
                'parameter11_name' => $request->parameter11_name, 'parameter11_num' => $request->parameter11_num, 'parameter11_power' => $request->parameter11_power, 'parameter11_topower' => $request->parameter11_topower,
                'parameter12_name' => $request->parameter12_name, 'parameter12_num' => $request->parameter12_num, 'parameter12_power' => $request->parameter12_power, 'parameter12_topower' => $request->parameter12_topower,
                'parameter13_name' => $request->parameter13_name, 'parameter13_num' => $request->parameter13_num, 'parameter13_power' => $request->parameter13_power, 'parameter13_topower' => $request->parameter13_topower,
                'parameter14_name' => $request->parameter14_name, 'parameter14_num' => $request->parameter14_num, 'parameter14_power' => $request->parameter14_power, 'parameter14_topower' => $request->parameter14_topower,
                'parameter15_name' => $request->parameter15_name, 'parameter15_num' => $request->parameter15_num, 'parameter15_power' => $request->parameter15_power, 'parameter15_topower' => $request->parameter15_topower,
                'parameter16_name' => $request->parameter16_name, 'parameter16_num' => $request->parameter16_num, 'parameter16_power' => $request->parameter16_power, 'parameter16_topower' => $request->parameter16_topower,
                'parameter17_name' => $request->parameter17_name, 'parameter17_num' => $request->parameter17_num, 'parameter17_power' => $request->parameter17_power, 'parameter17_topower' => $request->parameter17_topower,
                'parameter18_name' => $request->parameter18_name, 'parameter18_num' => $request->parameter18_num, 'parameter18_power' => $request->parameter18_power, 'parameter18_topower' => $request->parameter18_topower,
                'parameter19_name' => $request->parameter19_name, 'parameter19_topower' => $request->parameter19_topower
                ]);
            }
        }

        if($request->godown_long){
            $cas = 0;

            foreach ($request->godown_long as $key => $value ) {
                $id = $request->godown_id[$key];
                if(!$id){
                    $miller->godown_details()->create(['godown_long' => BanglaConverter::getNumToEn($value), 'godown_wide' => BanglaConverter::getNumToEn($request->godown_wide[$key]), 'godown_height' => BanglaConverter::getNumToEn($request->godown_height[$key]), 'godown_valume' => BanglaConverter::getNumToEn($value) * BanglaConverter::getNumToEn($request->godown_wide[$key]) * BanglaConverter::getNumToEn($request->godown_height[$key])]);
                }else{
                    $godown_detail = GodownDetail::find($id);
                    $godown_detail->update(['godown_long' => BanglaConverter::getNumToEn($value), 'godown_wide' => BanglaConverter::getNumToEn($request->godown_wide[$key]), 'godown_height' => BanglaConverter::getNumToEn($request->godown_height[$key]), 'godown_valume' => BanglaConverter::getNumToEn($value) * BanglaConverter::getNumToEn($request->godown_wide[$key]) * BanglaConverter::getNumToEn($request->godown_height[$key])]);
                }
                $cas += BanglaConverter::getNumToEn($value) * BanglaConverter::getNumToEn($request->godown_wide[$key]) * BanglaConverter::getNumToEn($request->godown_height[$key]);
            }

            $power = $cas / 4.077;


            $miller->areas_and_power()->update(['godown_area_total' => $cas, 'godown_power' => $power, 'final_godown_silo_power' => $power]);
        }

        if($miller->mill_type_id==5){
            if($request->license_section){
                $miller->autometic_miller_new()->update(['pro_flowdiagram' => $request->pro_flowdiagram, 'origin' => $request->origin, 'milling_parts_manufacturer' => $request->milling_parts_manufacturer, 'milling_parts_manufacturer_type' => $request->milling_parts_manufacturer_type]);
            }

            if($request->file('boiler_certificate_file')){
                $request->validate([
                    'boiler_certificate_file' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                ]);

                $imageName = time().'.'.$request->file('boiler_certificate_file')->extension();

                $img = Image::make($request->file('boiler_certificate_file')->path());

                $img->resize(config('global.img_large_size'), config('global.img_large_size'), function ($constraint) {
                    $constraint->aspectRatio();
                })->save(public_path('images/boiler_certificate_file').'/large/'.$imageName);

                $img->resize(config('global.img_thumb_size'), config('global.img_thumb_size'), function ($constraint) {
                    $constraint->aspectRatio();
                })->save(public_path('images/boiler_certificate_file').'/thumb/'.$imageName);

                //$request->file('boiler_certificate_file')->move(public_path('images/boiler_certificate_file'), $imageName);
                $miller->autometic_miller_new()->update(['boiler_certificate_file'=>$imageName]);
            }

            if($request->milling_unit_machinery_machinery_id){

                foreach ($request->milling_unit_machinery_machinery_id as $key => $value ) {
                    $n = BanglaConverter::getNumToEn($request->milling_unit_machinery_num[$key]);
                    $p = BanglaConverter::getNumToEn($request->milling_unit_machinery_power[$key]);
                    $hp = BanglaConverter::getNumToEn($request->milling_unit_machinery_horse_power[$key]);
                    $tp = $request->milling_unit_machinery_join_type[$key] == "অনুক্রম" ? $p : $n * $p;

                    $id = $request->mill_milling_unit_machinery_id[$key];
                    if(!$id){
                        $miller->mill_milling_unit_machineries()->create([
                            'machinery_id' => $value,
                            'name' => $request->milling_unit_machinery_name[$key],
                            'brand' => $request->milling_unit_machinery_brand[$key],
                            'manufacturer_country' => $request->milling_unit_machinery_manufacturer_country[$key],
                            'import_date' => $request->milling_unit_machinery_import_date[$key],
                            'join_type' => $request->milling_unit_machinery_join_type[$key],
                            'num' => $n,
                            'power' => $p,
                            'topower' => $tp,
                            'horse_power' => $hp
                        ]);
                    }else{
                        $mill_milling_unit_machineries = MillMillingUnitMachineries::find($id);
                        $mill_milling_unit_machineries->update([
                            'machinery_id' => $value,
                            'name' => $request->milling_unit_machinery_name[$key],
                            'brand' => $request->milling_unit_machinery_brand[$key],
                            'manufacturer_country' => $request->milling_unit_machinery_manufacturer_country[$key],
                            'import_date' => $request->milling_unit_machinery_import_date[$key],
                            'join_type' => $request->milling_unit_machinery_join_type[$key],
                            'num' => $n,
                            'power' => $p,
                            'topower' => $tp,
                            'horse_power' => $hp
                        ]);
                    }
                }
            }

            if($request->boiler_machineries_name){
                $cas = 0;

                foreach ($request->boiler_machineries_name as $key => $value ) {
                    $n = BanglaConverter::getNumToEn($request->boiler_machineries_num[$key]);
                    $p = BanglaConverter::getNumToEn($request->boiler_machineries_power[$key]);
                    $pr = BanglaConverter::getNumToEn($request->boiler_machineries_pressure[$key]);
                    $hp = 0;//BanglaConverter::getNumToEn($request->boiler_machineries_horse_power[$key]);

                    $id = $request->mill_boiler_machinery_id[$key];
                    if(!$id){
                        $miller->mill_boiler_machineries()->create([
                            'name' => $value,
                            'brand' => $request->boiler_machineries_brand[$key],
                            'manufacturer_country' => $request->boiler_machineries_manufacturer_country[$key],
                            'import_date' => $request->boiler_machineries_import_date[$key],
                            'pressure' => $pr,
                            'num' => $n,
                            'power' => $p,
                            'topower' => $n * $p,
                            'horse_power' => $hp
                        ]);
                    }else{
                        $mill_boiler_machineries = MillBoilerMachineries::find($id);
                        $mill_boiler_machineries->update([
                            'name' => $value,
                            'brand' => $request->boiler_machineries_brand[$key],
                            'manufacturer_country' => $request->boiler_machineries_manufacturer_country[$key],
                            'import_date' => $request->boiler_machineries_import_date[$key],
                            'pressure' => $pr,
                            'num' => $n,
                            'power' => $p,
                            'topower' => $n * $p,
                            'horse_power' => $hp
                        ]);
                    }

                    $cas += $n * $p;
                }

                $power = $cas * 12;

                $miller->areas_and_power()->update(['boiler_machineries_steampower' => $cas, 'boiler_machineries_power' => $power]);
            }
            if($request->silo_radius ){
               // dd($request->silo_radius);
                $cas = 0;

                foreach ($request->silo_radius as $key => $value ) {

                    $id = $request->silo_id[$key];
                    if(!$id){
                        $miller->silo_details()->create(['silo_radius' => BanglaConverter::getNumToEn($value),
                        'silo_height' => BanglaConverter::getNumToEn($request->silo_height[$key]),
                        'silo_volume' =>M_PI * pow(BanglaConverter::getNumToEn($value), 2) * BanglaConverter::getNumToEn($request->silo_height[$key])]);
                      
                    }else{
                        $silo_detail = SiloDetail::find($id);
                        $silo_detail->update(['silo_radius' => BanglaConverter::getNumToEn($value),
                        'silo_height' => BanglaConverter::getNumToEn($request->silo_height[$key]),
                        'silo_volume' =>M_PI * pow(BanglaConverter::getNumToEn($value), 2) * BanglaConverter::getNumToEn($request->silo_height[$key])]);
                    }
                    $cas +=  M_PI * pow(BanglaConverter::getNumToEn($value), 2) * BanglaConverter::getNumToEn($request->silo_height[$key]);

                }

                $power_silo = $cas / 1.75 ;
                $gdpw = DB::table('areas_and_powers')
                            ->where("miller_id", $miller->miller_id)
                            ->value('godown_power');
                $power_godown = $gdpw;
                //dd($power_godown);
                $miller->areas_and_power()->update(['silo_area_total' => $cas,
                'silo_power' => $power_silo,'final_godown_silo_power' => $power_silo + $power_godown]);
            }
        }

        if($request->boiler_radius && $request->chal_type_id !=1){
            $cas = 0;
            $qty_sum = 0;

            foreach ($request->boiler_radius as $key => $value ) {
                $r = BanglaConverter::getNumToEn($value);
                $h1 = BanglaConverter::getNumToEn($request->cylinder_height[$key]);
                $h2 = BanglaConverter::getNumToEn($request->cone_height[$key]);
                $qty = BanglaConverter::getNumToEn($request->qty[$key]);

                $id = $request->boiler_id[$key];
                if(!$id){
                    $miller->boiler_details()->create(['boiler_radius' => $r, 'cylinder_height' => $h1, 'cone_height' => $h2, 'boiler_volume' => pi() * $r * $r * ($h1+$h2/3), 'qty' => $qty]);
                }else{
                    $boiler_detail = BoilerDetail::find($id);
                    $boiler_detail->update(['boiler_radius' => $r, 'cylinder_height' => $h1, 'cone_height' => $h2, 'boiler_volume' => pi() * $r * $r * ($h1+$h2/3), 'qty' => $qty]);
                }
                $cas += pi() * $r * $r * ($h1+$h2/3) * $qty;
                $qty_sum += $qty;
            }

            $power = $cas * 13 / 1.75;

            $miller->areas_and_power()->update(['boiler_number_total' => $qty_sum, 'boiler_volume_total' => $cas, 'boiler_power' => $power]);
        }

        if($request->dryer_length){
            $cas = 0;

            foreach ($request->dryer_length as $key => $value ) {
                $l = BanglaConverter::getNumToEn($value);
                $w = BanglaConverter::getNumToEn($request->dryer_width[$key]);
                $h1 = BanglaConverter::getNumToEn($request->cube_height[$key]);
                $h2 = BanglaConverter::getNumToEn($request->pyramid_height[$key]);

                $id = $request->dryer_id[$key];

                if(!$id){
                    $miller->dryer_details()->create(['dryer_length' => $l, 'dryer_width' => $w, 'cube_height' => $h1, 'pyramid_height' => $h2, 'dryer_volume' => $l * $w * ($h1+$h2/3)]);
                }else{
                    $dryer_detail = DryerDetail::find($id);
                    $dryer_detail->update(['dryer_length' => $l, 'dryer_width' => $w, 'cube_height' => $h1, 'pyramid_height' => $h2, 'dryer_volume' => $l * $w * ($h1+$h2/3)]);
                }
                $cas += $l * $w * ($h1+$h2/3);
            }

            $power = $cas * 0.65 * 13 / 1.75;

            $miller->areas_and_power()->update(['dryer_volume_total' => $cas, 'dryer_power' => $power]);
        }

        if($request->chatal_long){
            $cas = 0;

            foreach ($request->chatal_long as $key => $value ) {
                $id = $request->chatal_id[$key];
                if(!$id){
                    $miller->chatal_details()->create(['chatal_long' => BanglaConverter::getNumToEn($value), 'chatal_wide' => BanglaConverter::getNumToEn($request->chatal_wide[$key]), 'chatal_area' => BanglaConverter::getNumToEn($value) * BanglaConverter::getNumToEn($request->chatal_wide[$key])]);
                }else{
                    $chatal_detail = ChatalDetail::find($id);
                    $chatal_detail->update(['chatal_long' => BanglaConverter::getNumToEn($value), 'chatal_wide' => BanglaConverter::getNumToEn($request->chatal_wide[$key]), 'chatal_area' => BanglaConverter::getNumToEn($value) * BanglaConverter::getNumToEn($request->chatal_wide[$key])]);
                }
                $cas += BanglaConverter::getNumToEn($value) * BanglaConverter::getNumToEn($request->chatal_wide[$key]);
            }

            $power = $cas * 7 / 125;

            $miller->areas_and_power()->update(['chatal_area_total' => $cas, 'chatal_power' => $power]);
        }

        if($request->steeping_house_long){
            $cas = 0;

            foreach ($request->steeping_house_long as $key => $value ) {
                $id = $request->steeping_house_id[$key];
                if(!$id){
                    $miller->steeping_house_details()->create(['steeping_house_long' => BanglaConverter::getNumToEn($value), 'steeping_house_wide' => BanglaConverter::getNumToEn($request->steeping_house_wide[$key]), 'steeping_house_height' => BanglaConverter::getNumToEn($request->steeping_house_height[$key]), 'steeping_house_volume' => BanglaConverter::getNumToEn($value) * BanglaConverter::getNumToEn($request->steeping_house_wide[$key]) * BanglaConverter::getNumToEn($request->steeping_house_height[$key])]);
                }else{
                    $steeping_house_detail = SteepingHouseDetail::find($id);
                    $steeping_house_detail->update(['steeping_house_long' => BanglaConverter::getNumToEn($value), 'steeping_house_wide' => BanglaConverter::getNumToEn($request->steeping_house_wide[$key]), 'steeping_house_height' => BanglaConverter::getNumToEn($request->steeping_house_height[$key]), 'steeping_house_volume' => BanglaConverter::getNumToEn($value) * BanglaConverter::getNumToEn($request->steeping_house_wide[$key]) * BanglaConverter::getNumToEn($request->steeping_house_height[$key])]);
                }
                $cas += BanglaConverter::getNumToEn($value) * BanglaConverter::getNumToEn($request->steeping_house_wide[$key]) * BanglaConverter::getNumToEn($request->steeping_house_height[$key]);
            }

            $power = $cas * 7 / 1.75;

            $miller->areas_and_power()->update(['steping_area_total' => $cas, 'steping_power' => $power]);
        }

        if($request->motor_power_id){
            $cas = 0;

            foreach ($request->motor_power_id as $key => $value ) {
                $motor_power = MotorPower::find($value);
                $id = $request->motor_id[$key];
                if(!$id){
                    $miller->motor_details()->create(['motor_horse_power' => $motor_power->motor_power, 'motor_holar_num' => $motor_power->holar_num, 'motor_filter_power' => $motor_power->power_per_hour]);
                }else{
                    $motor_detail = MotorDetail::find($id);
                    $motor_detail->update(['motor_horse_power' => $motor_power->motor_power, 'motor_holar_num' => $motor_power->holar_num, 'motor_filter_power' => $motor_power->power_per_hour]);
                }
                $cas += $motor_power->power_per_hour / 1000;
            }

            $power = $cas * 8 * 11;

            $miller->areas_and_power()->update(['motor_area_total' => $cas, 'motor_power' => $power]);
        }

        if($request->sheller_paddy_seperator_output && $request->whitener_grader_output && $request->colour_sorter_output){

            $cas = min($request->sheller_paddy_seperator_output, $request->whitener_grader_output, $request->colour_sorter_output);
            $power = $cas * 60 * 8 * 13 / 1000;
            $power /= 0.65;

            $miller->areas_and_power()->update(['milling_unit_output' => $cas, 'milling_unit_power' => $power]);
        }

        $miller->update($request->all());

        if($miller->mill_type_id==3 || $miller->mill_type_id==4)
        {
            $millar_p_power = min($miller->areas_and_power->chatal_power, $miller->areas_and_power->steping_power, $miller->areas_and_power->godown_power, $miller->areas_and_power->motor_power);
            $miller->update(['millar_p_power' => $millar_p_power, 'millar_p_power_chal' => $millar_p_power * 0.65]);
        }
        elseif($miller->mill_type_id==1)
        {
            $millar_p_power = min($miller->areas_and_power->chatal_power, $miller->areas_and_power->godown_power, $miller->areas_and_power->motor_power);
            $miller->update(['millar_p_power' => $millar_p_power, 'millar_p_power_chal' => $millar_p_power * 0.65]);
        }
        elseif($miller->mill_type_id==5)
        {
            if($miller->chal_type_id != 1)
                $millar_p_power = min($miller->areas_and_power->boiler_power, $miller->areas_and_power->dryer_power, $miller->areas_and_power->final_godown_silo_power, $miller->areas_and_power->milling_unit_power);
            else
                $millar_p_power = min($miller->areas_and_power->dryer_power, $miller->areas_and_power->final_godown_silo_power, $miller->areas_and_power->milling_unit_power);

            $miller->update(['millar_p_power' => $millar_p_power, 'millar_p_power_chal' => $millar_p_power * 0.65]);
        }

        if($request->file('license_deposit_chalan_file')){
            $request->validate([
                'license_deposit_chalan_file' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $chalanImageName = time().'.'.$request->file('license_deposit_chalan_file')->extension();

            $img = Image::make($request->file('license_deposit_chalan_file')->path());

            $img->resize(config('global.img_large_size'), config('global.img_large_size'), function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('images/license_deposit_chalan_file').'/large/'.$chalanImageName);

            $img->resize(config('global.img_thumb_size'), config('global.img_thumb_size'), function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('images/license_deposit_chalan_file').'/thumb/'.$chalanImageName);

            //$request->file('license_deposit_chalan_file')->move(public_path('images/license_deposit_chalan_file'), $chalanImageName);
            $miller->update(['license_deposit_chalan_image'=>$chalanImageName]);
        }
        else
            $chalanImageName = $miller->license_deposit_chalan_image;

        if($request->file('vat_file')){

            $request->validate([
                'vat_file' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $vatImageName = time().'.'.$request->file('vat_file')->extension();

            $img = Image::make($request->file('vat_file')->path());

            $img->resize(config('global.img_large_size'), config('global.img_large_size'), function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('images/vat_file').'/large/'.$vatImageName);

            $img->resize(config('global.img_thumb_size'), config('global.img_thumb_size'), function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('images/vat_file').'/thumb/'.$vatImageName);

            $request->file('vat_file')->move(public_path('images/vat_file'), $vatImageName);
            $miller->update(['vat_file'=>$vatImageName]);
        }
        else
            $vatImageName = $miller->vat_file;

        if($request->file('signature_file')){
            $request->validate([
                'signature_file' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $signatureImageName = time().'.'.$request->file('signature_file')->extension();

            $img = Image::make($request->file('signature_file')->path());

            $img->resize(config('global.img_large_size'), config('global.img_large_size'), function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('images/signature_file').'/large/'.$signatureImageName);

            $img->resize(config('global.img_thumb_size'), config('global.img_thumb_size'), function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('images/signature_file').'/thumb/'.$signatureImageName);

            //$request->file('signature_file')->move(public_path('images/signature_file'), $signatureImageName);
            $miller->update(['signature_file'=>$signatureImageName]);
        }
        else
            $signatureImageName = $miller->signature_file;

        if($request->license_fee_id){
            $miller->license_histories()->create([
            'miller_id' => $miller->miller_id,
            'license_no' => $request->license_no,
            'date_license' => $request->date_license,
            'date_renewal' => $request->date_renewal,
            'date_last_renewal' => $request->date_last_renewal,
            'license_fee_id' => $request->license_fee_id,
            'license_deposit_amount' => $request->license_deposit_amount,
            'license_deposit_date' => $request->license_deposit_date,
            'license_deposit_bank' => $request->license_deposit_bank,
            'license_deposit_branch' => $request->license_deposit_branch,
            'license_deposit_chalan_no' => $request->license_deposit_chalan_no,
            'license_deposit_chalan_image' => $chalanImageName,
            'vat_file' => $vatImageName,
            'signature_file' => $signatureImageName
            ]);
        }

        if($request->file('photo_file')){
            $request->validate([
                'photo_file' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $imageName = time().'.'.$request->file('photo_file')->extension();

            $img = Image::make($request->file('photo_file')->path());

            $img->resize(config('global.img_large_size'), config('global.img_large_size'), function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('images/photo_file').'/large/'.$imageName);

            $img->resize(config('global.img_thumb_size'), config('global.img_thumb_size'), function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('images/photo_file').'/thumb/'.$imageName);

            //$request->file('photo_file')->move(public_path('images/photo_file'), $imageName);
            $miller->update(['photo_of_miller'=>$imageName]);
        }

        if($request->file('tax_file')){
            $request->validate([
                'tax_file' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $imageName = time().'.'.$request->file('tax_file')->extension();

            $img = Image::make($request->file('tax_file')->path());

            $img->resize(config('global.img_large_size'), config('global.img_large_size'), function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('images/tax_file').'/large/'.$imageName);

            $img->resize(config('global.img_thumb_size'), config('global.img_thumb_size'), function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('images/tax_file').'/thumb/'.$imageName);

            //$request->file('tax_file')->move(public_path('images/tax_file'), $imageName);
            $miller->update(['tax_file_of_miller'=>$imageName]);
        }

        if($request->file('license_file')){
            $request->validate([
                'license_file' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $imageName = time().'.'.$request->file('license_file')->extension();

            $img = Image::make($request->file('license_file')->path());

            $img->resize(config('global.img_large_size'), config('global.img_large_size'), function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('images/license_file').'/large/'.$imageName);

            $img->resize(config('global.img_thumb_size'), config('global.img_thumb_size'), function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('images/license_file').'/thumb/'.$imageName);

            //$request->file('license_file')->move(public_path('images/license_file'), $imageName);
            $miller->update(['license_file_of_miller'=>$imageName]);
        }

        if($request->file('electricity_file')){
            $request->validate([
                'electricity_file' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $imageName = time().'.'.$request->file('electricity_file')->extension();

            $img = Image::make($request->file('electricity_file')->path());

            $img->resize(config('global.img_large_size'), config('global.img_large_size'), function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('images/electricity_file').'/large/'.$imageName);

            $img->resize(config('global.img_thumb_size'), config('global.img_thumb_size'), function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('images/electricity_file').'/thumb/'.$imageName);

            //$request->file('electricity_file')->move(public_path('images/electricity_file'), $imageName);
            $miller->update(['electricity_file_of_miller'=>$imageName]);
        }

        if($request->file('miller_p_power_approval_file')){
            $request->validate([
                'miller_p_power_approval_file' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $imageName = time().'.'.$request->file('miller_p_power_approval_file')->extension();

            $img = Image::make($request->file('miller_p_power_approval_file')->path());

            $img->resize(config('global.img_large_size'), config('global.img_large_size'), function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('images/miller_p_power_approval_file').'/large/'.$imageName);

            $img->resize(config('global.img_thumb_size'), config('global.img_thumb_size'), function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('images/miller_p_power_approval_file').'/thumb/'.$imageName);

            //$request->file('miller_p_power_approval_file')->move(public_path('images/miller_p_power_approval_file'), $imageName);
            $miller->update(['miller_p_power_approval_file'=>$imageName]);
        }

        /*
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
                        "Mobile"=> $miller->mobile_no,
                        "Status"=> $miller->miller_status]
                    );

                    $fps_mo_status = $mo_response != null && $mo_response->status == true ? "update_success":"update_fail";
                }
                else{
                    $FPS_NID_VERIFICATION  = env('FPS_NID_VERIFICATION');

                    if($request->nid_no && $request->birth_date && $FPS_NID_VERIFICATION == "on"){
                        $login_response = $this->fps->login();
                        if($login_response != null && $login_response->status == true ){
                            $response = $this->fps->nid_verification(['token' => $login_response->result->token,'NID'=>$request->nid_no, 'DOB' => \Carbon\Carbon::parse($request->birth_date)->format("Y-m-d")]);
                            if($response->status != true){
                                return redirect()->back()->withInput()
                                ->withErrors(['millers_nid_no'=>$response->message]);
                            }
                        }
                    }

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
                        "Mobile"=> $miller->mobile_no,
                        "Status"=> $miller->miller_status]
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
                        "Status"=> $miller->miller_status,
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
                        "Status"=> $miller->miller_status,
                        "Rice_Type"=> $miller->chal_type_id == 1 ? "white":"parboiled",
                        "Mobile"=> $miller->mobile_no,
                        "Meter"=> $miller->meter_no,
                        "Remark"=> "Ok"]
                    );
                      //New Add For Update Old License
                    if($mill_response->status == true){
                        if($millerCheck->license_no != null && $millerCheck->license_no !=""){
                            if($miller->license_no != $millerCheck->license_no){

                                $old_mill_exist = $this->fps->get_mill([
                                    'token' => $login_response->result->token,
                                    'License' => $millerCheck->license_no]
                                );

                                if($old_mill_exist){
                                    $mill_response = $this->fps->update_mill([
                                        'token' => $login_response->result->token,
                                        'NID'=> $millerCheck->nid_no,
                                        "Name"=> $millerCheck->mill_name,
                                        "Address"=> $millerCheck->mill_address,
                                        "District"=> $millerCheck->district != null ? $millerCheck->district->name : "",
                                        "Upazila"=> $millerCheck->upazilla != null ? $millerCheck->upazilla->name : "",
                                        "Mill_Type"=> $mill_type,
                                        "Capacity"=> $millerCheck->millar_p_power_chal,
                                        "License"=> $millerCheck->license_no,
                                        "Issue_Date"=> $millerCheck->date_license != null ? $millerCheck->date_license->format("Y-m-d") : "",
                                        "Renew_Date"=> $millerCheck->date_renewal != null ? $millerCheck->date_renewal->format("Y-m-d") : "",
                                        "Status"=> "inactive",
                                        "Rice_Type"=> $millerCheck->chal_type_id == 1 ? "white":"parboiled",
                                        "Mobile"=> $millerCheck->mobile_no,
                                        "Meter"=> $millerCheck->meter_no,
                                        "Remark"=> "Old_LC_Update"]
                                    );
                                }


                               }
                        }

                    }

                    $fps_mill_status = $mill_response != null && $mill_response->status == true ? "insert_success":"insert_fail";

                }

                $fps_mill_last_date = date("Y-m-d H:i:s");

                DB::table('miller')
                    ->where('miller_id', $miller->miller_id)
                    ->update([
                        'fps_mo_status'=> $fps_mo_status,
                        'fps_mo_last_date'=> $fps_mo_last_date,
                        'fps_mill_status'=> $fps_mill_status,
                        'fps_mill_last_date'=> $fps_mill_last_date
                    ]);
            }
        }
        */

        $option = $request->option;

        if($option && $option == 'licenseonly')
            return redirect(route('millers.edit', $miller->miller_id)."?option=licenseonly")->with('success','মিলার এর তথ্য সফলভাবে পরিবর্তন করা হয়েছে');
        else
            return redirect()->route('millers.edit', $miller->miller_id)->with('success','মিলার এর তথ্য সফলভাবে পরিবর্তন করা হয়েছে'.$formMessage);
    }

   /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Miller  $miller
     * @return \Illuminate\Http\Response
     */

    public function moveToHalnagadAutometic(Request $request)
    {
        //dd($miller->mill_type_id);

        if(!DGFAuth::check2(1,  3)) return view('nopermission');
        $miller_id = $request->get('miller_id');
        $miller = Miller::find($miller_id);

        $pp_page = session()->get('pp_page');
        $pp_division = session()->get('pp_division');
        $pp_district = session()->get('pp_district');
        $pp_mill_upazila = session()->get('pp_mill_upazila');

        $pp_mill_type_id = session()->get('pp_mill_type_id');
        $pp_miller_status = session()->get('pp_miller_status');
        $pp_cmp_status = session()->get('pp_cmp_status');
        $pp_owner_type = session()->get('pp_owner_type');
        $pp_searchtext = session()->get('pp_searchtext');

        //dd($miller->miller_id);

        if($miller->mill_type_id!= "2"){
            return redirect()->route('millers.list', ['page'=> $pp_page, 'division_id'=> $pp_division, 'district_id'=> $pp_district, 'mill_upazila_id'=> $pp_mill_upazila, 'mill_type_id'=> $pp_mill_type_id, 'miller_status'=> $pp_miller_status, 'cmp_status'=> $pp_cmp_status, 'owner_type'=> $pp_owner_type, 'searchtext'=> $pp_searchtext])->with('message', 'শুধু অটোমেটিক মিল্ পরিবর্তন করা যাবে|');
        }
        if($miller->mill_type_id == "2"){
            $miller->update(['mill_type_id' => '5', 'changed_mill_type' => 1, 'millar_p_power'=>0, 'millar_p_power_chal'=>0]);

            // Delete Autometic Jontopati

            $miller->autometic_miller()
                ->where("miller_id", $miller->miller_id)
                ->delete();

            // Areas and Power

            $miller->areas_and_power()->update(['miller_id' => $miller->miller_id, 'boiler_machineries_steampower' => 0, 'boiler_machineries_power' => 0, 'boiler_number_total' => 0, 'boiler_volume_total' => 0, 'boiler_power' => 0,'dryer_volume_total' => 0, 'dryer_power' => 0,'chatal_area_total' => 0, 'chatal_power' => 0,'godown_area_total' => 0, 'godown_power' => 0,'steping_area_total' => 0, 'steping_power' => 0,'motor_area_total' => 0, 'motor_power' => 0,'milling_unit_output' => 0, 'milling_unit_power' => 0]);

            // Autometic New Miller

            $miller->autometic_miller_new()->create(['miller_id' => $miller->miller_id,
            'pro_flowdiagram' => '',
            'origin' => '',
            'milling_parts_manufacturer' => '',
            'milling_parts_manufacturer_type' => 'একক কোম্পানী' ,
            'boiler_certificate_file' => ''
        ]);

           // Mill Milling Units Machineries

            $milling_unit_machinerys = MillingUnitMachinery::all();

            foreach ($milling_unit_machinerys as $milling_unit_machinery) {
                $n = BanglaConverter::getNumToEn(0);
                $p = BanglaConverter::getNumToEn(0);
                $hp = BanglaConverter::getNumToEn(0);
                $tp = BanglaConverter::getNumToEn(0);;

                $miller->mill_milling_unit_machineries()->create([
                    'miller_id' => $miller->miller_id,
                    'machinery_id' => $milling_unit_machinery->machinery_id,
                    'name' => $milling_unit_machinery->name,
                    'brand' => '',
                    'manufacturer_country' => '',
                    //'import_date' => '',
                    'join_type' =>'',
                    'num' => $n,
                    'power' => $p,
                    'topower' => $tp,
                    'horse_power' => $hp
                ]);
            }

            // Mill Boiler Machineries

            $cas = 0;

            $n = BanglaConverter::getNumToEn(0);
            $p = BanglaConverter::getNumToEn(0);
            $pr = BanglaConverter::getNumToEn(0);
            $hp = 0;//BanglaConverter::getNumToEn($request->boiler_machineries_horse_power[$key]);

            $miller->mill_boiler_machineries()->create([
                'miller_id' => $miller->miller_id,
                'name' => 'বয়লার',
                'brand' => '',
                'manufacturer_country' => '',
                //'import_date' => $request->boiler_machineries_import_date[$key],
                'pressure' => $pr,
                'num' => $n,
                'power' => $p,
                'topower' => $n * $p,
                'horse_power' => $hp
            ]);

            $cas += $n * $p;

                $power = $cas * 12;

                $miller->areas_and_power()->update(['boiler_machineries_steampower' => $cas, 'boiler_machineries_power' => $power]);


            // Boiler Details
                $cas = 0;
                $qty_sum = 0;

                $r = BanglaConverter::getNumToEn(0);
                $h1 = BanglaConverter::getNumToEn(0);
                $h2 = BanglaConverter::getNumToEn(0);
                $qty = BanglaConverter::getNumToEn(1);

                $miller->boiler_details()->create(['boiler_radius' => $r,
                'miller_id' => $miller->miller_id,
                'cylinder_height' => $h1, 'cone_height' => $h2,
                'boiler_volume' => pi() * $r * $r * ($h1+$h2/3), 'qty' => $qty]);
                $cas += pi() * $r * $r * ($h1+$h2/3) * $qty;
                $qty_sum += $qty;

                $power = $cas * 13 / 1.75;

                $miller->areas_and_power()->update(['boiler_number_total' => $qty_sum, 'boiler_volume_total' => $cas, 'boiler_power' => $power]);

                // Dryer Details

                $cas = 0;

                $l = BanglaConverter::getNumToEn(0);
                $w = BanglaConverter::getNumToEn(0);
                $h1 = BanglaConverter::getNumToEn(0);
                $h2 = BanglaConverter::getNumToEn(0);

                $miller->dryer_details()->create([
                    'miller_id' => $miller->miller_id,
                    'dryer_length' => $l, 'dryer_width' => $w,
                    'cube_height' => $h1, 'pyramid_height' => $h2,
                    'dryer_volume' => $l * $w * ($h1+$h2/3)]);
                $cas += $l * $w * ($h1+$h2/3);

                $power = $cas * 0.65 * 13 / 1.75;

                $miller->areas_and_power()->update(['dryer_volume_total' => $cas, 'dryer_power' => $power]);

             // Godown Details

                $cas = 0;

                $miller->godown_details()->create([
                    'miller_id' => $miller->miller_id,
                    'godown_long' => BanglaConverter::getNumToEn(0),
                    'godown_wide' => BanglaConverter::getNumToEn(0),
                    'godown_height' => BanglaConverter::getNumToEn(0),
                    'godown_valume' => BanglaConverter::getNumToEn(0) * BanglaConverter::getNumToEn(0) * BanglaConverter::getNumToEn(0)]);
                $cas += BanglaConverter::getNumToEn(0) * BanglaConverter::getNumToEn(0) * BanglaConverter::getNumToEn(0);

                $power = $cas / 4.077;

                $miller->areas_and_power()->update(['godown_area_total' => $cas, 'godown_power' => $power]);

        }




        return redirect()->route('millers.list', ['page'=> $pp_page, 'division_id'=> $pp_division, 'district_id'=> $pp_district, 'mill_upazila_id'=> $pp_mill_upazila, 'mill_type_id'=> $pp_mill_type_id, 'miller_status'=> $pp_miller_status, 'cmp_status'=> $pp_cmp_status, 'owner_type'=> $pp_owner_type, 'searchtext'=> $pp_searchtext])->with('message', 'মিলার সফলভাবে পরিবর্তন হয়েছে');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Miller  $miller
     * @return \Illuminate\Http\Response
     */
    public function destroy(Miller $miller)
    {
        //dd($miller->mill_name);
        if(!DGFAuth::check2(1,  4)) return view('nopermission');

        $pp_page = session()->get('pp_page');
        $pp_division = session()->get('pp_division');
        $pp_district = session()->get('pp_district');
        $pp_mill_upazila = session()->get('pp_mill_upazila');

        $pp_mill_type_id = session()->get('pp_mill_type_id');
        $pp_miller_status = session()->get('pp_miller_status');
        $pp_cmp_status = session()->get('pp_cmp_status');
        $pp_owner_type = session()->get('pp_owner_type');
        $pp_searchtext = session()->get('pp_searchtext');

        $millerCheck = DB::table('miller')
        ->where("miller_id", $miller->miller_id)
        ->first();

        if($millerCheck->miller_status == "active"){
            return redirect()->route('millers.list', ['page'=> $pp_page, 'division_id'=> $pp_division, 'district_id'=> $pp_district, 'mill_upazila_id'=> $pp_mill_upazila, 'mill_type_id'=> $pp_mill_type_id, 'miller_status'=> $pp_miller_status, 'cmp_status'=> $pp_cmp_status, 'owner_type'=> $pp_owner_type, 'searchtext'=> $pp_searchtext])->with('message', 'মিলটি একটিভ আছে, সে কারণে বাদ করা সম্ভব হচ্ছে না।');
        }

        if ($millerCheck->fps_mill_status == "insert_success" || $millerCheck->fps_mill_status == "update_success"){
            return redirect()->route('millers.list', ['page'=> $pp_page, 'division_id'=> $pp_division, 'district_id'=> $pp_district, 'mill_upazila_id'=> $pp_mill_upazila, 'mill_type_id'=> $pp_mill_type_id, 'miller_status'=> $pp_miller_status, 'cmp_status'=> $pp_cmp_status, 'owner_type'=> $pp_owner_type, 'searchtext'=> $pp_searchtext])->with('message', 'মিলটি এফ পি এস পাঠানো হয়ে গেছে, সে কারণে বাদ করা সম্ভব হচ্ছে না।');
        }


        foreach($miller->inspections as $inspection){
            if($inspection->insp_autometic_miller)
                $inspection->insp_autometic_miller->delete();

            $inspection->insp_chatal_details->each->delete();
            $inspection->insp_godown_details->each->delete();
            $inspection->insp_motor_details->each->delete();
            $inspection->insp_steeping_house_details->each->delete();

            if($inspection->insp_miller)
                $inspection->insp_miller->delete();

            $inspection->delete();
        }

        if($miller->areas_and_power)
            $miller->areas_and_power->delete();
        if($miller->autometic_miller)
            $miller->autometic_miller->delete();

        $miller->license_histories->each->delete();
        $miller->chatal_details->each->delete();
        $miller->godown_details->each->delete();
        $miller->motor_details->each->delete();
        $miller->steeping_house_details->each->delete();

        $miller->delete();

        return redirect()->route('millers.list', ['page'=> $pp_page, 'division_id'=> $pp_division, 'district_id'=> $pp_district, 'mill_upazila_id'=> $pp_mill_upazila, 'mill_type_id'=> $pp_mill_type_id, 'miller_status'=> $pp_miller_status, 'cmp_status'=> $pp_cmp_status, 'owner_type'=> $pp_owner_type, 'searchtext'=> $pp_searchtext])->with('message', 'মিলার সফলভাবে বাদ দেওয়া হয়েছে');
    }

    public function getSelectedForms(Request $request)
    {
        if(!DGFAuth::check2(1,  2)) return view('nopermission');

        $edit_perm=false;
        if(DGFAuth::check2(1,  3)) $edit_perm=true;

        $checkedValues = $request->get('checkedValues');

        $millers = Miller::whereIn('miller_id', $checkedValues)->get();

        return view('miller.printforms', compact('millers', 'edit_perm'));
    }

    public function verifyNID(Request $request)
    {
        //if(!DGFAuth::check2(1,  2)) return view('nopermission');

        $nid_no = $request->get('nid_no');
        $birth_date = $request->get('birth_date');

        $status = false;
        $message = "";
        $data = array();

        $FPS_NID_VERIFICATION = env('FPS_NID_VERIFICATION');

        if($request->nid_no && $request->birth_date && $FPS_NID_VERIFICATION == "on"){
            $login_response = $this->fps->login();
            if($login_response != null && $login_response->status == true ){
                $response = $this->fps->nid_verification(['token' => $login_response->result->token,'NID'=>$request->nid_no, 'DOB' => \Carbon\Carbon::parse($request->birth_date)->format("Y-m-d")]);
                if($response->status != true){
                    $status = false;
                    $message = $response->message;
                }
                else{
                    $status = true;
                    $message = $response->message;
                    $data = $response->result->data;
                }
            }
            else{
                $status = false;
                $message = "Login in FPS failed";
            }
        }
        else{
            $status = false;
            $message = "NID_VERIFICATION is off";
        }

        return response()->json(['status' => $status, 'message' => $message, 'data' => $data]);
    }

    public function getMillerByNID(Request $request)
    {
        //if(!DGFAuth::check2(1,  2)) return view('nopermission');

        $nid_no = $request->get('nid_no');

        $miller = Miller::where('nid_no', $nid_no)->first();

        return response()->json($miller);
    }

    public function getSelectedLicenseForms(Request $request)
    {
        if(!DGFAuth::check2(1,  2)) return view('nopermission');

        $edit_perm=false;
        if(DGFAuth::check2(1,  3)) $edit_perm=true;

        $checkedValues = $request->get('checkedValues');

        $millers = Miller::whereIn('miller_id', $checkedValues)->get();
        

        return view('miller.printlicenseforms', compact('millers', 'edit_perm'));
    }

    public function getSelectedLicenseHistory(Request $request)
    { 
        if(!DGFAuth::check2(1,  2)) return view('nopermission');

        $edit_perm=false;
        if(DGFAuth::check2(1,  3)) $edit_perm=true;

        $checkedValues = $request->get('checkedValues');

        $millers = Miller::whereIn('miller_id', $checkedValues)->get();

        return view('miller.printlicensehistory', compact('millers', 'edit_perm'));
    }

   // public function newRegisterMiller(Request $request)
    //{
    //    $millers = Miller::where("miller_status", "new_register")->paginate(10);

    //    return view('miller.newRegisterMiller', compact('millers'));
   // }

    public function newRegisterMiller(Request $request)
    {
        if(!DGFAuth::check2(1,  2)) return view('nopermission');

        $division_id = $request->get('division_id');
        $district_id = $request->get('district_id');
        $mill_upazila_id = $request->get('mill_upazila_id');
        $chal_type_id = $request->get('chal_type_id');
        $mill_type_id = $request->get('mill_type_id');
        $searchtext = $request->get('searchtext');

        $miller_status = $request->get('miller_status');
        $cmp_status = $request->get('cmp_status');
        $owner_type = $request->get('owner_type');

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
        $divisions = DGFAuth::filtereddivision();// Division::all();
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

        $millers = Miller::sortable()->where("miller_status", "new_register");

        if($division_id)
            $millers = $millers->where("division_id", $division_id);

        if($district_id)
            $millers = $millers->where("district_id", $district_id);

        if($mill_upazila_id)
            $millers = $millers->where("mill_upazila_id", $mill_upazila_id);

        if($mill_type_id)
            $millers = $millers->where("miller.mill_type_id", $mill_type_id);

        if($chal_type_id)
            $millers = $millers->where("chal_type_id", $chal_type_id);

        if($miller_status)
            $millers = $millers->where("miller_status", $miller_status);

        if($cmp_status!=null)
            $millers = $millers->where("cmp_status", $cmp_status);

        if($owner_type!=null)
            $millers = $millers->where("owner_type", $owner_type);

        if($searchtext!=null){
            $millers = $millers->where(function ($query)use ($searchtext) {
                $query->orWhere('mill_name', 'like', '%'.$searchtext.'%')
                      ->orWhere('owner_name', 'like', '%'.$searchtext.'%')
                      ->orWhere('nid_no', 'like', '%'.$searchtext.'%')
                      ->orWhere('license_no', 'like', '%'.$searchtext.'%')
                      ->orWhere('form_no', 'like', '%'.BanglaConverter::bn2en($searchtext).'%')
                      ->orWhere('millar_p_power_chal', 'like', '%'.$searchtext.'%');
            });
        }

        $millers = $millers->select('miller.*')
        ->join('mill_type', 'miller.mill_type_id', '=', 'mill_type.mill_type_id')
        ->orderBy('miller.division_id')->orderBy('miller.district_id')->orderBy('miller.mill_upazila_id')->orderBy('miller.division_id')->orderBy('miller.district_id')->orderBy('miller.mill_upazila_id')->orderBy('mill_type.ordering');

        $millers = $millers->paginate(25);

        $chalTypes = ChalType::all();
        $millTypes = MillType::orderBy('ordering')->get();

        return view('miller.newRegisterMiller', compact('millers','divisions','districts','upazillas','chalTypes','millTypes','division_id','district_id','mill_upazila_id','searchtext', 'miller_status', 'cmp_status', 'owner_type', 'chal_type_id', 'mill_type_id'));
    }

    public function inactiveMiller(Request $request)
    {
        if(!DGFAuth::check2(1,  2)) return view('nopermission');

        $division_id = $request->get('division_id');
        $district_id = $request->get('district_id');
        $mill_upazila_id = $request->get('mill_upazila_id');


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
        $divisions = DGFAuth::filtereddivision();// Division::all();
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
         //dd($request->all());

        $todate = Carbon::now()->toDateTimeString();  // Today date
        $year = Carbon::now()->year;  // get current year
        $lastDayOfDeposite = Carbon::today()->setDate($year,6,30); //make last deposite date

        //$millers = Miller::sortable()
        //->whereDate("license_deposit_date",'>', $lastDayOfDeposite)
        //->Where("license_no", '!=', null)
        //->Where("license_type_id", '=', "2");

        $millers = Miller::sortable()
        ->join('license_fee', 'miller.license_fee_id', '=', 'license_fee.id')
        ->whereDate("miller.license_deposit_date",'>', $lastDayOfDeposite)
        ->Where("miller.license_no", '!=', null)
        ->Where("license_fee.license_type_id", '=', "2");

        //dd($today);

        if($division_id)
            $millers = $millers->where("division_id", $division_id);

        if($district_id)
            $millers = $millers->where("district_id", $district_id);

        if($mill_upazila_id)
            $millers = $millers->where("mill_upazila_id", $mill_upazila_id);

        $millers = $millers->get();

          //dd($millers);

            foreach ($millers as $miller)
            {
                //$miller = Miller::find($miller_id);
                $miller->miller_status = 'inactive';
                $miller->save();

            }

        return redirect()->route('invalidLicence')->with('message','চালকল সফলভাবে বন্ধ করা হয়েছে ।');
    }

    public function invalidLicence(Request $request)
    {
        if(!DGFAuth::check2(1,  2)) return view('nopermission');

        $division_id = $request->get('division_id');
        $district_id = $request->get('district_id');
        $mill_upazila_id = $request->get('mill_upazila_id');


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
        $divisions = DGFAuth::filtereddivision();// Division::all();
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

        $todate = Carbon::now()->toDateTimeString();  // Today date
        $year = Carbon::now()->year;  // get current year
        $lastDayOfDeposite = Carbon::today()->setDate($year,6,30); //make last deposite date

       // $millers = Miller::sortable()
        //->whereDate("license_deposit_date",'>', $lastDayOfDeposite)
        //->Where("license_no", '!=', null)
        //->Where("license_type_id", '=', "2");

        $millers = Miller::sortable()
        ->join('license_fee', 'miller.license_fee_id', '=', 'license_fee.id')
        ->whereDate("miller.license_deposit_date",'>', $lastDayOfDeposite)
        ->Where("miller.license_no", '!=', null)
        ->Where("license_fee.license_type_id", '=', "2");

        //dd($today);

        if($division_id)
            $millers = $millers->where("division_id", $division_id);

        if($district_id)
            $millers = $millers->where("district_id", $district_id);

        if($mill_upazila_id)
            $millers = $millers->where("mill_upazila_id", $mill_upazila_id);

        $millers = $millers->paginate(25);

        return view('miller.invalidLicence', compact('millers','divisions','districts','upazillas','division_id','district_id','mill_upazila_id'));
    }

    public function validLicence(Request $request)
    {
        if(!DGFAuth::check2(1,  2)) return view('nopermission');

        $division_id = $request->get('division_id');
        $district_id = $request->get('district_id');
        $mill_upazila_id = $request->get('mill_upazila_id');


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
        $divisions = DGFAuth::filtereddivision();// Division::all();
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

        $todate = Carbon::now()->toDateTimeString();  // Today date
        $year = Carbon::now()->year;  // get current year
        $lastDayOfDeposite = Carbon::today()->setDate($year,6,30); //make last deposite date

        //$millers = Miller::sortable()
        //->whereDate("license_deposit_date",'<=', $lastDayOfDeposite)
        //->Where("license_no", '!=', null)
        //->Where("license_type_id", '=', "2");

        $millers = Miller::sortable()
        ->join('license_fee', 'miller.license_fee_id', '=', 'license_fee.id')
        ->whereDate("miller.license_deposit_date",'<=', $lastDayOfDeposite)
        ->Where("miller.license_no", '!=', null)
        ->Where("license_fee.license_type_id", '=', "2");

        //dd($today);

        if($division_id)
            $millers = $millers->where("division_id", $division_id);

        if($district_id)
            $millers = $millers->where("district_id", $district_id);

        if($mill_upazila_id)
            $millers = $millers->where("mill_upazila_id", $mill_upazila_id);

        $millers = $millers->paginate(25);

        return view('miller.validLicence', compact('millers','divisions','districts','upazillas','division_id','district_id','mill_upazila_id'));
    }


    public function newLicence(Request $request)
    {
        if(!DGFAuth::check2(1,  2)) return view('nopermission');

        $division_id = $request->get('division_id');
        $district_id = $request->get('district_id');
        $mill_upazila_id = $request->get('mill_upazila_id');


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
        $divisions = DGFAuth::filtereddivision();// Division::all();
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

       // $todate = Carbon::now()->toDateTimeString();  // Today date
       // $year = Carbon::now()->year;  // get current year
       // $lastDayOfDeposite = Carbon::today()->setDate($year,6,30); //make last deposite date

       // $millers = Miller::sortable()->Where("license_type_id", '=', "1");

       $millers = Miller::sortable()
       ->join('license_fee', 'miller.license_fee_id', '=', 'license_fee.id')
       ->Where("license_fee.license_type_id", '=', "1");


        //dd($today);

        if($division_id)
            $millers = $millers->where("division_id", $division_id);

        if($district_id)
            $millers = $millers->where("district_id", $district_id);

        if($mill_upazila_id)
            $millers = $millers->where("mill_upazila_id", $mill_upazila_id);

        $millers = $millers->paginate(25);

        return view('miller.newLicence', compact('millers','divisions','districts','upazillas','division_id','district_id','mill_upazila_id'));
    }

    public function duplicateLicence(Request $request)
    {
        if(!DGFAuth::check2(1,  2)) return view('nopermission');

        $division_id = $request->get('division_id');
        $district_id = $request->get('district_id');
        $mill_upazila_id = $request->get('mill_upazila_id');


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
        $divisions = DGFAuth::filtereddivision();// Division::all();
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

       // $todate = Carbon::now()->toDateTimeString();  // Today date
       // $year = Carbon::now()->year;  // get current year
      //  $lastDayOfDeposite = Carbon::today()->setDate($year,6,30); //make last deposite date

        //$millers = Miller::sortable()->Where("license_no", '!=', null)
        //->Where("license_type_id", '=', "3");

        $millers = Miller::sortable()
        ->join('license_fee', 'miller.license_fee_id', '=', 'license_fee.id')
        ->Where("miller.license_no", '!=', null)
        ->Where("license_fee.license_type_id", '=', "3");

        //dd($today);

        if($division_id)
            $millers = $millers->where("division_id", $division_id);

        if($district_id)
            $millers = $millers->where("district_id", $district_id);

        if($mill_upazila_id)
            $millers = $millers->where("mill_upazila_id", $mill_upazila_id);

        $millers = $millers->paginate(25);

        return view('miller.duplicateLicence', compact('millers','divisions','districts','upazillas','division_id','district_id','mill_upazila_id'));
    }

    public function sendtofps(Request $request)
    {
        $miller_id = $request->get('miller_id');
        $miller = Miller::find($miller_id);

        $page = $request->get('page');

        $division_id = $request->get('division_id');
        $district_id = $request->get('district_id');
        $mill_upazila_id = $request->get('mill_upazila_id');
        $miller_status_filter = $request->get('miller_status');
        $fps_mo_status_filter = $request->get('fps_mo_status');
        $fps_mill_status_filter = $request->get('fps_mill_status');
        $searchtext = $request->get('searchtext');

        $message = "";

        if($miller->mill_type_id == 2){
            $message = "অটোমেটিক মিল পরিবর্তন করে হালনাগাদ অটোমেটিক মিল এ নিয়ে যান, তাহলে FPS এ পাঠাতে পারবেন ।";
            return redirect()->route('millerListFPSStatus',['division_id'=> $division_id, 'district_id'=> $district_id, 'mill_upazila_id'=> $mill_upazila_id, 'miller_status'=> $miller_status_filter, 'fps_mo_status'=> $fps_mo_status_filter, 'fps_mill_status'=> $fps_mill_status_filter, 'searchtext'=> $searchtext, 'page'=> $page])->with('message', $message);    
        }

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
                        "Mobile"=> $miller->mobile_no,
                        "Status"=> "active"]
                    );
                    if($mo_response != null){
                        $fps_mo_status = $mo_response->status == true ? "update_success":"update_fail";
                        $message = $mo_response->message;
                    }
                    else{
                        $fps_mo_status = "update_fail";
                        $message = "Error in FPS System";
                    }
                }
                else{
                    $FPS_NID_VERIFICATION  = env('FPS_NID_VERIFICATION');

                    if($miller->nid_no && $miller->birth_date && $FPS_NID_VERIFICATION == "on"){
                        $response = $this->fps->nid_verification(['token' => $login_response->result->token,'NID'=>$miller->nid_no, 'DOB' => \Carbon\Carbon::parse($miller->birth_date)->format("Y-m-d")]);
                        if($response->status != true){
                            return redirect()->back()->withInput()
                            ->with('message', $response->message);
                        }
                    }

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
                        "Mobile"=> $miller->mobile_no,
                        "Status"=> "active"]
                    );
                    if($mo_response != null){
                        $fps_mo_status = $mo_response->status == true ? "insert_success":"insert_fail";
                        $message = $mo_response->message;
                    }
                    else{
                        $fps_mo_status = "insert_fail";
                        $message = "Error in FPS System";
                    }
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
                        "Status"=> $miller->miller_status,
                        "Rice_Type"=> $miller->chal_type_id == 1 ? "white":"parboiled",
                        "Mobile"=> $miller->mobile_no,
                        "Meter"=> $miller->meter_no,
                        "Remark"=> "Ok"]
                    );
                    if($mill_response != null){
                        $fps_mill_status = $mill_response != null && $mill_response->status == true ? "update_success":"update_fail";
                        $message .= "<br />".$mill_response->message;
                    }
                    else{
                        $fps_mill_status = "update_fail";
                        $message .= "<br />Error in FPS System";
                    }
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
                        "Status"=> $miller->miller_status,
                        "Rice_Type"=> $miller->chal_type_id == 1 ? "white":"parboiled",
                        "Mobile"=> $miller->mobile_no,
                        "Meter"=> $miller->meter_no,
                        "Remark"=> "Ok"]
                    );
                    if($mill_response != null){
                        $fps_mill_status = $mill_response->status == true ? "insert_success":"insert_fail";
                        $message .= "<br />".$mill_response->message;
                        }
                    else{
                        $fps_mill_status = "insert_fail";
                        $message .= "<br />Error in FPS System";
                    }
                }

                $fps_mill_last_date = date("Y-m-d H:i:s");

                DB::table('miller')
                    ->where('miller_id', $miller_id)
                    ->update([
                        'fps_mo_status'=> $fps_mo_status,
                        'fps_mo_last_date'=> $fps_mo_last_date,
                        'fps_mill_status'=> $fps_mill_status,
                        'fps_mill_last_date'=> $fps_mill_last_date
                    ]);
            }
            else
                $message = "API Login Failed.";
        }
        else
            $message = "API Settings Off.";

        return redirect()->route('millerListFPSStatus',['division_id'=> $division_id, 'district_id'=> $district_id, 'mill_upazila_id'=> $mill_upazila_id, 'miller_status'=> $miller_status_filter, 'fps_mo_status'=> $fps_mo_status_filter, 'fps_mill_status'=> $fps_mill_status_filter, 'searchtext'=> $searchtext, 'page'=> $page])->with('message', $message);
    }

    public function approve(Request $request)
    {
        $miller_id = $request->get('miller_id');

        $page = $request->get('page');

        $miller = Miller::find($miller_id);
        $message = "";

        $approver_user_id = Auth::user()->id;
        $approver_user_date = date("Y-m-d H:i:s");

        if(Auth::user()->user_type == 6){
            DB::table('miller')
                ->where('miller_id', $miller_id)
                ->update([
                    'approver_silo_user_id'=> $approver_user_id,
                    'approver_silo_user_date'=> $approver_user_date
                ]);

            $message = "Successfully Approved by Silo user.";
        }
        else if(Auth::user()->user_type == 2){
            DB::table('miller')
                ->where('miller_id', $miller_id)
                ->update([
                    'approver_rc_user_id'=> $approver_user_id,
                    'approver_rc_user_date'=> $approver_user_date
                ]);

            $message = "Successfully Approved by RC user.";
        }
        else if(Auth::user()->user_type == 3){
            DB::table('miller')
                ->where('miller_id', $miller_id)
                ->update([
                    'approver_dc_user_id'=> $approver_user_id,
                    'approver_dc_user_date'=> $approver_user_date
                ]);

            $message = "Successfully Approved by DC user.";
        }
        else{
            $message = "User doesn't have approve permission.";
        }

        return redirect()->route('millers.edit', $miller->miller_id)->with('message', $message);
    }

    public function send2fps(Request $request)
    {
        $miller_id = $request->get('miller_id');

        $page = $request->get('page');

        $miller = Miller::find($miller_id);
        $message = "";

        if($miller->mill_type_id == 2){
            $message = "অটোমেটিক মিল পরিবর্তন করে হালনাগাদ অটোমেটিক মিল এ নিয়ে যান, তাহলে FPS এ পাঠাতে পারবেন ।";
            return redirect()->route('millers.edit', $miller->miller_id)->with('message', $message);  
        }

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
                        "Mobile"=> $miller->mobile_no,
                        "Status"=> "active"]
                    );
                    if($mo_response != null){
                        $fps_mo_status = $mo_response->status == true ? "update_success":"update_fail";
                        $message = $mo_response->message;
                    }
                    else{
                        $fps_mo_status = "update_fail";
                        $message = "Error in FPS System";
                    }
                }
                else{
                    $FPS_NID_VERIFICATION  = env('FPS_NID_VERIFICATION');

                    if($miller->nid_no && $miller->birth_date && $FPS_NID_VERIFICATION == "on"){
                        $response = $this->fps->nid_verification(['token' => $login_response->result->token,'NID'=>$miller->nid_no, 'DOB' => \Carbon\Carbon::parse($miller->birth_date)->format("Y-m-d")]);
                        if($response->status != true){
                            return redirect()->back()->withInput()
                            ->with('message', $response->message);
                        }
                    }

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
                        "Status"=> "active"]
                    );
                    if($mo_response != null){
                        $fps_mo_status = $mo_response->status == true ? "insert_success":"insert_fail";
                        $message = $mo_response->message;
                    }
                    else{
                        $fps_mo_status = "insert_fail";
                        $message = "Error in FPS System";
                    }
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
                        "Status"=> $miller->miller_status,
                        "Rice_Type"=> $miller->chal_type_id == 1 ? "white":"parboiled",
                        "Mobile"=> $miller->mobile_no,
                        "Meter"=> $miller->meter_no,
                        "Remark"=> "Ok"]
                    );
                    if($mill_response != null){
                        $fps_mill_status = $mill_response != null && $mill_response->status == true ? "update_success":"update_fail";
                        $message .= "<br />".$mill_response->message;
                    }
                    else{
                        $fps_mill_status = "update_fail";
                        $message .= "<br />Error in FPS System";
                    }
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
                        "Status"=> $miller->miller_status,
                        "Rice_Type"=> $miller->chal_type_id == 1 ? "white":"parboiled",
                        "Mobile"=> $miller->mobile_no,
                        "Meter"=> $miller->meter_no,
                        "Remark"=> "Ok"]
                    );
                    if($mill_response != null){
                        $fps_mill_status = $mill_response->status == true ? "insert_success":"insert_fail";
                        $message .= "<br />".$mill_response->message;
                        }
                    else{
                        $fps_mill_status = "insert_fail";
                        $message .= "<br />Error in FPS System";
                    }
                }

                $fps_mill_last_date = date("Y-m-d H:i:s");

                DB::table('miller')
                    ->where('miller_id', $miller_id)
                    ->update([
                        'fps_mo_status'=> $fps_mo_status,
                        'fps_mo_last_date'=> $fps_mo_last_date,
                        'fps_mill_status'=> $fps_mill_status,
                        'fps_mill_last_date'=> $fps_mill_last_date
                    ]);
            }
            else
                $message = "API Login Failed.";
        }
        else
            $message = "API Settings Off.";

        return redirect()->route('millers.edit', $miller->miller_id)->with('message', $message);
    }

    public function activateMiller(Request $request)
    {
        $nid_no = $request->get('nid_no');
        $miller_status = $request->get('miller_status');

        $status = false;
        $message = "";
        $miller = array();

        $FPS_ENABLED = env('FPS_ENABLED');

        if($FPS_ENABLED == "on"){
            $login_response = $this->fps->login();

            if($login_response != null && $login_response->status == true ){
                $mo_exists = $this->fps->get_miller([
                    'token' => $login_response->result->token,
                    'NID'=> $nid_no]
                );

                if($mo_exists->status == true){
                    $miller = $mo_exists->result->Miller;

                    $mo_response = $this->fps->update_miller([
                        'token' => $login_response->result->token,
                        'NID'=> $nid_no,
                        "Name_Bangla"=> $miller->Name_Bangla,
                        "Name_English"=> $miller->Name_English,
                        "Mother_Name"=> "n/a",
                        "Father_Name"=> $miller->Father_Name,
                        "Gender"=> $miller->Gender,
                        "DOB"=> \Carbon\Carbon::parse($miller->DOB)->format("Y-m-d"),
                        "Permanent_Address"=> $miller->Permanent_Address,
                        "Current_Address"=> $miller->Current_Address,
                        "Mobile"=> $miller->Mobile,
                        "Status"=> $miller_status]
                    );
                    if($mo_response != null){
                        $status = true;
                        $message = $mo_response->message;
                    }
                    else{
                        $status = false;
                        $message = "Error in FPS System";
                    }
                }
                else{
                    $status = false;
                    $message = "Miller not exists.";
                }
            }
            else{
                $status = false;
                $message = "Login in FPS failed";
            }
        }
        else{
            $status = false;
            $message = "API Settings Off.";
        }

        return response()->json(['status' => $status, 'message' => $message, 'data' => $miller]);
    }

    public function activateMill(Request $request)
    {
        $license_no = $request->get('license_no');
        $mill_status = $request->get('mill_status');

        $status = false;
        $message = "";
        $miller = array();

        $FPS_ENABLED = env('FPS_ENABLED');

        if($FPS_ENABLED == "on"){
            $login_response = $this->fps->login();

            if($login_response != null && $login_response->status == true ){

                $mill_exists = $this->fps->get_mill([
                    'token' => $login_response->result->token,
                    'License' => $license_no]
                );

                if($mill_exists->status == true){
                    $miller = Miller::where("license_no", $license_no)->first();

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
                        "Status"=> $mill_status,
                        "Rice_Type"=> $miller->chal_type_id == 1 ? "white":"parboiled",
                        "Mobile"=> $miller->mobile_no,
                        "Meter"=> $miller->meter_no,
                        "Remark"=> "Ok"]
                    );

                    /*$miller = $mill_exists->result->Miller;

                    $mill_response = $this->fps->update_mill([
                        'token' => $login_response->result->token,
                        "NID"=> $miller->Miller_Nid,
                        "Name"=> $miller->Name,
                        "Address"=> $miller->Address,
                        "District"=> $miller->District,
                        "Upazila"=> $miller->Upazila,
                        "Mill_Type"=> $miller->Mill_Type,
                        "Capacity"=> $miller->Capacity,
                        "Issue_Date"=> \Carbon\Carbon::parse($miller->Issue_Date)->format("Y-m-d"),
                        "Renew_Date"=> \Carbon\Carbon::parse($miller->Renew_Date)->format("Y-m-d"),
                        "License"=> $license_no,
                        "Status"=> $mill_status,
                        "Rice_Type"=> $miller->Rice_Type,
                        "Meter"=> $miller->Meter,
                        "Remark"=> "Ok"]
                    );*/

                    if($mill_response != null){
                        $status = true;
                        $message = $mill_response->message;
                    }
                    else{
                        $status = false;
                        $message = "Error in FPS System";
                    }
                }
                else{
                    $status = false;
                    $message = "Mill not exists.";
                }
            }
            else{
                $status = false;
                $message = "Login in FPS failed";
            }
        }
        else{
            $status = false;
            $message = "API Settings Off.";
        }

        return response()->json(['status' => $status, 'message' => $message, 'data' => $miller]);
    }
}
