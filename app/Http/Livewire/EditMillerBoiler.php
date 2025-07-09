<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\BoilerDetail;

class EditMillerBoiler extends Component
{

    public $boiler_details = [];

    public function mount($boiler_details)
    {
        $this->boiler_details = $boiler_details->toArray();
    }

    public function increment()
    {
        $this->boiler_details[] = new BoilerDetail();//count($this->boiler_details);
    }

    public function remove($index)
    {
        $boiler_detail = $this->boiler_details[$index];
        if(isset($boiler_detail['boiler_id'])){
            BoilerDetail::find($boiler_detail['boiler_id'])->delete();
        }
        unset($this->boiler_details[$index]);
    }

    public function render()
    {
        return view('livewire.edit-miller-boiler');
    }
}
