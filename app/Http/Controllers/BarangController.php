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
        $warna = ['coklat','merah','putih','ungu','biru','kuning','hijau','abu','hitam'];
        // $warna = ['Hijau','Merah','Hitam','Biru','Putih','Coklat','Abu'];
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
        $warna = ['coklat','merah','putih','ungu','biru','kuning','hijau','abu','hitam'];

        // $warna = ['Hijau','Merah','Hitam','Biru','Putih','Coklat','Abu'];
        $ukuran = [];
        for ($i=2; $i <= 35; $i++) { 
            array_push($ukuran, $i);
        }
        return view('admin.barang-keluar.create-brg-keluar', [
            'title'         => 'Tambah Barang Keluar',
            'products'      => MasterProduk::all(),
            'listukuran'    => $ukuran,
            'listwarna'     => $warna
        ]);
    }

    
    public function store(Request $request) // SIMPAN BARANG MASUK
    {
        $id_barang      = $request->input('id_master');
        $warna          = $request->input('warna');
        $ukuran         = $request->input('ukuran');
        $stokbaru       = $request->input('stok');

        $listproduk     = Product::query()
                            ->where('id_master','=',$id_barang)
                            ->where('warna','=',$warna)
                            ->where('ukuran','=',$ukuran)->get();
        if ($listproduk->isEmpty()) echo 'he';
        
        // cek produk kalau ada data, kalau tidak kembali
        if ($listproduk->isEmpty()) return back(); 

        $stoklama       = $listproduk[0]["stok"]; // ambil stok lama
        $hasilstokbaru  = $stoklama + $stokbaru; // tambah stok lama dgn inputan

        // bikin barang masuk
        BarangMasuk::create([
            'id_master'     => $id_barang,
            'nama_supplier' => $request->input('nama_supplier'),
            'warna'         => $warna,
            'ukuran'        => $ukuran,
            'stok'          => $stokbaru,
            'tgl_masuk'     => $request->input('tgl_masuk')    
        ]);

        // update stok produk dari barang masuk
        Product::query()
                ->where('id_master','=',$id_barang)
                ->where('warna','=',$warna)
                ->where('ukuran','=',$ukuran)
                ->update([
                    'stok'  => $hasilstokbaru
        ]);
        return redirect('/barang-masuk');
    }

    public function store_brg_keluar(Request $request)
    {
        $id_barang      = $request->input('id_master');
        $stokbaru       = $request->input('stok');
        $warna          = $request->input('warna');
        $ukuran         = $request->input('ukuran');

        $listproduct    = Product::query()
                            ->where('id_master','=',$id_barang)
                            ->where('warna','=',$warna)
                            ->where('ukuran','=',$ukuran)->get();
        
        // cek produk kalau ada data, kalau tidak kembali
        if ($listproduct->isEmpty()) return back(); 
        
        $stoklama       = $listproduct[0]["stok"];
        $hasilstok      = $stoklama - $stokbaru;
        
        // cek hasil pengurangan stok lama dan baru, jika minus kembali
        if ($hasilstok < 0) return back();
        // cek hasil input baru jika lebih besar dari stok, kembali
        if ($stokbaru > $stoklama) return back();

        BarangKeluar::create([
            'id_master'     => $id_barang,
            'nama_bgudang'  => $request->input('nama_bgudang'),
            'warna'         => $warna,
            'ukuran'        => $ukuran,
            'stok'          => $stokbaru,
            'tgl_keluar'    => $request->input('tgl_keluar')    
        ]);

        Product::query()
                ->where('id_master','=',$id_barang)
                ->where('warna','=',$warna)
                ->where('ukuran','=',$ukuran)
                ->update([
                    'stok'  => $hasilstok
        ]);
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

        $listproduk     = Product::query()
                            ->where('id_master','=',$id_master)
                            ->where('warna','=',$warna)
                            ->where('ukuran','=',$ukuran)->get();

        $stoklama       = $listproduk[0]["stok"];
        $hasilstok      = $stoklama - $stoksekarang;

        // // jika hasil delete
        // if ($hasilstok < 0 ) return back();

        Product::query()
                ->where('id_master','=',$id_master)
                ->where('warna','=',$warna)
                ->where('ukuran','=',$ukuran)
                ->update([
                    'stok'  => $hasilstok
        ]);
        BarangMasuk::destroy($barang_masuk->id);
        return redirect('/barang-masuk');
    }

    public function destroy_brg_keluar(BarangKeluar $barang_keluar) // HAPUS BARANG KELUAR
    {
        $id_master      = $barang_keluar->id_master;
        $warna          = $barang_keluar->warna;
        $ukuran         = $barang_keluar->ukuran;
        $stoksekarang   = $barang_keluar->stok;

        $listproduk     = Product::query()
                            ->where('id_master','=',$id_master)
                            ->where('warna','=',$warna)
                            ->where('ukuran','=',$ukuran)->get();

        $stoklama       = $listproduk[0]["stok"];
        $hasilstok      = $stoksekarang + $stoklama;

        Product::query()
                ->where('id_master','=',$id_master)
                ->where('warna','=',$warna)
                ->where('ukuran','=',$ukuran)
                ->update([
                    'stok'  => $hasilstok
        ]);
        BarangKeluar::destroy($barang_keluar->id);
        return redirect('/barang-keluar');
    }

    /* FILTER LAPORAN BY DATE */
    public function LapmasukfilterByDate(Request $request)
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
    
    public function LapkeluarfilterByDate(Request $request)
    { 
        $startDate  = $request->input('start');
        $endDate    = $request->input('end');

        if ($request->post()) {
            $hasilFilter = BarangKeluar::query()
                ->where('tgl_keluar','>=', $startDate)
                ->where('tgl_keluar','<=', $endDate)
                ->get();
            return view('admin.laporan-keluar.index',[
                'title'         => 'Laporan Barang Keluar',
                'lapkeluar'     => $hasilFilter,
                'status'        => true,
                'startdate'     => $startDate,
                'enddate'       => $endDate
            ]);
        }
        return view('admin.laporan-keluar.index',[
            'title'         => 'Laporan Barang Keluar',
            'status'        => false,
            'startdate'     => $startDate,
            'enddate'       => $endDate,
            'lapkeluar'     => BarangKeluar::all()
        ]);
    }

    /* EXPORT PDF */
    public function LapmasukexportToPDF(Request $request)
    {
        if($request->is_null) return redirect('/products');
        // dd($request);
        $startDate      = $request->input('startdate');
        $endDate        = $request->input('enddate');
        $hasilFilter    = BarangMasuk::query()
                            ->where('tgl_masuk','>=', $startDate)
                            ->where('tgl_masuk','<=', $endDate)
                            ->get();
        $pdf    = PDF::loadView('cetak-lapmasuk',[
            'data'  => $hasilFilter 
        ]);
        return $pdf->download('laporan-masuk.pdf');
    }
    
    public function LapkeluarexportToPDF(Request $request)
    {
        if($request->is_null) return redirect('/products');
        // dd($request);
        $startDate      = $request->input('startdate');
        $endDate        = $request->input('enddate');
        $hasilFilter    = BarangKeluar::query()
                            ->where('tgl_keluar','>=', $startDate)
                            ->where('tgl_keluar','<=', $endDate)
                            ->get();
        $pdf    = PDF::loadView('cetak-lapkeluar',[
            'data'  => $hasilFilter 
        ]);
        return $pdf->download('laporan-keluar.pdf');
    }

}
