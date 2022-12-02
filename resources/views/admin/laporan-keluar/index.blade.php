@extends('layouts.main')

@section('konten')
    
    <div class="container-fluid">
    
        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800">Halaman {{ $title }}</h1>
        
        <!-- DataTales -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">{{ $title }}</h6>
            </div>
            <div class="card-body">
                <form action="/laporan-keluar" method="POST">
                    @csrf
                    <div class="row mb-4">
                        <div class="col-lg-2">
                            <label for="start">Tanggal Mulai</label>
                            <input type="date" class="form-control" name="start" id="">
                        </div>
                        <div class="col-lg-2">
                            <label for="end">Tanggal Akhir</label>
                            <input type="date" class="form-control" name="end" id="">
                        </div>
                        <div class="col-lg-2">
                            <label for="" class="d-block" style="visibility: hidden">Search</label>
                            <button class="btn btn-md btn-primary">Search..</button>
                            <a class="btn btn-md btn-default" href="/laporan-keluar">Reset</a>
                        </div>
                    </div>
                </form>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Nomor</th>
                                <th>Nama B. Gudang</th>
                                <th>Nama Barang</th>
                                <th>Warna</th>
                                <th>Ukuran</th>
                                <th>Stok</th>
                                <th>Tanggal Keluar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($lapkeluar as $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data->nama_bgudang }}</td>
                                <td>{{ $data->product->nama_produk }}</td>
                                <td>{{ $data->warna }}</td>
                                <td>{{ $data->ukuran }}</td>
                                <td>{{ $data->stok }}</td>
                                <td>{{ $data->tgl_keluar }}</td>
                            </tr>
                            @empty
                            <tr class="text-center">
                                <td colspan="7">Data Kosong</td>
                            </tr> 
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
    </div>

@endsection 