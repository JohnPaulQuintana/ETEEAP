<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Document;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Models\ForwardToDept;
use Illuminate\Support\Facades\Auth;

class ForwardToDeptController extends Controller
{
    public function index(){
        
        $department = Department::where('id', Auth::user()->department_id)->first();

        $forwardedToMe = Document::join('forward_to_depts', 'forward_to_depts.document_id', '=', 'documents.id')
        ->where('forward_to_depts.receiver_id', Auth::id())
        ->where('forward_to_depts.isForwarded', 0)
        ->select('forward_to_depts.receiver_id as forward_to', 'forward_to_depts.document_id', 'forward_to_depts.created_at as date',
            'documents.*',
            // 'checking_documents.sub_name', 'checking_documents.requirements', 'checking_documents.description', 'checking_documents.action', 'checking_documents.created_at as checked_date'
        )
        ->with('checked')
        ->get();
        // $forwardedToMe = User::has('forwardedDocs')->where('id', Auth::user()->id)->with(['forwardedDocs', 'documents'])->get();
        // dd($forwardedToMe);
        return view('department.forwarded', ['department' => $department,]);

    }
}
