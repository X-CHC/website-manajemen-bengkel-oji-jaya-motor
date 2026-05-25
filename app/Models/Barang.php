<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Barang extends Model
{
    use SoftDeletes;

    protected $table = 'tbl_barang';
    protected $primaryKey = 'id_barang';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_barang',
        'id_kategori_barang',
        'nama_barang',
        'harga_beli',
        'harga_jual',
        'jumlah_barang',
        'alert_jumlah_barang'
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriBarang::class, 'id_kategori_barang', 'id_kategori_barang');
    }

    public function detailStockOpname()
    {
        return $this->hasMany(
            DetailStockOpname::class,
            'id_barang',
            'id_barang'
        );
    }
}
