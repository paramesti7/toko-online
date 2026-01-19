<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Symfony\Component\HttpFoundation\Response;

class adminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // WAJIB pakai guard admin
        if (!Auth::guard('admin')->check()) {

            if ($request->ajax()) {
                return response()->json([
                    'message' => 'Kamu bukan admin'
                ], 403);
            }

            Alert::toast('Silakan login sebagai admin', 'error');
            return redirect('/admin');
        }

        return $next($request);

        // if (auth()->check() && auth()->user()->is_admin) {
        //     return $next($request);
        // }

        // if ($request->ajax()) {
        //     return response()->json(['error' => 'Kamu bukan admin'], 403);
        // }

        // Alert::toast('Kamu bukan admin', 'error');
        // return redirect('/admin');
    }
}
