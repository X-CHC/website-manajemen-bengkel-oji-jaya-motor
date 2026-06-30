<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\DetailPo;


class Po extends Model
{
    use SoftDeletes;

    protected $table = 'tbl_po';
    protected $primaryKey = 'id_po';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_po',
        'tgl_po',
        'mitra_po',
        'status_po'
        ];

    public function detailPo()
    {
        return $this->hasMany(DetailPo::class, 'id_po', 'id_po');
    }
}
