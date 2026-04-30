<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class SessionSecurityMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $userAgent = $request->userAgent();
            $ipAddress = $request->ip();

            if (!Session::has('session_user_agent')) {
                Session::put('session_user_agent', $userAgent);
                Session::put('session_ip_address', $ipAddress);
                Session::put('session_login_time', time());
            } else {
                if (Session::get('session_user_agent') !== $userAgent || Session::get('session_ip_address') !== $ipAddress) {
                    Auth::logout();
                    Session::invalidate();
                    Session::regenerateToken();
                    abort(403, 'Session hijacking detected.');
                }

                if (time() - Session::get('session_login_time') > 28800) { // 8 hours = 28800 seconds
                    Auth::logout();
                    Session::invalidate();
                    Session::regenerateToken();
                    return redirect()->route('login')->withErrors(['email' => 'Session expired. Please log in again.']);
                }
            }
        }

        return $next($request);
    }
}
