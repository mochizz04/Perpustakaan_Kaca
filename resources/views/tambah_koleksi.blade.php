<!DOCTYPE html>
<html>
<head>
    <title>Tambah Koleksi</title>
</head>
<body>

<h2>Tambah Data Koleksi</h2>

<form action="/koleksi/store" method="POST">
    @csrf

    <input type="text" name="id_koleksi" placeholder="ID Koleksi"><br><br>
    <input type="text" name="judul" placeholder="Judul"><br><br>
    <input type="text" name="kategori" placeholder="Kategori"><br><br>
    <input type="text" name="penulis" placeholder="Penulis"><br><br>
    <input type="text" name="tahun" placeholder="Tahun"><br><br>

    <button type="submit">Tambah</button>
</form>

@if($errors->any())
    <ul>
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

</body>
</html>