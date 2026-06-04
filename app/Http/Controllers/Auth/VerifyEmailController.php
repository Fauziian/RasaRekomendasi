<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Verified;

class VerifyEmailController extends Controller
{
    public function __invoke(Request $request, $id, $hash)
    {
        $user = User::findOrFail($id);

        if (sha1($user->email) !== $hash) {
            return response('', 403);
        }

        if (! $user->email_verified_at) {
            $user->email_verified_at = now();
            $user->save();
            Event::dispatch(new Verified($user));
        }

        return redirect()->route('dashboard', absolute: false)->with('verified', 1);
    }
}
