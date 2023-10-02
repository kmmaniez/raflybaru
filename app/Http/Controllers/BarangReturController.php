<?php

namespace App\Http\Controllers;

use App\Models\BarangMasuk;
use App\Models\BarangRetur;
use App\Models\MasterProduk;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;

class BarangReturController extends Controller
{
    public function index()
    {
        return view('admin.barang-retur.index', [
            'title'     => 'Data Barang Retur',
            'barangretur'   => BarangRetur::all()
        ]);
    }

    public function create()
    {
        if (!auth()->user()->is_admin) {
            return redirect('/dashboard');
        }
        $warna = ['coklat','merah','putih','ungu','biru','kuning','hijau','abu','hitam'];
        $ukuran = [];
        for ($i=2; $i <= 35; $i++) { 
            array_push($ukuran, $i);
        }
        return view('admin.barang-retur.create',[
            'title'         => 'Tambah Stok Barang Retur',
            'products'      => MasterProduk::all(),
            'supplier'      => Supplier::all(),
            'listwarna'     => $warna,
            'listukuran'    => $ukuran
        ]);
    }

    public function store(Request $request)
    {
        $id_kain        = $request->input('id_kain');
        $warna          = $request->input('warna');
        // $yard           = ;
        $stokbaru       = $request->input('stok');
        $yard =  (int) str_replace([' YARD',' yard',' Yard','YARD','yard','Yard'],'', $request->input('yard'));
        $listproduk     = Product::query()
                            ->where('id_master','=',$id_kain)
                            ->where('warna','=',$warna)
                            ->where('ukuran','=',$yard)->get();
        // dd($listproduk, $request->all());
        // cek produk kalau ada data, kalau tidak kembali
        if ($listproduk->isEmpty()) return back(); 

        $stoklama       = $listproduk[0]["stok"]; // ambil stok lama
        $hasilstokbaru  = $stoklama + $stokbaru; // tambah stok lama dgn inputan

        // bikin barang masuk
        BarangRetur::create([
            'id_master'     => $id_kain,
            'nama_supplier' => $request->input('nama_bgudang'),
            'warna'         => $warna,
            'yard'          => $yard,
            'stok'          => $stokbaru,
            'tgl_masuk'     => $request->input('tgl_masuk')    
        ]);

        // update stok produk dari barang masuk
        Product::query()
                ->where('id_master','=',$id_kain)
                ->where('warna','=',$warna)
                ->where('ukuran','=',$yard)
                ->update([
                    'stok'  => $hasilstokbaru
        ]);
        return redirect('/barang-retur');
    }
}
