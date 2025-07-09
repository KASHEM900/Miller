<?php

namespace App\Http\Controllers;

use App\Models\MenuPermission;
use App\Models\UserType;
use Illuminate\Http\Request;
use PhpParser\Builder\Method;
use App\DGFAuth;

class MenuPermissionController extends Controller
{
    private $menunum = 5033;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');

        $usertype_id = $request->get('usertype_id');
        
        $menuPermissions = MenuPermission::select('menu_permission.*')
        ->where('user_type_id', $usertype_id)
        ->join('menu', 'menu.id', '=', 'menu_id')       
        ->orderByRaw('menu.num')->get();
        $userTypes = UserType::all();
        
        return view('menupermissions.index',compact('menuPermissions', 'userTypes', 'usertype_id')); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');

        return view('menupermissions.create');
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

        MenuPermission::create($request->all());
   
        return redirect()->route('menupermissions.index')
                        ->with('success','মেনু পারমিশন সফলভাবে তৈরি হয়েছে');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MenuPermission  $menuPermission
     * @return \Illuminate\Http\Response
     */
    public function show(MenuPermission $menupermission)
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');

        return view('menupermissions.show',compact('menupermission'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MenuPermission  $menuPermission
     * @return \Illuminate\Http\Response
     */
    public function edit(MenuPermission $menupermission)
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');

        return view('menupermissions.edit',compact('menupermission'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MenuPermission  $menuPermission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MenuPermission $menupermission)
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');
        // TODO
        $menupermission->update($request->all());
  
        return redirect()->route('menupermissions.index')
                        ->with('success','মেনু পারমিশন সফলভাবে আপডেট হয়েছে');
    }

    public function menupermissionsupdate(Request $request)
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');

        $menu_ids = $request->get('menu_id');
        $allow_ids = $request->get('is_allow');        

        foreach($request->id as $value) {
            
            $menupermission = MenuPermission::find($value);
            if (in_array($value, $allow_ids)) {
                $menupermission->is_allow = 1;
            }
            else{
                $menupermission->is_allow = 0;
            }

            $menupermission->update();
        }     
        

        return redirect()->route('menupermissions.index')
                        ->with('success','মেনু পারমিশন সফলভাবে আপডেট হয়েছে');
    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MenuPermission  $menuPermission
     * @return \Illuminate\Http\Response
     */
    public function destroy(MenuPermission $menupermission)
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');
        
        $menupermission->delete();
  
        return redirect()->route('menupermissions.index')
                        ->with('success','মেনু পারমিশন সফলভাবে বাদ দেওয়া হয়েছে');
    }
}
