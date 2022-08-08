<?php

namespace App\Http\Livewire;

use App\Events\SendNotification;
use App\Events\ViewTransactions;
use App\Helpers\Functions;
use App\Mail\ShareWithUnregisteredUsers;
use App\Models\Account;
use App\Models\Category;
use App\Models\Notification;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Livewire\Component;

class Transactions extends Component
{
    public $user;

    public $transactions;
    public $grouped_transactions;
    public $transaction_status;
    public $load_amount = 70;
    public $total_transactions;

    public $account_id;
    public $aid;
    public $account;

    public $error = '';
    public $success = '';

    public $shareable_link = null;

    public $categories;

    public $balances;
    public $balance_status;

    public $institution;
    public $shared_emails = [];
    public $email = '';
    public $share_notes = 0;
    public $share_balance = 0;

    protected $listeners = ['refreshView' => 'refreshing'];

    public function mount($aid, $account_id)
    {
        $this->account_id = $account_id;
        $this->aid = $aid;
        $this->user = Auth::user();
        // $this->transactions = collect();

        $this->categories = Category::all()->toArray();

        $this->account = Account::where('id', $aid)->where('user_id', $this->user->id)->where('account_id', $this->account_id)->get()->first();
        $this->institution = $this->account->institution;

        $this->total_transactions = $this->account->transactions()->count();

        $this->load_balance();
        $this->load_transactions();
        $this->get_sharing_info();
    }

    public function refreshing()
    {
        // $this->load_transactions();
        $this->render();
    }

    private function load_balance()
    {
        if ($this->user->balance_error_code == null)
        {
            $this->balance_status = "Processing";
        }
        else if ($this->user->balance_error_code == 200)
        {
            $this->balances = $this->account->balances->toArray();
            $this->balance_status = "OK";
        }
        else
        {
            $this->balance_status = "Error";
        }
    }

    private function load_transactions()
    {
        if ($this->account->first_load == null)
        {
            
            $this->transaction_status = "Processing";
            Functions::fetchTransactions($this->user, $this->account, null, null);
            $this->account->first_load = Carbon::now()->toDateTimeString();
            $this->account->last_load_time = Carbon::now()->toDateTimeString();
            $this->account->save();
            $this->emit('transactionReFetched');
        }
        
        $llt = Carbon::parse($this->account->last_load_time);
        $now = Carbon::now();
        if($now->diffInHours($llt) > 22){
            $this->transaction_status = "Processing and Refreshing";
            // Functions::fetchTransactions($this->user, $this->account, $llt->toDateString(), null);
            Functions::fetchTransactions($this->user, $this->account, null, null);
            $this->account->last_load_time = Carbon::now()->toDateTimeString();
            $this->account->save();
            $this->emit('transactionReFetched');
        }
        
        // if ($this->user->transaction_error_code == 200)
        // {
            $select_array = [
                'id', 'fixed_date', 'year', 'custom_uid', 'debator_name', 'debtor_account', 'creditor_name', 'creditor_account', 'additional_information', 'status', 'purpose_code',
                'bank_transaction_code', 'remit_info_unstructured', 'transaction_currency', 'transaction_amount', 'notes', 'category_id', 'additional_information_structured',
                'balance_after_transaction', 'check_id', 'creditor_agent', 'creditor_id', 'currency_exchange', 'debtor_agent', 'mandate_id', 'proprietary_bank_transaction_code',
                'remittance_information_structured', 'remittance_information_structured_array', 'remittance_information_unstructured_array', 'ultimate_creditor', 'ultimate_debtor',
                'end_to_end_id'
            ];
            $this->transactions = $this->account->transactions()->with('category')->select($select_array)->skip(0)->take($this->load_amount)->orderBy('fixed_date', 'desc')->get();
            
            if ($this->transactions->count() >= $this->total_transactions)
            {
                $this->emit('allDataLoaded');
            }

            $this->grouped_transactions = $this->transactions->groupBy('year')->toArray();
            $this->transactions = $this->transactions->toArray();
            $this->transaction_status = "OK";
        // }
        // else
        // {
        //     $this->transaction_status = "Error";
        // }
    }

