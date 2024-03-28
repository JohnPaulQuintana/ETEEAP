<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmailVerificationPromptController extends Controller
{
    /**
     * Display the email verification prompt.
     */
    public function __invoke(Request $request): RedirectResponse|View
    {
        $user = $request->user();
        if ($user->hasVerifiedEmail()) {
            // Redirect users based on their roles
            if ($user->role === 1) {
                return redirect()->intended(RouteServiceProvider::AdminDashboard.'?verified=1');
            } elseif ($user->role === 2) {
                return redirect()->intended(RouteServiceProvider::DepartmentDashboard.'?verified=1');
            } else {
                return redirect()->intended(RouteServiceProvider::UserDashboard.'?verified=1');
            }
        }else{
            return view('auth.verify-email');
        }
        // return $request->user()->hasVerifiedEmail()
        //             ? redirect()->intended(RouteServiceProvider::HOME)
        //             : view('auth.verify-email');
    }
}
