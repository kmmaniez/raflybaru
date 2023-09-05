<?php

use App\Http\Controllers\BarangController;
use App\Http\Controllers\BarangReturController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SupplierController;
use App\Models\BarangKeluar;
use App\Models\BarangMasuk;
use App\Models\Product;
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

// LOGIN & LOGOUT
Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    
    // STATISTIK DASHBOARD
    Route::get('/', function () {
        return view('admin.dashboard',[
            'total_product'     => Product::all()->count(),
            'total_brg_masuk'   => BarangMasuk::all()->count(),
            'total_brg_keluar'  => BarangKeluar::all()->count(),
            'total_laporan'     => BarangMasuk::all()->count() + BarangKeluar::all()->count()
        ]);
    });

    /* HEREEE */
    Route::prefix('barang-retur')->group(function () {
        
        Route::get('/',[BarangReturController::class, 'index']);
        Route::get('/create',[BarangReturController::class, 'create']);
    });

    // URL KHUSUS PRODUCTS
    Route::resource('products', ProductController::class)
            ->only(['index','create','store','edit','update','destroy']);
    
    // URL KHUSUS BARANG MASUK
    Route::resource('/barang-masuk', BarangController::class)
            ->only(['index','create','store','edit','update','destroy']);
    
    // URL KHUSUS BARANG KELUAR
    Route::prefix('barang-keluar')->group(function () {
    
        Route::get('/', [BarangController::class, 'index_brg_keluar']); // HALAMAN AWAL TABEL
    
        Route::get('tambah-barang', [BarangController::class, 'create_brg_keluar']); // HALAMAN TAMBAH BRG
        Route::post('tambah-barang', [BarangController::class, 'store_brg_keluar']); // PROSES SIMPAN BRG
        
        Route::get('{barang_keluar}/edit', [BarangController::class, 'edit_brg_keluar']); // HALAMAN EDIT BRG
        Route::put('{barang_keluar}', [BarangController::class, 'update_brg_keluar']); // PROSES EDIT BRG
    
        Route::delete('/{barang_keluar}', [BarangController::class, 'destroy_brg_keluar']); // PROSES HAPUS BRG
    });

    // URL KHUSUS SUPPLIER
    Route::resource('supplier', SupplierController::class);

    // URL KHUSUS LAPORAN MASUK & PDF
    Route::get('/laporan-masuk', [BarangController::class, 'LapmasukfilterByDate'] );
    Route::post('/laporan-masuk', [BarangController::class, 'LapmasukfilterByDate']);
    Route::post('/lapmasuk-exportpdf', [BarangController::class, 'LapmasukexportToPDF']); //PDF
    
    // URL KHUSUS LAPORAN KELUAR & PDF
    Route::get('/laporan-keluar', [BarangController::class, 'LapkeluarfilterByDate']);
    Route::post('/laporan-keluar', [BarangController::class, 'LapkeluarfilterByDate']);
    Route::post('/lapkeluar-exportpdf', [BarangController::class, 'LapkeluarexportToPDF']); //PDF
});
