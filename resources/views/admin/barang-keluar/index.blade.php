@extends('layouts.main')

@section('konten')
    
    <div class="container-fluid">
    
        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800">Halaman {{ $title }}</h1>

        @if('tambah barang')
        <a href="/barang-keluar/tambah-barang" class="btn btn-md btn-primary mb-4"><i class="fas fa-fw fa-user-plus"></i> {{ $title }}</a>
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
                                <th>Ukuran</th>
                                <th>Stok</th>
                                <th>Tanggal Keluar</th>
                                @if(auth()->user()->is_admin)
                                <th>Aksi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($barangkeluar as $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data->nama_bgudang }}</td>
                                <td>{{ $data->product->nama_produk }}</td>
                                <td>{{ $data->warna }}</td>
                                <td>{{ $data->ukuran }}</td>
                                <td>{{ $data->stok }}</td>
                                <td>{{ $data->tgl_keluar }}</td>
                                @if(auth()->user()->is_admin)
                                <td>
                                    <form action="/barang-keluar/{{ $data->id }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <a class="btn btn-sm btn-primary" href="/barang-keluar/{{ $data->id }}/edit">Edit</a>
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