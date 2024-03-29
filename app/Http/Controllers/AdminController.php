<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Status;
use App\Models\History;
use App\Models\Document;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Models\CheckingDocument;
use App\Models\DepartmentComment;
use Illuminate\Support\Facades\Auth;
use App\Notifications\SendEmailNotification;
use Illuminate\Support\Facades\Notification;

class AdminController extends Controller
{
    // Apply middleware to a controller constructor
    public function __construct()
    {
        // Apply the 'checkUserRole' middleware to all methods in this controller for roles 0 and 1
        $this->middleware('checkUserRole:0,1');
    }
    public function accepted()
    {

        $alldocs = User::whereHas('documents', function ($query) {
            $query->whereHas('status', function ($subquery) {
                $subquery->whereNotIn('status', ['pending', 'rejected', 'in-review']);
            });
        })->with(['documents.status', 'interview'])->get();


        return view('admin.accepted', ['documents' => $alldocs]);
    }
    public function declined()
    {

        // $alldocs = User::whereHas('documents', function ($query) {
        //     $query->whereHas('status', function ($subquery) {
        //         $subquery->whereNotIn('status',['pending', 'rejected','in-review']);
        //     });
        // })->with(['documents.status', 'interview'])->get();


        return view('admin.declined');
    }
    public function index()
    {
        $userId = Auth::user()->id;

        // $alldocs = User::whereHas('documents', function ($query) {
        //     $query->whereHas('status', function ($subquery) {
        //         $subquery->whereNotIn('status',['accepted', 'rejected']);
        //     });
        // })
        // ->with(['documents.status', 'documents.status.notes', 'documents.tvids', 'documents.checked'])->get();
        // $userId = Auth::user()->id; // Retrieve the current user's ID
        $forwardedToMe = Document::join('forward_to_depts', 'forward_to_depts.document_id', '=', 'documents.id')
            // ->join('department_comments', 'department_comments.forward_to_depts_id', '=', 'forward_to_depts.id')
            ->where('forward_to_depts.receiver_id', Auth::id())
            ->where('forward_to_depts.isForwarded', 0)
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
            ->get();

        // dd($forwardedToMe);
        foreach ($forwardedToMe as $key => $value) {
            $comments = DepartmentComment::join('users', 'users.id', '=', 'department_comments.sender_id')
                ->select('department_comments.*', 'users.name')
                ->where('forward_to_depts_id', $value->ftd_id)->get();
            foreach ($value->checked as $key => $v) {
                $resubmitted = CheckingDocument::where('action', 'declined')->where('document_id', $v->document_id)->with('reupload')->get();
            }
        }

        // return view('admin.dashboard', ['documents' => $alldocs]);
        return view('admin.dashboard', ['forwardedDocuments' => $forwardedToMe, 'resubmitted' => $resubmitted ?? [], 'comments' => $comments ?? []]);
    }

    // department
    public function department()
    {
        $departments = Department::with('user')->withCount('user')->get();
        //    dd($departments);
        return view('admin.department', ['departments' => $departments]);
    }


    // call from ajax
    public function ajaxCall(Request $request, $id)
    {
        // dd($id);
        $documents = User::has('documents')->with('documents.status', 'documents.status.notes', 'documents.tvids')->where('id', $id)->get();
        // dd($documents);
        return response()->json(['documents' => $documents]);
    }
    // call from ajax update
    public function ajaxCallUpdate(Request $request, $id)
    {
        // dd($id);
        $notifyUser = User::where('id', $id)->first();
        $documents = User::has('documents')->with('documents.status', 'documents.status.notes', 'documents.tvids')->find($id);
        // Assuming there's a single document associated with the user
        // $document = $documents->documents->first();

        if ($documents) {
            foreach ($documents->documents as $document) {
                Status::where('id', $document->id)->update(['status' => 'in-review']);
                $existingRecord = History::where('document_id', $document->id)->where('status', 'in-review')->first();
                if (!$existingRecord) {
                    History::create(['document_id' => $document->id, 'status' => 'in-review', 'notes' => Auth::user()->name . ' is viewing your documents.']);
                    // Build the email notification details
                    // Set the time zone to Asia/Manila
                    date_default_timezone_set('Asia/Manila');
                    $details = [
                        'greetings' => "Hi " . $notifyUser->name,
                        'body' => "We wanted to inform you that your application is currently under review by our team.",
                        'body1' => "This process may take some time as we carefully evaluate each application to ensure the best possible outcome.",
                        'body2' => "Date: " . date('Y-m-d'),
                        'body3' => "Time: " . date('h:i A'),
                        'body4' => "Rest assured that we will notify you promptly once a decision has been made regarding your application.",
                        'body5' => "In the meantime, we encourage you to explore our website for more information about our organization and the opportunities we offer.",
                        'body6' => "If you have any questions or concerns regarding your application, please feel free to contact us. Our team is here to assist you throughout the process.",
                        'actiontext' => 'Go to Dashboard',
                        'actionurl' => route('user-dashboard'),
                        'lastline' => 'Thank you for your patience and understanding. We appreciate your interest in our organization.',
                    ];

                    //send notification to a user 
                    Notification::send($notifyUser, new SendEmailNotification($details));
                }

                // dd($document->id);
                return response()->json(['status' => 'success']);
            }
        }
    }

    // accept document
    public function acceptDocs(Request $request)
    {
        // dd($request);
        $documents = User::has('documents')->with('documents.status', 'documents.status.notes', 'documents.tvids')->find($request->input('user_id'));
        if ($documents) {
            foreach ($documents->documents as $document) {
                Status::where('id', $document->id)->update(['status' => $request->input('type')]);
                $existingRecord = History::where('document_id', $document->id)->where('status', $request->input('type'))->first();
                if (!$existingRecord) {
                    History::create(['document_id' => $document->id, 'status' => $request->input('type'), 'notes' => ($request->input('type') == 'accepted' ? ' Your Application is accepted, we will sending you an email for the interview.' : 'Your Application is rejected, the details available on return documents section.')]);
                }
            }
            return response()->json(['status' => 'success', 'message' => 'successfully accepted', 'user_id' => $documents->id]);
        }

        // If no documents were found
        return response()->json(['status' => 'error', 'message' => 'No documents found for the user.']);
    }
}
