<?php

namespace App\Http\Controllers;

use App\Models\Miller;
use App\Models\Division;
use App\Models\District;
use App\Models\Upazilla;
use App\Models\ChalType;
use App\Models\MillType;
use App\BanglaConverter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\DGFAuth;
use Illuminate\Support\Facades\Auth;

use App\Exports\MillerExport;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if(!DGFAuth::check(3000)) return view('nopermission');

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

        return view('reports.index', compact('millercount', 'activemillercount', 'inactivemillercount',
        'newautomillercount', 'semiautomillercount', 'automillercount', 'exceptpislerautomillercount', 'withpislersemiautomillercount'));
    }

    public function infowise(Request $request)
    {
        if(!DGFAuth::check(3010)) return view('nopermission');

        $division_id = $request->get('division_id');
        $district_id = $request->get('district_id');
        $cmp_status = $request->get('cmp_status');
        $searchtext = $request->get('searchtext');
        $miller_status = $request->get('miller_status');
        $owner_type = $request->get('owner_type');

        $divisions = DGFAuth::filtereddivision();
        if($division_id==0 && Auth::user()->division_id>0) $division_id = Auth::user()->division_id;
        if($district_id==0 && Auth::user()->district_id>0) {
            $district_id = Auth::user()->district_id;
            $districts = DB::table('district')
            ->where("distid", Auth::user()->district_id)
            ->get();
        }
        else{
            $districts = DB::table('district')
            ->where("divid", $division_id)
            ->get();
        }

        $millers = Miller::sortable();

        if($division_id)
            $millers = $millers->where("division_id", $division_id);

        if($district_id)
            $millers = $millers->where("district_id", $district_id);

        if(Auth::user()->upazila_id>0)
            $millers = $millers->where("mill_upazila_id", Auth::user()->upazila_id);

        if($cmp_status!=null)
            $millers = $millers->where("cmp_status", $cmp_status);

        if($miller_status)
            $millers = $millers->where("miller_status", $miller_status);

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
  //      ->join('mill_type', 'miller.mill_type_id', '=', 'mill_type.mill_type_id')
        ->orderBy('miller.division_id')->orderBy('miller.division_id')->orderBy('miller.division_id')->orderBy('miller.district_id')->orderBy('miller.mill_upazila_id')->orderBy('miller.cmp_status');//->orderBy('mill_type.ordering');

        $millers = $millers->paginate(25);

        return view('reports.infowise', compact('divisions', 'districts', 'millers', 'division_id', 'district_id', 'cmp_status','miller_status','searchtext','owner_type'));
    }

    public function regionwise(Request $request)
    {
        if(!DGFAuth::check(3020)) return view('nopermission');

        $division_id = $request->get('division_id');
        $district_id = $request->get('district_id');
        $mill_upazila_id = $request->get('upazila_id');
        $searchtext = $request->get('searchtext');
        $miller_status = $request->get('miller_status');
        $owner_type = $request->get('owner_type');

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
        if($mill_upazila_id==0 && Auth::user()->upazila_id>0) {
            $mill_upazila_id = Auth::user()->upazila_id;
            $upazillas = DB::table('upazilla')
            ->where("upazillaid", Auth::user()->upazila_id)
            ->get();
        }
        else{
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

        if($miller_status)
            $millers = $millers->where("miller_status", $miller_status);

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
       // ->join('mill_type', 'miller.mill_type_id', '=', 'mill_type.mill_type_id')
        ->orderBy('miller.division_id')->orderBy('miller.district_id')->orderBy('miller.mill_upazila_id');//->orderBy('mill_type.ordering');

        $millers = $millers->paginate(25);

        return view('reports.regionwise', compact('divisions', 'districts', 'upazillas', 'millers', 'division_id', 'district_id','mill_upazila_id','miller_status','searchtext','owner_type'));
    }

    public function typewise(Request $request)
    {
        if(!DGFAuth::check(3030)) return view('nopermission');

        $division_id = $request->get('division_id');
        $district_id = $request->get('district_id');
        $chal_type_id = $request->get('chal_type_id');
        $mill_type_id = $request->get('mill_type_id');
        $searchtext = $request->get('searchtext');
        $miller_status = $request->get('miller_status');
        $owner_type = $request->get('owner_type');

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

        $millers = Miller::sortable();

        if($division_id)
            $millers = $millers->where("division_id", $division_id);

        if($district_id)
            $millers = $millers->where("district_id", $district_id);

        if($owner_type!=null)
            $millers = $millers->where("owner_type", $owner_type);

        if(Auth::user()->upazila_id>0)
            $millers = $millers->where("mill_upazila_id", Auth::user()->upazila_id);

        if($mill_type_id)
            $millers = $millers->where("miller.mill_type_id", $mill_type_id);

        if($chal_type_id)
            $millers = $millers->where("chal_type_id", $chal_type_id);

        if($miller_status)
            $millers = $millers->where("miller_status", $miller_status);

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
        ->orderBy('miller.division_id')->orderBy('miller.district_id')->orderBy('miller.mill_upazila_id')->orderBy('mill_type.ordering');//->orderBy('mill_type.ordering');

        $millers = $millers->paginate(25);

        $chalTypes = ChalType::all();
        $millTypes = MillType::orderBy('ordering')->get();

        return view('reports.typewise', compact('divisions', 'owner_type', 'districts','chalTypes','millTypes', 'millers', 'division_id', 'district_id', 'chal_type_id', 'mill_type_id','miller_status','searchtext'));
    }

    public function printinfowise(Request $request)
    {
        if(!DGFAuth::check(3010)) return view('nopermission');

        $division_id = $request->get('division_id');
        $district_id = $request->get('district_id');
        $cmp_status = $request->get('cmp_status');
        $searchtext = $request->get('searchtext');

        $divisions = DGFAuth::filtereddivision();
        if($division_id==0 && Auth::user()->division_id>0) $division_id = Auth::user()->division_id;
        if($district_id==0 && Auth::user()->district_id>0) {
            $district_id = Auth::user()->district_id;
            $districts = DB::table('district')
            ->where("distid", Auth::user()->district_id)
            ->get();
        }
        else{
            $districts = DB::table('district')
            ->where("divid", $division_id)
            ->get();
        }

        $division = Division::find($division_id);
        $division_name = $division ? $division->divname:'';

        $district = District::find($district_id);
        $district_name = $district ? $district->distname:'';

        $millers = Miller::sortable();

        if($division_id)
            $millers = $millers->where("division_id", $division_id);

        if($district_id)
            $millers = $millers->where("district_id", $district_id);

        if(Auth::user()->upazila_id>0)
            $millers = $millers->where("mill_upazila_id", Auth::user()->upazila_id);

        if($cmp_status!=null)
            $millers = $millers->where("cmp_status", $cmp_status);

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
        ->orderBy('miller.division_id')->orderBy('miller.district_id')->orderBy('miller.mill_upazila_id')->orderBy('mill_type.ordering');

        $millers = $millers->get();

        return view('reports.printinfowise', compact('division_name', 'district_name', 'cmp_status', 'searchtext', 'millers','searchtext'));
    }

    public function printregionwise(Request $request)
    {
        if(!DGFAuth::check(3020)) return view('nopermission');

        $division_id = $request->get('division_id');
        $district_id = $request->get('district_id');
        $mill_upazila_id = $request->get('upazila_id');
        $searchtext = $request->get('searchtext');

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
        }
        else{
            $upazillas = DB::table('upazilla')
            ->where("distId", $district_id)
            ->get();
        }

        $division = Division::find($division_id);
        $division_name = $division ? $division->divname:'';

        $district = District::find($district_id);
        $district_name = $district ? $district->distname:'';

        $upazila = Upazilla::find($mill_upazila_id);
        $upazila_name = $upazila ? $upazila->upazillaname:'';

        $millers = Miller::sortable();

        if($division_id)
            $millers = $millers->where("division_id", $division_id);

        if($district_id)
            $millers = $millers->where("district_id", $district_id);

        if($mill_upazila_id)
            $millers = $millers->where("mill_upazila_id", $mill_upazila_id);

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
        ->orderBy('miller.division_id')->orderBy('miller.district_id')->orderBy('miller.mill_upazila_id')->orderBy('mill_type.ordering');

        $millers = $millers->get();

        return view('reports.printregionwise', compact('division_name', 'district_name', 'upazila_name', 'millers', 'searchtext'));
    }

    public function printtypewise(Request $request)
    {
        if(!DGFAuth::check(3030)) return view('nopermission');

        $division_id = $request->get('division_id');
        $district_id = $request->get('district_id');
        $chal_type_id = $request->get('chal_type_id');
        $mill_type_id = $request->get('mill_type_id');
        $searchtext = $request->get('searchtext');

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

        $division = Division::find($division_id);
        $division_name = $division ? $division->divname:'';

        $district = District::find($district_id);
        $district_name = $district ? $district->distname:'';

        $chal_type = ChalType::find($chal_type_id);
        $chal_type_name = $chal_type ? $chal_type->dchal_type_name:'';

        $mill_type = MillType::find($mill_type_id);
        $mill_type_name = $mill_type ? $mill_type->mill_type_name:'';

        $millers = Miller::sortable();

        if($division_id)
            $millers = $millers->where("division_id", $division_id);

        if($district_id)
            $millers = $millers->where("district_id", $district_id);

        if(Auth::user()->upazila_id>0)
            $millers = $millers->where("mill_upazila_id", Auth::user()->upazila_id);

        if($mill_type_id)
            $millers = $millers->where("miller.mill_type_id", $mill_type_id);

        if($chal_type_id)
            $millers = $millers->where("chal_type_id", $chal_type_id);

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
        ->orderBy('miller.division_id')->orderBy('miller.district_id')->orderBy('miller.mill_upazila_id')->orderBy('mill_type.ordering');

        $millers = $millers->get();

        return view('reports.printtypewise', compact('division_name', 'district_name','chal_type_name','mill_type_name', 'millers', 'searchtext'));
    }

    public function getFilteredMillers(Request $request)
    {
        $checkedValues = $request->get('checkedValues');

        $millers = Miller::whereIn('miller_id', $checkedValues)->get();

        return view('miller.printforms', compact('millers'));
    }

    public function summary($chal_type_id)
    {
        if(!DGFAuth::check(3040)) return view('nopermission');

        $chal_type = "আতপ";
        if($chal_type_id != 1){
            $chal_type = "সিদ্ধ";
            $chal_type_id = 2;
        }

        if(Auth::user()->division_id>0){
            return $this->summarywithdivision(Auth::user()->division_id, $chal_type_id);
        }

        $level=0;

        $millers_info = DB::table('division')
            ->select("divid as id", "divname as name",
                DB::raw('count(miller_id) as totalcount'),
                DB::raw('SUM(ROUND(millar_p_power_chal, 0)) as totalpower'),
                DB::raw('count(CASE WHEN mill_type_id = 1 THEN miller_id END) totalcount1'),
                DB::raw('SUM(ROUND(CASE WHEN mill_type_id = 1 THEN millar_p_power_chal END, 0)) totalpower1'),
                DB::raw('count(CASE WHEN mill_type_id = 2 THEN miller_id END) totalcount2'),
                DB::raw('SUM(ROUND(CASE WHEN mill_type_id = 2 THEN millar_p_power_chal END, 0)) totalpower2'),
                DB::raw('count(CASE WHEN mill_type_id = 3 THEN miller_id END) totalcount3'),
                DB::raw('SUM(ROUND(CASE WHEN mill_type_id = 3 THEN millar_p_power_chal END, 0)) totalpower3'),
                DB::raw('count(CASE WHEN mill_type_id = 4 THEN miller_id END) totalcount4'),
                DB::raw('SUM(ROUND(CASE WHEN mill_type_id = 4 THEN millar_p_power_chal END, 0)) totalpower4'),
                DB::raw('count(CASE WHEN mill_type_id = 5 THEN miller_id END) totalcount5'),
                DB::raw('SUM(ROUND(CASE WHEN mill_type_id = 5 THEN millar_p_power_chal END, 0)) totalpower5')
                )
            ->leftjoin(DB::raw("(select * from miller where chal_type_id = $chal_type_id && miller_status = 'active') AS miller"), 'miller.division_id', '=', 'divid')
            ->groupBy('divid', "divname")
            ->get();

        $millers_info_total = DB::table('division')
            ->select(
                DB::raw('count(miller_id) as totalcount'),
                DB::raw('SUM(ROUND(millar_p_power_chal, 0)) as totalpower'),
                DB::raw('count(CASE WHEN mill_type_id = 1 THEN miller_id END) totalcount1'),
                DB::raw('SUM(ROUND(CASE WHEN mill_type_id = 1 THEN millar_p_power_chal END, 0)) totalpower1'),
                DB::raw('count(CASE WHEN mill_type_id = 2 THEN miller_id END) totalcount2'),
                DB::raw('SUM(ROUND(CASE WHEN mill_type_id = 2 THEN millar_p_power_chal END, 0)) totalpower2'),
                DB::raw('count(CASE WHEN mill_type_id = 3 THEN miller_id END) totalcount3'),
                DB::raw('SUM(ROUND(CASE WHEN mill_type_id = 3 THEN millar_p_power_chal END, 0)) totalpower3'),
                DB::raw('count(CASE WHEN mill_type_id = 4 THEN miller_id END) totalcount4'),
                DB::raw('SUM(ROUND(CASE WHEN mill_type_id = 4 THEN millar_p_power_chal END, 0)) totalpower4'),
                DB::raw('count(CASE WHEN mill_type_id = 5 THEN miller_id END) totalcount5'),
                DB::raw('SUM(ROUND(CASE WHEN mill_type_id = 5 THEN millar_p_power_chal END, 0)) totalpower5')
                )
            ->leftjoin(DB::raw("(select * from miller where chal_type_id = $chal_type_id && miller_status = 'active') AS miller"), 'miller.division_id', '=', 'divid')
            ->first();

        $returnid = '';
        $headertext = '';

        return view('reports.summary', compact('millers_info', 'millers_info_total', 'level', 'returnid', 'headertext', 'chal_type', 'chal_type_id'));
    }

    public function summarywithdivision($id, $chal_type_id)
    {
        if(!DGFAuth::check(3040)) return view('nopermission');

        $chal_type = "আতপ";
        if($chal_type_id != 1){
            $chal_type = "সিদ্ধ";
            $chal_type_id = 2;
        }

        if(Auth::user()->district_id>0){
            return $this->summarywithdistrict(Auth::user()->district_id, $chal_type_id);
        }

        $level=1;

        $millers_info = DB::table('district')
            ->select("distid as id", "distname as name",
                DB::raw('count(miller_id) as totalcount'),
                DB::raw('SUM(ROUND(millar_p_power_chal, 0)) as totalpower'),
                DB::raw('count(CASE WHEN mill_type_id = 1 THEN miller_id END) totalcount1'),
                DB::raw('SUM(ROUND(CASE WHEN mill_type_id = 1 THEN millar_p_power_chal END, 0)) totalpower1'),
                DB::raw('count(CASE WHEN mill_type_id = 2 THEN miller_id END) totalcount2'),
                DB::raw('SUM(ROUND(CASE WHEN mill_type_id = 2 THEN millar_p_power_chal END, 0)) totalpower2'),
                DB::raw('count(CASE WHEN mill_type_id = 3 THEN miller_id END) totalcount3'),
                DB::raw('SUM(ROUND(CASE WHEN mill_type_id = 3 THEN millar_p_power_chal END, 0)) totalpower3'),
                DB::raw('count(CASE WHEN mill_type_id = 4 THEN miller_id END) totalcount4'),
                DB::raw('SUM(ROUND(CASE WHEN mill_type_id = 4 THEN millar_p_power_chal END, 0)) totalpower4'),
                DB::raw('count(CASE WHEN mill_type_id = 5 THEN miller_id END) totalcount5'),
                DB::raw('SUM(ROUND(CASE WHEN mill_type_id = 5 THEN millar_p_power_chal END, 0)) totalpower5')
                )
            ->leftjoin(DB::raw("(select * from miller where chal_type_id = $chal_type_id && miller_status = 'active') AS miller"), 'miller.district_id', '=', 'distid')
            ->where("district.divid", $id)
            ->groupBy('distid', "distname")
            ->get();

        $millers_info_total = DB::table('district')
            ->select(
                DB::raw('count(miller_id) as totalcount'),
                DB::raw('SUM(ROUND(millar_p_power_chal, 0)) as totalpower'),
                DB::raw('count(CASE WHEN mill_type_id = 1 THEN miller_id END) totalcount1'),
                DB::raw('SUM(ROUND(CASE WHEN mill_type_id = 1 THEN millar_p_power_chal END, 0)) totalpower1'),
                DB::raw('count(CASE WHEN mill_type_id = 2 THEN miller_id END) totalcount2'),
                DB::raw('SUM(ROUND(CASE WHEN mill_type_id = 2 THEN millar_p_power_chal END, 0)) totalpower2'),
                DB::raw('count(CASE WHEN mill_type_id = 3 THEN miller_id END) totalcount3'),
                DB::raw('SUM(ROUND(CASE WHEN mill_type_id = 3 THEN millar_p_power_chal END, 0)) totalpower3'),
                DB::raw('count(CASE WHEN mill_type_id = 4 THEN miller_id END) totalcount4'),
                DB::raw('SUM(ROUND(CASE WHEN mill_type_id = 4 THEN millar_p_power_chal END, 0)) totalpower4'),
                DB::raw('count(CASE WHEN mill_type_id = 5 THEN miller_id END) totalcount5'),
                DB::raw('SUM(ROUND(CASE WHEN mill_type_id = 5 THEN millar_p_power_chal END, 0)) totalpower5')
                )
            ->leftjoin(DB::raw("(select * from miller where chal_type_id = $chal_type_id && miller_status = 'active') AS miller"), 'miller.district_id', '=', 'distid')
            ->where("district.divid", $id)
            ->first();

        $returnid = '';
        $headertext = ' - '. Division::find( $id) -> divname . ' বিভাগ';

        return view('reports.summary', compact('millers_info', 'millers_info_total', 'level', 'returnid', 'headertext', 'chal_type', 'chal_type_id'));
    }

    public function summarywithdistrict($id, $chal_type_id)
    {
        if(!DGFAuth::check(3040)) return view('nopermission');

        $chal_type = "আতপ";
        if($chal_type_id != 1){
            $chal_type = "সিদ্ধ";
            $chal_type_id = 2;
        }

        if(Auth::user()->upazila_id>0){
            return $this->summarywithupazilla(Auth::user()->upazila_id, $chal_type_id);
        }

        $level=2;

        $millers_info = DB::table('upazilla')
            ->select("upazillaid as id", "upazillaname as name",
                DB::raw('count(miller_id) as totalcount'),
                DB::raw('SUM(ROUND(millar_p_power_chal, 0)) as totalpower'),
                DB::raw('count(CASE WHEN mill_type_id = 1 THEN miller_id END) totalcount1'),
                DB::raw('SUM(ROUND(CASE WHEN mill_type_id = 1 THEN millar_p_power_chal END, 0)) totalpower1'),
                DB::raw('count(CASE WHEN mill_type_id = 2 THEN miller_id END) totalcount2'),
                DB::raw('SUM(ROUND(CASE WHEN mill_type_id = 2 THEN millar_p_power_chal END, 0)) totalpower2'),
                DB::raw('count(CASE WHEN mill_type_id = 3 THEN miller_id END) totalcount3'),
                DB::raw('SUM(ROUND(CASE WHEN mill_type_id = 3 THEN millar_p_power_chal END, 0)) totalpower3'),
                DB::raw('count(CASE WHEN mill_type_id = 4 THEN miller_id END) totalcount4'),
                DB::raw('SUM(ROUND(CASE WHEN mill_type_id = 4 THEN millar_p_power_chal END, 0)) totalpower4'),
                DB::raw('count(CASE WHEN mill_type_id = 5 THEN miller_id END) totalcount5'),
                DB::raw('SUM(ROUND(CASE WHEN mill_type_id = 5 THEN millar_p_power_chal END, 0)) totalpower5')
                )
            ->leftjoin(DB::raw("(select * from miller where chal_type_id = $chal_type_id && miller_status = 'active') AS miller"), 'miller.mill_upazila_id', '=', 'upazillaid')
            ->where("upazilla.distid", $id)
            ->groupBy('upazillaid', "upazillaname")
            ->get();

        $millers_info_total = DB::table('upazilla')
            ->select(
                DB::raw('count(miller_id) as totalcount'),
                DB::raw('SUM(ROUND(millar_p_power_chal, 0)) as totalpower'),
                DB::raw('count(CASE WHEN mill_type_id = 1 THEN miller_id END) totalcount1'),
                DB::raw('SUM(ROUND(CASE WHEN mill_type_id = 1 THEN millar_p_power_chal END, 0)) totalpower1'),
                DB::raw('count(CASE WHEN mill_type_id = 2 THEN miller_id END) totalcount2'),
                DB::raw('SUM(ROUND(CASE WHEN mill_type_id = 2 THEN millar_p_power_chal END, 0)) totalpower2'),
                DB::raw('count(CASE WHEN mill_type_id = 3 THEN miller_id END) totalcount3'),
                DB::raw('SUM(ROUND(CASE WHEN mill_type_id = 3 THEN millar_p_power_chal END, 0)) totalpower3'),
                DB::raw('count(CASE WHEN mill_type_id = 4 THEN miller_id END) totalcount4'),
                DB::raw('SUM(ROUND(CASE WHEN mill_type_id = 4 THEN millar_p_power_chal END, 0)) totalpower4'),
                DB::raw('count(CASE WHEN mill_type_id = 5 THEN miller_id END) totalcount5'),
                DB::raw('SUM(ROUND(CASE WHEN mill_type_id = 5 THEN millar_p_power_chal END, 0)) totalpower5')
                )
            ->leftjoin(DB::raw("(select * from miller where chal_type_id = $chal_type_id && miller_status = 'active') AS miller"), 'miller.mill_upazila_id', '=', 'upazillaid')
            ->where("upazilla.distid", $id)
            ->first();

        $district = District::find($id);
        $returnid = $district->divid;
        $headertext = ' - '.  $district-> distname . ' জেলা';

        return view('reports.summary', compact('millers_info', 'millers_info_total', 'level', 'returnid', 'headertext', 'chal_type', 'chal_type_id'));
    }

    public function summarywithupazilla($id, $chal_type_id)
    {
        if(!DGFAuth::check(3040)) return view('nopermission');

        $chal_type = "আতপ";
        if($chal_type_id != 1){
            $chal_type = "সিদ্ধ";
            $chal_type_id = 2;
        }

        $level=3;

        $millers_info = DB::table('miller')
            ->select("miller_id as id", "mill_name as name",
                DB::raw('count(miller_id) as totalcount'),
                DB::raw('SUM(ROUND(millar_p_power_chal, 0)) as totalpower'),
                DB::raw('count(CASE WHEN mill_type_id = 1 THEN miller_id END) totalcount1'),
                DB::raw('SUM(ROUND(CASE WHEN mill_type_id = 1 THEN millar_p_power_chal END, 0)) totalpower1'),
                DB::raw('count(CASE WHEN mill_type_id = 2 THEN miller_id END) totalcount2'),
                DB::raw('SUM(ROUND(CASE WHEN mill_type_id = 2 THEN millar_p_power_chal END, 0)) totalpower2'),
                DB::raw('count(CASE WHEN mill_type_id = 3 THEN miller_id END) totalcount3'),
                DB::raw('SUM(ROUND(CASE WHEN mill_type_id = 3 THEN millar_p_power_chal END, 0)) totalpower3'),
                DB::raw('count(CASE WHEN mill_type_id = 4 THEN miller_id END) totalcount4'),
                DB::raw('SUM(ROUND(CASE WHEN mill_type_id = 4 THEN millar_p_power_chal END, 0)) totalpower4'),
                DB::raw('count(CASE WHEN mill_type_id = 5 THEN miller_id END) totalcount5'),
                DB::raw('SUM(ROUND(CASE WHEN mill_type_id = 5 THEN millar_p_power_chal END, 0)) totalpower5')
                )
                ->where("chal_type_id", $chal_type_id)
                ->where("mill_upazila_id", $id)
                ->where("miller_status",'=', 'active')
                ->groupBy('miller_id', "mill_name")
                ->get();

        $millers_info_total = DB::table('miller')
            ->select(
                DB::raw('count(miller_id) as totalcount'),
                DB::raw('SUM(ROUND(millar_p_power_chal, 0)) as totalpower'),
                DB::raw('count(CASE WHEN mill_type_id = 1 THEN miller_id END) totalcount1'),
                DB::raw('SUM(ROUND(CASE WHEN mill_type_id = 1 THEN millar_p_power_chal END, 0)) totalpower1'),
                DB::raw('count(CASE WHEN mill_type_id = 2 THEN miller_id END) totalcount2'),
                DB::raw('SUM(ROUND(CASE WHEN mill_type_id = 2 THEN millar_p_power_chal END, 0)) totalpower2'),
                DB::raw('count(CASE WHEN mill_type_id = 3 THEN miller_id END) totalcount3'),
                DB::raw('SUM(ROUND(CASE WHEN mill_type_id = 3 THEN millar_p_power_chal END, 0)) totalpower3'),
                DB::raw('count(CASE WHEN mill_type_id = 4 THEN miller_id END) totalcount4'),
                DB::raw('SUM(ROUND(CASE WHEN mill_type_id = 4 THEN millar_p_power_chal END, 0)) totalpower4'),
                DB::raw('count(CASE WHEN mill_type_id = 5 THEN miller_id END) totalcount5'),
                DB::raw('SUM(ROUND(CASE WHEN mill_type_id = 5 THEN millar_p_power_chal END, 0)) totalpower5')
                )
                ->where("chal_type_id", $chal_type_id)
                ->where("miller_status",'=', 'active')
                ->where("mill_upazila_id", $id)
                ->first();

        $upazilla = Upazilla::find($id);
        $returnid = $upazilla -> distid;
        $headertext = ' - '. $upazilla -> upazillaname . ' উপজেলা';

        return view('reports.summary', compact('millers_info', 'millers_info_total', 'level', 'returnid', 'headertext', 'chal_type', 'chal_type_id'));
    }
                /////////////////// Only Corporate (আতপ - সিদ্ধ) -Summery //////////////////////////////////


    public function summarycorporate($chal_type_id)
    {
        if(!DGFAuth::check(3040)) return view('nopermission');

        $chal_type = "আতপ";
        if($chal_type_id != 1){
            $chal_type = "সিদ্ধ";
            $chal_type_id = 2;
        }

        if(Auth::user()->division_id>0){
            return $this->summarywithdivision(Auth::user()->division_id, $chal_type_id);
        }

        $level=0;

        $millers_info = DB::table('division')
            ->select("divid as id", "divname as name",
                DB::raw('count(miller_id) as totalcount'),
                DB::raw('SUM(ROUND(millar_p_power_chal, 0)) as totalpower'),
                DB::raw('count(CASE WHEN mill_type_id = 1 THEN miller_id END) totalcount1'),
                DB::raw('SUM(ROUND(CASE WHEN mill_type_id = 1 THEN millar_p_power_chal END, 0)) totalpower1'),
                DB::raw('count(CASE WHEN mill_type_id = 2 THEN miller_id END) totalcount2'),
                DB::raw('SUM(ROUND(CASE WHEN mill_type_id = 2 THEN millar_p_power_chal END, 0)) totalpower2'),
                DB::raw('count(CASE WHEN mill_type_id = 3 THEN miller_id END) totalcount3'),
                DB::raw('SUM(ROUND(CASE WHEN mill_type_id = 3 THEN millar_p_power_chal END, 0)) totalpower3'),
                DB::raw('count(CASE WHEN mill_type_id = 4 THEN miller_id END) totalcount4'),
                DB::raw('SUM(ROUND(CASE WHEN mill_type_id = 4 THEN millar_p_power_chal END, 0)) totalpower4'),
                DB::raw('count(CASE WHEN mill_type_id = 5 THEN miller_id END) totalcount5'),
                DB::raw('SUM(ROUND(CASE WHEN mill_type_id = 5 THEN millar_p_power_chal END, 0)) totalpower5')
                )
            ->leftjoin(DB::raw("(select * from miller where chal_type_id = $chal_type_id && owner_type = 'corporate' && miller_status = 'active') AS miller"), 'miller.division_id', '=', 'divid')
            ->groupBy('divid', "divname")
            ->get();

        $millers_info_total = DB::table('division')
            ->select(
                DB::raw('count(miller_id) as totalcount'),
                DB::raw('SUM(ROUND(millar_p_power_chal, 0)) as totalpower'),
                DB::raw('count(CASE WHEN mill_type_id = 1 THEN miller_id END) totalcount1'),
                DB::raw('SUM(ROUND(CASE WHEN mill_type_id = 1 THEN millar_p_power_chal END, 0)) totalpower1'),
                DB::raw('count(CASE WHEN mill_type_id = 2 THEN miller_id END) totalcount2'),
                DB::raw('SUM(ROUND(CASE WHEN mill_type_id = 2 THEN millar_p_power_chal END, 0)) totalpower2'),
                DB::raw('count(CASE WHEN mill_type_id = 3 THEN miller_id END) totalcount3'),
                DB::raw('SUM(ROUND(CASE WHEN mill_type_id = 3 THEN millar_p_power_chal END, 0)) totalpower3'),
                DB::raw('count(CASE WHEN mill_type_id = 4 THEN miller_id END) totalcount4'),
                DB::raw('SUM(ROUND(CASE WHEN mill_type_id = 4 THEN millar_p_power_chal END, 0)) totalpower4'),
                DB::raw('count(CASE WHEN mill_type_id = 5 THEN miller_id END) totalcount5'),
                DB::raw('SUM(ROUND(CASE WHEN mill_type_id = 5 THEN millar_p_power_chal END, 0)) totalpower5')
                )
            ->leftjoin(DB::raw("(select * from miller where chal_type_id = $chal_type_id && owner_type = 'corporate' && miller_status = 'active') AS miller"), 'miller.division_id', '=', 'divid')
            ->first();

        $returnid = '';
        $headertext = '';

        return view('reports.summarycorporate', compact('millers_info', 'millers_info_total', 'level', 'returnid', 'headertext', 'chal_type', 'chal_type_id'));
    }

    // Corporate With division
    public function summarycorporatewithdivision($id, $chal_type_id)
    {
        //dd('div');

        if(!DGFAuth::check(3040)) return view('nopermission');

        $chal_type = "আতপ";
        if($chal_type_id != 1){
            $chal_type = "সিদ্ধ";
            $chal_type_id = 2;
        }


        if(Auth::user()->district_id>0){
            return $this->summarywithdistrict(Auth::user()->district_id, $chal_type_id);
        }

        $level=1;

        $millers_info = DB::table('district')
            ->select("distid as id", "distname as name",
                DB::raw('count(miller_id) as totalcount'),
                DB::raw('SUM(ROUND(millar_p_power_chal, 0)) as totalpower'),
                DB::raw('count(CASE WHEN mill_type_id = 1 THEN miller_id END) totalcount1'),
                DB::raw('SUM(ROUND(CASE WHEN mill_type_id = 1 THEN millar_p_power_chal END, 0)) totalpower1'),
                DB::raw('count(CASE WHEN mill_type_id = 2 THEN miller_id END) totalcount2'),
                DB::raw('SUM(ROUND(CASE WHEN mill_type_id = 2 THEN millar_p_power_chal END, 0)) totalpower2'),
                DB::raw('count(CASE WHEN mill_type_id = 3 THEN miller_id END) totalcount3'),
                DB::raw('SUM(ROUND(CASE WHEN mill_type_id = 3 THEN millar_p_power_chal END, 0)) totalpower3'),
                DB::raw('count(CASE WHEN mill_type_id = 4 THEN miller_id END) totalcount4'),
                DB::raw('SUM(ROUND(CASE WHEN mill_type_id = 4 THEN millar_p_power_chal END, 0)) totalpower4'),
                DB::raw('count(CASE WHEN mill_type_id = 5 THEN miller_id END) totalcount5'),
                DB::raw('SUM(ROUND(CASE WHEN mill_type_id = 5 THEN millar_p_power_chal END, 0)) totalpower5')
                )
            ->leftjoin(DB::raw("(select * from miller where chal_type_id = $chal_type_id && owner_type = 'corporate' && miller_status = 'active') AS miller"), 'miller.district_id', '=', 'distid')
            ->where("district.divid", $id)
            ->groupBy('distid', "distname")
            ->get();

        $millers_info_total = DB::table('district')
            ->select(
                DB::raw('count(miller_id) as totalcount'),
                DB::raw('SUM(ROUND(millar_p_power_chal, 0)) as totalpower'),
                DB::raw('count(CASE WHEN mill_type_id = 1 THEN miller_id END) totalcount1'),
                DB::raw('SUM(ROUND(CASE WHEN mill_type_id = 1 THEN millar_p_power_chal END, 0)) totalpower1'),
                DB::raw('count(CASE WHEN mill_type_id = 2 THEN miller_id END) totalcount2'),
                DB::raw('SUM(ROUND(CASE WHEN mill_type_id = 2 THEN millar_p_power_chal END, 0)) totalpower2'),
                DB::raw('count(CASE WHEN mill_type_id = 3 THEN miller_id END) totalcount3'),
                DB::raw('SUM(ROUND(CASE WHEN mill_type_id = 3 THEN millar_p_power_chal END, 0)) totalpower3'),
                DB::raw('count(CASE WHEN mill_type_id = 4 THEN miller_id END) totalcount4'),
                DB::raw('SUM(ROUND(CASE WHEN mill_type_id = 4 THEN millar_p_power_chal END, 0)) totalpower4'),
                DB::raw('count(CASE WHEN mill_type_id = 5 THEN miller_id END) totalcount5'),
                DB::raw('SUM(ROUND(CASE WHEN mill_type_id = 5 THEN millar_p_power_chal END, 0)) totalpower5')
                )
            ->leftjoin(DB::raw("(select * from miller where chal_type_id = $chal_type_id && owner_type = 'corporate' && miller_status = 'active') AS miller"), 'miller.district_id', '=', 'distid')
            ->where("district.divid", $id)
            ->first();

        $returnid = '';
        $headertext = ' - '. Division::find( $id) -> divname . ' বিভাগ';

        return view('reports.summarycorporate', compact('millers_info', 'millers_info_total', 'level', 'returnid', 'headertext', 'chal_type', 'chal_type_id'));
    }

    //Corporate with district

    public function summarycorporatewithdistrict($id, $chal_type_id)
    {
        if(!DGFAuth::check(3040)) return view('nopermission');

        $chal_type = "আতপ";
        if($chal_type_id != 1){
            $chal_type = "সিদ্ধ";
            $chal_type_id = 2;
        }


        if(Auth::user()->upazila_id>0){
            return $this->summarywithupazilla(Auth::user()->upazila_id, $chal_type_id);
        }

        $level=2;

        $millers_info = DB::table('upazilla')
            ->select("upazillaid as id", "upazillaname as name",
                DB::raw('count(miller_id) as totalcount'),
                DB::raw('SUM(ROUND(millar_p_power_chal, 0)) as totalpower'),
                DB::raw('count(CASE WHEN mill_type_id = 1 THEN miller_id END) totalcount1'),
                DB::raw('SUM(ROUND(CASE WHEN mill_type_id = 1 THEN millar_p_power_chal END, 0)) totalpower1'),
                DB::raw('count(CASE WHEN mill_type_id = 2 THEN miller_id END) totalcount2'),
                DB::raw('SUM(ROUND(CASE WHEN mill_type_id = 2 THEN millar_p_power_chal END, 0)) totalpower2'),
                DB::raw('count(CASE WHEN mill_type_id = 3 THEN miller_id END) totalcount3'),
                DB::raw('SUM(ROUND(CASE WHEN mill_type_id = 3 THEN millar_p_power_chal END, 0)) totalpower3'),
                DB::raw('count(CASE WHEN mill_type_id = 4 THEN miller_id END) totalcount4'),
                DB::raw('SUM(ROUND(CASE WHEN mill_type_id = 4 THEN millar_p_power_chal END, 0)) totalpower4'),
                DB::raw('count(CASE WHEN mill_type_id = 5 THEN miller_id END) totalcount5'),
                DB::raw('SUM(ROUND(CASE WHEN mill_type_id = 5 THEN millar_p_power_chal END, 0)) totalpower5')
                )
            ->leftjoin(DB::raw("(select * from miller where chal_type_id = $chal_type_id && owner_type = 'corporate' && miller_status = 'active') AS miller"), 'miller.mill_upazila_id', '=', 'upazillaid')
            ->where("upazilla.distid", $id)
            ->groupBy('upazillaid', "upazillaname")
            ->get();

        $millers_info_total = DB::table('upazilla')
            ->select(
                DB::raw('count(miller_id) as totalcount'),
                DB::raw('SUM(ROUND(millar_p_power_chal, 0)) as totalpower'),
                DB::raw('count(CASE WHEN mill_type_id = 1 THEN miller_id END) totalcount1'),
                DB::raw('SUM(ROUND(CASE WHEN mill_type_id = 1 THEN millar_p_power_chal END, 0)) totalpower1'),
                DB::raw('count(CASE WHEN mill_type_id = 2 THEN miller_id END) totalcount2'),
                DB::raw('SUM(ROUND(CASE WHEN mill_type_id = 2 THEN millar_p_power_chal END, 0)) totalpower2'),
                DB::raw('count(CASE WHEN mill_type_id = 3 THEN miller_id END) totalcount3'),
                DB::raw('SUM(ROUND(CASE WHEN mill_type_id = 3 THEN millar_p_power_chal END, 0)) totalpower3'),
                DB::raw('count(CASE WHEN mill_type_id = 4 THEN miller_id END) totalcount4'),
                DB::raw('SUM(ROUND(CASE WHEN mill_type_id = 4 THEN millar_p_power_chal END, 0)) totalpower4'),
                DB::raw('count(CASE WHEN mill_type_id = 5 THEN miller_id END) totalcount5'),
                DB::raw('SUM(ROUND(CASE WHEN mill_type_id = 5 THEN millar_p_power_chal END, 0)) totalpower5')
                )
            ->leftjoin(DB::raw("(select * from miller where chal_type_id = $chal_type_id && owner_type = 'corporate' && miller_status = 'active') AS miller"), 'miller.mill_upazila_id', '=', 'upazillaid')
            ->where("upazilla.distid", $id)
            ->first();

        $district = District::find($id);
        $returnid = $district->divid;
        $headertext = ' - '.  $district-> distname . ' জেলা';

        return view('reports.summarycorporate', compact('millers_info', 'millers_info_total', 'level', 'returnid', 'headertext', 'chal_type','chal_type_id',));
    }

    //Corporate with upazilla

    public function summarycorporatewithupazilla($id, $chal_type_id)
    {
        if(!DGFAuth::check(3040)) return view('nopermission');

        $chal_type = "আতপ";
        if($chal_type_id != 1){
            $chal_type = "সিদ্ধ";
            $chal_type_id = 2;
        }

        $level=3;

        $millers_info = DB::table('miller')
            ->select("miller_id as id", "mill_name as name",
                DB::raw('count(miller_id) as totalcount'),
                DB::raw('SUM(ROUND(millar_p_power_chal, 0)) as totalpower'),
                DB::raw('count(CASE WHEN mill_type_id = 1 THEN miller_id END) totalcount1'),
                DB::raw('SUM(ROUND(CASE WHEN mill_type_id = 1 THEN millar_p_power_chal END, 0)) totalpower1'),
                DB::raw('count(CASE WHEN mill_type_id = 2 THEN miller_id END) totalcount2'),
                DB::raw('SUM(ROUND(CASE WHEN mill_type_id = 2 THEN millar_p_power_chal END, 0)) totalpower2'),
                DB::raw('count(CASE WHEN mill_type_id = 3 THEN miller_id END) totalcount3'),
                DB::raw('SUM(ROUND(CASE WHEN mill_type_id = 3 THEN millar_p_power_chal END, 0)) totalpower3'),
                DB::raw('count(CASE WHEN mill_type_id = 4 THEN miller_id END) totalcount4'),
                DB::raw('SUM(ROUND(CASE WHEN mill_type_id = 4 THEN millar_p_power_chal END, 0)) totalpower4'),
                DB::raw('count(CASE WHEN mill_type_id = 5 THEN miller_id END) totalcount5'),
                DB::raw('SUM(ROUND(CASE WHEN mill_type_id = 5 THEN millar_p_power_chal END, 0)) totalpower5')
                )
                ->where("chal_type_id", $chal_type_id)
                ->where("owner_type", '=','corporate')
                ->where("mill_upazila_id", $id)
                ->where("miller_status",'=', 'active')
                ->groupBy('miller_id', "mill_name")
                ->get();

        $millers_info_total = DB::table('miller')
            ->select(
                DB::raw('count(miller_id) as totalcount'),
                DB::raw('SUM(ROUND(millar_p_power_chal, 0)) as totalpower'),
                DB::raw('count(CASE WHEN mill_type_id = 1 THEN miller_id END) totalcount1'),
                DB::raw('SUM(ROUND(CASE WHEN mill_type_id = 1 THEN millar_p_power_chal END, 0)) totalpower1'),
                DB::raw('count(CASE WHEN mill_type_id = 2 THEN miller_id END) totalcount2'),
                DB::raw('SUM(ROUND(CASE WHEN mill_type_id = 2 THEN millar_p_power_chal END, 0)) totalpower2'),
                DB::raw('count(CASE WHEN mill_type_id = 3 THEN miller_id END) totalcount3'),
                DB::raw('SUM(ROUND(CASE WHEN mill_type_id = 3 THEN millar_p_power_chal END, 0)) totalpower3'),
                DB::raw('count(CASE WHEN mill_type_id = 4 THEN miller_id END) totalcount4'),
                DB::raw('SUM(ROUND(CASE WHEN mill_type_id = 4 THEN millar_p_power_chal END, 0)) totalpower4'),
                DB::raw('count(CASE WHEN mill_type_id = 5 THEN miller_id END) totalcount5'),
                DB::raw('SUM(ROUND(CASE WHEN mill_type_id = 5 THEN millar_p_power_chal END, 0)) totalpower5')
                )
                ->where("chal_type_id", $chal_type_id)
                ->where("owner_type", '=','corporate')
                ->where("miller_status",'=', 'active')
                ->where("mill_upazila_id", $id)
                ->first();

        $upazilla = Upazilla::find($id);
        $returnid = $upazilla -> distid;
        $headertext = ' - '. $upazilla -> upazillaname . ' উপজেলা';

        return view('reports.summarycorporate', compact('millers_info', 'millers_info_total', 'level', 'returnid', 'headertext', 'chal_type','chal_type_id'));
    }


    public function destroy()
    {
        //
    }

    public function exportpasscode(Request $request)
    {
        $division_id = $request->get('division_id');
        $district_id = $request->get('district_id');
        $upazila_id = $request->get('upazila_id');

        $millers = Miller::sortable();

        if($division_id)
            $millers = $millers->where("division_id", $division_id);

        if($district_id)
            $millers = $millers->where("district_id", $district_id);

        if($upazila_id)
            $millers = $millers->where("mill_upazila_id", $upazila_id);

        $millers = $millers->select('miller.*')
        ->join('mill_type', 'miller.mill_type_id', '=', 'mill_type.mill_type_id')
        ->orderBy('miller.division_id')->orderBy('miller.district_id')->orderBy('miller.mill_upazila_id')->orderBy('mill_type.ordering');

        $millers = $millers->get();

        $data= array();

        foreach($millers as $res){
            $data[]= array(
            'mobile_no' => $res->mobile_no,
            'pass_code'=> $res->pass_code,
            'mill_name' => $res->mill_name,
            'owner_name' => $res->owner_name,
            'mill_type_name' => $res->milltype ? $res->milltype->mill_type_name : '',
            'chal_type_name' => $res->ChalType ? $res->ChalType->chal_type_name : '',
            'upazillaname' => $res->upazilla ? $res->upazilla->upazillaname:'',
            'distname'=> $res->district ? $res->district->distname:'',
            'divname'=> $res->division ? $res->division->divname:'' );
        }
        $exportdata = 4;
        $export= new MillerExport($data, $exportdata);

        return Excel::download($export, 'passcode.xlsx', 'Xlsx');
    }

    public function exportinfowise(Request $request)
    {
        $division_id = $request->get('division_id');
        $district_id = $request->get('district_id');
        $cmp_status = $request->get('cmp_status');
        $searchtext = $request->get('searchtext');

        $divisions = DGFAuth::filtereddivision();
        if($division_id==0 && Auth::user()->division_id>0) $division_id = Auth::user()->division_id;
        if($district_id==0 && Auth::user()->district_id>0) {
            $district_id = Auth::user()->district_id;
            $districts = DB::table('district')
            ->where("distid", Auth::user()->district_id)
            ->get();
        }
        else{
            $districts = DB::table('district')
            ->where("divid", $division_id)
            ->get();
        }

        $millers = Miller::sortable();

        if($division_id)
            $millers = $millers->where("division_id", $division_id);

        if($district_id)
            $millers = $millers->where("district_id", $district_id);

        if(Auth::user()->upazila_id>0)
            $millers = $millers->where("mill_upazila_id", Auth::user()->upazila_id);

        if($cmp_status!=null)
            $millers = $millers->where("cmp_status", $cmp_status);

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
        ->orderBy('miller.division_id')->orderBy('miller.district_id')->orderBy('miller.mill_upazila_id')->orderBy('mill_type.ordering');

        $millers = $millers->get();

        $data= array();


        foreach($millers as $res){
            $data[]= array( 'mill_name' => $res->mill_name,
            'owner_name' => $res->owner_name,
            'mobile_no' => $res->mobile_no,
            'license_no'=> $res->license_no,
            'mill_type_name' => $res->milltype ? $res->milltype->mill_type_name : '',
            'chal_type_name' => $res->ChalType ? $res->ChalType->chal_type_name : '',
            'millar_p_power_chal'=> BanglaConverter::en2bn(0, $res->millar_p_power_chal),
            'upazillaname' => $res->upazilla ? $res->upazilla->upazillaname:'',
            'distname'=> $res->district ? $res->district->distname:'',
            'divname'=> $res->division ? $res->division->divname:'' );
            //dd($res);
        }
        $exportdata = 1;
        $export= new MillerExport($data, $exportdata);

        return Excel::download($export, 'info_wise_millers.xlsx', 'Xlsx');
    }

    public function exportregionwise(Request $request)
    {
        $division_id = $request->get('division_id');
        $district_id = $request->get('district_id');
        $mill_upazila_id = $request->get('upazila_id');
        $searchtext = $request->get('searchtext');

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
        if($mill_upazila_id==0 && Auth::user()->upazila_id>0) {
            $mill_upazila_id = Auth::user()->upazila_id;
            $upazillas = DB::table('upazilla')
            ->where("upazillaid", Auth::user()->upazila_id)
            ->get();
        }
        else{
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
        ->orderBy('miller.division_id')->orderBy('miller.district_id')->orderBy('miller.mill_upazila_id')->orderBy('mill_type.ordering');

        $millers = $millers->get();

        $data= array();

        foreach($millers as $res){
            $data[]= array('mill_name' => $res->mill_name,
            'owner_name' => $res->owner_name,
            'mobile_no' => $res->mobile_no,
            'license_no'=> $res->license_no,
            'mill_type_name' => $res->milltype ? $res->milltype->mill_type_name : '',
            'chal_type_name' => $res->ChalType ? $res->ChalType->chal_type_name : '',
            'millar_p_power_chal'=> BanglaConverter::en2bn(0, $res->millar_p_power_chal),
            'upazillaname' => $res->upazilla ? $res->upazilla->upazillaname:'',
            'distname'=> $res->district ? $res->district->distname:'',
            'divname'=> $res->division ? $res->division->divname:'' );
        }
        $exportdata = 2;
        $export= new MillerExport($data,$exportdata);

        return Excel::download($export, 'region_wise_millers.xlsx', 'Xlsx');
    }

    public function exporttypewise(Request $request)
    {
        $division_id = $request->get('division_id');
        $district_id = $request->get('district_id');
        $chal_type_id = $request->get('chal_type_id');
        $mill_type_id = $request->get('mill_type_id');
        $searchtext = $request->get('searchtext');

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

        $millers = Miller::sortable();

        if($division_id)
            $millers = $millers->where("division_id", $division_id);

        if($district_id)
            $millers = $millers->where("district_id", $district_id);

        if(Auth::user()->upazila_id>0)
            $millers = $millers->where("mill_upazila_id", Auth::user()->upazila_id);

        if($mill_type_id)
            $millers = $millers->where("miller.mill_type_id", $mill_type_id);

        if($chal_type_id)
            $millers = $millers->where("chal_type_id", $chal_type_id);

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
        ->orderBy('miller.division_id')->orderBy('miller.district_id')->orderBy('miller.mill_upazila_id')->orderBy('mill_type.ordering');

        $millers = $millers->get();

        $data= array();

        foreach($millers as $res){
            $data[]= array('mill_name' => $res->mill_name,
            'owner_name' => $res->owner_name,
            'mobile_no' => $res->mobile_no,
            'license_no'=> $res->license_no,
            'mill_type_name' => $res->milltype ? $res->milltype->mill_type_name : '',
            'chal_type_name' => $res->ChalType ? $res->ChalType->chal_type_name : '',
            'millar_p_power_chal'=> BanglaConverter::en2bn(0, $res->millar_p_power_chal),
            'upazillaname' => $res->upazilla ? $res->upazilla->upazillaname:'',
            'distname'=> $res->district ? $res->district->distname:'',
            'divname'=> $res->division ? $res->division->divname:'' );
        }

        $exportdata = 3;
        $export= new MillerExport($data, $exportdata);

        return Excel::download($export, 'type_wise_millers.xlsx', 'Xlsx');
    }
}
