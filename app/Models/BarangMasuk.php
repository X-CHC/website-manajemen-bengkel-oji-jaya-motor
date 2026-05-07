<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\DetailMasuk;


class BarangMasuk extends Model
{
    use SoftDeletes;

    protected $table = 'tbl_barang_masuk';
    protected $primaryKey = 'id_barang_masuk';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_barang_masuk',
        'id_po',
        'tanggal_masuk',
        'total_bayar',
        'bukti_bayar'
    ];

    public function po()
    {
        return $this->belongsTo(TransaksiPo::class, 'id_po', 'id_po');
    }

    public function detailMasuk()
    {
        return $this->hasMany(DetailMasuk::class, 'id_barang_masuk', 'id_barang_masuk');
    }
}
