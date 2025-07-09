<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\SteepingHouseDetail;

class EditMillerSteeping extends Component
{

     public $steeping_house_details = [];

    public function mount($steeping_house_details)
    {
        $this->steeping_house_details = $steeping_house_details->toArray();
    }

    public function increment()
    {
        $this->steeping_house_details[] = new SteepingHouseDetail(); //count($this->steeping_house_details);
    }

    public function remove($index)
    {
        $steeping_house_detail = $this->steeping_house_details[$index];
        if(isset($steeping_house_detail['steeping_house_id'])){
            SteepingHouseDetail::find($steeping_house_detail['steeping_house_id'])->delete();
        }
        unset($this->steeping_house_details[$index]);
    }

    public function render()
    {
        return view('livewire.edit-miller-steeping');
    }
}
