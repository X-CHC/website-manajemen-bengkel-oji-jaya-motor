<?php

use App\Models\Menu;
use App\Models\UserMenu;
use App\Models\RoleMenu;

if (! function_exists('punyaAksesMenu')) {

    function punyaAksesMenu($routeName, $user)
    {
        if (!$user) {
            return false;
        }

        $menu = Menu::where('route_name', $routeName)
            ->first();

        if (!$menu) {
            return false;
        }

        /*
        |--------------------------------------------------------------------------
        | CEK AKSES KHUSUS USER
        |--------------------------------------------------------------------------
        */
        $aksesUser = UserMenu::where('id_user', $user->id_user)
            ->where('id_menu', $menu->id_menu)
            ->first();

        if ($aksesUser) {
            return (bool) $aksesUser->can_access;
        }

        /*
        |--------------------------------------------------------------------------
        | CEK AKSES DEFAULT ROLE
        |--------------------------------------------------------------------------
        */
        return RoleMenu::where('id_role', $user->id_role)
            ->where('id_menu', $menu->id_menu)
            ->where('can_access', true)
            ->exists();
    }
}
