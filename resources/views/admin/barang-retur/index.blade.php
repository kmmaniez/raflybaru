@extends('layouts.main')

@section('konten')
    
    <div class="container-fluid">
    
        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800">Halaman {{ $title }}</h1>

        @if(auth()->user()->is_admin)
        <a href="/barang-retur/create" class="btn btn-md btn-primary mb-4"><i class="fas fa-fw fa-user-plus"></i> {{ $title }}</a>
        @endif

        <!-- DataTables -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">{{ $title }}</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Nomor</th>
                                <th>Nama B Gudang</th>
                                <th>Nama Barang</th>
                                <th>Warna</th>
                                <th>Yard</th>
                                <th>Stok</th>
                                <th>Tanggal Masuks</th>
                                @if(auth()->user()->is_admin)
                                <th>Aksi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($barangretur as $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data->nama_supplier }}</td>
                                <td>{{ $data->masterproduk->nama_produk }}</td>
                                <td>{{ $data->warna }}</td>
                                <td>{{ $data->yard }} YARD</td>
                                <td>{{ $data->stok }}</td>
                                <td>{{ $data->tgl_masuk }}</td>
                                @if(auth()->user()->is_admin)
                                <td>
                                    <form action="/barang-masuk/{{ $data->id }}" method="post">
                                        @csrf
                                        @method('delete')
                                        {{-- <a class="btn btn-sm btn-primary" href="{{ route('barang-masuk.edit', $data->id) }}">Edit</a> --}}
                                        <button class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
                                </td>
                                @endif
                            </tr>
                            @empty
                            <tr class="text-center">
                                <td colspan="8">Data Kosong</td>
                            </tr> 
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
    </div>

@endsection