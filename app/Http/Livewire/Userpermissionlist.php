<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\UserEvent;
use App\User;
use Illuminate\Http\Request;
use App\DGFAuth;

class Userpermissionlist extends Component
{
    //public $userEvent;
    public $view_per;
    public $add_per;
    public $delete_per;
    public $edit_per;
    public $apr_per;
    public $name;
    public $upazillaname;
    public $user_type;
    public $event_name;
    public $event_id;
    public $active_status;
    public $usereventid;
    public $statusmessage;

    public function mount($usereventid,$upazillaname,$event_id, $name, $user_type, $event_name, $view_per, $add_per, $delete_per, $edit_per, $apr_per,$active_status)
    {
        //$this->userEvent = $userEvent;
        $this->usereventid=$usereventid;
        $this->event_id=$event_id;
        $this->name=$name;
        $this->upazillaname=$upazillaname;
        $this->user_type=$user_type;
        $this->event_name=$event_name;
        $this->view_per=$view_per;
        $this->add_per=$add_per;
        $this->delete_per=$delete_per;
        $this->edit_per=$edit_per;
        $this->apr_per=$apr_per;
        $this->active_status=$active_status;        
    }

    public function updateUserPerm()
    {
        if(!DGFAuth::check(2021)) return view('nopermission');

        $this->statusmessage="In progress";
        $userevent = UserEvent::find($this->usereventid);

        $userevent->view_per = $this->view_per;
        $userevent->add_per = $this->add_per;
        $userevent->delete_per = $this->delete_per;
        $userevent->edit_per = $this->edit_per;
        $userevent->apr_per = $this->apr_per;
        
        $userevent->save();

        $user = User::find($userevent->a_id);
        $user->active_status = $this->active_status;
        $user->save();
        $this->statusmessage="Success!";
    }

    public function render()
    {
        return view('livewire.userpermissionlist');
    }
}
