<?php

namespace App\Http\Livewire;

use App\Events\SendNotification;
use App\Mail\ShareWithUnregisteredUsers;
use App\Models\Account;
use App\Models\Agreement;
use App\Models\Notification;
use App\Models\Requisition;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Livewire\Component;

class MyAccounts extends Component
{
    public $accounts;
    public $selected_account_id = 0;
    public $sharing_details;
    public $error = "";
    public $success = "";
    public $email;
    public $share_notes = 0;
    protected $ids;
    public $share;
    public $user;
    public $reconnect_requisition_id;
    public $reconnect_error = "";
    public $shareable_link = null;

    public $shared_emails = [];

    public function mount($accounts)
    {
        $this->user = Auth::user();
        $this->ids = $this->accounts->pluck('id');
        $this->accounts = $accounts->groupBy('institution_id')->toArray();
        $this->get_share_values();
    }

    public function render()
    {
        return view('livewire.my-accounts');
    }

    public function get_sharing_info($id, $reset = true)
    {
        if ($reset)
        {
            $this->reset_status();
        }
        $this->selected_account_id = $id;
        $this->shareable_link = null;
        $account = Account::find($id);
        $this->shareable_link = $account->shareable_link;

        $temp_1 = DB::table('account_shares_with_unregistered_users')->selectRaw("id,email,created_at,'other' as type")->where('account_id', $this->selected_account_id)->get()->toArray();
        $structured_1 = [];
        foreach ($temp_1 as $temp)
        {
            $structured_1[] = [
                'id' => $temp->id,
                'email' => $temp->email,
                'created_at' => $temp->created_at,
                'type' => $temp->type,
            ];
        }

        $temp_2 = $account->shared_with()->selectRaw("users.id,users.email,'user' as type")->get()->toArray();
        $structured_2 = [];
        foreach ($temp_2 as $temp)
        {
            $structured_2[] = [
                'id' => $temp['id'],
                'email' => $temp['email'],
                'created_at' => $temp['pivot']['created_at'],
                'type' => $temp['type'],
            ];
        }

        $this->shared_emails = array_merge($structured_1, $structured_2);
        usort($this->shared_emails, function ($item1, $item2)
        {
            if (Carbon::parse($item2['created_at']) > Carbon::parse($item1['created_at']))
            {
                return 1;
            }
            else if (Carbon::parse($item2['created_at']) < Carbon::parse($item1['created_at']))
            {
                return -1;
            }
            else
            {
                return 0;
            }
        });
    }

    public function generate_shareable_link(){
        $token = Str::orderedUuid();
        $account = Account::find($this->selected_account_id);
        $account->shareable_link = (string)$token;
        $account->save();
        $this->shareable_link = (string)$token;
    }

    public function remove_shareable_link(){
        $account = Account::find($this->selected_account_id);
        $account->shareable_link = null;
        $account->save();
        $this->shareable_link = null;
    }

    public function add_shared_user()
    {
        $this->reset_status();
        if ($this->check_email())
        {
            $authenticated_user = Auth::user();
            if ($this->email == $authenticated_user->email)
            {
                $this->error = "You cannot share account with yourself.";
            }
            $user = User::where('email', $this->email)->first();
            if ($this->check_already_shared($user))
            {
                $this->error = "Account has already been shared with this user";
            }
            else
            {
                $account = Account::find($this->selected_account_id);
                if ($user != null)
                {
                    try
                    {
                        $user->shared_accounts()->attach($this->selected_account_id, ['notes_shared' => $this->share_notes ? 1 : 0]);


                        $message = $authenticated_user->fname . ' ' . $authenticated_user->lname . ' has shared an Account of ' . $account->institution->name;

                        $notification = Notification::create([
                            'type' => 'account_share',
                            'data' => $account->account_id.'-'.$account->id,
                            'user_id' => $user->id,
                            'message' => $message,
                            'read' => 0
                        ]);

                        SendNotification::dispatch($user, $notification);
                        // event(new SendNotification($user, $notification));
                    }
                    catch (Exception $e)
                    {
                        Log::error($e->getCode() . ' - ' . $e->getMessage() . ' - ' . $e->getFile() . ' - ' . $e->getLine());
                    }
                    $this->success = "Account has been Successfully Shared with the User.";
                }
                else
                {
                    try
                    {
                        DB::table('account_shares_with_unregistered_users')->insert([
                            'account_id' => $this->selected_account_id,
                            'email' => $this->email,
                            'notes_shared' => $this->share_notes ? 1 : 0,
                            "created_at" =>  Carbon::now()->toDateTimeString(),
                            "updated_at" => Carbon::now()->toDateTimeString()
                        ]);

                        Mail::to($this->email)->send(new ShareWithUnregisteredUsers(Auth::user(), $account));
                    }
                    catch (Exception $e)
                    {
                    }
                    $this->success = "Sharing Request has been Successfully sent to the user email address.";
                }
                $this->get_sharing_info($this->selected_account_id, false);
                $this->get_account_share_count($this->selected_account_id);
                $this->email = "";
            }
        }
    }

