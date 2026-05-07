<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetailMasuk extends Model
{
    use SoftDeletes;

    protected $table = 'tbl_detail_masuk';
    protected $primaryKey = 'id_detail_masuk';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_detail_masuk',
        'id_barang_masuk',
        'id_barang',
        'jumlah_barang',
        'harga_beli',
        'sub_total'
    ];

    public function barangMasuk()
    {
        return $this->belongsTo(BarangMasuk::class, 'id_barang_masuk', 'id_barang_masuk');
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang', 'id_barang');
    }
}
