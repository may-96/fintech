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
            return $this->getNotifications();
        }
        catch(Exception $e){
            return response()->json(['result' => 0], 200);
        }
    }

    public function read(Request $request, Notification $notification)
    {
        try{
            $notification->read = 1;
            $notification->save();

            return $this->getNotifications();
        }
        catch(Exception $e){
            return response()->json(['result' => 0], 200);
        }
    }

    public function unread(Request $request, Notification $notification)
    {
        try{
            $notification->read = 0;
            $notification->save();

            return $this->getNotifications();
        }
        catch(Exception $e){
            return response()->json(['result' => 0], 200);
        }
    }

    public function destroy(Request $request, Notification $notification)
    {
        try{
            $notification->delete();

            return $this->getNotifications();
        }
        catch(Exception $e){
            return response()->json(['result' => 0], 200);
        }
    }

    private function getNotifications(){
        /** @var \App\Models\User */
        $user = Auth::user();

        $data = $user->notifications()->orderBy('created_at', 'desc')->get()->flatten();
        return response()->json(['result' => 1, 'data' => $data], 200);
    }


}
