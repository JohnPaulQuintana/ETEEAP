<?php

namespace App\Http\Controllers;

use App\Models\ActionRequired;
use App\Models\AlertMessage;
use App\Models\Document;
use App\Models\InternalMessage;
use App\Models\LastSender;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class InternalMessageController extends Controller
{
    public function storeMessage(Request $request){
        //original 'user_id'=>$request->input('user_id')
        $lastSenderDepartment = LastSender::where('document_id', $request->input('user_document_id'))->latest()->first();

        if (Auth::user()->id == $request->input('user_id') && $lastSenderDepartment->last_sender !== null) {
            InternalMessage::create(['document_id'=>$request->input('user_document_id'),'user_id'=>$lastSenderDepartment->last_sender, 'sender_id'=>Auth::user()->id, 'message'=>$request->input('message'),'action_required'=>$request->input('action_required'), 'message_type'=>$request->input('message_type')]);
        }else{
            InternalMessage::create(['document_id'=>$request->input('user_document_id'),'user_id'=>$request->input('user_id'), 'sender_id'=>Auth::user()->id, 'message'=>$request->input('message'),'action_required'=>$request->input('action_required'), 'message_type'=>$request->input('message_type')]);
        }
       
        Document::where('id', $request->input('user_document_id'))->update(['created_at'=>now()]);
        // Find or create/update action required entry
        $action = ActionRequired::firstOrNew(['document_id' => $request->input('user_document_id')]);
        $action->action_required = $request->input('action_required');
        $action->save();

        if($request->input('message_type') === 'external'){

            if (Auth::user()->id == $request->input('user_id')) {
                AlertMessage::create(['reciever_id'=>$lastSenderDepartment->last_sender, 'sender_id'=>Auth::user()->id, 'notification'=>'A new message sent.']);
            } else {
                AlertMessage::create(['reciever_id'=>$request->input('user_id'), 'sender_id'=>Auth::user()->id, 'notification'=>'A new message sent.']);
            }
            
            // dd($lastSenderDepartment);
            
        }
       
        return Redirect::route('eteeap.document', $request->input('user_document_id'))->with(['status' => 'success', 'message' => 'Successfully']);
    }
}
