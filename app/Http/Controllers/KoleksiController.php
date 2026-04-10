<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KoleksiController extends Controller
{
    public function store(Request $request)
{
    $request->validate([
        'id_koleksi' => 'required|unique:koleksi,id_koleksi',
        'judul' => 'required|string|max:255',
        'kategori' => 'required|string|max:100',
        'penulis' => 'required|string|max:255',
        'tahun' => 'required|numeric|digits:4',
    ], [
        'id_koleksi.required' => 'ID koleksi wajib diisi',
        'id_koleksi.unique' => 'ID koleksi tidak boleh duplikat',
        'judul.required' => 'Judul wajib diisi',
        'kategori.required' => 'Kategori wajib diisi',
        'penulis.required' => 'Penulis wajib diisi',
        'tahun.required' => 'Tahun wajib diisi',
        'tahun.digits' => 'Tahun harus 4 digit',
    ]);

    DB::table('koleksi')->insert([
        'id_koleksi' => $request->id_koleksi,
        'judul' => $request->judul,
        'kategori' => $request->kategori,
        'penulis' => $request->penulis,
        'tahun' => $request->tahun,
        'created_at' => now(),
        'updated_at' => now()
    ]);

    return redirect()->back()->with('success', 'Data koleksi berhasil ditambahkan');
}
}