<?php

namespace App\Http\Livewire;

use App\Helpers\Functions;
use App\Models\User;
use Livewire\Component;

class ShareableLinkReport extends Component
{
    public $data;

    public $credit_score = 1;
    public $cash_flow = 1;
    public $expenses = 1;
    public $income = 1;
    public $email_check = 1;
    public $contact = 1;
    public $email = "";
    public $error = "";
    public $success = "";

    public $email_addr = "";
    public $contact_num = "";
    public $report_user_name = "";
    public $company_name = "";

    public $shared_emails = [];

    public $fetch_id;
    public $report_data;

    public $income_data_available = false;
    public $expense_data_available = false;
    public $cash_flow_data_available = false;

    public $shareable_link = null;

    public function mount($data)
    {
        $this->data = $data;
        
        if($this->data[0] == "shared"){
            $sharing_info = $this->data[1];
            $this->fetch_id = $sharing_info;
        }
    }

    public function render()
    {
        return view('livewire.shareable-link-report');
    }

    public function load_report(){
        $temp = User::find($this->fetch_id);
        
        $this->report_user_name = $temp->fname . " " . $temp->lname;
        $this->company_name = $temp->company;

        $this->email_addr = $temp->email;
        $this->contact_num = $temp->contact;

        $this->report_data = Functions::cash_flow_stats($temp);
        if($this->report_data != 0){
            $graphData = [];

            if(count($this->report_data[0]) > 0){
                $this->cash_flow_data_available = true;
                $graphData['cash_flow'] = $this->report_data[0];
            }
            if(count($this->report_data[1]) > 0){
                $this->income_data_available = true;
                $graphData['income'] = $this->report_data[1];
            }
            if(count($this->report_data[2]) > 0){
                $this->expense_data_available = true;
                $graphData['expense'] = $this->report_data[2];
            }

            $this->emit('reportLoaded', $graphData);
        }
        else{
            return redirect()->route('dashboard')->with('danger', 'Please Connect Your Bank Account');
        }
        
    }

}

