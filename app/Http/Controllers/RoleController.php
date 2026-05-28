<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\Menu;
use App\Models\RoleMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX ROLE
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        $role = Role::orderBy('tingkat_role', 'asc')
            ->get();

        return view('Role.index', compact('role'));
    }


    /*
    |--------------------------------------------------------------------------
    | FORM CREATE ROLE
    |--------------------------------------------------------------------------
    */
    public function create()
    {
        $menu = Menu::orderBy('urutan', 'asc')
            ->get()
            ->groupBy(function ($item) {

                $route = $item->route_name;

                if (!$route) {
                    return 'Lainnya';
                }

                return explode('.', $route)[0];
            });

        return view('Role.create', compact('menu'));
    }


    /*
    |--------------------------------------------------------------------------
    | SIMPAN ROLE
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $request->validate([
            'nama_role' => 'required|max:50|unique:tbl_role,nama_role',
            'tingkat_role' => 'required|integer|min:1',
            'id_menu' => 'nullable|array',
            'id_menu.*' => 'exists:tbl_menu,id_menu',
        ], [
            'nama_role.required' => 'Nama role wajib diisi',
            'nama_role.unique' => 'Nama role sudah digunakan',
            'nama_role.max' => 'Nama role maksimal 50 karakter',

            'tingkat_role.required' => 'Tingkat role wajib diisi',
            'tingkat_role.integer' => 'Tingkat role harus berupa angka',
            'tingkat_role.min' => 'Tingkat role minimal 1',

            'id_menu.*.exists' => 'Menu yang dipilih tidak valid',
        ]);

        DB::beginTransaction();

        try {

            /*
            |--------------------------------------------------------------------------
            | AUTO NUMBER ROLE
            |--------------------------------------------------------------------------
            */
            $roleTerakhir = Role::withTrashed()
                ->orderBy('id_role', 'desc')
                ->first();

            if (!$roleTerakhir) {
                $id_role = 'RL0001';
            } else {
                $kode = $roleTerakhir->id_role;

                $noUrut = (int) substr($kode, -4);

                $noUrut++;

                $id_role = 'RL' . sprintf('%04s', $noUrut);
            }


            /*
            |--------------------------------------------------------------------------
            | SIMPAN ROLE
            |--------------------------------------------------------------------------
            */
            Role::create([
                'id_role' => $id_role,
                'nama_role' => strtolower($request->nama_role),
                'tingkat_role' => $request->tingkat_role,
            ]);


            /*
            |--------------------------------------------------------------------------
            | AUTO NUMBER ROLE MENU
            |--------------------------------------------------------------------------
            */
            $roleMenuTerakhir = RoleMenu::withTrashed()
                ->orderBy('id_role_menu', 'desc')
                ->first();

            if (!$roleMenuTerakhir) {
                $nomorRoleMenu = 1;
            } else {
                $nomorRoleMenu = (int) substr(
                    $roleMenuTerakhir->id_role_menu,
                    -4
                ) + 1;
            }


            /*
            |--------------------------------------------------------------------------
            | SIMPAN AKSES DEFAULT ROLE
            |--------------------------------------------------------------------------
            */
            if ($request->id_menu) {

                foreach ($request->id_menu as $idMenu) {

                    $id_role_menu = 'RM' . sprintf('%04s', $nomorRoleMenu);

                    $nomorRoleMenu++;

                    RoleMenu::create([
                        'id_role_menu' => $id_role_menu,
                        'id_role' => $id_role,
                        'id_menu' => $idMenu,
                        'can_access' => true,
                    ]);
                }
            }

            DB::commit();

            return redirect()
                ->route('role.index')
                ->with('success', 'Role dan akses berhasil ditambahkan');

        } catch (\Exception $e) {

            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }


    /*
    |--------------------------------------------------------------------------
    | FORM EDIT ROLE
    |--------------------------------------------------------------------------
    */
    public function edit($id)
    {
        $role = Role::findOrFail($id);

        $menu = Menu::orderBy('urutan', 'asc')
            ->get();

        $aksesRole = RoleMenu::where('id_role', $id)
            ->where('can_access', true)
            ->pluck('id_menu')
            ->toArray();

        return view(
            'Role.edit',
            compact(
                'role',
                'menu',
                'aksesRole'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE ROLE
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_role' => 'required|max:50|unique:tbl_role,nama_role,' . $id . ',id_role',
            'tingkat_role' => 'required|integer|min:1',
            'id_menu' => 'nullable|array',
            'id_menu.*' => 'exists:tbl_menu,id_menu',
        ], [
            'nama_role.required' => 'Nama role wajib diisi',
            'nama_role.unique' => 'Nama role sudah digunakan',
            'nama_role.max' => 'Nama role maksimal 50 karakter',

            'tingkat_role.required' => 'Tingkat role wajib diisi',
            'tingkat_role.integer' => 'Tingkat role harus berupa angka',
            'tingkat_role.min' => 'Tingkat role minimal 1',

            'id_menu.*.exists' => 'Menu yang dipilih tidak valid',
        ]);

        DB::beginTransaction();

        try {

            $role = Role::findOrFail($id);

            /*
            |--------------------------------------------------------------------------
            | UPDATE ROLE
            |--------------------------------------------------------------------------
            */
            $role->update([
                'nama_role' => strtolower($request->nama_role),
                'tingkat_role' => $request->tingkat_role,
            ]);


            /*
            |--------------------------------------------------------------------------
            | HAPUS AKSES LAMA
            |--------------------------------------------------------------------------
            */
            RoleMenu::where('id_role', $id)
                ->delete();


            /*
            |--------------------------------------------------------------------------
            | AUTO NUMBER ROLE MENU
            |--------------------------------------------------------------------------
            */
            $roleMenuTerakhir = RoleMenu::withTrashed()
                ->orderBy('id_role_menu', 'desc')
                ->first();

            if (!$roleMenuTerakhir) {
                $nomorRoleMenu = 1;
            } else {
                $nomorRoleMenu = (int) substr(
                    $roleMenuTerakhir->id_role_menu,
                    -4
                ) + 1;
            }


            /*
            |--------------------------------------------------------------------------
            | SIMPAN AKSES BARU
            |--------------------------------------------------------------------------
            */
            if ($request->id_menu) {

                foreach ($request->id_menu as $idMenu) {

                    $id_role_menu = 'RM' . sprintf('%04s', $nomorRoleMenu);

                    $nomorRoleMenu++;

                    RoleMenu::create([
                        'id_role_menu' => $id_role_menu,
                        'id_role' => $id,
                        'id_menu' => $idMenu,
                        'can_access' => true,
                    ]);
                }
            }

            DB::commit();

            return redirect()
                ->route('role.index')
                ->with('success', 'Role dan akses berhasil diupdate');

        } catch (\Exception $e) {

            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }


    /*
    |--------------------------------------------------------------------------
    | HAPUS ROLE
    |--------------------------------------------------------------------------
    */
    public function destroy($id)
    {
        DB::beginTransaction();

        try {

            $role = Role::findOrFail($id);

            /*
            |--------------------------------------------------------------------------
            | CEK ROLE SUDAH DIPAKAI USER
            |--------------------------------------------------------------------------
            */
            $dipakaiUser = User::where('id_role', $id)
                ->exists();

            if ($dipakaiUser) {
                return redirect()
                    ->route('role.index')
                    ->with(
                        'error',
                        'Role tidak bisa dihapus karena sudah digunakan oleh user'
                    );
            }

            /*
            |--------------------------------------------------------------------------
            | HAPUS AKSES DEFAULT ROLE
            |--------------------------------------------------------------------------
            */
            RoleMenu::where('id_role', $id)
                ->delete();

            /*
            |--------------------------------------------------------------------------
            | HAPUS ROLE
            |--------------------------------------------------------------------------
            */
            $role->delete();

            DB::commit();

            return redirect()
                ->route('role.index')
                ->with('success', 'Role berhasil dihapus');

        } catch (\Exception $e) {

            DB::rollBack();

            return redirect()
                ->route('role.index')
                ->with('error', $e->getMessage());
        }
    }
}
