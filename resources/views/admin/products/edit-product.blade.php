@extends('layouts.main')

@section('konten')

    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 mb-5 text-gray-800">Halaman {{ $title }}</h1>

        <!-- Content Row -->

        <div class="row">

            <!-- Area Chart -->
            <div class="col-xl-6 col-lg-6">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div
                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">{{ $title }}</h6>
                    </div>
                    <!-- Card Body -->
                    {{-- @dd($produk) --}}
                    <div class="card-body">
                        <form action="" method="post">
                            {{-- @dd($produk) --}}
                            {{-- {{ route('products.update', $produk) }} --}}
                            @method('put')
                            @csrf
                            <div class="row d-block">
                                <div class="col-lg-8">
                                    <div class="form-group">
                                        <label for="nama_produk">Barang</label>
                                        <input type="text" class="form-control" name="nama_produk" id="nama_produk" value="{{ old('nama_produk', $produk->nama_produk) }}">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group">
                                                <label for="warna">Warna</label>
                                                <input type="text" class="form-control" name="warna" id="warna" value="{{ old('warna', $produk->warna) }}" disabled>
                                                <select name="ukuran" id="" class="form-control">
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
                                                <input type="text" class="form-control" name="ukuran" id="ukuran" value="{{ old('ukuran',  $produk->ukuran) }}" disabled>
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
                                                <input type="text" class="form-control" name="stok" id="stok" value="{{ old('stok',  $produk->stok) }}">
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="col-lg-6">
                                    
                                </div>
                                <div class="col-lg-6">
                                    
                                </div>
                            </div>
                            <button class="btn btn-primary btn-md">Ubah Barang</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>

    </div>

@endsection