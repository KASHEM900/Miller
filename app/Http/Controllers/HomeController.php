<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Models\Miller;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = null;
        $miller = null;
        if(Auth::user()->division_id == 0){
            $user = User::all();
            $miller = Miller::all();
        }else if(Auth::user()->upazila_id > 0){
            $user = User::where('upazila_id', Auth::user()->upazila_id);
            $miller = Miller::where('mill_upazila_id', Auth::user()->upazila_id);
        }else if(Auth::user()->district_id > 0){
            $user = User::where('district_id', Auth::user()->district_id);
            $miller = Miller::where('district_id', Auth::user()->district_id);
        }else if(Auth::user()->division_id > 0){
            $user = User::where('division_id', Auth::user()->division_id);
            $miller = Miller::where('division_id', Auth::user()->division_id);
        }

        $usercount = (clone $user)->count();
        $activeusercount = (clone $user)->where('active_status', 1)->count();
        $inactiveusercount = $usercount- $activeusercount;

        $millercount = (clone $miller)->count();
        $activemillercount = (clone $miller)->where('cmp_status', 1)->count();
        $inactivemillercount = $millercount - $activemillercount;
        $semiautomillercount = (clone $miller)->where('mill_type_id', 1)->count();
        $automillercount = (clone $miller)->where('mill_type_id', 2)->count();
        $exceptpislerautomillercount = (clone $miller)->where('mill_type_id', 3)->count();
        $withpislersemiautomillercount = (clone $miller)->where('mill_type_id', 4)->count();
        $newautomillercount = (clone $miller)->where('mill_type_id', 5)->count();
        //$corporateatopcount = (clone $miller)->where('chal_type_id', 1)->count();
        $corporateAtopcount = (clone $miller)->where('chal_type_id', 1)->whereNotNull('corporate_institute_id')->where('miller_status', 'active')->count();
        $corporateSiddocount = (clone $miller)->where('chal_type_id', 2)->whereNotNull('corporate_institute_id')->where('miller_status', 'active')->count();

        return view('home', compact('usercount', 'activeusercount', 'inactiveusercount', 'millercount', 'activemillercount', 'inactivemillercount',
        'newautomillercount', 'corporateAtopcount', 'corporateSiddocount', 'semiautomillercount', 'automillercount', 'exceptpislerautomillercount', 'withpislersemiautomillercount'));
    }
}
