<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX USER
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        $user = User::with('role')
            ->latest()
            ->get();

        return view('User.index', compact('user'));
    }


    /*
    |--------------------------------------------------------------------------
    | FORM CREATE USER
    |--------------------------------------------------------------------------
    */
    public function create()
    {
        $role = Role::orderBy('tingkat_role', 'asc')
            ->get();

        return view('User.create', compact('role'));
    }


    /*
    |--------------------------------------------------------------------------
    | SIMPAN USER
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $request->validate([
            'id_role' => 'required|exists:tbl_role,id_role',
            'email' => 'required|email|max:100|unique:tbl_user,email',
            'password' => 'required|min:3|confirmed',
        ], [
            'id_role.required' => 'Role wajib dipilih',
            'id_role.exists' => 'Role tidak valid',

            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.max' => 'Email maksimal 100 karakter',
            'email.unique' => 'Email sudah digunakan',

            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 3 karakter',
            'password.confirmed' => 'Konfirmasi password tidak sama',
        ]);

        DB::beginTransaction();

        try {

            /*
            |--------------------------------------------------------------------------
            | AUTO NUMBER USER
            |--------------------------------------------------------------------------
            | Pakai withTrashed supaya ID soft delete tetap terbaca.
            |--------------------------------------------------------------------------
            */
            $userTerakhir = User::withTrashed()
                ->orderBy('id_user', 'desc')
                ->first();

            if (!$userTerakhir) {
                $id_user = 'USR001';
            } else {
                $kode = $userTerakhir->id_user;

                $noUrut = (int) substr($kode, -3);

                $noUrut++;

                $id_user = 'USR' . sprintf('%03s', $noUrut);
            }

            /*
            |--------------------------------------------------------------------------
            | SIMPAN USER
            |--------------------------------------------------------------------------
            */
            User::create([
                'id_user' => $id_user,
                'id_role' => $request->id_role,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            DB::commit();

            return redirect()
                ->route('user.index')
                ->with('success', 'Akun berhasil dibuat');

        } catch (\Exception $e) {

            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }


    public function edit($id)
    {
        $user = User::findOrFail($id);

        $role = Role::orderBy('tingkat_role', 'asc')
            ->get();

        return view('User.edit', compact('user', 'role'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_role' => 'required|exists:tbl_role,id_role',
            'email' => 'required|email|max:100|unique:tbl_user,email,' . $id . ',id_user',
            'password' => 'nullable|min:3|confirmed',
        ], [
            'id_role.required' => 'Role wajib dipilih',
            'id_role.exists' => 'Role tidak valid',

            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.max' => 'Email maksimal 100 karakter',
            'email.unique' => 'Email sudah digunakan',

            'password.min' => 'Password minimal 3 karakter',
            'password.confirmed' => 'Konfirmasi password tidak sama',
        ]);

        DB::beginTransaction();

        try {

            $user = User::findOrFail($id);

            $data = [
                'id_role' => $request->id_role,
                'email' => $request->email,
            ];

            /*
            |--------------------------------------------------------------------------
            | UPDATE PASSWORD JIKA DIISI
            |--------------------------------------------------------------------------
            */
            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password);
            }

            $user->update($data);

            DB::commit();

            return redirect()
                ->route('user.index')
                ->with('success', 'Data akun berhasil diupdate');

        } catch (\Exception $e) {

            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }


    public function destroy($id)
    {
        DB::beginTransaction();

        try {

            /*
            |--------------------------------------------------------------------------
            | CEGAH USER MENGHAPUS AKUN SENDIRI
            |--------------------------------------------------------------------------
            */
            if (Auth::user()->id_user == $id) {
                return redirect()
                    ->route('user.index')
                    ->with('error', 'Akun yang sedang login tidak bisa dihapus');
            }

            $user = User::findOrFail($id);

            $user->delete();

            DB::commit();

            return redirect()
                ->route('user.index')
                ->with('success', 'Akun berhasil dihapus');

        } catch (\Exception $e) {

            DB::rollBack();

            return redirect()
                ->route('user.index')
                ->with('error', $e->getMessage());
        }
    }
}
