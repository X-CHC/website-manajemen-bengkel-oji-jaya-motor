<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use SoftDeletes;

    protected $table = 'tbl_role';
    protected $primaryKey = 'id_role';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['id_role', 'nama_role', 'tingkat_role'];

    public function users()
    {
        return $this->hasMany(User::class, 'id_role', 'id_role');
    }
}
