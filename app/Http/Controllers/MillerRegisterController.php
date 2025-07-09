<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\AreasAndPower;
use App\Models\Miller;
use App\Models\Division;
use App\Models\District;
use App\Models\Upazilla;
use App\Models\LicenseFee;
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
use App\DGFAuth;
use App\Models\MotorDetail;
use App\Models\MotorPower;
use Illuminate\Support\Facades\Auth;
use Image;
use Carbon\Carbon;

use App\Util\FPSHelper;

class MillerRegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     protected $fps;

     public function __construct(FPSHelper $fps)
     {
         $this->fps = $fps;
     }

     public function index(Request $request)
    {
        $mobile_no = $request->get('mobile_no');
        $pass_code = $request->get('pass_code');

        $millers = [];

       if($mobile_no && $pass_code) {
            $millers = Miller::where("mobile_no", $mobile_no)
            ->where('pass_code', 'like', ''.$pass_code.'')
            ->get();
        }

        return view('millerregister.index', compact('millers','mobile_no','pass_code'));
    }

    public function searchSubmitMiller(Request $request)
    {
        //dd($request->all());
        $mobile_no = $request->get('mobile_no');
        $pass_code = $request->get('pass_code');
        $nid_no = $request->get('nid_no');

        $millers = [];
       if($mobile_no && $pass_code) {
            $millers = Miller::where("mobile_no", $mobile_no)
            ->where('pass_code', 'like', '%'.$pass_code.'%')
            //->where("pass_code", $pass_code)
            ->get();
        }

        if($nid_no && $pass_code) {
            $millers = Miller::where("nid_no", $nid_no)
            ->where('pass_code', 'like', '%'.$pass_code.'%')
            //->where("pass_code", $pass_code)
            ->get();
        }

        return view('millerregister.index', compact('millers','mobile_no','pass_code','nid_no'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $district_id =0;
        $divisions = Division::all();
        $districts = District::all();
        $upazillas = Upazilla::all();

        //$licenseFees = LicenseFee::whereDate("effective_todate",'>', date(''))->get();
        $licenseFees = LicenseFee::whereDate('effective_todate', '>', Carbon::today())->get();
        $nobayonTypes = LicenseFee::where('license_type_id', 2)->whereDate("effective_todate",'>', date(''))->pluck('id')->toArray();

        $corporate_institutes = CorporateInstitute::all();
        $chalTypes = ChalType::all();
        $millTypes = MillType::orderBy('ordering')->get();
        $option = $request->query('option');
        $motor_powers = MotorPower::all();
        $milling_unit_machinery = MillingUnitMachinery::all();
        $miller = new Miller;

        if($option)
            return view('millerregister.create', compact('divisions','districts','upazillas','licenseFees','nobayonTypes','corporate_institutes','chalTypes','millTypes','option','motor_powers','miller', 'milling_unit_machinery','district_id'));
        else
            return redirect()->route('home');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!DGFAuth::checkregistration())
            return view('nopermission');

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

        $chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $pass_code = "";
        for ($i = 0; $i < 6; $i++) {
            $pass_code .= $chars[mt_rand(0, strlen($chars)-1)];
        }

        if($request->mobile_no){
           $count = Miller::where("mobile_no", $request->mobile_no)->where("pass_code", '!=', "")->count();
           if($count >= 1){
               $pass_code_getDB = Miller::where("mobile_no", $request->mobile_no)->where("pass_code", '!=', "")->first();
               //$pass_code = $pass_code_getDB->pass_code."_".$count;
               $pass_code = $pass_code_getDB->pass_code;
           }

           $request->merge(['pass_code' => $pass_code]);
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

        //$miller->areas_and_power()->create(['boiler_machineries_steampower' => 0, 'boiler_machineries_power' => 0, 'boiler_number_total' => 0, 'boiler_volume_total' => 0, 'boiler_power' => 0,'dryer_volume_total' => 0, 'dryer_power' => 0,'chatal_area_total' => 0, 'chatal_power' => 0,'godown_area_total' => 0, 'godown_power' => 0,'steping_area_total' => 0, 'steping_power' => 0,'motor_area_total' => 0, 'motor_power' => 0,'milling_unit_output' => 0, 'milling_unit_power' => 0]);

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

                    $miller->mill_milling_unit_machineries()->create([
                        'machinery_id' => $value,
                        'name' => $request->milling_unit_machinery_name[$key],
                        'brand' => $request->milling_unit_machinery_brand[$key],
                        'manufacturer_country' => $request->milling_unit_machinery_manufacturer_country[$key],
                        'import_date' => $request->milling_unit_machinery_import_date[$key],
                        'join_type' => $request->milling_unit_machinery_join_type[$key],
                        'num' => $n,
                        'power' => $p,
                        'topower' => $n * $p,
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

            $miller->areas_and_power()->update(['godown_area_total' => $cas, 'godown_power' => $power, 'final_godown_silo_power' => $power]);
            
        }

        // Silo

        if($request->final_godown_silo_power){
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

        if($request->cmp_status){
            $miller->update(['miller_stage'=> 'তথ্য সম্পূর্ণ']);
        }
        else{
            $miller->update(['miller_stage'=> 'চালকলের আবেদন']);
        }

        return redirect()->route('millerregister.edit', $miller->miller_id)
        ->with('success','আপনার পাস কোড = '.$pass_code. '<br/>ভবিষ্যতে অনুসন্ধানের জন্য পাস কোডটি নিজের কাছে সংরক্ষণ করুন।');
}

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Miller  $miller
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Miller  $miller
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $miller = Miller::find($id);
        $divisions = Division::all();
        $districts = District::all();
        $upazillas = Upazilla::all();

        //$licenseFees = LicenseFee::whereDate("effective_todate",'>', date(''))->get();
        $licenseFees = LicenseFee::whereDate('effective_todate', '>', Carbon::today())->get();
        $nobayonTypes = LicenseFee::where('license_type_id', 2)->whereDate("effective_todate",'>', date(''))->pluck('id')->toArray();

        $corporate_institutes = CorporateInstitute::all();
        $chalTypes = ChalType::all();
        $millTypes = MillType::orderBy('ordering')->get();
        $motor_powers = MotorPower::all();
        $milling_unit_machinery = MillingUnitMachinery::all();

        return view('millerregister.edit', compact('divisions', 'districts', 'upazillas', 'licenseFees', 'nobayonTypes', 'corporate_institutes', 'chalTypes','millTypes','motor_powers','miller', 'milling_unit_machinery'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Miller  $miller
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(!DGFAuth::checkregistration())
            return view('nopermission');

        $miller = Miller::find($id);

        if($request->nid_no){
            $owner_miller = DB::table('miller')
            ->where("miller_id", '!=', $miller->miller_id)
            ->where("owner_name", $request->owner_name)
            ->where("father_name", $request->father_name)
            ->where("mother_name", $request->mother_name)
            ->where("birth_date", $request->birth_date)
            ->first();

            if($owner_miller != null && $owner_miller->nid_no != $request->nid_no ){
                return redirect()->route('millerregister.edit', $miller->miller_id)
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
                return redirect()->route('millerregister.edit', $miller->miller_id)
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
                return redirect()->route('millerregister.edit', $miller->miller_id)
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

        if($request->mill_type_id==2)
        $miller->autometic_miller()->update(['pro_flowdiagram' => $request->pro_flowdiagram, 'origin' => $request->origin, 'visited_date' => $request->visited_date,
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
            $miller->autometic_miller_new()->update(['pro_flowdiagram' => $request->pro_flowdiagram, 'origin' => $request->origin, 'milling_parts_manufacturer' => $request->milling_parts_manufacturer, 'milling_parts_manufacturer_type' => $request->milling_parts_manufacturer_type]);

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
                            'topower' => $n * $p,
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
                            'topower' => $n * $p,
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

        if($request->godown_long){
            //dd($request->final_godown_silo_power);
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

            $miller->areas_and_power()->update(['godown_area_total' => $cas, 'godown_power' => $power]);
        }

        if($request->silo_radius){
             //dd($request->silo_radius);
             $cas = 0;

             foreach ($request->silo_radius as $key => $value ) {

                 $id = $request->silo_id[$key];
                 if(!$id){
                     $miller->silo_details()->create(['silo_radius' => BanglaConverter::getNumToEn($value),
                     'silo_height' => BanglaConverter::getNumToEn($request->silo_height[$key]),
                     'silo_volume' =>M_PI * pow(BanglaConverter::getNumToEn($value), 2) * BanglaConverter::getNumToEn($request->silo_height[$key])]);
                }
                 else{
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
                $millar_p_power = min($miller->areas_and_power->boiler_power, $miller->areas_and_power->dryer_power, $miller->areas_and_power->godown_power, $miller->areas_and_power->milling_unit_power);
            else
                $millar_p_power = min($miller->areas_and_power->dryer_power, $miller->areas_and_power->godown_power, $miller->areas_and_power->milling_unit_power);

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

        if($request->cmp_status){
            $miller->update(['miller_stage'=> 'তথ্য সম্পূর্ণ']);
        }
        else{
            $miller->update(['miller_stage'=> 'চালকলের আবেদন']);
        }

        return redirect()->route('millerregister.edit',$miller->miller_id)
                        ->with('success','মিলার এর তথ্য সফলভাবে পরিবর্তন করা হয়েছে');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Miller  $miller
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(!DGFAuth::checkregistration())
            return view('nopermission');

        $miller = Miller::find($id);
        if($miller->areas_and_power)
            $miller->areas_and_power->delete();
        if($miller->autometic_miller)
            $miller->autometic_miller->delete();
        $miller->chatal_details->each->delete();
        $miller->godown_details->each->delete();
        $miller->motor_details->each->delete();
        $miller->steeping_house_details->each->delete();
        $miller->delete();
        return redirect()->route('millerregister.index')->with('message', 'মিলার সফলভাবে বাদ দেওয়া হয়েছে');
    }
}
