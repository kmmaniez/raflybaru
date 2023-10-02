<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangRetur extends Model
{
    use HasFactory;
    protected $table = 'barang_returs';
    protected $fillable = [
        'id_master',
        'nama_supplier',
        'warna',
        'yard',
        'stok',
        'tgl_masuk'
    ];

    
    public function masterproduk()
    {
        return $this->belongsTo(MasterProduk::class, 'id_master');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'nama_supplier');
    }
}
