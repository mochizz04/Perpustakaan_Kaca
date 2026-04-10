<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Koleksi</title>

    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #4facfe, #00f2fe);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .card {
            background: white;
            padding: 30px;
            border-radius: 15px;
            width: 370px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px);}
            to { opacity: 1; transform: translateY(0);}
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 5px;
            border-radius: 8px;
            border: 1px solid #ccc;
            transition: 0.3s;
        }

        input:focus {
            border-color: #4facfe;
            outline: none;
            box-shadow: 0 0 5px rgba(79,172,254,0.5);
        }

        .error-text {
            color: red;
            font-size: 12px;
            margin-bottom: 8px;
        }

        button {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 8px;
            background: linear-gradient(135deg, #4facfe, #007bff);
            color: white;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            opacity: 0.9;
            transform: scale(1.02);
        }

        .alert-error {
            background: #ffe6e6;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 10px;
            color: red;
        }

        .alert-success {
            background: #e6ffed;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 10px;
            color: green;
        }
    </style>
</head>

<body>

<div class="card">
    <h2>📚 Tambah Koleksi Buku</h2>

    {{-- SUCCESS --}}
    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- ERROR GLOBAL --}}
    @if($errors->any())
        <div class="alert-error">
            Harap isi semua data dengan benar!
        </div>
    @endif

    <form action="/koleksi/store" method="POST">
        @csrf

        <input type="text" name="id_koleksi" placeholder="ID Koleksi" value="{{ old('id_koleksi') }}">
        @error('id_koleksi')
            <div class="error-text">{{ $message }}</div>
        @enderror

        <input type="text" name="judul" placeholder="Judul Buku" value="{{ old('judul') }}">
        @error('judul')
            <div class="error-text">{{ $message }}</div>
        @enderror

        <input type="text" name="kategori" placeholder="Kategori" value="{{ old('kategori') }}">
        @error('kategori')
            <div class="error-text">{{ $message }}</div>
        @enderror

        <input type="text" name="penulis" placeholder="Penulis" value="{{ old('penulis') }}">
        @error('penulis')
            <div class="error-text">{{ $message }}</div>
        @enderror

        <input type="text" name="tahun" placeholder="Tahun (contoh: 2024)" value="{{ old('tahun') }}">
        @error('tahun')
            <div class="error-text">{{ $message }}</div>
        @enderror

        <button type="submit">Tambah Koleksi</button>
    </form>
</div>

</body>
</html>