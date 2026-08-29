<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetailStockOpname extends Model
{
    use SoftDeletes;

    protected $table = 'tbl_detail_stock_opname';

    protected $primaryKey = 'id_detail_stock_opname';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id_detail_stock_opname',
        'id_stock_opname',
        'id_barang',
        'stok_sistem',
        'stok_toko',
        'selisih',
        'alasan',
    ];

    public function stockOpname()
    {
        return $this->belongsTo(
            StockOpname::class,
            'id_stock_opname',
            'id_stock_opname'
        );
    }

    public function barang()
    {
        return $this->belongsTo(
            Barang::class,
            'id_barang',
            'id_barang'
        );
    }
}
