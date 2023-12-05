<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
// use Illuminate\Routing\Controller;
use App\Models\User;
class VerificationController extends Controller 
{
    use VerifiesEmails;
    public function verify($user_id, Request $request) 
    {
        if (!$request->hasValidSignature()) {
            return view('verify_email_result',['message' => trans('api.email_verification_fail')]);
        }
        
        $user = User::findOrFail($user_id);
        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
        }

        return redirect('dashboard');
    }

    public function resend(Request $request) 
    {
        if ($request->user()->hasVerifiedEmail()) 
        {
            return response()->json(["msg" => "Email already verified."], 400);
        }
    
        $request->user()->sendEmailVerificationNotification();
        return response()->json(["msg" => "Email verification link sent on your email id"]);
    }
}
