<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    use SoftDeletes;

    protected $table = 'tbl_menu';

    protected $primaryKey = 'id_menu';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id_menu',
        'nama_menu',
        'route_name',
        'icon',
        'urutan',
    ];

    public function roleMenu()
    {
        return $this->hasMany(
            RoleMenu::class,
            'id_menu',
            'id_menu'
        );
    }

    public function userMenu()
    {
        return $this->hasMany(
            UserMenu::class,
            'id_menu',
            'id_menu'
        );
    }
}
