<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class DepartmentController extends Controller
{
    public function dashboard(){
        // dd(Auth::user());
        $department = Department::where('id', Auth::user()->department_id)->first();
        // dd($department);
        return view('department.dashboard', ['department' => $department]);
    }
    public function index(Request $request){
        // dd($request);
        $existingDept = Department::where('department_name',$request->input('department'))->first();
        if(!$existingDept){
            Department::create(['department_name'=>$request->input('department')]);
            return Redirect::route('department')->with(['status'=>'success','message'=>'Successfully added a new department name : '.$request->input('department')]);
        }
        return Redirect::route('department')->with(['status'=>'error','message'=>'This department name : '.$request->input('department'). ' is already created. try another one!']);
        
    }
    public function user(Request $request){
        // dd($request);
        $request->validate([
            'department_id' => ['required'],
            'name' => ['required'],
            'email' => ['required', 'unique:users'],
            'password' => ['required', 'min:8'],
        ]);
        $existingUser = User::where('name',$request->input('name'))->first();
        if(!$existingUser){
            User::create(['role'=>2,'name'=>$request->input('name'), 'email' =>$request->input('email'), 'password' => Hash::make($request->input('password')), 'department_id'=>$request->input('department_id') ]);
            return Redirect::route('department')->with(['status'=>'success','message'=>'Successfully added a new user : '.$request->input('name')]);
        }
        return Redirect::route('department')->with(['status'=>'error','message'=>'This user : '.$request->input('name'). ' is already created. try another one!']);
        
    }
}
