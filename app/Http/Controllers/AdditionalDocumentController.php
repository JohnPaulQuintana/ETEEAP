<?php

namespace App\Http\Controllers;

use App\Models\AdditionalDocument;
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
            return Redirect::route('timeline', $documentId)->with(['status' => 'success', 'message' => 'Successfully']);
        }


    }
}
