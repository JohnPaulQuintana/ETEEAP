<?php

namespace App\Http\Controllers;

use App\Models\ActionRequired;
use App\Models\InternalMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class InternalMessageController extends Controller
{
    public function storeMessage(Request $request){
        // dd($request);
        // "user_id" => "3"
        // "action_required" => null
        // "message" => "dwadwadwada dwawad"
        InternalMessage::create(['document_id'=>$request->input('user_document_id'),'user_id'=>$request->input('user_id'), 'sender_id'=>Auth::user()->id, 'message'=>$request->input('message'),'action_required'=>$request->input('action_required'), 'message_type'=>$request->input('message_type')]);
        $action = ActionRequired::find($request->input('user_document_id'));
        if(!$action){
            ActionRequired::create(['document_id'=>$request->input('user_document_id'), 'action_required'=>$request->input('action_required')]);
        }else{
            ActionRequired::where('document_id', $request->input('user_document_id'))->update(['action_required'=>$request->input('action_required')]); 
        }
       
        return Redirect::route('eteeap.document', $request->input('user_document_id'))->with(['status' => 'success', 'message' => 'Successfully']);
    }
}
