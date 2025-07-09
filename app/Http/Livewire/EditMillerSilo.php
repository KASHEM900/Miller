<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\SiloDetail;

class EditMillerSilo extends Component
{

     public $silo_details = [];

    public function mount($silo_details)
    {
        $this->silo_details = $silo_details->toArray();
    }

    public function increment()
    {
        $this->silo_details[] = new SiloDetail(); //count($this->silo_details);
    }

    public function remove($index)
    {
        $silo_detail = $this->silo_details[$index];
        if(isset($silo_detail['silo_id'])){
            SiloDetail::find($silo_detail['silo_id'])->delete();
        }
        unset($this->silo_details[$index]);
    }

    public function render()
    {
        return view('livewire.edit-miller-silo');
    }
}
