<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    // public function handle($request, Closure $next)
    // {
    //     if (auth()->guard('admin')->check()) {
    //         return $next($request);
    //     }

    //     if (request()->is('admin/login')) {
    //         if (auth()->guard('admin')->check()) {
    //             // Jika pengguna sudah memiliki sesi admin, dan mencoba mengakses halaman login, maka arahkan ke dashboard
    //             return redirect()->route('admin.dashboard')->with('error', 'Anda sudah memiliki sesi.');
    //         }
    //     }

    //     // Jika pengguna tidak memiliki sesi admin, arahkan ke halaman login
    //     return redirect()->route('admin.login')->with('error', 'Anda tidak memiliki sesi.');
    // }

    public function handle($request, Closure $next)
    {
        // Check if the user is authenticated as an admin
        if (auth()->guard('admin')->check()) {
            $user = auth()->guard('admin')->user();

            // Check if the admin user's status is 1
            if ($user->status == 1) {
                // If the status is 1, allow access to the requested route
                return $next($request);
            } else {
                // If the status is not 1, log out the user and redirect to the login page
                auth()->guard('admin')->logout();
                $request->session()->invalidate();
                return redirect()->route('admin.login')->with('info', 'Akunmu sudah tidak aktif.');
            }
        }

        // If the user is not authenticated as an admin, redirect to the login page
        return redirect()->route('admin.login')->with('warning', 'Kamu belum login.');
    }

}
