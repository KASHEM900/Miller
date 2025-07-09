<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\UserEvent;
use App\User;

class userdivisionedit extends Component
{

     public $userEvents = [];
     public $divisions;
     public $AllowedDivisionList = [];
     public $isSailoEdit;

     public function mount($userEvents, $divisions = null, $allowedDivisionList = null, $isSailoEdit=FALSE)
    {
        $this->userEvents = $userEvents->toArray();
        
        if($divisions){
            $this->divisions = $divisions;
        }     
        if($allowedDivisionList){
            $this->AllowedDivisionList = $allowedDivisionList;
        }  
        $this->isSailoEdit = $isSailoEdit;
    }

    public function render()
    {
        return view('livewire.userdivision-edit');
    }
}
