@extends('layouts.main')

@section('konten')
    
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800">Halaman {{ $title }}</h1>

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
                        <form action="{{ route('supplier.store') }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="nama_supplier">Nama Supplier</label>
                                        <input type="text" class="form-control" name="nama_supplier" id="nama_supplier">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="telepon">Nomor Telepon</label>
                                        <input type="tel" class="form-control" name="telepon" id="telepon">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="alamat_supplier">Alamat Supplier</label>
                                <input type="text" class="form-control" name="alamat_supplier" id="alamat_supplier">
                            </div>
                            <button class="btn btn-primary btn-md">Simpan data</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>

    </div>

@endsection