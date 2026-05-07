<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HistoryStok extends Model
{
    use SoftDeletes;

    protected $table = 'tbl_history_stok';
    protected $primaryKey = 'id_history_stok';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_history_stok',
        'id_barang',
        'jumlah_masuk',
        'jumlah_keluar',
        'jumlah_sisa',
        'jenis_stok',
        'jumlah_barang'
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang', 'id_barang');
    }
}
