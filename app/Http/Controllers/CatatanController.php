<?php
// app/Http/Controllers/CatatanController.php

namespace App\Http\Controllers;

use App\Models\Catatan; // Import Model Catatan
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Import Auth Facade

class CatatanController extends Controller
{
    /**
     * Tampilkan daftar catatan.
     * Hanya Admin dan Pelanggan yang bisa melihat (Pelanggan hanya catatan mereka sendiri).
     */
    public function index()
    {
        $userRole = Auth::user()->role;
        $catatanList = [];

        if ($userRole === 'admin') {
            $catatanList = Catatan::all();
        } elseif ($userRole === 'pelanggan') {
            // Pastikan user memiliki relasi dengan model Pelanggan
            if (Auth::user()->pelanggan) {
                $pelangganId = Auth::user()->pelanggan->id_pelanggan;
                $catatanList = Catatan::where('id_pelanggan', $pelangganId)->get();
            } else {
                abort(403, 'Anda tidak memiliki profil pelanggan.');
            }
        } else {
            abort(403, 'Akses Dilarang. Anda tidak memiliki izin untuk melihat catatan.');
        }

        return view('catatan.index', compact('catatanList'));
    }

    /**
     * Tampilkan form untuk membuat Catatan baru.
     * Hanya Admin dan Pelanggan yang bisa mengakses.
     */
    public function create()
    {
        $userRole = Auth::user()->role;
        if (!in_array($userRole, ['admin', 'pelanggan'])) {
            abort(403, 'Akses Dilarang. Anda tidak memiliki izin untuk menambah catatan.');
        }

        return view('catatan.create');
    }

    /**
     * Simpan Catatan yang baru dibuat.
     * Hanya Admin dan Pelanggan yang bisa mengakses.
     */
    public function store(Request $request)
    {
        $userRole = Auth::user()->role;
        if (!in_array($userRole, ['admin', 'pelanggan'])) {
            abort(403, 'Akses Dilarang. Anda tidak memiliki izin untuk menyimpan catatan.');
        }

        $request->validate([
            'tanggal_latihan' => 'required|date',
            'kegiatan_latihan' => 'required|string|max:255',
            'catatan_latihan' => 'nullable|string',
        ]);

        // Otomatis set id_pelanggan dari user yang sedang login
        // Pastikan user->pelanggan tidak null
        if (Auth::user()->pelanggan) {
            $request->merge(['id_pelanggan' => Auth::user()->pelanggan->id_pelanggan]);
        } else {
            abort(400, 'Profil pelanggan tidak ditemukan.'); // Error jika user tidak terhubung ke profil pelanggan
        }


        Catatan::create($request->all());

        return redirect()->route('pelanggan.catatan.index')
                         ->with('success', 'Catatan latihan berhasil ditambahkan!');
    }

    // Anda perlu menambahkan method show, edit, update, destroy di sini
    // dengan pengecekan role dan kepemilikan data yang sesuai.
    // Misalnya, pelanggan hanya bisa mengedit/menghapus catatan milik mereka sendiri.
    public function edit(Catatan $catatan)
    {
        $userRole = Auth::user()->role;
        if (!in_array($userRole, ['admin', 'pelanggan'])) {
            abort(403, 'Akses Dilarang.');
        }

        if ($userRole === 'pelanggan' && $catatan->id_pelanggan !== Auth::user()->pelanggan->id_pelanggan) {
            abort(403, 'Akses Dilarang. Anda hanya dapat mengedit catatan yang Anda buat.');
        }

        return view('catatan.edit', compact('catatan'));
    }

    public function update(Request $request, Catatan $catatan)
    {
        $userRole = Auth::user()->role;
        if (!in_array($userRole, ['admin', 'pelanggan'])) {
            abort(403, 'Akses Dilarang.');
        }

        if ($userRole === 'pelanggan' && $catatan->id_pelanggan !== Auth::user()->pelanggan->id_pelanggan) {
            abort(403, 'Akses Dilarang. Anda hanya dapat mengupdate catatan yang Anda buat.');
        }

        $request->validate([
            'tanggal_latihan' => 'required|date',
            'kegiatan_latihan' => 'required|string|max:255',
            'catatan_latihan' => 'nullable|string',
        ]);

        $catatan->update($request->all());

        return redirect()->route('pelanggan.catatan.index')
                         ->with('success', 'Catatan latihan berhasil diperbarui!');
    }

    public function destroy(Catatan $catatan)
    {
        $userRole = Auth::user()->role;
        if (!in_array($userRole, ['admin', 'pelanggan'])) {
            abort(403, 'Akses Dilarang.');
        }

        if ($userRole === 'pelanggan' && $catatan->id_pelanggan !== Auth::user()->pelanggan->id_pelanggan) {
            abort(403, 'Akses Dilarang. Anda hanya dapat menghapus catatan yang Anda buat.');
        }

        $catatan->delete();

        return redirect()->route('pelanggan.catatan.index')
                         ->with('success', 'Catatan latihan berhasil dihapus!');
    }
}
