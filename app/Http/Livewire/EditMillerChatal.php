<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\ChatalDetail;

class EditMillerChatal extends Component
{

     public $chatal_details = [];
     public $chatal_area_total;
     public $chatal_power;

    public function mount($chatal_details)
    {
        $this->chatal_details = $chatal_details->toArray();
        $cas = 0;

        foreach($this->chatal_details as $chatal_detail){
            $cas += $chatal_detail['chatal_long'] * $chatal_detail['chatal_wide'];
        }

        $this->chatal_area_total = $cas;
        $this->chatal_power = $cas * 7 / 125;
    }

    public function increment()
    {
        $this->chatal_details[] = new ChatalDetail(); //count($this->chatal_details);
    }

    public function remove($index)
    {
        $chatal_detail = $this->chatal_details[$index];
        if(isset($chatal_detail['chatal_id'])){
            ChatalDetail::find($chatal_detail['chatal_id'])->delete();
        }
        unset($this->chatal_details[$index]);
    }

    public function render()
    {
        return view('livewire.edit-miller-chatal');
    }
}
