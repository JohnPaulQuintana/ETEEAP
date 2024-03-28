<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\CheckingDocument;
use App\Models\Document;
use Illuminate\Support\Facades\Auth;

class CheckingDocumentController extends Controller
{
    public function checkedDocument(Request $request){
        $isReturned = $request->input('isReturned');
        // dd($isReturned);
        $documents = User::has('documents')->with('documents.status', 'documents.status.notes', 'documents.tvids')->find($request->input('user_id'));
        // dd($request);
        if ($documents) {
            foreach ($documents->documents as $document) {
                $existingRecord = CheckingDocument::where('document_id', $document->id)
                    ->where('sub_name', $request->input('subname'))
                    ->where('action', 'accepted')
                    ->first();
                if(!$existingRecord && $isReturned !== 'true'){
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
                    if($isReturned === 'true'){
                        $existingRecord->update([
                            'description'=>($request->input('description') === null) ? "This document is failed the validation by ".Auth::user()->name : $request->input('description'), 
                            'action'=>$request->input('type')
                        ]);

                        // update the documents
                        Document::where('id', $document->id)->update(['isForwarded'=>0]);
                        return response()->json(['status'=>'success','message'=>"document's marked as failed the validation."]);
                    }
                    
                    return response()->json(['status'=>'error','message'=>"document is already checked"]);
                }
            }
        }
    }
}
