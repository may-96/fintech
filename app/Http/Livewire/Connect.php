<?php

namespace App\Http\Livewire;

use App\Models\Country;
use Livewire\Component;

class Connect extends Component
{
    public $countries;
    public $selected;

    public function render()
    {
        $this->countries = Country::all();
        return view('livewire.connect');
    }

    public function format(){
        $this->selected = strtolower($this->selected);
    }


}
