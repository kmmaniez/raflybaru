@extends('layouts.main')

@section('konten')
    
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800">Halamans {{ $title }}</h1>

        <!-- Content Row -->

        <div class="row">
            <!-- Area Chart -->
            <div class="col-xl-6 col-lg-12">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div
                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">{{ $title }}</h6>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <form action="{{ route('barang-masuk.store') }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="nama_supplier">Nama Supplier</label>
                                        <select name="nama_supplier" id="" class="form-control">
                                            <option value="none" selected>--- Pilih B Gudang ---</option>
                                            {{-- @foreach ($supplier as $sp)
                                                <option value="{{ $sp->id }}">{{ $sp->nama }}</option>
                                            @endforeach --}}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="id_master">Nama Kain</label>
                                        <select name="id_master" id="" class="form-control">
                                            <option value="none" selected>--- Pilih Kain ---</option>
                                            @foreach ($products as $product)
                                                <option value="{{ $product->id }}">{{ $product->nama_produk }}</option>
                                            @endforeach
                                        </select> 
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="warna">Warna</label>
                                        <select name="warna" id="" class="form-control">
                                            <option value="none" selected>--- Pilih Warna ---</option>
                                            @foreach ($listwarna as $warna)
                                                <option value="{{ $warna }}">{{ $warna }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="stok">Yard</label>
                                        <input type="number" min="0" class="form-control" name="stok" id="stok">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="stok">Stok</label>
                                        <input type="number" class="form-control" name="stok" id="stok">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="tgl_masuk">Tanggal Masuk</label>
                                        <input type="date" class="form-control" name="tgl_masuk" id="tgl_masuk">
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-primary btn-md">Simpan data</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>

    </div>

@endsection