<?php

namespace App\Http\Controllers;

use App\Models\AdditionalDocument;
use App\Models\Course;
use App\Models\Department;
use App\Models\Document;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class EteeapController extends Controller
{
    // go to dashboard v2
    public function dashboardV2(){
        $application = Document::with(['user', 'status', 'action'])
        ->leftJoin('courses', 'documents.course_id', '=', 'courses.id')
        ->select('documents.*', 'courses.available_course')
        ->latest()->get();
        return view('department.document', compact('application'));
    }

    // document opem
    public function document($id){
        $additionalDocument = AdditionalDocument::where('document_id', $id)->get();
        // dd($additionalDocument);
        $documents = Document::leftJoin('courses', 'documents.course_id', '=', 'courses.id')
        ->where('documents.id', $id)
        ->select('documents.*', 'courses.available_course as applied_for')
        ->with(['user', 'status', 
            'internal' => function ($query) {
                $query->leftJoin('users', 'internal_messages.sender_id', '=', 'users.id')
                    ->select('internal_messages.*', 'users.name')
                    ->latest(); // Orders the internal relationship from latest to oldest
            }
        ])
        ->first();
      // Convert the collection to an array
        $documentsArray = $documents->toArray();

        // Add key-value pair to the first index of the documents array
        // if ($documents->isNotEmpty()) {
            foreach ($additionalDocument as $key => $value) {
                $documentsArray[$value->document_name] = $value->path;
            }
            
        // }
        // dd($documentsArray);
        return view('department.openDocument', compact('documentsArray'));
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
            User::create(['role' => 2, 'name' => $request->input('name'), 'email' => $request->input('email'), 'password' => Hash::make($request->input('password')), 'department_id' => $request->input('department_id'), 'course_id'=> $request->input('add_course')]);
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
}
