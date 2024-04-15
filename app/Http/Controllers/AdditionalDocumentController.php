<?php

namespace App\Http\Controllers;

use App\Models\AdditionalDocument;
use App\Models\AlertMessage;
use App\Models\History;
use App\Models\InternalMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class AdditionalDocumentController extends Controller
{
    public function additionalDocument(Request $request){
       
        // dd($request);
        // "documentId" => "1"
        //  "reuploadDocsName" => "test documents"
        //   "reuploadComment" => "ito na po"
        // reuploadDocs
        $userName = Auth::user()->name;
        $file = $request->file("reuploadDocs");
        $fileName = $request->input('reuploadDocsName');
        $reuploadComment = $request->input('reuploadComment');
        $documentId = $request->input('documentId');
        $senderId = $request->input('senderId');
        if($request->hasFile('reuploadDocs')){
            $extension = $file->getClientOriginalExtension();
            $uniqueFileName = 'additional_'. time() . '_' . uniqid() . '.' . $extension;

            $folderName = $userName;
            $path = $file->storeAs("public/documents/$folderName", $uniqueFileName);

            AdditionalDocument::create([
                'document_id' => $documentId,
                'document_name' => $fileName,
                'path' => $path,
            ]);

            // $history = History::with('document')->where('document_id', $documentId)->latest()->get();

            InternalMessage::create(['document_id'=>$documentId,'user_id'=>$senderId, 'sender_id'=>Auth::user()->id, 'message'=>$reuploadComment, 'action_required'=>'Additional Documents Uploaded', "message_type"=>"internal"]);
            //create a alert message to eteeap department
            AlertMessage::create(['reciever_id'=>$senderId, 'sender_id'=>Auth::user()->id, 'notification'=>'A new application submission has been reuploaded. Please review it at your earliest convenience.']);

            return Redirect::route('timeline', $documentId)->with(['status' => 'success', 'message' => 'Successfully']);
        }


    }

    public function userResponseAction(Request $request){
        // dd($request);
        $documentId = $request->input('documentId');
        $senderId = $request->input('senderId');
        $sendMessage = $request->input('sendMessage');
        InternalMessage::create(['document_id'=>$documentId,'user_id'=>$senderId, 'sender_id'=>Auth::user()->id, 'message'=>$sendMessage, 'action_required'=>'Applicant Response Needed', "message_type"=>"internal"]);
        AlertMessage::create(['reciever_id'=>$senderId, 'sender_id'=>Auth::user()->id, 'notification'=>'This user is sending you a message.']);
        return Redirect::route('timeline', $documentId)->with(['status' => 'success', 'message' => 'Successfully']);
    }
}
