<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>
</head>
<style>
    table{
        width: 100%;
        /* border: 2px solid #000; */ 
        /* border: 1px inset #000; */
    }
</style>
<body>
    <h1>Laporan Masuk</h1>
    <table border="1">
        <thead>
            <tr>
                <th>Nomor</th>
                <th>Nama Supplier</th>
                <th>Nama Produk</th>
                <th>Warna</th>
                <th>Ukuran</th>
                <th>Stok</th>
                <th>Tangal Masuk</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $laporan)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $laporan->supplier->nama }}</td>
                <td>{{ $laporan->product->nama_produk }}</td>
                <td>{{ $laporan->warna }}</td>
                <td>{{ $laporan->ukuran }}</td>
                <td>{{ $laporan->stok }}</td>
                <td>{{ $laporan->tgl_masuk }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>