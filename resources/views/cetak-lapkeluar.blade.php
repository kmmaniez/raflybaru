<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>
</head>
<style>
    table {
        width: 100%;
        /* border: 2px solid #000; */
        /* border: 1px inset #000; */
    }
    #header{
        text-align: center;
        width: 100%;
        height: max-content;
    }
</style>

<body>
    <div id="header">
        <h1 style="color: red;">CV. PRASETYA</h1>
        <p>Jl. Slompretan No. 57 Surabaya</p>
        <p>Telepon (031) 3557777 Hunting Fax. (031) 3557077</p>
    </div>
    <hr>
    <table border="1">
        <thead>
            <tr>
                <th>Nomor</th>
                <th>Nama Supplier</th>
                <th>Nama Produk</th>
                <th>Warna</th>
                <th>Ukuran</th>
                <th>Stok</th>
                <th>Tangal Keluar</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $laporan)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $laporan->nama_bgudang }}</td>
                    <td>{{ $laporan->masterproduk->nama_produk }}</td>
                    <td>{{ $laporan->warna }}</td>
                    <td>{{ $laporan->ukuran }}</td>
                    <td>{{ $laporan->stok }}</td>
                    <td>{{ $laporan->tgl_keluar }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
