<?php

namespace App\Console\Commands;

use App\Helpers\Functions;
use App\Models\Agreement;
use App\Models\Token;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DeleteEmptyAgreements extends Command
{
    protected $signature = 'command:delete.empty.agreements';

    protected $description = "Delete Agreements that doesn't have any requisitions";

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {

        $token = Token::where('status', 1)->get()->first();
        if(Functions::not_empty($token)){
            try{
                $agreements = Agreement::doesntHave('requisition')->get();
                foreach($agreements as $agreement){
                    
                    $agreement_delete_response = Http::withHeaders([
                        'accept' => 'application/json',
                        'Authorization' => 'Bearer ' . Crypt::decryptString($token->access),
                    ])->delete(
                        'https://ob.nordigen.com/api/v2/agreements/enduser/' . $agreement->agreement_id
                    );
        
                    if($agreement_delete_response->successful()){
                        $agreement->delete();
                        return 1;
                    }
                    else{
                        $error_json = $agreement_delete_response->json();
                        Log::error($error_json);
                    }
                }
            }
            catch(Exception $e){
                Log::error("From DeleteEmptyAgreements");
                Log::error($e->getCode() . ' - ' . $e->getMessage() . ' - ' . $e->getFile() . ' - ' . $e->getLine());
            }
        }
        return 0;
    }
}
