<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Role;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    use SoftDeletes;
    protected $table = 'tbl_user';

    protected $primaryKey = 'id_user';

    public $incrementing = false;

    protected $keyType = 'string';

    /**
     * Mass assignable
     */
    protected $fillable = [
        'id_user',
        'id_role',
        'email',
        'password',
    ];

    /**
     * Hidden field
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Casts
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'id_role', 'id_role');
    }

    public function stockOpname()
    {
        return $this->hasMany(
            StockOpname::class,
            'id_user',
            'id_user'
        );
    }

    /**
     * Untuk login pakai username, apa yakin? Kalau pakai email kan lebih umum, tapi kalau memang mau pakai username, bisa tambahkan method ini:
     *
     * public function getAuthIdentifierName()
     *{
     *    return 'username';
     *}
     */

}
