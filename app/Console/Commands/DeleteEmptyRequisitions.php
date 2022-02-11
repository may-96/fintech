<?php

namespace App\Console\Commands;

use App\Helpers\Functions;
use App\Models\Requisition;
use App\Models\Token;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class DeleteEmptyRequisitions extends Command
{

    protected $signature = 'command:delete.empty.requisitions';

    protected $description = "Delete Requisitions that doesn't have any associated accounts";

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $token = Token::where('status', 1)->get()->first();
        if(Functions::not_empty($token)){
            try{
                $requisitions = Requisition::doesntHave('accounts')->get();
                foreach($requisitions as $requisition){
                    $requisition_delete_response = Http::withHeaders([
                        'accept' => 'application/json',
                        'Authorization' => 'Bearer ' . Crypt::decryptString($token->access),
                    ])->delete(
                        'https://ob.nordigen.com/api/v2/requisitions/' . $requisition->requisition_id
                    );
        
                    if($requisition_delete_response->successful()){
                        $requisition->delete();
                        return 1;
                    }
                    else{
                        $error_json = $requisition_delete_response->json();
                        Log::error($error_json);
                    }
                }
            }
            catch(Exception $e){
                Log::error("From DeleteEmptyRequisitions");
                Log::error($e->getCode() . ' - ' . $e->getMessage() . ' - ' . $e->getFile() . ' - ' . $e->getLine());
            }
        }
        return 0;
    }
}
