<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\CheckingDocument;
use Illuminate\Support\Facades\Auth;

class CheckingDocumentController extends Controller
{
    public function checkedDocument(Request $request){
       
        $documents = User::has('documents')->with('documents.status', 'documents.status.notes', 'documents.tvids')->find($request->input('user_id'));
        // dd($request);
        if ($documents) {
            foreach ($documents->documents as $document) {
                $existingRecord = CheckingDocument::where('document_id', $document->id)->where('sub_name', $request->input('subname'))->first();
                if(!$existingRecord){
                    CheckingDocument::create(
                        [
                            'document_id'=>$document->id, 
                            'sub_name'=>$request->input('subname'), 
                            'requirements'=>$request->input('filename'), 
                            'description'=>($request->input('description') === null) ? "This document is passed the validation by ".Auth::user()->name : $request->input('description'), 
                            'action'=>$request->input('type')
                        ]
                    );
    
                    return response()->json(['status'=>'success','message'=>"document's updated successfully"]);
                }else{
                    return response()->json(['status'=>'error','message'=>"document is already checked"]);
                }
            }
        }
    }
}
