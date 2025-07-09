<?php

namespace App;

use App\Models\MenuPermission;
use App\Models\Menu;
use App\Models\UserEvent;
use App\Models\Event;
use App\Models\EventPermissionTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use App\Models\Division;
use App\Models\Registration_permission_time;

class DGFAuth {

    public static function check($menuid, $eventid=null, $optid=null)
    {
        if(Auth::guest())
        {
            return false;
        }

        $flag=false;

        $menuPerm = MenuPermission::where('user_type_id', Auth::user()->user_type)
                    ->join('menu', 'menu.id', '=', 'menu_id')
                    ->where('menu.num', $menuid)
                    ->where('is_allow', 1)
                    ->get();

        if($menuPerm->count()>0){
            $flag=true;
        }elseif($eventid!=null){
            $flag = DGFAuth::check2($eventid, $optid);
            if($flag){
                $menu = Menu::where('id', $menuid)
                ->where('data_level', '>=', Auth::user()->user_type)
                ->where('data_level', '!=', 99)
                ->get();

                if($menu->count()>0){
                    $flag=true;
                }else{
                    $flag=false;
                }
            }
        }

        return $flag;
    }

    public static function check2($eventid, $optid)
    {
        if(Auth::guest())
        {
            return false;
        }

        if(Auth::user()->user_type == 99)
            return true;

        $flag=false;

        $userEvents = Auth::user()->user_events;
        $userEvent = $userEvents->where('event_id', $eventid)->first();
        if($userEvent!=null){
            if( $optid==1){ //C
                $flag = $userEvent->add_per?$userEvent->add_per: false;
            }
            elseif( $optid==2){ //R
                $flag = $userEvent->view_per?$userEvent->view_per: false;
            }
            elseif( $optid==3){ //U
                $flag = $userEvent->edit_per?$userEvent->edit_per: false;
            }
            elseif( $optid==4){ //D
                $flag = $userEvent->delete_per?$userEvent->delete_per: false;
            }
            elseif( $optid==5){ //Approve
                $flag = $userEvent->apr_per?$userEvent->apr_per: false;
            }
        }

        $event = Event::find($eventid);

        if($flag){
            if($event != null && $event->is_timebased_perm_required && !DGFAuth::check3($eventid))
                $flag = false;
        }

        return $flag;
    }

    public static function check3($eventid)
    {
        if(Auth::guest())
        {
            return false;
        }

        $eventpermissiontime = EventPermissionTime::where('event_id', '=', $eventid)
        ->where('perm_start_time', '<', date("Y-m-d H:i:s"))
        ->where('perm_end_time', '>', date("Y-m-d H:i:s"))->get();

        if($eventpermissiontime->count()>0)
            return true;
        else
            return false;
    }

    public static function filtereddivision()
    {
        if(Auth::guest())
        {
            return false;
        }

        if(Auth::user()->division_id>0)
            if(Auth::user()->user_type <> 6)
                $divisions = Division::where("divid", Auth::user()->division_id)->get();
            else
            {
                $AllowedDivisionList = explode(',', Auth::user()->allowed_divisions);
                $divisions = Division::whereIn("divid", $AllowedDivisionList )->get();
            }                
        else
            $divisions = Division::all();

        return $divisions;

    }

    public static function checkregistration()
    {
        $registration_permission_time = Registration_permission_time::where('perm_start_time', '<', date("Y-m-d H:i:s"))
        ->where('period_end_time', '>', date("Y-m-d H:i:s"))->get();

        if($registration_permission_time->count()>0)
            return true;
        else
            return false;
    }

}
