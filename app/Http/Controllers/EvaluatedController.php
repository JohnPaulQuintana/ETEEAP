<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Document;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Models\CheckingDocument;
use App\Models\DepartmentComment;
use Illuminate\Support\Facades\Auth;

class EvaluatedController extends Controller
{
    public function evaluated()
    {
        $department = Department::where('id', Auth::user()->department_id)->first();
        $forwardedToMe = Document::join('forward_to_depts', 'forward_to_depts.document_id', '=', 'documents.id')
            // ->join('department_comments', 'department_comments.forward_to_depts_id', '=', 'forward_to_depts.id')
            ->where('forward_to_depts.receiver_id', Auth::user()->id)
            ->where('forward_to_depts.isForwarded', 1)
            ->select(
                'forward_to_depts.receiver_id as forward_to',
                'forward_to_depts.document_id',
                'forward_to_depts.id as ftd_id',
                'forward_to_depts.created_at as date',
                'documents.*'
                // 'checking_documents.sub_name', 'checking_documents.requirements', 'checking_documents.description', 'checking_documents.action', 'checking_documents.created_at as checked_date'
            )
            ->with(['checked' => function ($query) {
                $query->where('action', 'accepted');
            }, 'user', 'status'])
            ->groupBy('documents.id')
            ->latest('forward_to_depts.created_at')
            ->get();

        // dd($forwardedToMe);
        // $commentsRecords = collect(); // Initialize an empty collection to hold the accepted records
        foreach ($forwardedToMe as $key => $value) {
            // $commentsRecords = $commentsRecords->merge(DepartmentComment::join('users', 'users.id', '=', 'department_comments.sender_id')
            // ->select('department_comments.*', 'users.name')
            // ->where('forward_to_depts_id', $value->ftd_id)->get());
            $comments = DepartmentComment::join('users', 'users.id', '=', 'department_comments.sender_id')
                ->select('department_comments.*', 'users.name')
                ->where('document_id', $value->document_id)
                ->orderByDesc('created_at')
                ->get();
            $users = User::where('id', $value->user_id)->get();
            $value->comments = $comments;
            $value->owner = $users;
            foreach ($value->checked as $key => $v) {
                $resubmitted = CheckingDocument::where('action', 'declined')->where('document_id', $v->document_id)->with('reupload')->get();
            }
        }
        // dd($forwardedToMe);
        return view('department.evaluated', ['department'=>$department, 'documents'=>$forwardedToMe, 'resubmitted' => $resubmitted ?? [],]);
    }
}
