<?php
// app/Http/Controllers/CatatanController.php

namespace App\Http\Controllers;

use App\Models\Catatan; // Import Model Catatan
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Import Auth Facade
use Illuminate\Support\Facades\Log;

class CatatanController extends Controller
{
    public function createCatatan()
    {
        // Anda bisa menambahkan logic otorisasi di sini jika diperlukan
        $user = Auth::user();
        if ($user->role !== 'pelanggan') {
            abort(403, 'Akses Dilarang.');
        }

        return view('pelanggan.catatan_latihan.create'); // Akan mengarahkan ke view baru
    }
    public function storeCatatan(Request $request)
    {
        $user = Auth::user();
        $pelanggan = $user->pelanggan;

        if (!$pelanggan) {
            return redirect()->back()->withErrors('Data pelanggan tidak ditemukan.');
        }

        $request->validate([
            'tanggal_latihan' => ['required', 'date'],
            'kegiatan_latihan' => ['required', 'string', 'max:255'],
            'catatan_latihan' => ['nullable', 'string'],
        ]);

        try {
            Catatan::create([
                'id_pelanggan' => $pelanggan->id_pelanggan,
                'tanggal_latihan' => $request->tanggal_latihan,
                'kegiatan_latihan' => $request->kegiatan_latihan,
                'catatan_latihan' => $request->catatan_latihan,
            ]);

            return redirect()->route('pelanggan.dashboard', ['tab' => 'myNotes'])->with('success', 'Catatan latihan berhasil ditambahkan!');
        } catch (\Exception $e) {
            Log::error('Error adding catatan: ' . $e->getMessage());
            return redirect()->back()->withInput()->withErrors('Gagal menambahkan catatan. Silakan coba lagi.');
        }
    }

    /**
     * Menampilkan formulir untuk mengedit catatan latihan tertentu.
     * Menggunakan Route Model Binding untuk Catatan.
     */
    public function editCatatan(Catatan $catatan)
    {
        $user = Auth::user();
        $pelanggan = $user->pelanggan;

        // Pastikan catatan ini milik pelanggan yang sedang login
        if (!$pelanggan || $catatan->id_pelanggan !== $pelanggan->id_pelanggan) {
            abort(403, 'Akses Dilarang. Anda tidak memiliki izin untuk mengedit catatan ini.');
        }

        // Anda bisa membuat view terpisah untuk edit, misalnya 'pelanggan.catatan.edit'
        // atau mengembalikan data untuk modal/inline edit.
        // Untuk contoh ini, kita akan mengasumsikan view terpisah.
        return view('pelanggan.catatan_latihan.edit', compact('catatan'));
    }

    /**
     * Memperbarui catatan latihan tertentu di database.
     * Menggunakan Route Model Binding untuk Catatan.
     */
    public function updateCatatan(Request $request, Catatan $catatan)
    {
        $user = Auth::user();
        $pelanggan = $user->pelanggan;

        // Pastikan catatan ini milik pelanggan yang sedang login
        if (!$pelanggan || $catatan->id_pelanggan !== $pelanggan->id_pelanggan) {
            abort(403, 'Akses Dilarang. Anda tidak memiliki izin untuk memperbarui catatan ini.');
        }

        $request->validate([
            'tanggal_latihan' => ['required', 'date'],
            'kegiatan_latihan' => ['required', 'string', 'max:255'],
            'catatan_latihan' => ['nullable', 'string'],
        ]);

        try {
            $catatan->update([
                'tanggal_latihan' => $request->tanggal_latihan,
                'kegiatan_latihan' => $request->kegiatan_latihan,
                'catatan_latihan' => $request->catatan_latihan,
            ]);

            return redirect()->route('pelanggan.dashboard', ['tab' => 'myNotes'])->with('success', 'Catatan latihan berhasil diperbarui!');
        } catch (\Exception $e) {
            Log::error('Error updating catatan: ' . $e->getMessage());
            return redirect()->back()->withInput()->withErrors('Gagal memperbarui catatan. Silakan coba lagi.');
        }
    }

    /**
     * Menghapus catatan latihan tertentu dari database.
     * Menggunakan Route Model Binding untuk Catatan.
     */
    public function destroyCatatan(Catatan $catatan)
    {
        $user = Auth::user();
        $pelanggan = $user->pelanggan;

        // Pastikan catatan ini milik pelanggan yang sedang login
        if (!$pelanggan || $catatan->id_pelanggan !== $pelanggan->id_pelanggan) {
            abort(403, 'Akses Dilarang. Anda tidak memiliki izin untuk menghapus catatan ini.');
        }

        try {
            $catatan->delete();
            return redirect()->route('pelanggan.dashboard', ['tab' => 'myNotes'])->with('success', 'Catatan latihan berhasil dihapus!');
        } catch (\Exception $e) {
            Log::error('Error deleting catatan: ' . $e->getMessage());
            return redirect()->back()->withErrors('Gagal menghapus catatan. Silakan coba lagi.');
        }
    }    
}