    public function render()
    {
        return view('livewire.transactions');
    }

    public function save_note($id, $value)
    {
        Transaction::where('id', $id)->update([
            'notes' => $value,
        ]);
        $this->load_transactions();
        $this->emit('commentSaved');
    }

    public function load_more()
    {
        $this->load_amount += 20;
        $this->load_transactions();
    }

    public function updateCategory($transaction_id, $category_id)
    {
        $transaction = Transaction::find($transaction_id);
        if ($category_id == null)
        {
            $transaction->category_id = null;
        }
        else
        {
            $transaction->category_id = $category_id;
            // $category = Category::find($category_id);
            // $transaction->category()->associate($category);
        }
        $transaction->save();
        $this->load_transactions();
    }

    public function get_sharing_info()
    {
        $this->shareable_link = $this->account->shareable_link;

        $temp_1 = DB::table('account_shares_with_unregistered_users')->selectRaw("id,email,created_at,'other' as type")->where('account_id', $this->account->id)->get()->toArray();
        
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

        $temp_2 = $this->account->shared_with()->selectRaw("users.id,users.email,'user' as type")->get()->toArray();
        
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

    public function generate_shareable_link()
    {
        $token = Str::orderedUuid();
        $this->account->shareable_link = (string)$token;
        $this->account->save();
        $this->shareable_link = (string)$token;
        // $this->refreshing();
    }

    public function remove_shareable_link()
    {
        $this->account->shareable_link = null;
        $this->account->save();
        $this->shareable_link = null;
        // $this->refreshing();
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

                if ($user != null)
                {
                    try
                    {
                        $user->shared_accounts()->attach($this->account->id, ['notes_shared' => $this->share_notes ? 1 : 0, 'balance_shared' => $this->share_balance ? 1 : 0]);


                        $message = $authenticated_user->fname . ' ' . $authenticated_user->lname . ' has shared an Account of ' . $this->institution->name;

                        $notification = Notification::create([
                            'type' => 'account_share',
                            'data' => $this->account->account_id . '-' . $this->account->id,
                            'user_id' => $user->id,
                            'message' => $message,
                            'read' => 0
                        ]);

                        SendNotification::dispatch($user, $notification);
                        // event(new SendNotification($user, $notification));
                        $this->success = "Account has been Successfully Shared with the User.";
                    }
                    catch (Exception $e)
                    {
                        Log::error($e->getCode() . ' - ' . $e->getMessage() . ' - ' . $e->getFile() . ' - ' . $e->getLine());
                        $this->success = "Error Raised while sharing Account.";
                    }
                    
                }
                else
                {
                    try
                    {
                        DB::table('account_shares_with_unregistered_users')->insert([
                            'account_id' => $this->account->id,
                            'email' => $this->email,
                            'notes_shared' => $this->share_notes ? 1 : 0,
                            'balance_shared' => $this->share_balance ? 1 : 0,
                            "created_at" =>  Carbon::now()->toDateTimeString(),
                            "updated_at" => Carbon::now()->toDateTimeString()
                        ]);

                        Mail::to($this->email)->send(new ShareWithUnregisteredUsers(Auth::user(), $this->account));
                        $this->success = "Sharing Request has been Successfully sent to the user email address.";
                    }
                    catch (Exception $e)
                    {
                        $this->error = "Error Raised while sharing Account.";
                    }
                    
                }
                $this->get_sharing_info();
                $this->email = "";
                // $this->refreshing();
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
                $user->shared_accounts()->detach($this->account->id);
            }
        }
        $this->get_sharing_info();
        // $this->refreshing();
    }

    private function check_already_shared($user = null)
    {
        $exists = false;
        if ($user != null)
        {
            $exists = $user->shared_accounts()->newPivotStatementForId($this->account->id)->exists();
        }

        if (!$exists)
        {
            $other_exists = DB::table('account_shares_with_unregistered_users')->where('account_id', $this->account->id)->where('email', $this->email)->count();
            if ($other_exists > 0)
            {
                return true;
            }
            return false;
        }
        return true;
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

    private function reset_status()
    {
        $this->error = "";
        $this->success = "";
    }
}
