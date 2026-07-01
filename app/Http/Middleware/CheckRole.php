<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        
        if (in_array($user->role, $roles)) {
            return $next($request);
        }

        // If unauthorized, redirect to respective dashboard
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard')->with('error', 'Akses ditolak.');
        }

        return redirect()->route('anggota.dashboard')->with('error', 'Akses ditolak.');
    }
}
