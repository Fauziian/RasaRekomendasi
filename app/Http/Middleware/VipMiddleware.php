<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class VipMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check() || !Auth::user()->hasActiveVip()) {
            return redirect()->route('vip.index')->with('error', 'Fitur ini hanya untuk Member VIP.');
        }

        return $next($request);
    }
}
