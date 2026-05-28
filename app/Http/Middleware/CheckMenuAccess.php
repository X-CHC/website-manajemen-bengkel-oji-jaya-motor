<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Menu;
use App\Models\UserMenu;
use App\Models\RoleMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class CheckMenuAccess
{
    public function handle(Request $request, Closure $next, $routeAkses = null)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        /*
        |--------------------------------------------------------------------------
        | ROUTE YANG DICEK
        |--------------------------------------------------------------------------
        */
        $routeName = $routeAkses ?: $request->route()?->getName();

        if (!$routeName) {
            return $this->redirectKeAksesPertama(
                $user,
                'Route tidak valid'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | CARI MENU BERDASARKAN ROUTE NAME
        |--------------------------------------------------------------------------
        */
        $menu = Menu::where('route_name', $routeName)
            ->first();

        if (!$menu) {
            return $this->redirectKeAksesPertama(
                $user,
                'Akses belum diatur untuk halaman ini'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | CEK AKSES KHUSUS USER
        |--------------------------------------------------------------------------
        | Jika ada data di tbl_user_menu, maka data ini lebih diprioritaskan
        | daripada akses default role.
        |--------------------------------------------------------------------------
        */
        $aksesUser = UserMenu::where('id_user', $user->id_user)
            ->where('id_menu', $menu->id_menu)
            ->first();

        if ($aksesUser) {
            if ($aksesUser->can_access) {
                return $next($request);
            }

            return $this->redirectKeAksesPertama(
                $user,
                'Akses ditolak. Kamu tidak memiliki izin membuka halaman ini',
                $routeName
            );
        }

        /*
        |--------------------------------------------------------------------------
        | CEK AKSES DEFAULT ROLE
        |--------------------------------------------------------------------------
        */
        $aksesRole = RoleMenu::where('id_role', $user->id_role)
            ->where('id_menu', $menu->id_menu)
            ->where('can_access', true)
            ->exists();

        if ($aksesRole) {
            return $next($request);
        }

        /*
        |--------------------------------------------------------------------------
        | AKSES DITOLAK
        |--------------------------------------------------------------------------
        */
        return $this->redirectKeAksesPertama(
            $user,
            'Akses ditolak. Kamu tidak memiliki izin membuka halaman ini',
            $routeName
        );
    }


    /*
    |--------------------------------------------------------------------------
    | REDIRECT KE AKSES PERTAMA USER
    |--------------------------------------------------------------------------
    | Supaya user yang tidak punya akses dashboard tidak muter redirect
    | ke dashboard terus-menerus.
    |--------------------------------------------------------------------------
    */
    private function redirectKeAksesPertama($user, $pesan, $routeSaatIni = null)
    {
        $routeTujuan = $this->routePertamaYangBisaDiakses($user, $routeSaatIni);

        if (!$routeTujuan) {
            abort(403, $pesan);
        }

        return redirect()
            ->route($routeTujuan)
            ->with('error', $pesan);
    }


    /*
    |--------------------------------------------------------------------------
    | CARI ROUTE PERTAMA YANG BISA DIAKSES
    |--------------------------------------------------------------------------
    | Prioritas:
    | 1. Akses khusus user dari tbl_user_menu
    | 2. Akses default role dari tbl_role_menu
    |--------------------------------------------------------------------------
    */
    private function routePertamaYangBisaDiakses($user, $routeSaatIni = null)
    {
        /*
        |--------------------------------------------------------------------------
        | CEK AKSES KHUSUS USER
        |--------------------------------------------------------------------------
        */
        $aksesUser = UserMenu::join(
                'tbl_menu',
                'tbl_user_menu.id_menu',
                '=',
                'tbl_menu.id_menu'
            )
            ->where('tbl_user_menu.id_user', $user->id_user)
            ->where('tbl_user_menu.can_access', true)
            ->orderBy('tbl_menu.urutan', 'asc')
            ->pluck('tbl_menu.route_name');

        foreach ($aksesUser as $routeName) {
            if (
                $routeName &&
                $routeName != $routeSaatIni &&
                Route::has($routeName)
            ) {
                return $routeName;
            }
        }


        /*
        |--------------------------------------------------------------------------
        | CEK AKSES DEFAULT ROLE
        |--------------------------------------------------------------------------
        */
        $aksesRole = RoleMenu::join(
                'tbl_menu',
                'tbl_role_menu.id_menu',
                '=',
                'tbl_menu.id_menu'
            )
            ->where('tbl_role_menu.id_role', $user->id_role)
            ->where('tbl_role_menu.can_access', true)
            ->orderBy('tbl_menu.urutan', 'asc')
            ->pluck('tbl_menu.route_name');

        foreach ($aksesRole as $routeName) {
            if (
                $routeName &&
                $routeName != $routeSaatIni &&
                Route::has($routeName)
            ) {
                return $routeName;
            }
        }

        return null;
    }
}
