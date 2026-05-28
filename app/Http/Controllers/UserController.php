<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\Menu;
use App\Models\RoleMenu;
use App\Models\UserMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $user = User::with('role')
            ->latest()
            ->get();

        return view('User.index', compact('user'));
    }


    public function create()
    {
        $role = Role::orderBy('tingkat_role', 'asc')
            ->get();

        $menu = Menu::orderBy('urutan', 'asc')
            ->get()
            ->groupBy(function ($item) {
                if (!$item->route_name) {
                    return 'lainnya';
                }

                return explode('.', $item->route_name)[0];
            });

        /*
        |--------------------------------------------------------------------------
        | DATA AKSES DEFAULT ROLE UNTUK JAVASCRIPT
        |--------------------------------------------------------------------------
        */
        $roleMenuMap = RoleMenu::where('can_access', true)
            ->get()
            ->groupBy('id_role')
            ->map(function ($items) {
                return $items->pluck('id_menu')->values();
            });

        return view(
            'User.create',
            compact(
                'role',
                'menu',
                'roleMenuMap'
            )
        );
    }


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
            | Akses tidak disimpan ke tbl_user_menu karena user baru otomatis
            | mengikuti default akses dari tbl_role_menu.
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

        $menu = Menu::orderBy('urutan', 'asc')
            ->get()
            ->groupBy(function ($item) {

                if (!$item->route_name) {
                    return 'lainnya';
                }

                return explode('.', $item->route_name)[0];
            });

        /*
        |--------------------------------------------------------------------------
        | AKSES DEFAULT SETIAP ROLE
        |--------------------------------------------------------------------------
        */
        $roleMenuMap = RoleMenu::where('can_access', true)
            ->get()
            ->groupBy('id_role')
            ->map(function ($items) {
                return $items->pluck('id_menu')->values();
            });

        /*
        |--------------------------------------------------------------------------
        | AKSES KHUSUS USER
        |--------------------------------------------------------------------------
        | Bentuk:
        | id_menu => can_access
        |--------------------------------------------------------------------------
        */
        $userMenuMap = UserMenu::where('id_user', $id)
            ->get()
            ->mapWithKeys(function ($item) {
                return [
                    $item->id_menu => (int) $item->can_access
                ];
            });

        return view(
            'User.edit',
            compact(
                'user',
                'role',
                'menu',
                'roleMenuMap',
                'userMenuMap'
            )
        );
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_role' => 'required|exists:tbl_role,id_role',
            'email' => 'required|email|max:100|unique:tbl_user,email,' . $id . ',id_user',
            'password' => 'nullable|min:3|confirmed',
            'id_menu' => 'nullable|array',
            'id_menu.*' => 'exists:tbl_menu,id_menu',
        ], [
            'id_role.required' => 'Role wajib dipilih',
            'id_role.exists' => 'Role tidak valid',

            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.max' => 'Email maksimal 100 karakter',
            'email.unique' => 'Email sudah digunakan',

            'password.min' => 'Password minimal 3 karakter',
            'password.confirmed' => 'Konfirmasi password tidak sama',

            'id_menu.*.exists' => 'Akses menu yang dipilih tidak valid',
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


            /*
            |--------------------------------------------------------------------------
            | HAPUS AKSES KHUSUS LAMA
            |--------------------------------------------------------------------------
            */
            UserMenu::where('id_user', $id)
                ->delete();


            /*
            |--------------------------------------------------------------------------
            | AMBIL SEMUA MENU
            |--------------------------------------------------------------------------
            */
            $semuaMenu = Menu::pluck('id_menu')
                ->toArray();


            /*
            |--------------------------------------------------------------------------
            | AKSES DEFAULT ROLE
            |--------------------------------------------------------------------------
            */
            $aksesDefaultRole = RoleMenu::where('id_role', $request->id_role)
                ->where('can_access', true)
                ->pluck('id_menu')
                ->toArray();


            /*
            |--------------------------------------------------------------------------
            | AKSES YANG DICENTANG DI FORM
            |--------------------------------------------------------------------------
            */
            $aksesDipilih = $request->id_menu ?? [];


            /*
            |--------------------------------------------------------------------------
            | AUTO NUMBER USER MENU
            |--------------------------------------------------------------------------
            */
            $userMenuTerakhir = UserMenu::withTrashed()
                ->orderBy('id_user_menu', 'desc')
                ->first();

            if (!$userMenuTerakhir) {
                $nomorUserMenu = 1;
            } else {
                $nomorUserMenu = (int) substr(
                    $userMenuTerakhir->id_user_menu,
                    -4
                ) + 1;
            }


            /*
            |--------------------------------------------------------------------------
            | SIMPAN HANYA YANG BERBEDA DARI DEFAULT ROLE
            |--------------------------------------------------------------------------
            |
            | Kondisi:
            | 1. Default role punya akses, tapi form tidak dicentang
            |    => simpan can_access = false
            |
            | 2. Default role tidak punya akses, tapi form dicentang
            |    => simpan can_access = true
            |
            | 3. Sama dengan default role
            |    => tidak perlu simpan ke tbl_user_menu
            |
            |--------------------------------------------------------------------------
            */
            foreach ($semuaMenu as $idMenu) {

                $defaultPunyaAkses = in_array($idMenu, $aksesDefaultRole);

                $userPilihAkses = in_array($idMenu, $aksesDipilih);

                /*
                |--------------------------------------------------------------------------
                | JIKA SAMA DENGAN DEFAULT ROLE, LEWATI
                |--------------------------------------------------------------------------
                */
                if ($defaultPunyaAkses == $userPilihAkses) {
                    continue;
                }

                $id_user_menu = 'UM' . sprintf('%04s', $nomorUserMenu);

                $nomorUserMenu++;

                UserMenu::create([
                    'id_user_menu' => $id_user_menu,
                    'id_user' => $id,
                    'id_menu' => $idMenu,
                    'can_access' => $userPilihAkses,
                ]);
            }

            DB::commit();

            return redirect()
                ->route('user.index')
                ->with('success', 'Data akun dan akses berhasil diupdate');

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
            | TIDAK BISA HAPUS AKUN YANG SEDANG LOGIN
            |--------------------------------------------------------------------------
            */
            if (Auth::user()->id_user == $id) {
                return redirect()
                    ->route('user.index')
                    ->with('error', 'Akun yang sedang login tidak bisa dihapus');
            }

            $user = User::findOrFail($id);

            /*
            |--------------------------------------------------------------------------
            | HAPUS AKSES KHUSUS USER
            |--------------------------------------------------------------------------
            */
            UserMenu::where('id_user', $id)
                ->delete();

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
