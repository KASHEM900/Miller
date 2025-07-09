<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\DryerDetail;

class EditMillerDryer extends Component
{

    public $dryer_details = [];

    public function mount($dryer_details)
    {
        $this->dryer_details = $dryer_details->toArray();
    }

    public function increment()
    {
        $this->dryer_details[] = new DryerDetail();//count($this->dryer_details);
    }

    public function remove($index)
    {
        $dryer_detail = $this->dryer_details[$index];
        if(isset($dryer_detail['dryer_id'])){
            DryerDetail::find($dryer_detail['dryer_id'])->delete();
        }
        unset($this->dryer_details[$index]);
    }

    public function render()
    {
        return view('livewire.edit-miller-dryer');
    }
}
