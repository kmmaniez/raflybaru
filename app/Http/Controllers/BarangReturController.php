<?php

namespace App\Http\Controllers;

use App\Models\BarangMasuk;
use App\Models\MasterProduk;
use App\Models\Product;
use Illuminate\Http\Request;

class BarangReturController extends Controller
{
    public function index()
    {
        return view('admin.barang-retur.index', [
            'title'     => 'Data Barang Retur',
            'barangmasuk'   => BarangMasuk::all()
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
            'listwarna'     => $warna,
            'listukuran'    => $ukuran
        ]);
    }

    public function store(Request $request)
    {
        // $chekproduk = Product::query()
        //                 ->where('id_master','=', $request->input('id_master'))
        //                 ->where('warna','=', $request->input('warna'))
        //                 ->where('ukuran','=', $request->input('ukuran'))->get();

        // jika ada input produk yg sama, maka kembali / gaboleh
        // if ($chekproduk->isNotEmpty()) return back();

        // Product::create([
        //     'id_master'     => $request->input('id_master'),
        //     'warna'         => $request->input('warna'),
        //     'ukuran'        => $request->input('ukuran'),
        //     'stok'          => $request->input('stok')
        // ]);
        return redirect('/products');
    }
}
