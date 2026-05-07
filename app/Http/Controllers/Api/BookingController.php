<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    // MENAMBAH BOOKING
    public function store(Request $request)
    {
        try {
            $buku = DB::table('cp_koleksi')
                ->where('id_cp_koleksi', $request->id_cp_koleksi)
                ->first();

            if (!$buku) {
                return response()->json([
                    'message' => 'Buku tidak ditemukan'
                ], 404);
            }

            if ($buku->status_buku == 'Dipinjam') {
                return response()->json([
                    'message' => 'Buku sedang dipinjam'
                ], 400);
            }

            $siswa = DB::table('mst_siswa')
                ->where('id_siswa_tetap', $request->id_siswa_tetap)
                ->first();

            $jumlahBooking = DB::table('tr_booking')
            ->where('id_siswa_tetap', $request->id_siswa_tetap)
            ->where('status_booking', 'Aktif')
            ->count();

            if ($jumlahBooking >= 3) {
                return response()->json([
                    'message' => 'Siswa hanya boleh booking maksimal 3 buku'
                ], 400);
            }

            $bookingAktif = DB::table('tr_booking')
            ->where('id_cp_koleksi', $request->id_cp_koleksi)
            ->where('status_booking', 'Aktif')
            ->exists();

            if ($bookingAktif) {
                return response()->json([
                    'message' => 'Buku sedang dibooking pengguna lain'
                ], 400);
            }

            DB::table('tr_booking')->insert([
                'id_cp_koleksi' => $request->id_cp_koleksi,
                'id_siswa_tetap' => $request->id_siswa_tetap,
                'tgl_booking' => now(),
                'status_booking' => 'Aktif',
                'keterangan' => $request->keterangan ?? '-',
                'created_at' => now(),
                'updated_at' => now(),
                'expired_at' => now()->addDays(2),
            ]);

            DB::table('log_activity')->insert([
                'aktivitas' => 'Menambahkan booking buku',
                'user' => $siswa->nama_siswa_tetap,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return response()->json([
                'message' => 'Booking berhasil dibuat'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal membuat booking',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    // MEMBATALKAN BOOKING
    public function cancel($id)
    {
        try {
            $booking = DB::table('tr_booking')
                ->where('id_booking', $id)
                ->first();

            if (!$booking) {
                return response()->json([
                    'message' => 'Data booking tidak ditemukan'
                ], 404);
            }

            DB::table('tr_booking')
                ->where('id_booking', $id)
                ->update([
                    'status_booking' => 'Dibatalkan',
                    'updated_at' => now(),
                ]);
            
                DB::table('log_activity')->insert([
                    'aktivitas' => 'Membatalkan booking buku',
                    'user' => $booking->id_siswa_tetap,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

            return response()->json([
                'message' => 'Booking berhasil dibatalkan'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal membatalkan booking',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // MENAMPILKAN BOOKING
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
            if ($request->status_booking) {
                $booking->where('booking.status_booking', $request->status_booking);
            }

            $booking = $booking
                ->orderBy('booking.tgl_booking', 'desc')
                ->paginate(10);

        return response()->json($booking);
    }
}