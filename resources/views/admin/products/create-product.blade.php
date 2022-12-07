@extends('layouts.main')

@section('konten')
    
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 mb-5 text-gray-800">Halaman {{ $title }}</h1>

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
                        <form action="{{ route('products.store') }}" method="post">
                            @csrf
                            <div class="row d-block">
                                <div class="col-lg-8">
                                    <div class="form-group">
                                        <label for="id_master">Barang</label>
                                        <select name="id_master" id="" class="form-control">
                                            <option value="none" selected>--- Pilih Barang ---</option>
                                            @foreach ($products as $product)
                                                <option value="{{ $product->id }}">{{ $product->nama_produk }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col">
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
                                        <div class="col">
                                            <div class="form-group">
                                                <label for="ukuran">Ukuran</label>
                                                <select name="ukuran" id="" class="form-control">
                                                    <option value="none" selected>--- Pilih Ukuran ---</option>
                                                    @foreach ($listukuran as $ukuran)
                                                        <option value="{{ $ukuran }}">{{ $ukuran }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group">
                                                <label for="stok">Stok</label>
                                                <input type="number" min="0" class="form-control" name="stok" id="stok">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    
                                </div>
                            </div>
                            <button class="btn btn-primary btn-md">Simpan Barang</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>

    </div>

@endsection