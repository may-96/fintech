<?php

namespace App\Http\Livewire;

use App\Helpers\Functions;
use App\Models\ReportRequestByLink;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Component;

class RequestReportByLink extends Component
{
    public $data;
    public $user;

    public $amount;
    public $currency;
    public $details;

    public $report_request = null;
    public $link = "";

    public $edit_mode = 0;
    public $edit_id = null;

    public $currencies;
    
    public $error = '';
    public $success = '';

    public $btn_txt = "Generate New Link";

    public function mount($data){
        $this->data = $data;
        $this->user = Auth::user();
        $this->currencies = DB::table('currencies')->select('currency','code')->distinct()->orderBy('code','asc')->get()->flatten()->toArray();
        $this->currencies  = array_map(function ($value) { return (array)$value; }, $this->currencies );
    }

    public function render()
    {
        return view('livewire.request-report-by-link');
    }

    public function generateLink()
    {
        $this->reset_msg();
        if(Functions::is_empty($this->amount) || (float) $this->amount <= 0){
            $this->error = "Amount cannot be empty or less than or equal to zero";
            return;
        }
        if(Functions::is_empty($this->currency)){
            $this->error = "Currency cannot be empty";
            return;
        }
        if(Functions::is_empty($this->details)){
            $this->error = "Please enter details.";
            return;
        }

        if(Functions::is_empty($this->link)){
            $this->link = Str::orderedUuid();
            
            $report_request = $this->user->request_links()->create([
                'amount' => $this->amount,
                'currency' => $this->currency,
                'details' => $this->details,
                'link' => $this->link,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ]);
            $actual_link = route('fetch.request.link.data', ['token' => $this->link]);
            $this->success = "Link Generated: ". $actual_link;
            $this->refetchData();          
        }
        else{
            // $this->report_request = ReportRequestByLink::where('link', $this->link)->get()->first();
            if(Functions::not_empty($this->report_request)){
                $this->report_request->amount = $this->amount;
                $this->report_request->currency = $this->currency;
                $this->report_request->details = $this->details;
                $this->report_request->save();

                $actual_link = route('fetch.request.link.data', ['token' => $this->link]);
                $this->success = "Data updated for this link: ". $actual_link;
            }
            else{
                $this->error = "Error raised while editing content of the link.";
            }
        }

        $this->reset_fields();
    }

    public function edit_link_data($link){
        $this->reset_msg();
        $this->report_request = ReportRequestByLink::where('link', $link)->get()->first();
        if(Functions::not_empty($this->report_request)){
            if($this->report_request->user_id == $this->user->id){
                $this->edit_mode = 1;
                $this->link = $link;
                $this->btn_txt = "Update Content";
                $this->amount = $this->report_request->amount;
                $this->currency = $this->report_request->currency;
                $this->details = $this->report_request->details;
                $this->emit('setQuillContent');
            }
            else{
                $this->error = "You're not authorized to edit the content of this link.";
            }
        }
        else{
            $this->error = "Error raised while retrieving data of this link.";
        }
        
    }

    public function deleteLink($id){
        $report_request = ReportRequestByLink::where('id', $id)->get()->first();
        $link = $report_request->link;
        $report_request->delete();
        DB::table('report_user')->where('reference', $link)->delete();
        $this->refetchData();
        $this->reset_fields();
    }

    public function reset_msg(){
        $this->success = "";
        $this->error = "";
    }

    public function reset_fields(){
        $this->amount = "";
        $this->currency = "";
        $this->details = "";
        $this->link = "";
        $this->report_request = null;
        $this->edit_mode = 0;
        $this->btn_txt = "Generate New Link";
        $this->emit('clearQuillContent');
    }

    public function refetchData(){
        $this->data = $this->user->request_links()->select('*')->get()->flatten()->toArray();
    }
}
