<?php

namespace App\Http\Controllers;

use App\Models\UserType;
use App\Models\Menu;
use App\Models\MenuPermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\DGFAuth;

class UserTypeController extends Controller
{
    private $menunum = 5032;
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');

        $userTypes = UserType::paginate(5);
        return view('usertypes.index',compact('userTypes')); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');

        return view('usertypes.create');
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
            'name' => 'required'
        ]);
  
        UserType::create($request->all());
        
        $userType = UserType::find(DB::table('user_type')->max('id'));
        $menus = Menu::all();
        foreach($menus as $menu){
            $menupermission = new MenuPermission();
            $menupermission->user_type_id = $userType->id;
            $menupermission->menu_id = $menu->id;
            $menupermission->is_allow = false;
            $menupermission->save();
        }
   
        return redirect()->route('usertypes.index')
                        ->with('success','ইউজারের ধরন সফলভাবে তৈরি হয়েছে');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserType  $userType
     * @return \Illuminate\Http\Response
     */
    public function show(UserType $usertype)
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');

        return view('usertypes.show',compact('usertype'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UserType  $userType
     * @return \Illuminate\Http\Response
     */
    public function edit(UserType $usertype)
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');

        return view('usertypes.edit',compact('usertype'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserType  $userType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserType $usertype)
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');

        $request->validate([
            'name' => 'required',
        ]);
  
        $usertype->update($request->all());

        $usertype_id=$usertype->id;
        $menus = Menu::whereNotExists(function ($query)  use ($usertype_id) {
            $query->select(DB::raw(1))
                  ->from('menu_permission')
                  ->where('user_type_id',$usertype_id)
                  ->whereRaw('menu_permission.menu_id = menu.id');
        })
        ->get();

        foreach($menus as $menu){
            $menupermission = new MenuPermission();
            $menupermission->user_type_id = $usertype->id;
            $menupermission->menu_id = $menu->id;
            $menupermission->is_allow = false;
            $menupermission->save();
        }
  
        return redirect()->route('usertypes.index')
                        ->with('success','ইউজারের ধরন সফলভাবে আপডেট হয়েছে');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserType  $userType
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserType $usertype)
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');
        
        $usertype->delete();
  
        return redirect()->route('usertypes.index')
                        ->with('success','ইউজারের ধরন সফলভাবে বাদ দেওয়া হয়েছে');
    }
}