    public function remove_shared_user($id, $type)
    {
        if ($type == 'other')
        {
            DB::table('account_shares_with_unregistered_users')->where('id', $id)->delete();
        }
        if ($type == 'user')
        {
            $user = User::find($id);
            if ($user)
            {
                $user->shared_accounts()->detach($this->selected_account_id);
            }
        }
        $this->get_sharing_info($this->selected_account_id, false);
        $this->get_account_share_count($this->selected_account_id);
    }

    private function check_email()
    {
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL))
        {
            $this->error = "Please enter a Valid Email Address";
            return false;
        }
        return true;
    }

    private function check_already_shared($user = null)
    {

        // $acc_id = $this->selected_account_id;
        // Integer Result
        // $exists = User::where('id', $user->id)->whereHas('shared_accounts', function ($q) use ($acc_id) { $q->where('accounts.id', $acc_id); })->count();

        // Boolean Result
        $exists = false;
        if ($user != null)
        {
            $exists = $user->shared_accounts()->newPivotStatementForId($this->selected_account_id)->exists();
        }

        if (!$exists)
        {
            $other_exists = DB::table('account_shares_with_unregistered_users')->where('account_id', $this->selected_account_id)->where('email', $this->email)->count();
            if ($other_exists > 0)
            {
                return true;
            }
            return false;
        }
        return true;
    }

    private function reset_status()
    {
        $this->error = "";
        $this->success = "";
    }

    private function get_share_values()
    {
        foreach ($this->ids as $id)
        {
            $this->get_account_share_count($id);
        }
    }

    private function get_account_share_count($id)
    {
        $count_1 = DB::table('account_shares_with_unregistered_users')->where('account_id', $id)->count();
        $count_2 = DB::table('account_user')->where('account_id', $id)->count();
        $count = $count_1 + $count_2;
        $this->share[$id]["count"] = $count;
    }

    public function reconnect()
    {
        $this->reconnect_error = "";
        $old_requisition = Requisition::find($this->reconnect_requisition_id);
        $old_agreement = $old_requisition->agreement;
        $institution = $old_agreement->institution;
        $iid = $institution->institution_id;
        // $iid = "SANDBOXFINANCE_SFIN0000";
        $new_agreement = $this->createAgreement($old_agreement, $iid);
        if ($new_agreement != false)
        {
            $reference_id = uniqid("" . $this->user->id, true);
            $new_requisition = $this->createLink($reference_id, $iid, $new_agreement['id']);
            if ($new_requisition != false)
            {
                $this->redirectToLink($old_agreement, $new_agreement, $institution, $old_requisition, $new_requisition, $reference_id);
            }
            else
            {
                $this->reconnect_error = "There was an error while reconnecting your account.";
            }
        }
        else
        {
            $this->reconnect_error = "There was an error while reconnecting your account.";
        }
        
    }

    private function createAgreement($oa, $iid)
    {
        $access_scope = [];

        if ($oa->balances_scope == 1)
        {
            $access_scope[] = 'balances';
        }
        if ($oa->details_scope == 1)
        {
            $access_scope[] = 'details';
        }
        if ($oa->transactions_scope == 1)
        {
            $access_scope[] = 'transactions';
        }

        $response = Http::withHeaders([
            'accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . Crypt::decryptString(Session::get('access_token')),
        ])->post(
            'https://ob.nordigen.com/api/v2/agreements/enduser/',
            [
                'institution_id' => $iid,
                'max_historical_days' => $oa->max_historical_days,
                'access_valid_for_days' => $oa->access_valid_for_days,
                'access_scope' => $access_scope
            ]
        );

        if ($response->successful())
        {
            $data = $response->json();
            $this->user->update_error_code("agreement_error_code", null);
            return $data;
        }
        else
        {
            $this->user->update_error_code("agreement_error_code", $response->status());
            return false;
        }
    }

    private function createLink($ref_id, $iid, $aid)
    {

        $response = Http::withHeaders([
            'accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . Crypt::decryptString(Session::get('access_token')),
        ])->post(
            'https://ob.nordigen.com/api/v2/requisitions/',
            [
                'redirect' => env('APP_URL') ."/reconnect/status/" . $ref_id, // env('APP_URL') . 
                'institution_id' => $iid,
                'reference' => "" . $ref_id,
                'agreement' => $aid,
                'user_language' => 'EN',
            ]
        );

        if ($response->successful())
        {
            $data = $response->json();

            $this->user->update_error_code("requisition_create_error_code", null);
            return $data;
        }
        else
        {
            $this->user->update_error_code("requisition_create_error_code", $response->status());
            return false;
        }
    }

    private function redirectToLink($old_agree, $new_agree, $institution, $old_req, $new_req, $ref)
    {
        $balances_access_scope = 0;
        $details_access_scope = 0;
        $transactions_access_scope = 0;
        if ($old_agree->balances_scope == 1)
        {
            $balances_access_scope = 1;
        }
        if ($old_agree->details_scope == 1)
        {
            $details_access_scope = 1;
        }
        if ($old_agree->transactions_scope == 1)
        {
            $transactions_access_scope = 1;
        }

        $agreement = new Agreement([
            'user_id' => $this->user->id,
            'agreement_id' => $new_agree['id'],
            'agreement_date' => $new_agree['created'],
            'balances_scope' => $balances_access_scope,
            'details_scope' => $details_access_scope,
            'transactions_scope' => $transactions_access_scope,
            'max_historical_days' => $old_agree->max_historical_days,
            'access_valid_for_days' => $old_agree->access_valid_for_days,
            'accepted' => $new_agree['accepted'],
            'institution_id' => $institution->id,
            'ip_address' => request()->ip(),
        ]);
        $agreement->save();

        $requisition = new Requisition([
            'agreement_id' => $agreement->id,
            'requisition_id' => $new_req['id'],
            'language' => 'EN',
            'status' => $new_req['status'],
            'status_long' => $this->getRequisitionStatusLong($new_req['status']),
            'status_description' => $this->getRequisitionStatusDescription($new_req['status']),
            'reference_id' => $ref,
            'link' => $new_req['link'],
        ]);
        $requisition->save();

        $this->emit('processReconnectLink', $new_req['link']);
    }

    private function getRequisitionStatusLong($status)
    {
        switch ($status)
        {
            case 'CR':
                return "CREATED";
            case 'LN':
                return "LINKED";
            case 'EX':
                return "EXPIRED";
            case 'RJ':
                return "REJECTED";
            case 'UA':
                return "UNDERGOING_AUTHENTICATION";
            case 'GA':
                return "GRANTING_ACCESS";
            case 'SA':
                return "SELECTING_ACCOUNTS";
            case 'SU':
                return "SUSPENDED";
            case 'GC':
                return "GIVING_CONSENT";
            default:
                return "";
        }
    }

    private function getRequisitionStatusDescription($status)
    {
        switch ($status)
        {
            case 'CR':
                return "Requisition has been successfully created";
            case 'LN':
                return "Account has been successfully linked to requisition";
            case 'EX':
                return "Access to account has expired as set in End User Agreement";
            case 'RJ':
                return "SSN verification has failed";
            case 'UA':
                return "End-user is redirected to the financial institution for authentication";
            case 'GA':
                return "End-user is granting access to their account information";
            case 'SA':
                return "End-user is selecting accounts";
            case 'SU':
                return "Requisition is suspended due to numerous consecutive errors that happened while accessing its accounts";
            case 'GC':
                return "End-user is giving consent at Nordigen's consent screen";
            default:
                return "";
        }
    }
}
