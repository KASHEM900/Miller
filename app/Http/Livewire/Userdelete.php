<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Routing\RedirectController;
use App\DGFAuth;

class Userdelete extends Component
{
    //public $user;
    public $users=[];
    public $confirming;
    
    public function mount($users)
    {
        //$this->user = $user;
        $this->users = $users;        
    }

    public function remove($index)
    {   
        if(!DGFAuth::check(2023, 2, 4)) return view('nopermission');
      
        $user = $this->users[$index];
        if(isset($user['id'])){
            User::find($user['id'])->delete();
        }
        unset($this->users[$index]);
    }

    public function confirmDelete($id)
    {
        $this->confirming = $id;
    }
    

    public function render()
    {
        return view('livewire.userdelete');
    }
}
