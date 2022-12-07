<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangMasuk extends Model
{
    use HasFactory;
    protected $table = 'barang_masuk';
    protected $fillable = [
        'id_master',
        'nama_supplier',
        'warna',
        'ukuran',
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
