<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetailPo extends Model
{
    use SoftDeletes;

    protected $table = 'tbl_detail_po';
    protected $primaryKey = 'id_detail_po';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['id_detail_po', 'id_po', 'id_barang', 'jumlah_po'];

    public function po()
    {
        return $this->belongsTo(Po::class, 'id_po', 'id_po');
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang', 'id_barang');
    }
}
