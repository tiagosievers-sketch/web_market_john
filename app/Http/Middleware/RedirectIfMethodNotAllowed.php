<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class RedirectIfMethodNotAllowed
{
    public function handle(Request $request, Closure $next)
    {
        try {
            return $next($request);
        } catch (MethodNotAllowedHttpException $e) {
            if ($request->is('auth/login')) {
                return redirect()->route('login.form');
            }
            throw $e;
        }
    }
}