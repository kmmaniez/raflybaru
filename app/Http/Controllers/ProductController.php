<?php

namespace App\Http\Controllers;

use App\Models\MasterProduk;
use App\Models\Product;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Exists;

use function PHPUnit\Framework\isEmpty;

class ProductController extends Controller
{

    public function index()
    {
        return view('admin.products.index', [
            'title'     => 'Data Barang',
            'produk'    => Product::all()
        ]);
    }

    public function create()
    {
        if (!auth()->user()->is_admin) {
            return redirect('/dashboard');
        }
        $warna = ['Hijau','Merah','Hitam','Biru','Putih','Coklat','Abu'];
        $ukuran = [];
        for ($i=2; $i <= 35; $i++) { 
            array_push($ukuran, $i);
        }
        return view('admin.products.create-product',[
            'title'         => 'Tambah Stok Barang',
            'products'      => MasterProduk::all(),
            'listwarna'     => $warna,
            'listukuran'    => $ukuran
        ]);
    }

    public function store(Request $request)
    {
        $chekproduk = Product::query()
                        ->where('id_master','=', $request->input('id_master'))
                        ->where('warna','=', $request->input('warna'))
                        ->where('ukuran','=', $request->input('ukuran'))->get();

        // jika ada input produk yg sama, maka kembali / gaboleh
        if ($chekproduk->isNotEmpty()) return back();

        Product::create([
            'id_master'     => $request->input('id_master'),
            'warna'         => $request->input('warna'),
            'ukuran'        => $request->input('ukuran'),
            'stok'          => $request->input('stok')
        ]);
        return redirect('/products');
    }

    // public function show(Product $product)
    // {
    //     //
    // }

    public function edit(Product $product)
    {   
        $warna = ['Hijau','Merah','Hitam','Biru','Putih','Coklat','Abu'];
        $ukuran = [];
        for ($i=2; $i <= 35; $i++) { 
            array_push($ukuran, $i);
        }
        return view('admin.products.edit-product', [
            'title'         => 'Edit Product',
            'produk'        => $product,
            'listwarna'     => $warna,
            'listukuran'    => $ukuran
        ]);
    }

    public function update(Request $request, Product $product)
    {
        // $validated = $request->validate([
        //     'nama_produk'   => 'required|string|max:15',
        //     'warna'         => 'required',
        //     'ukuran'        => 'required',
        //     'stok'          => 'required',
        // ]);
        // Product::where('id', $product->id)->update($validated);
        // return redirect(route('products.index'));
    }

    public function destroy(Product $product)
    {
        // Product::destroy($product->id);
        // return redirect(route('products.index'));
    }

}