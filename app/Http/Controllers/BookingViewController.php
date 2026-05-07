<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingViewController extends Controller
{
    public function index(Request $request)
    {
        $booking = DB::table('tr_booking as booking')
            ->join('mst_siswa as siswa', 'booking.id_siswa_tetap', '=', 'siswa.id_siswa_tetap')
            ->join('cp_koleksi as copy', 'booking.id_cp_koleksi', '=', 'copy.id_cp_koleksi')
            ->join('mst_koleksi_buku as buku', 'copy.ISBN', '=', 'buku.ISBN')
            ->select(
                'booking.id_booking',
                'booking.tgl_booking',
                'booking.status_booking',
                'siswa.nama_siswa_tetap',
                'buku.judul_koleksi'
            );

        // SEARCH
        if ($request->search) {
            $booking->where('buku.judul_koleksi', 'like', '%' . $request->search . '%');
        }

        // FILTER STATUS
        if ($request->status_booking) {
            $booking->where('booking.status_booking', $request->status_booking);
        }

        $booking = $booking
            ->orderBy('booking.tgl_booking', 'desc')
            ->paginate(10);

        $koleksi = DB::table('cp_koleksi as copy')
        ->join('mst_koleksi_buku as buku', 'copy.ISBN', '=', 'buku.ISBN')
        ->select(
            'copy.id_cp_koleksi',
            'buku.judul_koleksi'
        )
        ->get();
        $siswa = DB::table('mst_siswa')->get();

        return view('booking.index', compact('booking', 'koleksi', 'siswa'));
    }
    public function store(Request $request)
    {
        DB::table('tr_booking')->insert([
            'id_cp_koleksi' => $request->id_cp_koleksi,
            'id_siswa_tetap' => $request->id_siswa_tetap,
            'tgl_booking' => now(),
            'status_booking' => 'Aktif',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect('/booking')->with('success', 'Booking berhasil ditambahkan');
    }

    public function cancel($id)
    {
        DB::table('tr_booking')
            ->where('id_booking', $id)
            ->update([
                'status_booking' => 'Dibatalkan',
                'updated_at' => now(),
            ]);

        return redirect('/booking')->with('success', 'Booking berhasil dibatalkan');
    }
}