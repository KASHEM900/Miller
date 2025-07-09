<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use App\DGFAuth;

class MenuController extends Controller
{
    private $menunum = 9999;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');

        $menus = Menu::paginate(5);
        return view('menus.index',compact('menus')); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');

        return view('menus.create');
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

        Menu::create($request->all());
   
        return redirect()->route('menus.index')
                        ->with('success','মেনু সফলভাবে তৈরি হয়েছে');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Menu  $millType
     * @return \Illuminate\Http\Response
     */
    public function show(Menu $menu)
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');

        return view('menus.show',compact('menu'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Menu  $millType
     * @return \Illuminate\Http\Response
     */
    public function edit(Menu $menu)
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');

        return view('menus.edit',compact('menu'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Menu  $millType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Menu $menu)
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');

        $menu->update($request->all());
  
        return redirect()->route('menus.index')
                        ->with('success','মেনু সফলভাবে আপডেট হয়েছে');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Menu  $millType
     * @return \Illuminate\Http\Response
     */
    public function destroy(Menu $menu)
    {
        if(!DGFAuth::check($this->menunum)) return view('nopermission');

        $menu->delete();
  
        return redirect()->route('menus.index')
                        ->with('success','মেনু সফলভাবে বাদ দেওয়া হয়েছে');
    }
}
