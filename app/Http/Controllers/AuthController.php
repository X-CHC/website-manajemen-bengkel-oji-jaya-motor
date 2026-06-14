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
            switch ($role) {
                case 'admin':  $route = 'dashboard.index'; break;
                case 'owner':  $route = 'laporan.index'; break;
                case 'kasir':  $route = 'transaksi.create'; break;
                case 'gudang': $route = 'barang.index'; break;
                default:       $route = 'login';
            }

            return redirect()->route($route)->with('success', 'Login berhasil');

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

        return redirect('/');
}
}
