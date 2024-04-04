<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\User;
use App\Models\Status;
use App\Models\History;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// use Illuminate\Notifications\Notification;

use App\Notifications\SendEmailNotification;
use Illuminate\Support\Facades\Notification;

class DocumentController extends Controller
{
    public function index(){
        //for admin
        // $mydocs = User::with(['documents.status'])->where('role',Auth::user()->role)->get();

        //for user 
        $mydocs = User::with(['documents.status','documents.status.notes', 'documents.tvids'])->where('id',Auth::user()->id)->get();
        // dd($mydocs);
        return view('users.dashboard', ['documents' => $mydocs]);
    }

    //store all the documents on storage facade
    public function store(Request $request){
        // dd($request);

        // Get the user's name or any unique identifier
        $userName = Auth::user()->name;

        $existingDocument = Document::where('user_id', Auth::user()->id)
            // ->where('status', ['approved', 'pending', 'in-review']) // Adjust the desired status
            ->first();
        if($existingDocument){
            return response()->json(['status'=>"error", 'message' => "We have noticed that you have already submitted an application to us. Please await review by the ETEEAP Department."]);
            // return "Document with ID already exists and has an approved status. Upload not allowed.";
        }

         // Handle the uploaded files
         $paths = [];

         $fileNames = [
            'loi', 'ce', 'cr', 'nce', 'hdt', 'f137_8', 'abcb', 'mc', 'nbc', 'tvid', 'ge', 'pc', 'rl', 'cgmc', 'cer',
        ];

        foreach ($fileNames as $fileName) {
            if ($request->hasFile($fileName)) {
                // Handle array-based file uploads for 'tvid'
                if ($fileName === 'tvid' && is_array($request->file($fileName))) {
                    foreach ($request->file($fileName) as $index => $file) {
                        $extension = $file->getClientOriginalExtension();
                        $uniqueFileName = $fileName . '_' . time() . '_' . $index . '.' . $extension;

                        $folderName = $userName;
                        $path = $file->storeAs("public/documents/$folderName", $uniqueFileName);
                        $paths[$fileName] = $path;
                    }
                } else {
                    $extension = $request->file($fileName)->getClientOriginalExtension();
                    $uniqueFileName = $fileName . '_' . time() . '.' . $extension;

                    $folderName = $userName;
                    $path = $request->file($fileName)->storeAs("public/documents/$folderName", $uniqueFileName);
                    $paths[$fileName] = $path;

                    
                }
            }
         }

         // Assuming $paths is your array of file paths
        $keysToInsert = ['loi', 'ce', 'cr', 'nce', 'hdt', 'f137_8', 'abcb', 'mc', 'nbc', 'ge', 'pc', 'rl', 'cgmc', 'cer'];

        $dataToInsert = [];

        foreach ($keysToInsert as $key) {
            // Check if the key exists in the $paths array
            if (array_key_exists($key, $paths)) {
                $dataToInsert[$key] = $paths[$key];
            }
        }

        // Include sender_id and receiver_id in the data to insert
        $dataToInsert['user_id'] = Auth::user()->id; // sender_id

        // get the first destination
        $firstDesitination = User::where('isReceiver', 1)->first();
        $dataToInsert['reciever_id'] = $firstDesitination->id; // eteeap


        // Insert into the database
        $insertedDocs = Document::create($dataToInsert);
        // history
        History::create(['document_id' => $insertedDocs->id, 'status'=>'pending', 'notes' => "Your application has been successfully sent."]);
        Status::create(['document_id'=>$insertedDocs->id, 'status'=>'pending']);

        Note::create(['status_id'=>$insertedDocs->id, 'notes'=>"The application has been submitted successfully. We will notify you once it has been reviewed."]);
        // return response()->json(['status'=>'success', 'message'=>"Your document's successfully submitted, hava a nice day!"]);
       
        // Get the administrator user
        $notifyUser = User::where('role', 1)->first();

        // Set the time zone to Asia/Manila
        date_default_timezone_set('Asia/Manila');

        // Prepare the notification details
        $details = [
            'greetings' => "Hello ".$notifyUser->name."!",
            'body' => "A new application has been submitted and is currently awaiting review by our team.",
            'body1' => "Please ensure to review the application promptly and thoroughly.",
            'body2' => "Sender Name: ". Auth::user()->name,
            'body3' => "Date: ". date('Y-m-d'),
            'body4' => "Time: ". date('h:i A'),
            'body5' => "Rest assured that you will be notified promptly once a decision has been made regarding the application.",
            
            // 'body5' => "",
            'body6' => "Thank you for your attention to this matter.",
            'body7' => "",
            'body8' => "",
            'actiontext' => 'Go to Dashboard',
            'actionurl' => route('admin-dashboard'), // Assuming 'admin.dashboard' is the route name for the admin dashboard
            'lastline' => 'Best regards, ETEEAP Application Tracking System',
            'lastline2' => '',
            'lastline3' => '',
            'lastline4' => '',
            'lastline5' => '',
        ];

        // Send the notification to the administrator
        Notification::send($notifyUser, new SendEmailNotification($details));
         //for user 
         $mydocs = User::with(['documents.status','documents.status.notes', 'documents.tvids'])->where('id',Auth::user()->id)->get();
         // dd($mydocs);
         return view('users.dashboard', ['documents' => $mydocs]);
    }
}
