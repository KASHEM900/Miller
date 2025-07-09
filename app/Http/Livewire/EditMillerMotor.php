<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\MotorDetail;

class EditMillerMotor extends Component
{

    public $motor_details = [];
    public $motor_powers = [];
    public $motor_area_total;
    public $motor_power;

    public function mount($motor_details, $motor_powers)
    {
        $this->motor_details = $motor_details->toArray();
        $this->motor_powers = $motor_powers->toArray();
        $cas = 0;

        foreach($this->motor_details as $motor_detail){
            $cas += $motor_detail['motor_filter_power'] * 0.001;
        }

        $this->motor_area_total = $cas;
        $this->motor_power = $cas * 8 * 11;
    }

    public function increment()
    {
        $this->motor_details[] = new MotorDetail(); //count($this->motor_details);
    }

    public function remove($index)
    {
        $motor_detail = $this->motor_details[$index];
        if(isset($motor_detail['motor_id'])){
            MotorDetail::find($motor_detail['motor_id'])->delete();
        }
        unset($this->motor_details[$index]);
    }

    public function render()
    {
        return view('livewire.edit-miller-motor');
    }
}
