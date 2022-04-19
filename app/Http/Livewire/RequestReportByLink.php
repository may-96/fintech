<?php

namespace App\Http\Livewire;

use Livewire\Component;

class RequestReportByLink extends Component
{
    public $data;
    
    public $amount;
    public $currency;
    public $details;

    public $edit_mode = 0;
    public $edit_id = null;

    public function mount($data){
        $this->data = $data;
    }

    public function render()
    {
        return view('livewire.request-report-by-link');
    }
}
