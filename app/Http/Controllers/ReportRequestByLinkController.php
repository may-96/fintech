<?php

namespace App\Http\Controllers;

use App\Events\SendNotification;
use App\Helpers\Functions;
use App\Models\Notification;
use App\Models\ReportRequestByLink;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ReportRequestByLinkController extends Controller
{
    public function request_report_by_link(Request $request)
    {

        /** @var \App\Models\User */
        $user = Auth::user();

        $data = $user->request_links()->select('*')->get()->flatten()->toArray();
        // $data_unregistered = DB::table('report_requested_from_unregistered_users')->select('email')->where('user_id', $user->id)->get()->flatten()->pluck('email')->toArray();

        // $merge_data = array_merge($data, $data_unregistered);
        // sort($merge_data);

        return view('app.request_report_by_link', ['data' => $data]);
    }

    public function fetchRequestLinkData(Request $request, $token){
        $request_link = ReportRequestByLink::where('link',$token)->get()->first();
        if(Functions::not_empty($request_link)){
            $ip = $request->ip();
            return view('app.request_link_view', ['data' => $request_link, 'ip' => $ip]);
        }
        abort(404);
    }

    public function grantAccess(Request $request)
    {
        /** @var \App\Models\User */
        $user = Auth::user();

        if($user->accounts->count() == 0){
            return redirect()->back()->with('warning',"Please connect your Bank Account before sharing the Credit Report.");
        }

        $data = $request->validate([
            'credit_score' => ['sometimes', 'in:on'],
            'cash_flow' => ['sometimes', 'in:on'],
            'expenses' => ['sometimes', 'in:on'],
            'income' => ['sometimes', 'in:on'],
            'email_check' => ['sometimes', 'in:on'],
            'contact' => ['sometimes', 'in:on'],
            'initials_only' => ['sometimes', 'in:on'],
            'account_initials_only' => ['sometimes', 'in:on'],
            'link' => ['required', 'string', 'exists:request_report_by_link,link'],
        ]);

        $data = Functions::filtered_request_data($data);

        $request_link_query = ReportRequestByLink::where('link',$data['link'])->get();
        $request_link = $request_link_query->first();
        
        $shared_with = $request_link->user_id;
        $shared_user = User::find($shared_with);

        if($shared_with == $user->id){
            return redirect()->back()->with('warning',"You cannot share report with yourself.");
        }

        $check = $request_link_query->count();
        if ($check == 1)
        {
            $check2 = $user->shared_reports()->wherePivotNotNull('reference')->where('user_id', $user->id)->wherePivot('reference',$data['link'])->count();
            if ($check2 == 0 && $shared_user)
            {
                $amount = $request_link->amount;
                $currency = $request_link->currency;
                $token = (string) Str::orderedUuid();

                $shared_user->shared_reports_with()->attach($user->id, [
                    'view_cash_flow' => $request->cash_flow ? 1 : 0,
                    'view_expense' => $request->expenses ? 1 : 0,
                    'view_income' => $request->income ? 1 : 0,
                    'view_email' => $request->email_check ? 1 : 0,
                    'view_contact' => $request->contact ? 1 : 0,
                    'view_credit_score' => $request->credit_score ? 1 : 0,
                    'view_initials_only' => $request->initials_only ? 1 : 0,
                    'view_account_initials_only' => $request->account_initials_only ? 1 : 0,
                    'amount' => $amount,
                    'currency' => $currency,
                    'token' => $token,
                    'reference' => $data['link'],
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

                SendNotification::dispatch($shared_user, $notification);
                SendNotification::dispatch($user, $notification2);

                return redirect()->back()->with('success',"Report Shared Successfully");
            }
            $user->report_requested_from()->detach($shared_with);
            return redirect()->back()->with('warning',"Report has already been shared using this link.");
        }
        else
        {
            return redirect()->back()->with('warning',"No such Report Request Exist.");
        }
    }
}
