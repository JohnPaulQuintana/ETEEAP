<?php

namespace App\Http\Controllers;

use App\Models\CheckingDocument;
use App\Models\History;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // Apply middleware to a controller constructor
    public function __construct()
    {
         // Apply the 'checkUserRole' middleware to all methods in this controller for roles 0 and 1
         $this->middleware('checkUserRole:0,1');
    }

    public function index(){
        //for admin
        // $mydocs = User::with(['documents.status'])->where('role',Auth::user()->role)->get();

        //for user 
        $mydocs = User::with(['documents.status','documents.status.notes', 'documents.tvids'])->where('id',Auth::user()->id)->get();
        // dd($mydocs);
        return view('users.dashboard', ['documents' => $mydocs]);
    }

    public function timeline(Request $request,$id){
        $history = History::with('document')->where('document_id', $id)->latest()->get();

        $declined = CheckingDocument::where('document_id',$id) ->where('action', 'declined')
            ->with(['reupload'])
            ->get();
        // dd($declined[0]->reuploadDocuments);
        return view('users.timeline', ['histories'=>$history, 'declined'=>$declined]);
    }
    // get the history with documents
    public function ajaxCallHistory($id){
        $history = History::with('document')->where('document_id', $id)->latest()->get();
        return response()->json(['histories'=>$history]);
    }
}
