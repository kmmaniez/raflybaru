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
                <div class="row">
                    <div class="col-lg-10">
                        <form action="/laporan-masuk" method="POST">
                            @csrf
                            <div class="row mb-4">
                                <div class="col-lg">
                                    <label for="start">Tanggal Mulai</label>
                                    <input type="date" class="form-control" name="start" id="">
                                </div>
                                <div class="col-lg">
                                    <label for="end">Tanggal Akhir</label>
                                    <input type="date" class="form-control" name="end" id="">
                                </div>
                                <div class="col-lg">
                                    <label for="" class="d-block" style="visibility: hidden">Search</label>
                                    <button class="btn btn-md btn-primary"><i class="fas fa-fw fa-filter"></i>Filter Data</button>
                                    <button type="reset" class="btn btn-md btn-default">Reset</button>
                                    </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-lg-2">
                        <form action="/export-pdf" method="post">
                            @csrf
                            <input type="hidden" name="startdate" value="{{ $startdate ? $startdate : '' }}">
                            <input type="hidden" name="enddate" value="{{ $enddate ? $enddate : ''  }}">
                            @if ($status === true)
                            <label for="end" class="d-block" style="visibility: hidden">Export </label>
                            <button class="btn btn-md btn-success text-decoration-none"><i class="fas fa-fw fa-file-pdf"></i> Export Data</button>
                            {{-- <a href="/export-pdf" class="btn btn-md btn-success text-decoration-none"><i class="fas fa-fw fa-file-pdf"></i> Export Data</a> --}}
                            @endif
                        </form>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Nomor</th>
                                <th>Nama supplier</th>
                                <th>Nama Barang</th>
                                <th>Warna</th>
                                <th>Ukuran</th>
                                <th>Stok</th>
                                <th>Tanggal Masuk</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($lapmasuk as $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data->supplier->nama }}</td>
                                <td>{{ $data->product->nama_produk }}</td>
                                <td>{{ $data->warna }}</td>
                                <td>{{ $data->ukuran }}</td>
                                <td>{{ $data->stok }}</td>
                                <td>{{ $data->tgl_masuk }}</td>
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