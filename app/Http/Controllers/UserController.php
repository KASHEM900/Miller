<?php

namespace App\Http\Controllers;

use App\Exports\UserExport;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Division;
use App\Models\District;
use App\Models\Upazilla;
use App\Models\Event;
use App\Models\UserEvent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\DGFAuth;
use Image;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if(!DGFAuth::check(2022, 2, 2)) return view('nopermission');

        $division_id = $request->get('division_id');
        $district_id = $request->get('district_id');
        $upazila_id = $request->get('upazila_id');

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
        $users = User::sortable()->where("name","!=", "sadmin");
        if($division_id && $district_id & $upazila_id) {
            $users = $users->where("upazila_id", $upazila_id)->paginate(10);
        }
        else if($division_id && $district_id) {
            $users = $users->where("district_id", $district_id)->paginate(10);
        }
        else if($division_id) {
            $users = $users->where("division_id", $division_id)->paginate(10);
        }
        else
            $users = $users->paginate(10);

        return view('users.index', compact('users','divisions','districts','upazillas','division_id','district_id','upazila_id'));
    }

    public function deleteindex(Request $request)
    {
        return $this->commondeleteindex($request);
    }

    public function filterdeleteindex(Request $request)
    {
        return $this->commondeleteindex($request);
    }

    private function commondeleteindex(Request $request)
    {
        if(!DGFAuth::check(2023, 2, 4)) return view('nopermission');

        $division_id = $request->get('division_id');
        $district_id = $request->get('district_id');
        $upazila_id = $request->get('upazila_id');

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

        $users=[];
        if($division_id && $district_id & $upazila_id) {
            $users = User::where("upazila_id", $upazila_id)->get();
        }
        else if($division_id && $district_id) {
            $users = User::where("district_id", $district_id)->get();
        }
        else if($division_id) {
            $users = User::where("division_id", $division_id)->get();
        }

        return view('users.indexfordelete', compact('users','divisions','districts','upazillas','division_id','district_id','upazila_id'));
    }

    public function userindex()
    {
        $user = null;
        $miller = null;
        if(Auth::user()->division_id == 0){
            $user = User::all();
        }else if(Auth::user()->upazila_id > 0){
            $user = User::where('upazila_id', Auth::user()->upazila_id);
        }else if(Auth::user()->district_id > 0){
            $user = User::where('district_id', Auth::user()->district_id);
        }else if(Auth::user()->division_id > 0){
            $user = User::where('division_id', Auth::user()->division_id);
        }

        $usercount = (clone $user)->count();
        $activeusercount = (clone $user)->where('active_status', 1)->count();
        $inactiveusercount = $usercount- $activeusercount;

        $adminusercount = (clone $user)->where('user_type', 1)->count();
        $divisionusercount = (clone $user)->where('user_type', 2)->count();
        $districtuserercount = (clone $user)->where('user_type', 3)->count();
        $upazillauserercount = $usercount - $adminusercount - $divisionusercount -$districtuserercount;
        return view('users.manageuser', compact('usercount', 'activeusercount', 'inactiveusercount', 'adminusercount', 'divisionusercount', 'districtuserercount', 'upazillauserercount'));
    }

    public function create() //admin
    {
        if(!DGFAuth::check(2011)) return view('nopermission');

        return view('users.create');
    }

    public function create1() //DGF
    {
        if(!DGFAuth::check(2012, 2, 1)) return view('nopermission');

        $offices = DB::table('office')
        ->join('office_type', 'office_type.office_type_id', '=', 'office.office_type_id')
        ->where("office_type.office_type_id", 1)
        ->get();

        return view('users.create1', compact('offices'));
    }

    public function create2() //division
    {
        if(!DGFAuth::check(2013, 2, 1)) return view('nopermission');

        $divisions = DGFAuth::filtereddivision();// Division::all();
        if(Auth::user()->division_id>0)
            $division_id = Auth::user()->division_id;
        else
            $division_id=0;

        $offices = DB::table('office')
        ->where("division_id", $division_id)
        ->where("office_type_id", 2)
        ->get();
        return view('users.create2', compact('divisions', 'division_id', 'offices'));
    }

    public function getOfficeListByDivId(Request $request)
    {
        $divId = $request->get('divId');
        $data = DB::table('office')
        ->where("division_id", $divId)
        ->where("office_type_id", 2)
        ->get();
        $output = '<option value="">অফিস</option>';
        foreach($data as $row)
        {
         $output .= '<option value="'.$row->office_id.'">'.$row->office_name.'</option>';
        }
        echo $output;
    }

    public function create3() //district
    {
        if(!DGFAuth::check(2014, 2, 1)) return view('nopermission');

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

        $offices = DB::table('office')
        ->where("district_id", $district_id)
        ->where("office_type_id", 3)
         ->get();
        return view('users.create3', compact('divisions', 'districts', 'division_id', 'district_id', 'offices'));
    }

    public function getOfficeListByDistId(Request $request)
    {
        $distId = $request->get('distId');
        $data = DB::table('office')
        ->where("district_id", $distId)
        ->where("office_type_id", 3)
        ->get();
        $output = '<option value="">অফিস</option>';
        foreach($data as $row)
        {
         $output .= '<option value="'.$row->office_id.'">'.$row->office_name.'</option>';
        }
        echo $output;
    }

    public function create4() //upazilla
    {
        if(!DGFAuth::check(2015, 2, 1)) return view('nopermission');

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

        $offices = DB::table('office')
        ->where("upazilla_id", $upazila_id)
        ->where("office_type_id", 4)
        ->get();

        return view('users.create4', compact('divisions', 'districts', 'upazillas', 'division_id', 'district_id','upazila_id', 'offices'));
    }

    public function getOfficeListByUpzId(Request $request)
    {
        $upazila_id = $request->get('upazila_id');
        $data = DB::table('office')
        ->where("upazilla_id", $upazila_id)
        ->where("office_type_id", 4)
        ->get();
        $output = '<option value="">অফিস</option>';
        foreach($data as $row)
        {
         $output .= '<option value="'.$row->office_id.'">'.$row->office_name.'</option>';
        }
        echo $output;
    }

    public function create5() //LSD
    {
        if(!DGFAuth::check(2016, 2, 1)) return view('nopermission');

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

        $offices = DB::table('office')
        ->where("upazilla_id", $upazila_id)
        ->whereIn("office_type_id", [5, 6] )
        ->get();
        return view('users.create5', compact('divisions', 'districts', 'upazillas', 'division_id', 'district_id','upazila_id', 'offices'));
    }

    public function getOfficeListByLSD(Request $request)
    {
        $upazila_id = $request->get('upazila_id');
        $data = DB::table('office')
        ->where("upazilla_id", $upazila_id)
        ->whereIn("office_type_id", [5, 6] )
        ->get();
        $output = '<option value="">অফিস</option>';
        foreach($data as $row)
        {
         $output .= '<option value="'.$row->office_id.'">'.$row->office_name.'</option>';
        }
        echo $output;
    }

    public function create6() //sailo
    {
        if(!DGFAuth::check(2017, 2, 1)) return view('nopermission');

        $divisions = DGFAuth::filtereddivision();// Division::all();
        if(Auth::user()->division_id>0)
            $division_id = Auth::user()->division_id;
        else
            $division_id=0;

        $offices = DB::table('office')
        ->where("division_id", $division_id)
        ->where("office_type_id", 2)
        ->get();
        return view('users.create6', compact('divisions', 'division_id', 'offices'));
    }

    public function store(Request $request)
    {
        if(!DGFAuth::check(2011)) return view('nopermission');

        $request->merge([ 'division_id' => 0, 'district_id' => 0,  'upazila_id' => 0]);
        return $this->storecommon($request, 99, 'createuser');
    }

    public function store1(Request $request)
    {
        if(!DGFAuth::check(2012, 2, 1)) return view('nopermission');

        $request->merge([ 'division_id' => 0, 'district_id' => 0,  'upazila_id' => 0]);
        return $this->storecommon($request, 1, 'createuser1');
    }

    public function store2(Request $request)
    {
        if(!DGFAuth::check(2013, 2, 1)) return view('nopermission');

        $request->merge([ 'district_id' => 0,  'upazila_id' => 0]);
        return $this->storecommon($request, 2, 'createuser2');
    }

    public function store3(Request $request)
    {
        if(!DGFAuth::check(2014, 2, 1)) return view('nopermission');

        $request->merge([  'upazila_id' => 0]);
        return $this->storecommon($request, 3, 'createuser3');
    }

    public function store4(Request $request)
    {
        if(!DGFAuth::check(2015, 2, 1)) return view('nopermission');

        return $this->storecommon($request, 4, 'createuser4');
    }

    public function store5(Request $request)
    {
        if(!DGFAuth::check(2016, 2, 1)) return view('nopermission');

        return $this->storecommon($request, 5, 'createuser5');
    }

    public function store6(Request $request)
    {
        if(!DGFAuth::check(2017, 2, 1)) return view('nopermission');

        $allowedDivisions = $request["AllowedDivisionList"];
        if($allowedDivisions && count($allowedDivisions) > 0){
            $allowedDivisionsString = implode(",", $allowedDivisions);
            
            $request->merge(['district_id' => 0,  'upazila_id' => 0, 'allowed_divisions'=>$allowedDivisionsString]);
            
            return $this->storecommon($request, 6, 'createuser6');
        }
        else{
            return;
        }
    }

    private function storecommon(Request $request, int $type, string $routestr)
    {
        $request->validate([
            'name' => 'required',
            'password' => 'required|between:8,255|confirmed',
            'password_confirmation' => 'required',
            'email' => 'required|confirmed',
            'email_confirmation' => 'required',
        ]);

        $request->merge([ 'active_status' => 1, 'user_type' => $type ]);

        $email = $request->get('email');

        $data = DB::table('users')->where('email',$email)->first();

        if(!$data){
            $request->merge([ 'active_status' => 1, 'user_type' => $type ]);
            $user = User::create($request->all());
            $events = Event::all();
            foreach($events as $event){
                $userevent = new UserEvent;
                $userevent->a_id = $user->id;
                $userevent->event_id = $event->event_id;
                $userevent->view_per = 0;
                $userevent->add_per = 0;
                $userevent->delete_per = 0;
                $userevent->edit_per = 0;
                $userevent->apr_per = 0;
                $userevent->save();
            }
            return redirect($routestr)
                            ->with('success','ইউজার সফলভাবে তৈরি হয়েছে');
        }
        else{
            return redirect($routestr)
                   ->with('Warning','একই ইমেল পাওয়া গেছে।');
        }
    }

    public function edit(User $user)
    {
        $divisions = DGFAuth::filtereddivision();// Division::all();
        $districts = DB::table('district')
        ->where("divid", $user->division_id)
        ->get();
        $upazillas = DB::table('upazilla')
        ->where("distId", $user->district_id)
        ->get();
        $users = User::all();
        return view('users.edit2', compact('divisions','districts','upazillas','user'));
    }


    public function changepassword()
    {
        return view('users.changepassword');
    }

    public function changeuserpassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:8',
            'password-confirm' => 'required|same:password'
        ]);

        $user = User::find(Auth::user()->id);
        $user->password = $request->get('password');
        $user->save();

        return redirect()->route('changepassword')
                        ->with('success','পাসওয়ার্ড সফলভাবে আপডেট হয়েছে');
    }

    public function changeotherpassword($id)
    {
        $user =  User::find($id);
        return view('users.changeotherpassword', compact('user'));
    }

    public function changeotheruserpassword($id,Request $request)
    { 
        $request->validate([
            'password' => 'required|min:8',
            'password-confirm' => 'required|same:password'
        ]);

        $user =  User::find($id);
        $user->password = $request->get('password');
        $user->save();

        return redirect()->route('changeotherpassword', compact('id'))
                        ->with('success','পাসওয়ার্ড সফলভাবে আপডেট হয়েছে');
    }

    public function editdivisionindex(Request $request)
    {
        if(!DGFAuth::check(2025, 2, 3)) return view('nopermission');

       $division_id = $request->get('division_id');
       $user_id = $request->get('user_id');

       if($user_id==null){
        $userEvents = DB::table('user_event')
            ->select("user_event.*", "users.name", "users.active_status","users.signature_file", "event.event_name", 'user_type.name AS user_type')
            ->join('users', 'users.id', '=', 'user_event.a_id')
            ->join('event', 'event.event_id', '=', 'user_event.event_id')
            ->join('user_type', 'user_type.id', '=', 'users.user_type')
            ->where("users.division_id", $division_id)
            ->get();
        }

        $divisions = DGFAuth::filtereddivision();// Division::all();
        if($division_id==0 && Auth::user()->division_id>0) $division_id = Auth::user()->division_id;

        $users = DB::table('users')
        ->where("division_id", $division_id)->where("user_type", 2)->get();

        return view('users.edit2',  compact('divisions', 'users','userEvents','division_id','user_id'));
    }

    public function editdivisionuserlist(Request $request)
    {
        if(!DGFAuth::check(2025, 2, 3)) return view('nopermission');

        $division_id = $request->get('division_id');//division_id
        $user_id = $request->get('user_id');//user_id

        $divisions = DGFAuth::filtereddivision();// Division::all();
        if($division_id==0 && Auth::user()->division_id>0) $division_id = Auth::user()->division_id;

        if($user_id !=null){
            $userEvents = DB::table('user_event')
                ->select("user_event.*", "users.name", "users.active_status","users.signature_file", "event.event_name", 'user_type.name AS user_type')
                ->join('users', 'users.id', '=', 'user_event.a_id')
                ->join('event', 'event.event_id', '=', 'user_event.event_id')
                ->join('user_type', 'user_type.id', '=', 'users.user_type')
                ->where("users.division_id", $division_id)
                ->where("user_event.a_id", $user_id)
                ->get();
        }

        $users = DB::table('users')->where("division_id", $division_id)->where("user_type", 2)->get();

        return view('users.edit2',  compact('divisions', 'users','userEvents','division_id','user_id'));
    }

    public function update(Request $request, User $user)
    {
        if(isset($request->id))
        {
            foreach ($request->id as $key => $value ) {
                $userevent = UserEvent::find($value);
                $userevent->view_per = 0;
                $userevent->add_per = 0;
                $userevent->delete_per = 0;
                $userevent->edit_per = 0;
                $userevent->apr_per = 0;
                $userevent->update();
    
                $user = User::find($userevent->a_id);
                $user->active_status = $request->has('active_status');
                $user->save();
    
                break;
            }
            $this->updateSignature($request, $user);
        }
        

        if(isset($request->view_per))
        foreach ($request->view_per as $key => $value ) {
            $userevent = UserEvent::find($value);
            $userevent->view_per = 1;
            $userevent->update();
        }

        if(isset($request->add_per))
        foreach ($request->add_per as $key => $value ) {
            $userevent = UserEvent::find($value);
            $userevent->add_per = 1;
            $userevent->update();
        }

        if(isset($request->delete_per))
        foreach ($request->delete_per as $key => $value ) {
            $userevent = UserEvent::find($value);
            $userevent->delete_per = 1;
            $userevent->update();
        }

        if(isset($request->edit_per))
        foreach ($request->edit_per as $key => $value ) {
            $userevent = UserEvent::find($value);
            $userevent->edit_per = 1;
            $userevent->update();
        }

        if(isset($request->apr_per))
        foreach ($request->apr_per as $key => $value ) {
            $userevent = UserEvent::find($value);
            $userevent->apr_per = 1;
            $userevent->update();
        }
        return redirect()->route('editdivisionindex',$user->user_id)
                        ->with('success','ইউজারের ইভেন্টস সফলভাবে আপডেট হয়েছে');
    }

    public function update3(Request $request, User $user)
    {
        if(isset($request->id))
        {
            foreach ($request->id as $key => $value ) {
                $userevent = UserEvent::find($value);
                $userevent->view_per = 0;
                $userevent->add_per = 0;
                $userevent->delete_per = 0;
                $userevent->edit_per = 0;
                $userevent->apr_per = 0;
                $userevent->update();
                $user = User::find($userevent->a_id);
                $user->active_status = $request->has('active_status');
                $user->save();
    
                break;
            }
            $this->updateSignature($request, $user);
        }
        
        if(isset($request->view_per))
        foreach ($request->view_per as $key => $value ) {
            $userevent = UserEvent::find($value);
            $userevent->view_per = 1;
            $userevent->update();
        }
        if(isset($request->add_per))
        foreach ($request->add_per as $key => $value ) {
            $userevent = UserEvent::find($value);
            $userevent->add_per = 1;
            $userevent->update();
        }
        if(isset($request->delete_per))
        foreach ($request->delete_per as $key => $value ) {
            $userevent = UserEvent::find($value);
            $userevent->delete_per = 1;
            $userevent->update();
        }
        if(isset($request->edit_per))
        foreach ($request->edit_per as $key => $value ) {
            $userevent = UserEvent::find($value);
            $userevent->edit_per = 1;
            $userevent->update();
        }
        if(isset($request->apr_per))
        foreach ($request->apr_per as $key => $value ) {
            $userevent = UserEvent::find($value);
            $userevent->apr_per = 1;
            $userevent->update();
        }
        return redirect()->route('editdisupzindex',$user->user_id)
                        ->with('success','ইউজারের ইভেন্টস সফলভাবে আপডেট হয়েছে');
    }

    public function update6(Request $request, User $user)
    {
        if(isset($request->id))
        {         
            foreach ($request->id as $key => $value ) {
                $userevent = UserEvent::find($value);
                $userevent->view_per = 0;
                $userevent->add_per = 0;
                $userevent->delete_per = 0;
                $userevent->edit_per = 0;
                $userevent->apr_per = 0;
                $userevent->update();
    
                $user = User::find($userevent->a_id);
                $user->active_status = $request->has('active_status');
                $allowedDivisions = $request["AllowedDivisionList"];
                if($allowedDivisions && count($allowedDivisions) > 0){
                    $user->allowed_divisions = implode(",", $allowedDivisions);
                }
    
                $user->save();

                break;
            } 
            
            $this->updateSignature($request, $user);
        }
        

        if(isset($request->view_per))
        foreach ($request->view_per as $key => $value ) {
            $userevent = UserEvent::find($value);
            $userevent->view_per = 1;
            $userevent->update();
        }

        if(isset($request->add_per))
        foreach ($request->add_per as $key => $value ) {
            $userevent = UserEvent::find($value);
            $userevent->add_per = 1;
            $userevent->update();
        }

        if(isset($request->delete_per))
        foreach ($request->delete_per as $key => $value ) {
            $userevent = UserEvent::find($value);
            $userevent->delete_per = 1;
            $userevent->update();
        }

        if(isset($request->edit_per))
        foreach ($request->edit_per as $key => $value ) {
            $userevent = UserEvent::find($value);
            $userevent->edit_per = 1;
            $userevent->update();
        }

        if(isset($request->apr_per))
        foreach ($request->apr_per as $key => $value ) {
            $userevent = UserEvent::find($value);
            $userevent->apr_per = 1;
            $userevent->update();
        }
        return redirect()->route('editsailoindex',$user->user_id)
                        ->with('success','ইউজারের ইভেন্টস সফলভাবে আপডেট হয়েছে');
    }

    private function updateSignature(Request $request, User $user){
        if($request->file('signature_file')){
            $request->validate([
                'signature_file' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $signatureImageName = $user->id.'.'.time().'.'.$request->file('signature_file')->extension();

            $img = Image::make($request->file('signature_file')->path());

            $img->resize(config('global.img_large_size'), config('global.img_large_size'), function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('images/user_signature_file').'/large/'.$signatureImageName);

            $img->resize(config('global.img_thumb_size'), config('global.img_thumb_size'), function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('images/user_signature_file').'/thumb/'.$signatureImageName);

            $user->update(['signature_file'=>$signatureImageName]);
        }

    }

    public function getUserListByDivId(Request $request)
    {
        $divId = $request->get('divId');
        $data = DB::table('users') ->where("division_id", $divId)->where("user_type", 2)->get();
        $output = '<option value="">ইউজার</option>';
        foreach($data as $row)
        {
         $output .= '<option value="'.$row->id.'">'.$row->name.'</option>';
        }
        echo $output;
    }

    public function editdisupzindex(Request $request)
    {
        if(!DGFAuth::check(2026, 2, 3)) return view('nopermission');

       $division_id = $request->get('division_id');
       $district_id = $request->get('district_id');//district_id
       $user_id = $request->get('user_id');

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

       if($user_id==null)
       {
        $userEvents = DB::table('user_event')
            ->select("user_event.*", "users.name", "users.active_status","users.signature_file", "event.event_name", 'user_type.name AS user_type')
            ->join('users', 'users.id', '=', 'user_event.a_id')
            ->join('event', 'event.event_id', '=', 'user_event.event_id')
            ->join('user_type', 'user_type.id', '=', 'users.user_type')
            ->where("users.division_id", $division_id)
            ->where("users.district_id", $district_id)
            ->where("user_event.a_id", $user_id)
            ->get();
        }


       $users = DB::table('users')->where("district_id", $district_id)
       ->whereIn("user_type", [3, 4] ) ->get();

        return view('users.edit3',  compact('divisions','districts', 'users','userEvents',
        'division_id','district_id','user_id'));
    }

    public function editdisupzuserlist(Request $request)
    {
        if(!DGFAuth::check(2026, 2, 3)) return view('nopermission');

        $division_id = $request->get('division_id');
        $district_id = $request->get('district_id');//district_id
        $user_id = $request->get('user_id');

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

        if($user_id != null)
        {
         $userEvents = DB::table('user_event')
            ->select("user_event.*", "users.name", "users.active_status","users.signature_file", "event.event_name", 'user_type.name AS user_type')
            ->join('users', 'users.id', '=', 'user_event.a_id')
            ->join('event', 'event.event_id', '=', 'user_event.event_id')
            ->join('user_type', 'user_type.id', '=', 'users.user_type')
            ->where("users.district_id", $district_id)
            ->where("user_event.a_id", $user_id)
            ->get();
         }

        //  $users = DB::table('users')
        //  ->where("division_id", $division_id)
        //  ->where("users.district_id", $district_id)
        //  ->whereIn("user_type", [3, 4] ) ->get();
         $users = User::where("district_id", $district_id)
         ->whereIn("user_type", [3, 4] )->get();

        foreach($users as $row)
        {
            if($row->user_type==3)
                $row->name = $row->district->distname.' '.$row->name;
            else
                $row->name = $row->upazilla->upazillaname.' '.$row->name;
        }
        
         return view('users.edit3',  compact('divisions','districts', 'users','userEvents',
         'division_id','district_id','user_id'));
    }

    public function getUserListByDistId(Request $request)
    {
        $distId = $request->get('distId');
        // $data = DB::table('users')->where("district_id", $distId)
        // ->whereIn("user_type", [3, 4] ) ->get();
        $data = User::where("district_id", $distId)
        ->whereIn("user_type", [3, 4] )->get();

        $output = '<option value="">ইউজার</option>';
        foreach($data as $row)
        {
            if($row->user_type==3)
                $output .= '<option value="'.$row->id.'">'.$row->district->distname.' '.$row->name.'</option>';
            else
                $output .= '<option value="'.$row->id.'">'.$row->upazilla->upazillaname.' '.$row->name.'</option>';
        }
        echo $output;
    }

    public function editdgfindex(Request $request)
    {
        if(!DGFAuth::check(2024, 2, 3)) return view('nopermission');
        $user_id = $request->get('user_id');
        if($user_id == null)
        {
         $userEvents = DB::table('user_event')
            ->select("user_event.*", "users.name", "users.active_status","users.signature_file", "event.event_name", 'user_type.name AS user_type')
            ->join('users', 'users.id', '=', 'user_event.a_id')
            ->join('event', 'event.event_id', '=', 'user_event.event_id')
            ->join('user_type', 'user_type.id', '=', 'users.user_type')
            ->where("user_event.a_id", $user_id)
            ->get();
         }

         $users = DB::table('users')
         ->where("user_type", 1) ->get();
         
         return view('users.edit4',  compact( 'users','userEvents','user_id'));
    }

    public function editdgflist(Request $request)
    {
        if(!DGFAuth::check(2024, 2, 3)) return view('nopermission');
        $user_id = $request->get('user_id');
        if($user_id != null)
        {
         $userEvents = DB::table('user_event')
            ->select("user_event.*", "users.name", "users.active_status","users.signature_file", "event.event_name", 'user_type.name AS user_type')
            ->join('users', 'users.id', '=', 'user_event.a_id')
            ->join('event', 'event.event_id', '=', 'user_event.event_id')
            ->join('user_type', 'user_type.id', '=', 'users.user_type')
            ->where("user_event.a_id", $user_id)
            ->get();
         }

         $users = DB::table('users')
         ->where("user_type", 1) ->get();
         return view('users.edit4',  compact( 'users','userEvents','user_id'));
    }
    

    public function updatedgfuser(Request $request, User $user)
    {
        if(isset($request->id))
        {
            foreach ($request->id as $key => $value ) {
                $userevent = UserEvent::find($value);
                $userevent->view_per = 0;
                $userevent->add_per = 0;
                $userevent->delete_per = 0;
                $userevent->edit_per = 0;
                $userevent->apr_per = 0;
                $userevent->update();
                $user = User::find($userevent->a_id);
                $user->active_status = $request->has('active_status');
                $user->save();
    
                break;
            }

            $this->updateSignature($request, $user);
        }
        
        if(isset($request->view_per))
        foreach ($request->view_per as $key => $value ) {
            $userevent = UserEvent::find($value);
            $userevent->view_per = 1;
            $userevent->update();
        }
        if(isset($request->add_per))
        foreach ($request->add_per as $key => $value ) {
            $userevent = UserEvent::find($value);
            $userevent->add_per = 1;
            $userevent->update();
        }
        if(isset($request->delete_per))
        foreach ($request->delete_per as $key => $value ) {
            $userevent = UserEvent::find($value);
            $userevent->delete_per = 1;
            $userevent->update();
        }
        if(isset($request->edit_per))
        foreach ($request->edit_per as $key => $value ) {
            $userevent = UserEvent::find($value);
            $userevent->edit_per = 1;
            $userevent->update();
        }
        if(isset($request->apr_per))
        foreach ($request->apr_per as $key => $value ) {
            $userevent = UserEvent::find($value);
            $userevent->apr_per = 1;
            $userevent->update();
        }
        return redirect()->route('editdgfindex',$user->user_id)
                        ->with('success','ইউজারের ইভেন্টস সফলভাবে আপডেট হয়েছে');
    }

    public function editsailoindex(Request $request)
    {
        if(!DGFAuth::check(2028, 2, 3)) return view('nopermission');

        $divisions = Division::all();
        $users = DB::table('users')
        ->where("user_type", 6) ->get();
        $allowedDivisionList = [];
        
        $user_id = $request->get('user_id');

        if($user_id == null)
        {
         $userEvents = DB::table('user_event')
            ->select("user_event.*", "users.name", "users.active_status","users.allowed_divisions","users.signature_file", "event.event_name", 'user_type.name AS user_type')
            ->join('users', 'users.id', '=', 'user_event.a_id')
            ->join('event', 'event.event_id', '=', 'user_event.event_id')
            ->join('user_type', 'user_type.id', '=', 'users.user_type')
            ->where("user_event.a_id", $user_id)
            ->get();

            if($userEvents &&  $userEvents->count()) 
            {
                $userEvent = $userEvents[0];

                if($userEvent && $userEvent->allowed_divisions){
                    $allowedDivisionList = explode(',', $userEvent->allowed_divisions);
                }
            }           
            
         }                  

         return view('users.edit6',  compact( 'users','userEvents','user_id', 'divisions', 'allowedDivisionList'));
    }


    public function editsailolist(Request $request)
    {
        if(!DGFAuth::check(2028, 2, 3)) return view('nopermission');

        $divisions = Division::all();
        $users = DB::table('users')
        ->where("user_type", 6) ->get();
        $allowedDivisionList = [];

        $user_id = $request->get('user_id');

        if($user_id)
        {
         $userEvents = DB::table('user_event')
            ->select("user_event.*", "users.name", "users.active_status","users.allowed_divisions","users.signature_file", "event.event_name", 'user_type.name AS user_type')
            ->join('users', 'users.id', '=', 'user_event.a_id')
            ->join('event', 'event.event_id', '=', 'user_event.event_id')
            ->join('user_type', 'user_type.id', '=', 'users.user_type')
            ->where("user_event.a_id", $user_id)
            ->get();

            if($userEvents &&  $userEvents->count()) 
            {
                $userEvent = $userEvents[0];

                if($userEvent && $userEvent->allowed_divisions){
                    $allowedDivisionList = explode(',', $userEvent->allowed_divisions);
                }
            }           
            
         }       

                    
         return view('users.edit6',  compact( 'users','userEvents','user_id', 'divisions', 'allowedDivisionList'));
    }

    public function editlsdindex(Request $request)
    {
        if(!DGFAuth::check(2027, 2, 3)) return view('nopermission');

        $division_id = $request->get('division_id');
        $district_id = $request->get('district_id');//district_id
        $upazila_id = $request->get('upazila_id');
        $user_id = $request->get('user_id');

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

        if($user_id == null)
        {
         $userEvents = DB::table('user_event')
            ->select("user_event.*", "users.name", "users.active_status","users.signature_file", "event.event_name", 'user_type.name AS user_type')
            ->join('users', 'users.id', '=', 'user_event.a_id')
            ->join('event', 'event.event_id', '=', 'user_event.event_id')
            ->join('user_type', 'user_type.id', '=', 'users.user_type')
            ->where("users.district_id", $district_id)
            ->where("users.upazila_id", $upazila_id)
            ->where("user_event.a_id", $user_id)
            ->get();
         }

         $users = DB::table('users')
         ->where("division_id", $division_id)
         ->where("users.district_id", $district_id)
         ->where("users.upazila_id", $upazila_id)
         ->where("user_type",5)
         ->get();

         return view('users.edit5',  compact('divisions','districts','upazillas', 'users','userEvents',
         'division_id','district_id','user_id','upazila_id'));

    }

    public function editlsdlist(Request $request)
    {
        if(!DGFAuth::check(2027, 2, 3)) return view('nopermission');
        $division_id = $request->get('division_id');
        $district_id = $request->get('district_id');//district_id
        $upazila_id = $request->get('upazila_id');

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

        $user_id = $request->get('user_id');
        if($user_id != null)
        {
         $userEvents = DB::table('user_event')
            ->select("user_event.*", "users.name", "users.active_status","users.signature_file", "event.event_name", 'user_type.name AS user_type')
            ->join('users', 'users.id', '=', 'user_event.a_id')
            ->join('event', 'event.event_id', '=', 'user_event.event_id')
            ->join('user_type', 'user_type.id', '=', 'users.user_type')
            ->where("users.district_id", $district_id)
            ->where("users.upazila_id", $upazila_id)
            ->where("user_event.a_id", $user_id)
            ->get();
         }

         $users = DB::table('users')
         ->where("division_id", $division_id)
         ->where("users.district_id", $district_id)
         ->where("users.upazila_id", $upazila_id)
         ->where("user_type", 5 ) ->get();

         return view('users.edit5',  compact('divisions','districts','upazillas', 'users','userEvents',
         'division_id','district_id','user_id','upazila_id'));
    }

    public function updatelsduser(Request $request, User $user)
    {
        if(isset($request->id))
        {
            foreach ($request->id as $key => $value ) {
                $userevent = UserEvent::find($value);
                $userevent->view_per = 0;
                $userevent->add_per = 0;
                $userevent->delete_per = 0;
                $userevent->edit_per = 0;
                $userevent->apr_per = 0;
                $userevent->update();
                $user = User::find($userevent->a_id);
                $user->active_status = $request->has('active_status');
                $user->save();
    
                break;
            }
            $this->updateSignature($request, $user);
        }
        
        if(isset($request->view_per))
        foreach ($request->view_per as $key => $value ) {
            $userevent = UserEvent::find($value);
            $userevent->view_per = 1;
            $userevent->update();
        }
        if(isset($request->add_per))
        foreach ($request->add_per as $key => $value ) {
            $userevent = UserEvent::find($value);
            $userevent->add_per = 1;
            $userevent->update();
        }
        if(isset($request->delete_per))
        foreach ($request->delete_per as $key => $value ) {
            $userevent = UserEvent::find($value);
            $userevent->delete_per = 1;
            $userevent->update();
        }
        if(isset($request->edit_per))
        foreach ($request->edit_per as $key => $value ) {
            $userevent = UserEvent::find($value);
            $userevent->edit_per = 1;
            $userevent->update();
        }
        if(isset($request->apr_per))
        foreach ($request->apr_per as $key => $value ) {
            $userevent = UserEvent::find($value);
            $userevent->apr_per = 1;
            $userevent->update();
        }
        return redirect()->route('editlsdindex',$user->user_id)
                        ->with('success','ইউজারের ইভেন্টস সফলভাবে আপডেট হয়েছে');
    }

    public function getUserListByUpzId(Request $request)
    {
        //dd($request->all());
        $upazila_id = $request->get('upazillaid');
        $data = DB::table('users')->where("upazila_id", $upazila_id)
        ->where("user_type",5) ->get();

        $output = '<option value="">ইউজার</option>';
        foreach($data as $row)
        {
         $output .= '<option value="'.$row->id.'">'.$row->name.'</option>';
        }
        echo $output;
    }

    public function exportusers(Request $request)
    {
        $division_id = $request->get('division_id');
        $district_id =  $request->get('district_id');
        $upazila_id = $request->get('upazila_id');

        if($division_id && $district_id & $upazila_id) {
            $users = User::where("upazila_id", $upazila_id)->get();
        }
        else if($division_id && $district_id) {
            $users = User::where("district_id", $district_id)->get();
        }
        else if($division_id) {
            $users = User::where("division_id", $division_id)->get();
        }

        $user_array= array();

        foreach($users as $res){
            $usertypename =  $res->usertype->name;
            $user_array[]= array('Name' => $res->name,'User Type' => $usertypename, 'Email'=> $res->email );
        }

        $user_export= new UserExport($user_array);

        return Excel::download($user_export, 'users.xlsx', 'Xlsx');
    }
}
