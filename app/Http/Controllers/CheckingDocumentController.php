<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Document;
use Illuminate\Http\Request;
use App\Models\CheckingDocument;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\SendReuploadNotification;

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

                    $m = "";
                    if ($request->input('type') !== 'declined') {
                       $m = "This document has been validated by ".Auth::user()->name;
                    }else{
                       $m = $request->input('description');
                       if($request->input('description') === null){
                            $m = "This document has failed validation by ".Auth::user()->name;
                       }else{
                            $m = $request->input('description');
                       }
                    }
                    CheckingDocument::create(
                        [
                            'document_id'=>$document->id, 
                            'sub_name'=>$request->input('subname'), 
                            'requirements'=>$request->input('filename'), 
                            'description'=> $m, 
                            'action'=>$request->input('type')
                        ]
                    );

                    if ($request->input('type') === 'declined') {
                        $notifyUser = user::where('id', $request->input('user_id'))->first();
                        $details = [
                            "greetings"=>"Dear Ms/Mr ".$notifyUser->name,
                            "body" => "I hope this message finds you well.",
                            "body2" => "We would like to inform you that upon reviewing the document you submitted, it appears that there are certain areas that require revision or additional information. Therefore, we kindly request you to resubmit the document with the necessary changes as soon as possible.",
                            "body3" => "Your prompt attention to this matter would be greatly appreciated. Should you have any questions or require further assistance, please do not hesitate to contact us.",
                            "lastline" => "Thank you for your cooperation.",
                            "actiontext"=>"Available on Dashboard",
                            "actionurl"=>route('user-dashboard'),
                
                        ];
                        //send notification to a user 
                        Notification::send($notifyUser, new SendReuploadNotification($details));
                    }
    
                    return response()->json(['status'=>'success','message'=>"The document has been updated successfully."]);
                }else{
                    if($isReturned === 'true'){
                        $existingRecord->update([
                            'description'=>($request->input('description') === null) ? "This application has failed validation by ".Auth::user()->name : $request->input('description'), 
                            'action'=>$request->input('type')
                        ]);

                        // update the documents
                        Document::where('id', $document->id)->update(['isForwarded'=>0]);

                        $notifyUser = user::where('id', $request->input('user_id'))->first();
                        $details = [
                            "greetings"=>"Dear Ms/Mr ".$notifyUser->name,
                            "body" => "I hope this message finds you well.",
                            "body2" => "We would like to inform you that upon reviewing the document you submitted, it appears that there are certain areas that require revision or additional information. Therefore, we kindly request you to resubmit the document with the necessary changes as soon as possible.",
                            "body3" => "Your prompt attention to this matter would be greatly appreciated. Should you have any questions or require further assistance, please do not hesitate to contact us.",
                            "lastline" => "Thank you for your cooperation.",
                            "actiontext"=>"Available on Dashboard",
                            "actionurl"=>route('user-dashboard'),
                
                        ];
                        //send notification to a user 
                        Notification::send($notifyUser, new SendReuploadNotification($details));
                        
                        return response()->json(['status'=>'success','message'=>"The document has failed validation."]);
                    }
                    
                    return response()->json(['status'=>'error','message'=>"The documents have already been checked."]);
                }
            }
        }
    }
}
