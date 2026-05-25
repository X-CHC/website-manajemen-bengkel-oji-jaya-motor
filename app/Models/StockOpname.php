<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StockOpname extends Model
{
    use SoftDeletes;

    protected $table = 'tbl_stock_opname';

    protected $primaryKey = 'id_stock_opname';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id_stock_opname',
        'id_user',
        'tanggal_opname',
    ];

    public function user()
    {
        return $this->belongsTo(
            User::class,
            'id_user',
            'id_user'
        );
    }

    public function detailStockOpname()
    {
        return $this->hasMany(
            DetailStockOpname::class,
            'id_stock_opname',
            'id_stock_opname'
        );
    }
}
