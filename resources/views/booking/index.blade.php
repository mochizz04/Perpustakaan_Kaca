<!DOCTYPE html>
<html>
<head>
    <title>Booking Buku</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">

    <h2 class="mb-4">Data Booking Buku</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- FORM TAMBAH BOOKING -->
    <div class="card mb-4">
        <div class="card-header">
            Tambah Booking
        </div>

        <div class="card-body">
            <form action="/booking/store" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-5">
                        <label>Buku</label>

                        <select name="id_cp_koleksi" class="form-control" required>
                            <option value="">Pilih Buku</option>
                             @foreach($koleksi as $k)
                                <option value="{{ $k->judul_koleksi }} - Copy {{ $k->id_cp_koleksi }}">
                                    {{ $k->id_cp_koleksi }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-5">
                        <label>Siswa</label>

                        <select name="id_siswa_tetap" class="form-control" required>
                            <option value="">Pilih Siswa</option>

                            @foreach($siswa as $s)
                                <option value="{{ $s->id_siswa_tetap }}">
                                    {{ $s->nama_siswa_tetap }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                     <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">
                            Booking
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- SEARCH DAN FILTER -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="/booking">
                <div class="row">
                    <div class="col-md-5">
                        <input
                        type="text"
                            name="search"
                            class="form-control"
                            placeholder="Cari judul buku..."
                            value="{{ request('search') }}"
                        >
                    </div>

                    <div class="col-md-4">
                        <select name="status_booking" class="form-control">
                            <option value="">Semua Status</option>
                            <option value="Aktif">Aktif</option>
                            <option value="Dibatalkan">Dibatalkan</option>
                            <option value="Expired">Expired</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-success w-100">
                            Filter
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- TABEL BOOKING -->
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Nama Siswa</th>
                        <th>Judul Buku</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($booking as $index => $b)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $b->tgl_booking }}</td>
                            <td>{{ $b->nama_siswa_tetap }}</td>
                            <td>{{ $b->judul_koleksi }}</td>
                            <td>
                                <span class="badge bg-primary">
                                    {{ $b->status_booking }}
                                </span>
                            </td>
                            <td>
                                @if($b->status_booking == 'Aktif')
                                    <form action="/booking/cancel/{{ $b->id_booking }}" method="POST">
                                        @csrf
                                        @method('PUT')

                                        <button class="btn btn-danger btn-sm">
                                            Cancel
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                    <tr>
                            <td colspan="6" class="text-center">
                                Data booking kosong
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-3">
                {{ $booking->links() }}
            </div>
        </div>
    </div>

</div>

</body>
</html>
