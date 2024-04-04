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
use Illuminate\Support\Facades\Session;
use App\Notifications\SendEmailNotification;
use Illuminate\Support\Facades\Notification;
use App\Notifications\SendRejectedNotification;

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
                $subquery->whereNotIn('status', ['pending', 'rejected', 'in-review', 'forwarded']);
            });
        })->with(['documents.status', 'interview'])->get();


        return view('admin.accepted', ['documents' => $alldocs]);
    }
    public function declined()
    {

        $alldocs = User::whereHas('documents', function ($query) {
            $query->whereHas('status', function ($subquery) {
                $subquery->whereNotIn('status', ['pending', 'accepted', 'in-review', 'forwarded']);
            });
        })->with(['documents.status', 'interview'])->get();

        // dd($alldocs);

        return view('admin.declined',['documents' => $alldocs]);
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
            ->where('forward_to_depts.receiver_id', Auth::user()->id)
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
            ->orderByDesc('created_at')
            ->get();

        // dd($forwardedToMe);
        foreach ($forwardedToMe as $key => $value) {
            // $comments = DepartmentComment::join('users', 'users.id', '=', 'department_comments.sender_id')
            //     ->select('department_comments.*', 'users.name')
            //     ->where('forward_to_depts_id', $value->ftd_id)->get();
                $comments = DepartmentComment::join('users', 'users.id', '=', 'department_comments.sender_id')
                ->select('department_comments.*', 'users.name')
                ->where('document_id', $value->document_id)
                ->orderByDesc('created_at')
                ->get();
            foreach ($value->checked as $key => $v) {
                $resubmitted = CheckingDocument::where('action', 'declined')->where('document_id', $v->document_id)->with('reupload')->get();
            }
        }

        $acceptedApplicants = User::whereHas('documents', function ($query) {
            $query->whereHas('status', function ($subquery) {
                $subquery->whereNotIn('status', ['pending', 'rejected', 'in-review']);
            });
        })->with(['documents.status', 'interview'])->get();

        $declinedApplicants = User::whereHas('documents', function ($query) {
            $query->whereHas('status', function ($subquery) {
                $subquery->whereNotIn('status', ['pending', 'accepted', 'in-review']);
            });
        })->with(['documents.status', 'interview'])->get();

        $departmentCount = Department::count();

        // return view('admin.dashboard', ['documents' => $alldocs]);
        return view('admin.dashboard', [
            'forwardedDocuments' => $forwardedToMe, 
            'resubmitted' => $resubmitted ?? [], 
            'comments' => $comments ?? [], 
            'accepted' => count($acceptedApplicants),
            'declined' => count($declinedApplicants),
            'department' => $departmentCount,
        ]);
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
                    History::create(['document_id' => $document->id, 'status' => $request->input('type'), 'notes' => ($request->input('type') == 'accepted' ? ' Your application has been accepted, we will sending you an email for the interview.' : 'Your application is rejected.')]);
                }

                if($request->input('type') === 'rejected'){
                    $markAsForwarded = ForwardToDept::where('document_id', $document->id)->where('receiver_id',Auth::user()->id)->first();
                    if($markAsForwarded){
                        $markAsForwarded->update(['isForwarded'=>true]);
                        $notifyUser = user::where('id', $request->input('user_id'))->first();
                        $details = [
                            "greetings" => "Dear Ms/Mr " . $notifyUser->name . ",",
                            "body" => "We regret to inform you that your application has been rejected. We appreciate the time and effort you put into the application process.",
                            "lastline" => "Thank you for your cooperation.",
                            "actiontext" => "Available on Dashboard",
                            "actionurl" => route('user-dashboard'),
                        ];
                        
                        //send notification to a user 
                        Notification::send($notifyUser, new SendRejectedNotification($details));
                    }
                }
            }

            
            return response()->json(['status' => 'success', 'message' => 'successfully '.$request->input('type'), 'user_id' => $documents->id]);
        }

        // If no documents were found
        return response()->json(['status' => 'error', 'message' => 'No documents found for the user.']);
    }

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

    public function delete(Request $request){
        // dd($request->input('id'));
        $id = $request->input('id');
        if ($id) {
            $deleted = Department::destroy($id);
            return $deleted ? response()->json(['status'=>'success','message' => 'Department deleted successfully']) : response()->json(['status'=>'error','message' => 'Department not found']);
        } else {
            return response()->json(['status'=>'error','message' => 'Department not found'], 400);
        }
    }

    public function info(Request $request){
        // dd($request);

        $users = User::join('departments', 'departments.id', '=', 'users.department_id')
            ->where('users.id', $request->input('user_id'))
            ->select('users.*', 'departments.department_name', 'departments.id as dept_id')
            ->get();
            // dd($users);
        $depts = Department::whereNotIn('id', [$users[0]->department_id])->get();
        if($users){
            return response()->json(['status'=>'success', 'users'=>$users, 'depts'=>$depts]);
        }
        return response()->json(['status'=>'error', 'data'=>[], 'depts'=> []]);
    }

    public function update(Request $request){
        // dd($request);
        $isReceiver = User::where('isReceiver', 1)->update(['isReceiver'=>0]);
        // dd($isReceiver);

       
        // $isReceiver->update(['isReceiver',0]);
       
        $updated = User::where('id', $request->input('user_id'))
            ->update(['name'=>$request->input('name'), 'email'=>$request->input('email'), 'department_id'=>$request->input('dept'), 'isReceiver'=>$request->input('isReceiver')]);

        if($updated){
            return response()->json(['status'=>'success', 'message'=>'Successfully Updated']);
        }else{
            return response()->json(['status'=>'error', 'message'=>'Error Updating']);
        }
    }

    public function deleteUser(Request $request){
        // dd($request);
        $id = $request->input('user_id');
        if ($id) {
            $deleted = User::destroy($id);
            return $deleted ? response()->json(['status'=>'success','message' => 'User deleted successfully']) : response()->json(['status'=>'error','message' => 'Department not found']);
        } else {
            return response()->json(['status'=>'error','message' => 'User not found'], 400);
        }
    }
}
