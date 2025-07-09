<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\GodownDetail;

class EditMillerGodown extends Component
{

     public $godown_details = [];

    public function mount($godown_details)
    {
        $this->godown_details = $godown_details->toArray();
    }

    public function increment()
    {
        $this->godown_details[] = new GodownDetail();//count($this->godown_details);
    }

    public function remove($index)
    {
        $godown_detail = $this->godown_details[$index];
        if(isset($godown_detail['godown_id'])){
            GodownDetail::find($godown_detail['godown_id'])->delete();
        }
        unset($this->godown_details[$index]);
    }

    public function render()
    {
        return view('livewire.edit-miller-godown');
    }
}
