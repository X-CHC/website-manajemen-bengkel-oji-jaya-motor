<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Barang;

class KategoriBarang extends Model
{
    use SoftDeletes;

    protected $table = 'tbl_kategori_barang';
    protected $primaryKey = 'id_kategori_barang';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['id_kategori_barang', 'nama_kategori'];

    public function barang()
    {
        return $this->hasMany(Barang::class, 'id_kategori_barang', 'id_kategori_barang');
    }
}
