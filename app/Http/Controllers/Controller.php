<?php

namespace App\Http\Controllers;

abstract class Controller
{
    public function store(Request $request)
{
    try {

        $request->validate([
            'id_koleksi' => 'required|unique:koleksi,id_koleksi',
            'judul' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'penulis' => 'required|string|max:255',
            'tahun' => 'required|numeric|digits:4',
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

        return redirect()->back()->with('success', 'Berhasil tambah data');

    } catch (\Exception $e) {
        dd($e->getMessage());
    }
}
}
