<?php

namespace App\Http\Controllers;

use App\Models\ActionRequired;
use App\Models\Document;
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

        Document::where('id', $request->input('user_document_id'))->update(['created_at'=>now()]);
        // Find or create/update action required entry
        $action = ActionRequired::firstOrNew(['document_id' => $request->input('user_document_id')]);
        $action->action_required = $request->input('action_required');
        $action->save();
       
        return Redirect::route('eteeap.document', $request->input('user_document_id'))->with(['status' => 'success', 'message' => 'Successfully']);
    }
}
