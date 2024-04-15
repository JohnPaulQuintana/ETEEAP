<?php

namespace App\Http\Controllers;

use App\Models\AdditionalDocument;
use App\Models\AlertMessage;
use App\Models\Course;
use App\Models\Department;
use App\Models\Document;
use App\Models\EndorseApplication;
use App\Models\ForwardToDept;
use App\Models\History;
use App\Models\InternalMessage;
use App\Models\LastSender;
use App\Models\MarkAsEndorsed;
use App\Models\Status;
use App\Models\User;
use App\Notifications\SendEmailNotification;
use App\Notifications\SendRejectedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class EteeapController extends Controller
{
    // go to dashboard v2
    public function dashboardV2(){
        if (Auth::user()->isReceiver) {
            // dd($latestMessages);
            $application = Document::with(['user', 'status', 'action', 'forwardedTo' => function ($query) {
                $query->latest()->first();
            }])
            ->leftJoin('courses', 'documents.course_id', '=', 'courses.id')
            ->select('documents.*', 'courses.available_course')
            ->orderByDesc('created_at')
            ->get();
        }else{
            $forwadedApplicationToMe = EndorseApplication::where('receiver_id', Auth::user()->id)->get();
            // Extract document IDs from the collection
            $documentIds = $forwadedApplicationToMe->pluck('document_id')->toArray();

            // Fetch documents associated with the extracted document IDs
            $application = Document::with(['user', 'status', 'action', 'forwardedTo' => function ($query) {
                $query->latest()->first();
            }])
            ->leftJoin('courses', 'documents.course_id', '=', 'courses.id')
            ->select('documents.*', 'courses.available_course')
            ->whereIn('documents.id', $documentIds) // Filter by document IDs
            ->orderByDesc('created_at')
            ->get();
        }

        $latestMessages = AlertMessage::leftJoin('users', 'alert_messages.sender_id', '=', 'users.id')
                ->where('reciever_id', Auth::user()->id)
                ->select('alert_messages.*', 'users.name')
                ->latest()
                ->get()
                ->groupBy('sender_id')
                ->map(function ($messages) {
                    return $messages->first();
                });

        return view('department.document', compact('application', 'latestMessages'));
    }

    // document opem
    public function document($id){
        $myID = Auth::user()->id;
        $additionalDocument = AdditionalDocument::where('document_id', $id)->get();
        // dd($additionalDocument);
        $documents = Document::leftJoin('courses', 'documents.course_id', '=', 'courses.id')
        ->where('documents.id', $id)
        ->select('documents.*', 'courses.available_course as applied_for')
        ->with(['user', 'status', 
            'internal' => function ($query) {
                $query->leftJoin('users', 'internal_messages.sender_id', '=', 'users.id')
                    ->select('internal_messages.*', 'users.name')
                    ->orderByDesc('created_at'); // Orders the internal relationship from latest to oldest
            },
            'forwardedTo' => function ($query) {
                $query->latest()->first();
            }
        ])
        ->first();

        //external message
        $externalMessages = InternalMessage::leftJoin('users', 'internal_messages.sender_id', '=', 'users.id')
            ->where('document_id', $id)
            ->where('message_type', 'external')
            // ->where('user_id', $myID)
            ->select('internal_messages.*', 'users.name')
            ->orderByDesc('created_at')->get();
        // dd($externalMessages);
      // Convert the collection to an array
        $documentsArray = $documents->toArray();
        // Add key-value pair to the first index of the documents array
        // if ($documents->isNotEmpty()) {
            foreach ($additionalDocument as $key => $value) {
                $documentsArray[$value->document_name] = $value->path;
            }
            
        // }
        // dd($documentsArray['user_id']);
        
        return view('department.openDocument', compact('documentsArray', 'id', 'myID', 'externalMessages'));
    }
    //go to department section
    public function index(){
        $department = Department::where('id', Auth::user()->department_id)->first();

        $departmentList = DB::table('departments')
        ->leftJoin('users', 'departments.id', '=', 'users.department_id')
        ->select('departments.*', DB::raw('COUNT(users.id) as user_count'))
        ->where('departments.id', '!=', Auth::user()->department_id)
        ->groupBy('departments.id', 'departments.department_name')
        ->orderByDesc('departments.department_name')
        ->get();
        
        return view('department.department',['department'=>$department, 'department_list'=>$departmentList]);
    }

    public function users(Request $request, $id){
        $courses = Course::get();
        $department = Department::leftJoin('users', 'departments.id', '=', 'users.department_id')
        ->leftJoin('courses', 'users.course_id', '=', 'courses.id')
        ->where('departments.id', $id)
        ->select('departments.department_name','departments.id as dept_id', 'users.*', 'courses.available_course')
        ->get();

        // dd($department);
        return view('department.user',['department_users'=>$department, 'courses' => $courses]);
    }
  
    public function departmentStore(Request $request){
        // dd($request);
        $existingDept = Department::where('department_name', $request->input('department_name'))->first();
        if (!$existingDept) {
            Department::create(['department_name' => $request->input('department_name')]);
            return Redirect::route('eteeap.department')->with(['status' => 'success', 'message' => 'Successfully added a new department name : ' . $request->input('department_name')]);
        }
        return Redirect::route('eteeap.department')->with(['status' => 'error', 'message' => 'This department name : ' . $request->input('department_name') . ' is already created. try another one!']);
    }

    public function userStore(Request $request){
        // dd($request);
        $existingUser = User::where('name', $request->input('name'))->first();
        if (!$existingUser) {
            User::create(['role' => 2, 'end_user'=>$request->input('end_user') ,'name' => $request->input('name'), 'email' => $request->input('email'), 'password' => Hash::make($request->input('password')), 'department_id' => $request->input('department_id'), 'course_id'=> $request->input('add_course')]);
            return Redirect::route('eteeap.users', $request->input('department_id'))->with(['status' => 'success', 'message' => 'Successfully added a new user : ' . $request->input('name')]);
        }
        return Redirect::route('eteeap.users',$request->input('department_id'))->with(['status' => 'error', 'message' => 'This user : ' . $request->input('name') . ' is already created. try another one!']);
    }

    public function userEdit(Request $request){
        // dd($request);
        User::where('id', $request->input('user_id'))->update(['name'=>$request->input('name'), 'email'=>$request->input('email')]);
        return Redirect::route('eteeap.users', $request->input('department_id'))->with(['status' => 'success', 'message' => 'Successfully updated a user : ' . $request->input('name')]);
    }

    public function userDelete(Request $request){
        // dd($request);
        $id = $request->input('user_id');
        if ($id) {
            $deleted = User::destroy($id);
            return Redirect::route('eteeap.users', $request->input('department_id'))->with(['status' => 'success', 'message' => 'Successfully deleted a user : ' . $request->input('name')]);
        } else {
            return Redirect::route('eteeap.users',$request->input('department_id'))->with(['status' => 'error', 'message' => 'This user : ' . $request->input('name') . ' is undefined. try another one!']);
        }
    }

    public function endorse($id){
        // dd($id);
        $department = Department::where('id', '!=', Auth::user()->department_id)->with(['user'])->get();
        return response()->json(['departmentWithUsers'=>$department]);
    }

    public function endorseApplication(Request $request){
        // dd($request);
        EndorseApplication::create(['document_id'=>$request->input('document_id'), 'receiver_id'=>$request->input('endorse_user')]);
        AlertMessage::create(['reciever_id'=>$request->input('endorse_user'), 'sender_id'=>Auth::user()->id, 'notification'=>'A new application has been submitted for your consideration. Please review it at your earliest convenience.']);
        
        //Last department sender of application
        LastSender::create(['last_sender'=>Auth::user()->id, 'document_id'=>$request->input('document_id')]);
        // forwarded to
        MarkAsEndorsed::create(['document_id'=>$request->input('document_id'), 'receiver_id'=>$request->input('endorse_user')]);
        // update the forwarded columns 
        // Document::where('id', $request->input('document_id'))->update(['isForwarded'=>1]);
        return Redirect::route('eteeap.dashboard')->with(['status' => 'success', 'message' => 'Successfully forwarded']);
    }

    public function updateStatusApplication($id){
        // dd($id);
        $notifyUser = User::where('id', $id)->first();
        // dd($notifyUser);
        $documents = User::has('documents')->with('documents.status', 'documents.status.notes', 'documents.tvids')->find($id);
        // dd($documents);
        // Assuming there's a single document associated with the user
        // $document = $documents->documents->first();

        if ($documents) {
            foreach ($documents->documents as $document) {
                Status::where('id', $document->id)->update(['status' => 'in-review']);
                $existingRecord = History::where('document_id', $document->id)->where('status', 'in-review')->first();
                if (!$existingRecord) {
                    History::create(['document_id' => $document->id, 'status' => 'in-review', 'notes' => 'Your application is under review. Thank you for your patience.']);
                    // Build the email notification details
                    // Set the time zone to Asia/Manila
                    date_default_timezone_set('Asia/Manila');
                    $details = [
                        'subject' => "Notification: Your Application is Under Review.",
                        'greetings' => "Hi " . $notifyUser->name,
                        'body' => "We wanted to inform you that your application is currently under review by our team.",
                        'body1' => "This process may take some time as we carefully evaluate each application to ensure the best possible outcome.",
                        'body2' => "Date: " . date('Y-m-d'),
                        'body3' => "Time: " . date('h:i A'),
                        'body4' => "Rest assured that we will notify you promptly once a decision has been made regarding your application.",
                        'body5' => "In the meantime, we encourage you to explore our website for more information about our organization and the opportunities we offer.",
                        'body6' => "If you have any questions or concerns regarding your application, please feel free to contact us. Our team is here to assist you throughout the process.",
                        'body7' => "",
                        'body8' => "",
                        'actiontext' => 'Go to Dashboard',
                        'actionurl' => route('user-dashboard'),
                        'lastline' => 'Thank you for your patience and understanding. We appreciate your interest in our organization.',
                        'lastline2' => '',
                        'lastline3' => '',
                        'lastline4' => '',
                        'lastline5' => '',
                    ];

                    //send notification to a user 
                    Notification::send($notifyUser, new SendEmailNotification($details));
                }

                // dd($document->id);
                return response()->json(['status' => 'success']);
            }
        }
    }

    public function Application(Request $request)
    {
        // dd($request);
        date_default_timezone_set('Asia/Manila');
        $notes = '';
        $notifyUser = user::where('id', $request->input('user_id'))->first();
        $documents = User::has('documents')->with('documents.status', 'documents.status.notes', 'documents.tvids')->find($request->input('user_id'));
        if ($documents) {
            foreach ($documents->documents as $document) {
                Status::where('id', $document->id)->update(['status' => $request->input('type')]);
                $existingRecord = History::where('document_id', $document->id)->where('status', $request->input('type'))->first();
                if (!$existingRecord) {
                    switch ($request->input('type')) {
                        case 'accepted':
                            $notes = 'Your application has been accepted. An email containing the interview schedule will be sent to you shortly.';
                            break;
                        case 'rejected':
                            $notes = 'Your application is rejected.';
                            
                            $details = [
                                "greetings" => "Dear Ms/Mr " . $notifyUser->name . ",",
                                "body" => "We regret to inform you that your application has been rejected. We appreciate the time and effort you put into the application process.",
                                "lastline" => "Thank you for your cooperation.",
                                "actiontext" => "Available on Dashboard",
                                "actionurl" => route('user-dashboard'),
                            ];
                            
                            //send notification to a user 
                            Notification::send($notifyUser, new SendRejectedNotification($details));
                            break;
                        case 'in-review':
                            $notes = 'Your application is under review. Thank you for your patience.';

                           
                            $details = [
                                'subject' => "Notification: Your Application is Under Review.",
                                'greetings' => "Hi " . $notifyUser->name,
                                'body' => "We wanted to inform you that your application is currently under review by our team.",
                                'body1' => "This process may take some time as we carefully evaluate each application to ensure the best possible outcome.",
                                'body2' => "Date: " . date('Y-m-d'),
                                'body3' => "Time: " . date('h:i A'),
                                'body4' => "Rest assured that we will notify you promptly once a decision has been made regarding your application.",
                                'body5' => "In the meantime, we encourage you to explore our website for more information about our organization and the opportunities we offer.",
                                'body6' => "If you have any questions or concerns regarding your application, please feel free to contact us. Our team is here to assist you throughout the process.",
                                'body7' => "",
                                'body8' => "",
                                'actiontext' => 'Go to Dashboard',
                                'actionurl' => route('user-dashboard'),
                                'lastline' => 'Thank you for your patience and understanding. We appreciate your interest in our organization.',
                                'lastline2' => '',
                                'lastline3' => '',
                                'lastline4' => '',
                                'lastline5' => '',
                            ];

                            //send notification to a user 
                            Notification::send($notifyUser, new SendEmailNotification($details));
                            
                            break;
                        
                        default:
                            # code...
                            break;
                    }
                    
                    History::create(['document_id' => $document->id, 'status' => $request->input('type'), 'notes' => $notes]);
                }

               
            }

            
            return response()->json(['status' => 'success','type' => $request->input('type') , 'message' => 'successfully '.$request->input('type'), 'user_id' => $documents->id]);
        }

        // If no documents were found
        return response()->json(['status' => 'error', 'message' => 'No documents found for the user.']);
    }
}
