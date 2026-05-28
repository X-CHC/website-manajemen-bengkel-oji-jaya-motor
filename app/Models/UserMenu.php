<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserMenu extends Model
{
    use SoftDeletes;

    protected $table = 'tbl_user_menu';

    protected $primaryKey = 'id_user_menu';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id_user_menu',
        'id_user',
        'id_menu',
        'can_access',
    ];

    public function user()
    {
        return $this->belongsTo(
            User::class,
            'id_user',
            'id_user'
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
