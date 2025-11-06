<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSiswa
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu');
        }

        if (!auth()->user()->isSiswa()) {
            abort(403, 'Akses ditolak. Hanya Siswa yang dapat mengakses halaman ini.');
        }

        return $next($request);
    }
}