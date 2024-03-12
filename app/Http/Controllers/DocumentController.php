<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\User;
use App\Models\Status;
use App\Models\History;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            return response()->json(['status'=>"error", 'message' => "We found out that your already sent a document's to us, please wait for the authorized personel to reviewed it."]);
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
        $dataToInsert['reciever_id'] = 1; // admin


        // Insert into the database
        $insertedDocs = Document::create($dataToInsert);
        // history
        History::create(['document_id' => $insertedDocs->id, 'status'=>'pending', 'notes' => "Your Document's is successfully sent"]);
        Status::create(['document_id'=>$insertedDocs->id, 'status'=>'pending']);

        Note::create(['status_id'=>$insertedDocs->id, 'notes'=>"Document's is sumitted successfully, we will send a notification once its reviewed."]);
        // return response()->json(['status'=>'success', 'message'=>"Your document's successfully submitted, hava a nice day!"]);
       
         //for user 
         $mydocs = User::with(['documents.status','documents.status.notes', 'documents.tvids'])->where('id',Auth::user()->id)->get();
         // dd($mydocs);
         return view('users.dashboard', ['documents' => $mydocs]);
    }
}