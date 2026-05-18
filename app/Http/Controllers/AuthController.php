<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'password.required' => 'Password wajib diisi',
        ]);

        if (Auth::attempt($credentials)) {

            $request->session()->regenerate();

            /*
            |--------------------------------------------------------------------------
            | AMBIL ROLE USER
            |--------------------------------------------------------------------------
            */
            $role = strtolower(Auth::user()->role->nama_role ?? '');

            /*
            |--------------------------------------------------------------------------
            | REDIRECT BERDASARKAN ROLE
            |--------------------------------------------------------------------------
            */
            if ($role == 'admin') {
                return redirect()->route('dashboard.index');
            }

            if ($role == 'owner') {
                return redirect()->route('laporan.index');
            }

            if ($role == 'kasir') {
                return redirect()->route('transaksi.create');
            }

            if ($role == 'gudang') {
                return redirect()->route('barang.index');
            }

            /*
            |--------------------------------------------------------------------------
            | FALLBACK
            |--------------------------------------------------------------------------
            */
            return redirect()->route('dashboard.index');
        }

        return back()
            ->withInput()
            ->withErrors([
                'email' => 'Email atau password salah',
            ]);
    }


    public function logout(Request $request)
    {
        Auth::logout(); // hapus auth user

        $request->session()->invalidate(); // hapus semua session
        $request->session()->regenerateToken(); // reset CSRF

        return redirect('/login');
}
}
