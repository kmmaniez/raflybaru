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
    // FITUR DONE ALL
    // public function __construct() {
    //     $this->authorize('tambah barang');
    // }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd(MasterProduk::all());
        return view('admin.products.index', [
            'title'     => 'Data Barang',
            'produk'    => Product::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $this->authorize('tambah barang');
        if (!auth()->user()->is_admin) {
            return redirect('/dashboard');
        }
        // $product = [
        //     'Hem Pendek',
        //     'Hem Panjang',
        //     'Celana Pendek',
        //     'Celana Panjang',
        //     'Rok Plisir',
        //     'Rok TP',
        //     'Celana Kempol',
        //     'Hem Pramuka'
        // ];
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        // $this->authorize('tambah barang');
        // $exist = Product::query()
        //     ->where('nama_produk','=', $request->input('nama_produk'))
        //     ->where('warna','=',  $request->input('warna'))
        //     ->where('ukuran','=', $request->input('ukuran'))->get();
        // if ($exist->isNotEmpty()) {
        //     return back();
        // }
        Product::create([
            'id_master'     => $request->input('id_master'),
            'warna'         => $request->input('warna'),
            'ukuran'        => $request->input('ukuran'),
            'stok'          => $request->input('stok')
        ]);
        return redirect(route('products.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    // public function show(Product $product)
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {   
        // dd($product);
        // $this->authorize('tambah barang');
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        // $this->authorize('tambah barang');
        
        $validated = $request->validate([
            'nama_produk'   => 'required|string|max:15',
            'warna'         => 'required',
            'ukuran'        => 'required',
            'stok'          => 'required',
        ]);
        Product::where('id', $product->id)->update($validated);
        return redirect(route('products.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        // $this->authorize('tambah barang');
        
        Product::destroy($product->id);
        return redirect(route('products.index'));
    }

    public function indexcetak()
    {
        return view('index', [
            'products' => Product::all()
        ]);
    }

    public function exportpdf()
    {
        $data = Product::all();
        
        $pdf = PDF::loadView('cetak-laporan',['data' => $data]);
        return $pdf->download('user.pdf');
        # code...
    }
}
