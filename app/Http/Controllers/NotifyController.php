<?php

namespace App\Http\Controllers;

use App\Models\ForwardToDept;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\SendNotifyNotification;

class NotifyController extends Controller
{
    public function notify(Request $request){
        // dd(Auth::user());
        $message = $request->input('message');
        // find the user who have the documents;
        $user = User::where('id', Auth::user()->id)->with('documents')->first();
       
        $locationNow = ForwardToDept::where('document_id', $user->documents[0]->id)->latest()->first();
        // dd($locationNow->receiver_id);
        // notify this user department
        $notifyUser = user::where('id', $locationNow->receiver_id)->first();
        $details = [
            "greetings"=>"Dear ms/mr ".$notifyUser->name,
            "body" => $message,
            "lastline" => "Thank you for your attention to this matter.",
            
            "lastline2" => "From : ".Auth::user()->name,

        ];
        //send notification to a user 
        Notification::send($notifyUser, new SendNotifyNotification($details));

        return response()->json(['status'=>'success', 'message'=>'You have successfully notify the department. ']);
    }
}
