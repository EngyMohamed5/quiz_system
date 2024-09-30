<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResendVerificationEmailController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = Auth::user();

        // Check if the user already has a verified email
        if ($user->hasVerifiedEmail()) {
            return redirect()->route('verification.notice')
                ->with('message', 'Your email is already verified.');
        }

        // Send the verification email
        $user->sendEmailVerificationNotification();

        return redirect()->route('verification.notice')
            ->with('message', 'Verification email has been resent!');
    }
}
