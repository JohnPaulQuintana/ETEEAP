<?php

namespace App\Http\Controllers;

use App\Models\History;
use Illuminate\Http\Request;
use App\Models\CheckingDocument;
use App\Models\ReuploadDocument;
use Illuminate\Support\Facades\Auth;

class ReuploadDocumentController extends Controller
{
    public function reupload(Request $request){
        // dd($request);
        // Get the user's name or any unique identifier
        $userName = Auth::user()->name;
        //store the reupload documents
    //     "checkedId" => "14"
    //   "checkedName" => "Authenticated Birth Certificate/Affidavit of Birth (original)"
    //   "checkedSubName" => "abcb"
    //   "reuploadComment" => "dwadwad"
        //reuploadDocs -> files
        $file = $request->file("reuploadDocs");
        $fileName = $request->input('checkedSubName');
        $checkedId = $request->input('checkedId');
        $reuploadComment = $request->input('reuploadComment');
        $documentId = $request->input('documentId');

        if($request->hasFile('reuploadDocs')){
            $extension = $file->getClientOriginalExtension();
            $uniqueFileName = 'resubmitted_'.$fileName . '_' . time() . '_' . uniqid() . '.' . $extension;

            $folderName = $userName;
            $path = $file->storeAs("public/documents/$folderName", $uniqueFileName);

            ReuploadDocument::create([
                'checking_document_id' => $checkedId,
                'reupload_description' => $reuploadComment,
                'path' => $path,
            ]);
            
            $history = History::with('document')->where('document_id', $documentId)->latest()->get();

            $declined = CheckingDocument::where('document_id',$documentId) ->where('action', 'declined')
                ->with('reupload')
                ->get();
            // dd($declined);
            return view('users.timeline', ['histories'=>$history, 'declined'=>$declined]);
        }
    }
}
