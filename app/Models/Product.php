<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_master',
        'warna',
        'ukuran',
        'stok',
    ];

    public function masterproduk()
    {
        return $this->belongsTo(MasterProduk::class, 'id_master');
    }
}
