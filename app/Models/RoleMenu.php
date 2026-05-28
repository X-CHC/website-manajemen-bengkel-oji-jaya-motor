<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoleMenu extends Model
{
    use SoftDeletes;

    protected $table = 'tbl_role_menu';

    protected $primaryKey = 'id_role_menu';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id_role_menu',
        'id_role',
        'id_menu',
        'can_access',
    ];

    public function role()
    {
        return $this->belongsTo(
            Role::class,
            'id_role',
            'id_role'
        );
    }

    public function menu()
    {
        return $this->belongsTo(
            Menu::class,
            'id_menu',
            'id_menu'
        );
    }
}
