<?php

namespace App\Http\Controllers;

use App\Models\LicenseFee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\LicenseType;
use App\DGFAuth;
use Illuminate\Support\Facades\Auth;

class LicenseFeeController extends Controller
{
    private $menunum = 5028;

    public function index()
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');

        $license_fees = LicenseFee::paginate(15);
        return view('license_fees.index', compact('license_fees'));
    }


    public function getLicenseTypeByTypeId(Request $request)
    {
        $license_type_id = $request->get('license_type_id');
        $query = DB::table('license_type')
          ->where("license_type_id", $license_type_id);

        if(Auth::user()!=null && Auth::user()->id>0)
            $query = $query->where("id", Auth::user()->id);

        $data = $query->get();

        $output = '<option value="">লাইসেন্স টাইপ</option>';
        foreach($data as $row)
        {
            $output .= '<option value="'.$row->id.'">'.$row->name.'</option>';
        }
        echo $output;
    }

    public function create()
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');

        $license_types = LicenseType::all();
        $divisions = DGFAuth::filtereddivision();// Division::all();
        return view('license_fees.create', compact('license_types','divisions'));
    }


    public function store(Request $request)
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');

        $request->validate([
            'license_type_id' => 'required',
            'effective_todate' => 'required',
            'license_fee' => 'required',
            'name' => 'required',
        ]);

        LicenseFee::create($request->all());

        return redirect()->route('license_fees.index')
                        ->with('success','লাইসেন্স ফী সফলভাবে তৈরি হয়েছে');
    }


    public function show(LicenseFee $license_fee)
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');

        return view('license_fees.show',compact('license_fee'));
    }


    public function edit(LicenseFee $license_fee)
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');

        $divisions = DGFAuth::filtereddivision();// LicenseType::all();
        $license_types = LicenseType::all();
        $license_type_id =  $license_fee->license_type_id;
        return view('license_fees.edit',compact('license_fee', 'license_types','divisions', 'license_type_id'));
    }


    public function update(Request $request, LicenseFee $license_fee)
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');

        $request->validate([
            'license_type_id' => 'required',
            'effective_todate' => 'required',
            'license_fee' => 'required',
            'name' => 'required',
        ]);


        $license_fee->update($request->all());

        return redirect()->route('license_fees.index')
                        ->with('success','লাইসেন্স ফী সফলভাবে আপডেট হয়েছে');
    }

    public function destroy(LicenseFee $license_fee)
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');

        $license_fee->delete();

        return redirect()->route('license_fees.index')
                        ->with('success','লাইসেন্স ফী সফলভাবে বাদ দেওয়া হয়েছে');
    }
}
