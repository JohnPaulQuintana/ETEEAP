<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Status;
use App\Models\History;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    // Apply middleware to a controller constructor
    public function __construct()
    {
         // Apply the 'checkUserRole' middleware to all methods in this controller for roles 0 and 1
         $this->middleware('checkUserRole:0,1');
    }
    public function index(){
        $alldocs = User::whereHas('documents', function ($query) {
            $query->whereHas('status', function ($subquery) {
                $subquery->where('status', '!=','accepted');
            });
        })->with(['documents.status', 'documents.status.notes', 'documents.tvids'])->get();
        
        // dd($alldocs);
        return view('admin.dashboard',['documents' => $alldocs]);
    }


    // call from ajax
    public function ajaxCall(Request $request, $id){
        // dd($id);
        $documents = User::has('documents')->with('documents.status', 'documents.status.notes', 'documents.tvids')->where('id',$id)->get();
        // dd($documents);
        return response()->json(['documents'=>$documents]);
    }
    // call from ajax update
    public function ajaxCallUpdate(Request $request, $id){
        // dd($id);
        $documents = User::has('documents')->with('documents.status', 'documents.status.notes', 'documents.tvids')->find($id);
        // Assuming there's a single document associated with the user
        // $document = $documents->documents->first();
       
        if ($documents) {
            foreach ($documents->documents as $document) {
                Status::where('id', $document->id)->update(['status'=>'in-review']);
                $existingRecord = History::where('document_id', $document->id)->where('status', 'in-review')->first();
                if(!$existingRecord){
                    History::create(['document_id' => $document->id, 'status'=> 'in-review', 'notes' => Auth::user()->name.' is viewing your documents.']);
                }
               
                // dd($document->id);
                return response()->json(['status'=>'success']);
            }
        }
       
    }
}
