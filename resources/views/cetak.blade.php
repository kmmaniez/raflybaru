<h1 class="display-4">Data Karyawan</h1>
<table class="table" border="1">
    <thead>
        <tr>
            <th scope="col">Nama</th>
            <th scope="col">Warna</th>
            <th scope="col">Stok</th>
            <th scope="col">Ukuran</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $item)
            <tr>
                <th scope="row">{{ $item->nama_produk }}</th>
                <td>{{ $item->warna }}</td>
                <td>{{ $item->stok }}</td>
                <td>{{ $item->ukuran }}</td>
            </tr>
        @endforeach
    </tbody>
</table>