<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KoleksiController;

Route::get('/test-db', function () {
    try {
        // Test koneksi
        DB::connection()->getPdo();
        
        $siswa = DB::table('mst_siswa')->get();
        
        return $siswa;
        
    } catch (\Exception $e) {
        return "Gagal nyambung ke database nih. Error: " . $e->getMessage();
    }
});

Route::post('/koleksi/store', [KoleksiController::class, 'store']);

Route::get('/koleksi/tambah', function () {
    return view('tambah_koleksi');
});