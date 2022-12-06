<?php

use App\Http\Controllers\BarangController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SupplierController;
use App\Models\BarangKeluar;
use App\Models\BarangMasuk;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('admin.dashboard',[
        'total_product' => Product::all()->count(),
        'total_brg_masuk' => BarangMasuk::all()->count(),
        'total_brg_keluar' => BarangKeluar::all()->count(),
        'total_laporan' => BarangMasuk::all()->count() + BarangKeluar::all()->count()
    ]);
})->middleware('auth');

// login
Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// already login
Route::get('/dashboard', function(){
    return view('admin.dashboard');
})->middleware('auth');

Route::resource('products', ProductController::class)
        ->only(['index','create','store','edit','update','destroy']);

Route::resource('/barang-masuk', BarangController::class)
        ->only(['index','create','store','edit','update','destroy']);

Route::prefix('barang-keluar')->group(function () {

    Route::get('/', [BarangController::class, 'index_brg_keluar']); // HALAMAN AWAL TABEL

    Route::get('tambah-barang', [BarangController::class, 'create_brg_keluar']); // HALAMAN TAMBAH BRG
    Route::post('tambah-barang', [BarangController::class, 'store_brg_keluar']); // PROSES SIMPAN BRG
    
    Route::get('{barang_keluar}/edit', [BarangController::class, 'edit_brg_keluar']); // HALAMAN EDIT BRG
    Route::put('{barang_keluar}', [BarangController::class, 'update_brg_keluar']); // PROSES EDIT BRG

    Route::delete('/{barang_keluar}', [BarangController::class, 'destroy_brg_keluar']); // PROSES HAPUS BRG
});

Route::get('/laporan-masuk',[BarangController::class, 'filterByDate'] );
Route::post('/laporan-masuk',[BarangController::class, 'filterByDate'] );
// Route::post('/laporan-masuk', function(Request $request){
//     dd($request);
//     $brg = DB::table('barang_masuk')
//             ->whereBetween('tgl_masuk',[
//                 $request->input('start'),
//                 $request->input('end')
//             ])->get();
    
// });
Route::get('/laporan-keluar', function (){ // HALAMAN LAPORAN KELUAR
    return view('admin.laporan-keluar.index',[
        'title'         => 'Laporan Barang Keluar',
        'lapkeluar'     => BarangKeluar::all()
    ]);
});

Route::resource('supplier', SupplierController::class);

Route::get('/data', [ProductController::class, 'indexcetak']);
Route::get('/export/cetak_pdf', [ProductController::class, 'exportpdf']);

// Route::get('/export', [ProductController::class,'exportpdf']);