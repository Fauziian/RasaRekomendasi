<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Illuminate\Auth\Notifications\ResetPassword;

class PasswordResetLinkController extends Controller
{
    public function create()
    {
        return response('', 200);
    }

    public function store(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();
        if ($user) {
            // Create a simple token and send via notification. Tests rely on the notification token.
            $token = Str::random(64);
            $user->notify(new ResetPassword($token));
        }

        return back();
    }
}
