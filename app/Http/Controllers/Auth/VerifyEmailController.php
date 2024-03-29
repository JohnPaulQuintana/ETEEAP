<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
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
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        // return redirect()->intended(RouteServiceProvider::HOME.'?verified=1');
        if ($user->role === 1) {
            return redirect()->intended(RouteServiceProvider::AdminDashboard.'?verified=1');
        } elseif ($user->role === 2) {
            return redirect()->intended(RouteServiceProvider::DepartmentDashboard.'?verified=1');
        } else {
            return redirect()->intended(RouteServiceProvider::UserDashboard.'?verified=1');
        }
    }
}
