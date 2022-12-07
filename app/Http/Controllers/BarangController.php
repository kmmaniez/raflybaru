<?php

namespace App\Http\Controllers;

use App\Models\BarangKeluar;
use App\Models\BarangMasuk;
use App\Models\MasterProduk;
use App\Models\Product;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BarangController extends Controller
{
    
    public function index() // VIEW TABLE BARANG MASUK
    {
        // $brg = DB::table('barang_masuk')->where('tgl_masuk','=','2022-11-29')->get();
        $brg = DB::table('barang_masuk')
            ->whereBetween('tgl_masuk',['2022-11-20','2022-11-29'])->get();
        // echo $brg->product->nama_produk;
        return view('admin.barang-masuk.index',[
            'title'         => 'Data Stok Barang Masuk',
            'barangmasuk'   => BarangMasuk::all()
        ]);
    }

    public function index_brg_keluar()
    {
        return view('admin.barang-keluar.index',[
            'title'         => 'Data Stok Barang Keluar',
            'barangkeluar'  => BarangKeluar::all()
        ]);
    }

    
    public function create() // VIEW CREATE BARANG MASUK
    {
        if (!auth()->user()->is_admin) {
            return redirect()->back();
        }
        $warna = ['Hijau','Merah','Hitam','Biru','Putih','Coklat','Abu'];
        $ukuran = [];
        for ($i=2; $i <= 35; $i++) { 
            array_push($ukuran, $i);
        }
        
        return view('admin.barang-masuk.create-brg-masuk', [
            'title'         => 'Tambah Barang Masuk',
            'products'      => MasterProduk::all(),
            'supplier'      => Supplier::all(),
            'listukuran'    => $ukuran,
            'listwarna'     => $warna
        ]);
    }

    public function create_brg_keluar()
    {
        // $this->authorize('tambah barang');
        $warna = ['Hijau','Merah','Hitam','Biru','Putih','Coklat','Abu'];
        $ukuran = [];
        for ($i=2; $i <= 35; $i++) { 
            array_push($ukuran, $i);
        }
        return view('admin.barang-keluar.create-brg-keluar', [
            'title'         => 'Tambah Barang Keluar',
            'products'      => Product::all(),
            'listukuran'    => $ukuran,
            'listwarna'     => $warna
        ]);
    }

    
    public function store(Request $request) // SIMPAN BARANG MASUK
    {
        // dd($request);
        $id_barang      = $request->input('id_master');
        $warna          = $request->input('warna');
        $ukuran         = $request->input('ukuran');
        $stokbaru       = $request->input('stok');
        $listProduk     = Product::query()
                            ->where('id_master','=',$id_barang)
                            ->where('warna','=',$warna)
                            ->where('ukuran','=',$ukuran)->get();
        $stoklama       = 0;
        foreach ($listProduk as $key) {
            $stoklama   = $key["stok"];
        }
        $hasilstokbaru       = $stoklama + $stokbaru;

        // cek produk kalau ada data, kalau tidak kembali
        if ($listProduk->isEmpty()) return back(); 
        
        // bikin barang masuk
        BarangMasuk::create([
            'id_master'     => $id_barang,
            'nama_supplier' => $request->input('nama_supplier'),
            'warna'         => $request->input('warna'),
            'ukuran'        => $request->input('ukuran'),
            'stok'          => $stokbaru,
            'tgl_masuk'     => $request->input('tgl_masuk')    
        ]);
        // update stok produk dari barang masuk
        Product::firstWhere('id_master',$id_barang)->update([
            'stok'          => $hasilstokbaru
        ]);
        
        return redirect('/barang-masuk');
    }

    public function store_brg_keluar(Request $request)
    {
        // $this->authorize('tambah barang');
        $id_barang      = $request->input('id_barang');
        $inputStokBaru  = $request->input('stok');
        $stokLama       = 0;

        $stokNow        = Product::query()->where('id','=',$id_barang)->get();
        foreach ($stokNow as $key) {
            $stokLama   = $key["stok"];
        }
        $stokbaru       = $stokLama - $inputStokBaru;
        if ($stokbaru < 0) return back();

        BarangKeluar::create([
            'nama_bgudang'  => $request->input('nama_bgudang'),
            'id_barang'     => $request->input('id_barang'),
            'warna'         => $request->input('warna'),
            'ukuran'        => $request->input('ukuran'),
            'stok'          => $request->input('stok'),
            'tgl_keluar'    => $request->input('tgl_keluar')    
        ]);
        Product::firstWhere('id',$id_barang)->update([
            'stok'          => $stokbaru
        ]);
        // DB::table('products')->where('id','=',$id_barang)->update([
        //     'stok'          => $stokbaru
        // ]);
        return redirect('/barang-keluar');
    }

    
    // public function show($id)
    // {
    //     //
    // }

    
    public function edit(BarangMasuk $barang_masuk) // VIEW EDIT BARANG MASUK
    {
        // $this->authorize('tambah barang');
        
        return view('admin.barang-masuk.edit-brg-masuk', [
            'title'     => 'Edit Barang Masuk',
            'brgmasuk'  => $barang_masuk,
            'products'  => Product::all()
        ]);
    }


    public function edit_brg_keluar(BarangKeluar $barang_keluar)
    {
        // $this->authorize('tambah barang');
        
        return view('admin.barang-keluar.edit-brg-keluar', [
            'title'     => 'Edit Barang Keluar',
            'brgkeluar' => $barang_keluar,
            'products'  => Product::all()
        ]);
    }

    
    public function update(Request $request, BarangMasuk $barang_masuk) // UPDATE BARANG MASUK
    {
        // $this->authorize('tambah barang');
        
        BarangMasuk::where('id', $barang_masuk->id)->update([
            'id_barang'     => $request->input('id_barang'),
            'nama_supplier' => $request->input('nama_supplier'),
            'warna'         => $request->input('warna'),
            'ukuran'        => $request->input('ukuran'),
            'stok'          => $request->input('stok'),
        ]);
        return redirect('/barang-masuk');
    }

    public function update_brg_keluar(Request $request, BarangKeluar $barang_keluar)
    {
        // $this->authorize('tambah barang');
        
        BarangKeluar::where('id', $barang_keluar->id)->update([
            'id_barang'     => $request->input('id_barang'),
            'nama_bgudang'  => $request->input('nama_bgudang'),
            'warna'         => $request->input('warna'),
            'ukuran'        => $request->input('ukuran'),
            'stok'          => $request->input('stok'),
        ]);
        return redirect('/barang-keluar');
    }

    
    public function destroy(BarangMasuk $barang_masuk) // HAPUS BARANG MASUK
    {
        $id_master      = $barang_masuk->id_master;
        $warna          = $barang_masuk->warna;
        $ukuran         = $barang_masuk->ukuran;
        $stoksekarang   = $barang_masuk->stok;

        $Produk         = Product::query()
                            ->where('id_master','=',$id_master)
                            ->where('warna','=',$warna)
                            ->where('ukuran','=',$ukuran)->get();
        // die;
        // echo $Produk[0]["stok"];
        // die;
        $stokLama = 0;
        foreach ($Produk as $key) {
            echo $key. '<br>';
            $stokLama = $key['stok'];
        }
        $updateStok = $stokLama - $stoksekarang;

        Product::firstWhere('id_master',$id_master)->update([
            'stok'          => $updateStok
        ]);
    
        BarangMasuk::destroy($barang_masuk->id);
        return redirect('/barang-masuk');
    }

    public function destroy_brg_keluar(BarangKeluar $barang_keluar)
    {
        // $this->authorize('tambah barang');
        
        BarangKeluar::destroy($barang_keluar->id);
        return redirect('/barang-keluar');
    }

    public function filterByDate(Request $request)
    { 
        $startDate  = $request->input('start');
        $endDate    = $request->input('end');

        if ($request->post()) {
            $hasilFilter = BarangMasuk::query()
                ->where('tgl_masuk','>=', $startDate)
                ->where('tgl_masuk','<=', $endDate)
                ->get();
            return view('admin.laporan-masuk.index',[
                'title'         => 'Laporan Barang Masuk',
                'lapmasuk'      => $hasilFilter,
                'status'        => true,
                'startdate'     => $startDate,
                'enddate'       => $endDate
            ]);
        }
        return view('admin.laporan-masuk.index',[
            'title'         => 'Laporan Barang Masuk',
            'status'        => false,
            'startdate'     => $startDate,
            'enddate'       => $endDate,
            'lapmasuk'      => BarangMasuk::all()
        ]);
    }

    public function exportToPDF(Request $request)
    {
        if($request->is_null) return redirect('/products');
        // dd($request);
        $startDate      = $request->input('startdate');
        $endDate        = $request->input('enddate');
        $hasilFilter    = BarangMasuk::query()
                            ->where('tgl_masuk','>=', '2022-12-06')
                            ->where('tgl_masuk','<=', '2022-12-09')
                            ->get();
        $pdf    = PDF::loadView('cetak-laporan',[
            'data'  => $hasilFilter 
        ]);
        return $pdf->download('laporan.pdf');
    }

    public function exportpdf()
    {
        $data = Product::all();
        return view('cetak-laporan');
        $pdf = PDF::loadView('cetak-laporan',['data' => $data]);
        return $pdf->download('user.pdf');
        # code...
    }
}
