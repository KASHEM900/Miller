<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\MillBoilerMachineries;

class EditMillBoilerMachineries extends Component
{

    public $mill_boiler_machineries = [];

    public function mount($mill_boiler_machineries)
    {
        $this->mill_boiler_machineries = $mill_boiler_machineries->toArray();
    }

    public function increment()
    {
        $this->mill_boiler_machineries[] = new MillBoilerMachineries();//count($this->mill_boiler_machineries);
    }

    public function remove($index)
    {
        $mill_boiler_machineries = $this->mill_boiler_machineries[$index];
        if(isset($mill_boiler_machineries['mill_boiler_machinery_id'])){
            MillBoilerMachineries::find($mill_boiler_machineries['mill_boiler_machinery_id'])->delete();
        }
        unset($this->mill_boiler_machineries[$index]);
    }

    public function render()
    {

        return view('livewire.edit-mill-boiler-machineries');
    }
}
