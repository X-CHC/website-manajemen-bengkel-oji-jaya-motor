<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Menu;
use App\Models\RoleMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;

class CheckStockOpnameMode
{
    public function handle(Request $request, Closure $next)
    {
        $modeStockOpname = Cache::get('stock_opname_mode', false);

        if (!$modeStockOpname) {
            return $next($request);
        }

        // Route yang tetap boleh diakses tanpa dicek lebih lanjut
        if (
            $request->routeIs('stock-opname.*') ||
            $request->routeIs('logout') ||
            $request->routeIs('login') ||
            $request->routeIs('login.*')
        ) {
            return $next($request);
        }

        if (!Auth::check()) {
            return $next($request);
        }

        $user = Auth::user();

        /*
        |--------------------------------------------------------------------------
        | CEK APAKAH ROLE USER PUNYA AKSES KE HALAMAN STOCK OPNAME
        |--------------------------------------------------------------------------
        */
        $menuStockOpname = Menu::where('route_name', 'stock-opname.create')->first();

        $bolehKeStockOpname = $menuStockOpname
            ? RoleMenu::where('id_role', $user->id_role)
                ->where('id_menu', $menuStockOpname->id_menu)
                ->where('can_access', true)
                ->exists()
            : false;

        if ($bolehKeStockOpname) {
            return redirect()
                ->route('stock-opname.create')
                ->with('warning', 'Mode stock opname sedang aktif. Fitur lain sementara dinonaktifkan.');
        }

        /*
        |--------------------------------------------------------------------------
        | ROLE TANPA AKSES STOCK OPNAME: LOGOUT PAKSA
        |--------------------------------------------------------------------------
        */
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('login')
            ->with('warning', 'Sistem sedang dalam mode Stock Opname. Silakan login kembali setelah proses selesai.');
    }
}
