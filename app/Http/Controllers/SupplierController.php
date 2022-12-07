<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    
    public function index()
    {
        return view('admin.supplier.index', [
            'title'     => 'Data Supplier',
            'supplier'  => Supplier::all()
        ]);
    }

    public function create()
    {
        return view('admin.supplier.create', [
            'title' => 'Tambah Data Supplier'
        ]);
    }

    public function store(Request $request)
    {
        Supplier::create([
            'nama'      => $request->input('nama_supplier'),
            'telepon'   => $request->input('telepon')
        ]);
        return redirect('/supplier');
    }

    // public function show(Supplier $supplier)
    // {
    //     //
    // }

    // public function edit(Supplier $supplier)
    // {
    //     //
    // }

    // public function update(Request $request, Supplier $supplier)
    // {
    //     //
    // }

    public function destroy(Supplier $supplier)
    {
        Supplier::destroy($supplier->id);
        return redirect('/supplier');
    }
}
