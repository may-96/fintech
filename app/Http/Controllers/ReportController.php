<?php

namespace App\Http\Controllers;

use App\Events\SendNotification;
use App\Helpers\Functions;
use App\Mail\RequestReportFromRegisteredUsers;
use App\Mail\RequestReportFromUnregisteredUsers;
use App\Mail\SharedReportWithUnregisteredUsers;
use App\Models\Notification;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ReportController extends Controller
{
    public function show(Request $request)
    {

        /** @var \App\Models\User */
        $user = Auth::user();

        $data = $user->report_requests()->select('email')->get()->flatten()->pluck('email')->toArray();
        $data_unregistered = DB::table('report_requested_from_unregistered_users')->select('email')->where('user_id', $user->id)->get()->flatten()->pluck('email')->toArray();

        $merge_data = array_merge($data, $data_unregistered);
        sort($merge_data);

        return view('app.request_report', ['data' => $merge_data]);
    }

    public function fetchReport(Request $request, $token = null)
    {
        /** @var \App\Models\User */

        // $user = Auth::user();
        
        $user = Auth::guard('web')->user();

        if (Functions::is_empty($token))
        {
            $data = ['self'];
        }
        else
        {
            if(Functions::not_empty($user)){
                $shared_user = $user->shared_reports_with()->wherePivot('token', $token)->first();
                $main_user = $user->shared_reports()->wherePivot('token', $token)->first(); 
                if (Functions::not_empty($shared_user))
                {
                    $data = ['shared', $shared_user->pivot];
                }
                else if(Functions::not_empty($main_user)){
                    $data = ['self_shared', $main_user->pivot];
                }
                else{
                    $report_user = User::where('report_shareable_link', $token)->first();
                    $report_data = DB::table('report_user')->where('shareable_link', $token)->get()->flatten()->first();

                    if($report_user){
                        $access = [
                            "view_expense" => 1,
                            "view_cash_flow" => 1,
                            "view_income" => 1,
                            "view_email" => 1,
                            "view_contact" => 1,
                            "view_credit_score" => 1,
                            "view_initials_only" => 1,
                            "view_account_initials_only" => 1,
                            "currency" => $report_user->currency,
                        ];
                        $data = ['link_shared_everyone', $report_user->id, $access];
                    }
                    else if(Functions::not_empty($report_data)){
                        $data = ['link_shared', $report_data->user_id, $report_data];
                    }
                    else{
                        abort(404);
                    }
                }
            }
            else
            {
                $user = User::where('report_shareable_link', $token)->first();
                $report_data = DB::table('report_user')->where('shareable_link', $token)->get()->flatten()->first();

                if($user){
                    $access = [
                        "view_expense" => 1,
                        "view_cash_flow" => 1,
                        "view_income" => 1,
                        "view_email" => 1,
                        "view_contact" => 1,
                        "view_credit_score" => 1,
                        "view_initials_only" => 1,
                        "view_account_initials_only" => 1,
                        "currency" => $user->currency,
                    ];
                    $data = ['link_shared_everyone', $user->id, $access];
                }
                else if(Functions::not_empty($report_data)){
                    $data = ['link_shared', $report_data->user_id, $report_data];
                }
                else{
                    abort(404);
                }
            }
        }

        return view('app.reports', ['data' => $data]);
    }

    public function requestReport(Request $request)
    {
        $request->validate([
            'amount' => ['required', 'numeric', 'gte:0'],
            'currency' => ['required', 'string', 'exists:currencies,code'],
            'emails' => ['required', 'string']
        ]);

        $emails = $request->emails;
        $amount = $request->amount;
        $currency = $request->currency;

        $emails_formatted = str_replace("\r\n", ",", str_replace(" ", ",", str_replace("  ", ",", $emails)));
        $emails_array = array_values(array_filter(explode(",", $emails_formatted)));
        $invalid_emails = 0;
        $my_email = 0;
        $already_shared = 0;
        $requested_success = 0;

        /** @var \App\Models\User */
        $auth_user = Auth::user();

        foreach ($emails_array as $email)
        {
            if ($this->check_email($email))
            {
                if ($email == $auth_user->email)
                {
                    $my_email = 1;
                    continue;
                }
                $user = User::where('email', $email)->first();
                if ($this->check_already_requested($auth_user->id, $email, $user))
                {
                    $already_shared += 1;
                    continue;
                }
                else
                {
                    $token = (string) Str::orderedUuid();
                    if ($user != null)
                    {
                        try
                        {

                            $user->report_requested_from()->attach($auth_user->id, [
                                'amount' => $amount,
                                'currency' => $currency,
                            ]);

                            $message = $auth_user->fname . ' ' . $auth_user->lname . ' has requested you to share your Credit Report.';

                            $notification = Notification::create([
                                'type' => 'request_report',
                                'data' => $auth_user->id,
                                'user_id' => $user->id,
                                'message' => $message,
                                'read' => 0
                            ]);

                            SendNotification::dispatch($user, $notification);
                            Mail::to($user->email)->send(new RequestReportFromRegisteredUsers($auth_user, $user));
                            // event(new SendNotification($user, $notification));

                            $requested_success += 1;
                        }
                        catch (Exception $e)
                        {
                            Log::error($e->getCode() . ' - ' . $e->getMessage() . ' - ' . $e->getFile() . ' - ' . $e->getLine());
                        }
                    }
                    else
                    {
                        try
                        {
                            DB::table('report_requested_from_unregistered_users')->insert([
                                'user_id' => $auth_user->id,
                                'email' => $email,
                                'amount' => $amount,
                                'currency' => $currency,
                                "created_at" =>  Carbon::now()->toDateTimeString(),
                                "updated_at" => Carbon::now()->toDateTimeString()
                            ]);

                            Mail::to($email)->send(new RequestReportFromUnregisteredUsers($auth_user));

                            $requested_success += 1;
                        }
                        catch (Exception $e)
                        {
                        }
                    }
                }
            }
            else
            {
                $invalid_emails += 1;
            }
        }
        $message = "";
        if ($requested_success > 0)
        {
            $message = "New Request Sent to " . $requested_success . " Users.";
        }
        if ($invalid_emails > 0)
        {
            if ($message != "")
            {
                $message .= "\n\n";
            }
            $message .= "Invalid Emails: " . $invalid_emails;
        }
        if ($already_shared > 0)
        {
            if ($message != "")
            {
                $message .= "\n\n";
            }
            $message .= "You've already requested report from " . $already_shared . " Users.";
        }
        if ($my_email > 0)
        {
            if ($message != "")
            {
                $message .= "\n\n";
            }
            $message .= "You cannot send report request to yourself.";
        }

        return redirect()->route('request.report')->with('info', $message);
    }

    private function check_email($email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            return false;
        }
        return true;
    }

    private function check_already_requested($id, $email, $user = null)
    {
        $exists = false;
        if ($user != null)
        {
            $exists = $user->report_requested_from()->newPivotStatementForId($id)->exists();
        }

        if (!$exists)
        {
            $other_exists = DB::table('report_requested_from_unregistered_users')->where('user_id', $id)->where('email', $email)->count();
            if ($other_exists > 0)
            {
                return true;
            }
            return false;
        }
        return true;
    }

    public function grantAccess(Request $request)
    {
        /** @var \App\Models\User */
        $user = Auth::user();

        if($user->accounts->count() == 0){
            return "Please connect your Bank Account before sharing the Credit Report.";
        }

        $shared_with = $request->shared_with;
        $shared_user = User::find($shared_with);

        $check = $user->report_requested_from()->wherePivot('user_id', $shared_with)->count();
        if ($check == 1)
        {
            $check2 = $user->shared_reports()->wherePivot('shared_with', $shared_with)->count();
            if ($check2 == 0 && $shared_user)
            {
                $amount = $user->report_requested_from()->wherePivot('user_id', $shared_with)->get()->first()->pivot->amount;
                $currency = $user->report_requested_from()->wherePivot('user_id', $shared_with)->get()->first()->pivot->currency;
                $token = (string) Str::orderedUuid();
                
                $shared_user->shared_reports_with()->attach($user->id, [
                    'view_cash_flow' => $request->view_cash_flow ? 1 : 0,
                    'view_expense' => $request->view_expense ? 1 : 0,
                    'view_income' => $request->view_income ? 1 : 0,
                    'view_email' => $request->view_email ? 1 : 0,
                    'view_contact' => $request->view_contact ? 1 : 0,
                    'view_credit_score' => $request->view_credit_score ? 1 : 0,
                    'view_initials_only' => $request->view_initials_only ? 1 : 0,
                    'view_account_initials_only' => $request->view_account_initials_only ? 1 : 0,
                    'amount' => $amount,
                    'currency' => $currency,
                    'token' => $token,
                ]);

                $message = $user->fname . ' ' . $user->lname . ' has shared the Credit Report with you.';

                $notification = Notification::create([
                    'type' => 'report_share',
                    'data' => $token,
                    'user_id' => $shared_with,
                    'message' => $message,
                    'read' => 0
                ]);

                $message2 = 'Report shared successfully with '.$shared_user->fname . ' ' . $shared_user->lname .'. Click here to view the shared report.';

                $notification2 = Notification::create([
                    'type' => 'report_share',
                    'data' => $token,
                    'user_id' => $user->id,
                    'message' => $message2,
                    'read' => 0
                ]);

                $del_notification = Notification::where('type','request_report')->where('data',$shared_with)->where('user_id',$user->id)->delete();

                SendNotification::dispatch($shared_user, $notification);
                SendNotification::dispatch($user, $notification2);
                $user->report_requested_from()->detach($shared_with);

                return "Report Shared Successfully";
            }
            $user->report_requested_from()->detach($shared_with);
            return "Report has already been Shared with this User";
        }
        else
        {
            return "No such Report Request Exist.";
        }
    }

    public function sharedReports(Request $request)
    {
        /** @var \App\Models\User */
        $user = Auth::user();
        $data = $user->shared_reports_with()->select(['fname', 'lname'])->get()->flatten();

        return view('app.shared_reports', ['data' => $data]);
    }

    public function reportsIShared(Request $request){
        /** @var \App\Models\User */
        $user = Auth::user();
        $data = $user->shared_reports()->get()->flatten();

        return view('app.my_shared_reports', ['data' => $data]);
    }

    public function shareable_report(Request $request, $token){
        try{
            $user = User::where('report_shareable_link', $token)->first();
            if($user){
                $data = ['shared', $user->id];
                return view('app.shareable_link_reports', ['data' => $data]);
            }
            else{

            }
            
            return redirect()->back()->with('danger', "No such Account Exist");

        }
        catch(Exception $e){
            Log::error($e->getCode() . ' - ' . $e->getMessage() . ' - ' . $e->getFile() . ' - ' . $e->getLine());
            return redirect()->back()->with('danger', $e->getMessage());
        }
    }

    public function remove_report(Request $request, $token)
    {
        /** @var \App\Models\User */
        $user = Auth::user();
        try{
            DB::table('report_user')->where('shared_with', $user->id)->where('token', $token)->delete();
            return redirect()->back()->with('success','Report Deleted Successfully.');
        }
        catch(Exception $e){
            return redirect()->back()->with('error','Error while Deleting Report');
        }
    }

    public function remove_my_shared_report(Request $request, $token)
    {
        /** @var \App\Models\User */
        $user = Auth::user();
        try{
            DB::table('report_user')->where('user_id', $user->id)->where('token', $token)->delete();
            return redirect()->back()->with('success','Report Deleted Successfully.');
        }
        catch(Exception $e){
            return redirect()->back()->with('error','Error while Deleting Report');
        }
    }

    public function remove_report_request(Request $request)
    {
        /** @var \App\Models\User */
        $user = Auth::user();
        $data = $request->validate([
            'email' => ['required','email', 'string' ],
        ]);
        try{
            $data = Functions::filtered_request_data($data);
            $requested_from = User::where('email' , $data['email'])->get()->first();

            if(Functions::not_empty($requested_from)){
                DB::table('report_request')->where('user_id', $user->id)->where('requested_from', $requested_from->id)->delete();
            }
            else{
                DB::table('report_requested_from_unregistered_users')->where('user_id', $user->id)->where('email', $data['email'])->delete();
            }

            return redirect()->back()->with('success','Report Request Deleted Successfully.');
        }
        catch(Exception $e){
            return redirect()->back()->with('error','Error while Deleting Report Request');
        }
    }
}
