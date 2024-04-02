<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Status;
use App\Models\History;
use App\Models\Document;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Models\ForwardToDept;
use App\Models\CheckingDocument;
use App\Models\DepartmentComment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use App\Notifications\SendEmailNotification;
use Illuminate\Support\Facades\Notification;

class DepartmentController extends Controller
{
    public function dashboard()
    {
        $acceptedApplicants = User::whereHas('documents', function ($query) {
            $query->whereHas('status', function ($subquery) {
                $subquery->whereNotIn('status', ['pending', 'rejected', 'in-review', 'forwarded']);
            });
        })->with(['documents.status', 'interview'])->get();

        $declinedApplicants = User::whereHas('documents', function ($query) {
            $query->whereHas('status', function ($subquery) {
                $subquery->whereNotIn('status', ['pending', 'accepted', 'in-review', 'forwarded']);
            });
        })->with(['documents.status', 'interview'])->get();

        $departmentCount = Department::count();

        // dd(Auth::user());
        $department = Department::where('id', Auth::user()->department_id)->first();

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
            $value->comments = $comments;
            foreach ($value->checked as $key => $v) {
                $resubmitted = CheckingDocument::where('action', 'declined')->where('document_id', $v->document_id)->with('reupload')->get();
            }
        }
        // dd($department);
        if ($department->department_name === 'ETEEAP Department') {
            $alldocs = User::whereHas('documents', function ($query) {
                $query->whereHas('status', function ($subquery) {
                    $subquery->whereNotIn('status', ['accepted', 'rejected','forwarded'])
                        ->where('isForwarded', 0);
                });
            })->with(['documents.status', 'documents.status.notes', 'documents.tvids', 'documents.checked'])->get();
            // dd($alldocs);
            if (count($alldocs) > 0) {
                // $checked = CheckingDocument::where('document_id', $alldocs[0]->documents[0]->id)
                //     ->select('sub_name', 'action')->get();

                foreach ($alldocs as $key => $alldoc) {
                    foreach ($alldoc->documents as $value) {
                        $checked = CheckingDocument::where('document_id', $value->id)
                        ->select('sub_name', 'action')->get();
                        $alldoc->checked = $checked;

                        $declined = CheckingDocument::where('document_id', $value->id)->where('action', 'declined')
                        ->with(['reupload'])
                        ->get();

                        $alldoc->declined = $declined;

                    }
                }

                $subNames = $checked->pluck('sub_name')->toArray();
                $subNameCounts = array_count_values($subNames);
                $acceptedRecords = collect(); // Initialize an empty collection to hold the accepted records

                foreach ($subNameCounts as $subName => $count) {
                    if ($count >= 2) {
                        $acceptedRecords = $acceptedRecords->merge(
                            CheckingDocument::where('sub_name', $subName)
                                ->where('action', 'accepted')
                                ->latest()
                                ->get()
                        );
                        // Now you have $acceptedRecords containing records with sub_name occurring 2 or more times and action as 'accepted'
                    }
                }

                // dd($acceptedRecords);

                // $declined = CheckingDocument::where('document_id', $alldocs[0]->documents[0]->id)->where('action', 'declined')
                //     ->with(['reupload'])
                //     ->get();
            }



            // dd($alldocs);
            return view('department.dashboard', [
                'department' => $department,
                'documents' => $alldocs,
                'checked' => $checked ?? [],
                'declined' => $declined ?? [],
                'resubmittedDocument' => $acceptedRecords ?? [],
                'forwardedDocuments' => $forwardedToMe,
                'resubmitted' => $resubmitted ?? [],
                'acceptedCount' => count($acceptedApplicants) ?? [],
                'declinedCount' => count($declinedApplicants) ?? [],
                'departmentCount' => $departmentCount ?? [],
            ]);
        } else {
            // $department = Department::where('id', Auth::user()->department_id)->first();
            //   dd($forwardedToMe);
            return view('department.dashboard', [
                'department' => $department,
                'forwardedDocuments' => $forwardedToMe,
                'resubmitted' => $resubmitted ?? [],
                'comments' => $comments ?? [],
                'acceptedCount' => count($acceptedApplicants) ?? [],
                'declinedCount' => count($declinedApplicants) ?? [],
                'departmentCount' => $departmentCount ?? [],
            ]);
        }
    }
    public function index(Request $request)
    {
        // dd($request);
        $existingDept = Department::where('department_name', $request->input('department'))->first();
        if (!$existingDept) {
            Department::create(['department_name' => $request->input('department')]);
            return Redirect::route('department')->with(['status' => 'success', 'message' => 'Successfully added a new department name : ' . $request->input('department')]);
        }
        return Redirect::route('department')->with(['status' => 'error', 'message' => 'This department name : ' . $request->input('department') . ' is already created. try another one!']);
    }
    public function user(Request $request)
    {
        // dd($request);
        $request->validate([
            'department_id' => ['required'],
            'name' => ['required'],
            'email' => ['required', 'unique:users'],
            'password' => ['required', 'min:8'],
        ]);
        $existingUser = User::where('name', $request->input('name'))->first();
        if (!$existingUser) {
            User::create(['role' => 2, 'name' => $request->input('name'), 'email' => $request->input('email'), 'password' => Hash::make($request->input('password')), 'department_id' => $request->input('department_id')]);
            return Redirect::route('department')->with(['status' => 'success', 'message' => 'Successfully added a new user : ' . $request->input('name')]);
        }
        return Redirect::route('department')->with(['status' => 'error', 'message' => 'This user : ' . $request->input('name') . ' is already created. try another one!']);
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
                    History::create(['document_id' => $document->id, 'status' => 'in-review', 'notes' => 'Your application are currently being processed. Please be patient as we meticulously review each detail to ensure accuracy and quality.']);
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

    // get department user
    public function departmentUser()
    {
        $departmentUsers = User::where('role', '!=', 0)->where('name', '!=', Auth::user()->name)->with('department')->get();
        // dd($departmentUsers);
        return response()->json(['departmentUsers' => $departmentUsers]);
    }

    // outgoing document's 
    public function outgoing(Request $request)
    {
        // dd($request);
        // this is the prpoblem on forwarding
        $markAsForwarded = ForwardToDept::where('document_id', $request->input('document_id'))->where('receiver_id', Auth::user()->id)->where('isForwarded', 0)->first();
        if ($markAsForwarded) {
            $markAsForwarded->update(['isForwarded' => true]);
        }
        [$userId, $dept] = explode("|", $request->input('user_id'));
        $ftp = ForwardToDept::create(['sender_id' => Auth::user()->id, 'receiver_id' => $userId, 'document_id' => $request->input('document_id')]);
        DepartmentComment::create(['forward_to_depts_id' => $ftp->id, 'department_comment' => $request->input('message'), 'sender_id' => Auth::user()->id, 'receiver_id' => $userId, 'document_id' => $request->input('document_id')]);
        Document::where('id', $request->input('document_id'))->update(['isForwarded' => 1]);
        History::create(['document_id' => $request->input('document_id'), 'status' => 'forwarded', 'notes' => "Your application is forwarded to department name " . $dept]);
        Status::where('id', $request->input('document_id'))->update(['status' => 'forwarded']);
        Session::flash('pop-message', 'Your successfully sent this document to ' . $dept);
        return redirect()->back()->withInput();
    }
}
