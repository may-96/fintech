<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        try{
            /** @var \App\Models\User */
            $user = Auth::user();

            $data = $user->notifications;
            return response()->json(['result' => 1, 'data' => $data], 200);
        }
        catch(Exception $e){
            return response()->json(['result' => 0], 200);
        }
    }

    public function read(Request $request, Notification $notification)
    {
        try{

        }
        catch(Exception $e){

        }
    }

    public function unread(Request $request, Notification $notification)
    {
        try{

        }
        catch(Exception $e){

        }
    }

    public function destroy(Request $request, Notification $notification)
    {
        try{

        }
        catch(Exception $e){

        }
    }


}
