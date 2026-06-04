<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ConfirmablePasswordController extends Controller
{
    public function show()
    {
        return response('', 200);
    }

    public function store(Request $request)
    {
        $request->validate(['password' => 'required']);

        $user = $request->user();

        if (! Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'Incorrect password']);
        }

        $request->session()->put('auth.password_confirmed_at', time());

        return redirect()->back();
    }
}
