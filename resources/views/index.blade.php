<!doctype html>
<html lang="en">
 
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
 
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
 
    <title>Data Karyawan</title>
</head>
 
<body>
    <div class="container">
        <div class="mt-5 mb-5">
            <h1 class="display-4">Data Karyawan</h1>
        </div>
        <a href="/export/cetak_pdf" class="btn btn-primary">Export Data</a>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Nama</th>
                    <th scope="col">Warna</th>
                    <th scope="col">Stok</th>
                    <th scope="col">Ukuran</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $item)
                    <tr>
                        <th scope="row">{{ $item->nama_produk }}</th>
                        <td>{{ $item->warna }}</td>
                        <td>{{ $item->stok }}</td>
                        <td>{{ $item->ukuran }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
 
 
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
</body>
 
</html>