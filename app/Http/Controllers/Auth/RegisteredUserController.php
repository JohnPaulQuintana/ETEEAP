<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'course' => ['required', 'string'],    // Validation rules for course
            'education' => ['required', 'string'], // Validation rules for education
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'course' => $request->course,       // Assign value of course field
            'education' => $request->education, // Assign value of education field
        ]);

        event(new Registered($user));

        Auth::login($user);

        // return redirect(RouteServiceProvider::HOME);
        // Redirect users based on their roles
        if ($user->role === 1) {
            return redirect()->intended(RouteServiceProvider::AdminDashboard);
        } elseif ($user->role === 2) {
            return redirect()->intended(RouteServiceProvider::DepartmentDashboard);
        } else {
            return redirect()->intended(RouteServiceProvider::UserDashboard);
        }
    }
}
