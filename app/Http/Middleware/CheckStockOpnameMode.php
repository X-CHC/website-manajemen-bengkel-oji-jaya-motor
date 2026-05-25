<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CheckStockOpnameMode
{
    public function handle(Request $request, Closure $next)
    {
        $modeStockOpname = Cache::get('stock_opname_mode', false);

        /*
        |--------------------------------------------------------------------------
        | JIKA MODE STOCK OPNAME MATI
        |--------------------------------------------------------------------------
        | Semua fitur berjalan normal.
        |--------------------------------------------------------------------------
        */
        if (!$modeStockOpname) {
            return $next($request);
        }

        /*
        |--------------------------------------------------------------------------
        | ROUTE YANG TETAP BOLEH DIAKSES SAAT MODE STOCK OPNAME AKTIF
        |--------------------------------------------------------------------------
        */
        if (
            $request->routeIs('stock-opname.*') ||
            $request->routeIs('logout')
        ) {
            return $next($request);
        }

        /*
        |--------------------------------------------------------------------------
        | BLOKIR FITUR LAIN
        |--------------------------------------------------------------------------
        */
        return redirect()
            ->route('stock-opname.create')
            ->with(
                'warning',
                'Mode stock opname sedang aktif. Fitur lain sementara dinonaktifkan.'
            );
    }
}
