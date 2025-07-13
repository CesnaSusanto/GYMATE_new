<?php

namespace App\Http\Controllers;

use App\Models\Kartu;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KartuController extends Controller
{
    /**
     * Tampilkan daftar kartu (tergantung role).
     * Admin/Trainer melihat semua, Pelanggan hanya melihat kartu mereka sendiri.
     */
    public function index()
    {
        $userRole = Auth::user()->role;
        $kartuList = [];

        if ($userRole === 'admin') {
            $kartuList = Kartu::all();
        } elseif ($userRole === 'personal_trainer') {
            // Hanya kartu yang diberikan oleh trainer yang sedang login
            $trainerId = Auth::user()->personalTrainer->id_personal_trainer;
            $kartuList = Kartu::where('id_personal_trainer', $trainerId)->get();
        } else {
            abort(403, 'Akses Dilarang.');
        }

        return view('kartu.index', compact('kartuList'));
    }

    /**
     * Tampilkan daftar kartu khusus untuk pelanggan.
     * Hanya pelanggan yang bisa melihat kartu mereka.
     */
    public function indexForPelanggan()
    {
        $userRole = Auth::user()->role;
        if (!in_array($userRole, ['admin', 'pelanggan'])) { // Admin juga bisa lihat
            abort(403, 'Akses Dilarang.');
        }

        $pelangganId = Auth::user()->pelanggan->id_pelanggan;
        $kartuList = Kartu::where('id_pelanggan', $pelangganId)->get();

        return view('kartu.index_pelanggan', compact('kartuList')); // View terpisah
    }


    /**
     * Tampilkan form untuk membuat Kartu baru.
     * Hanya Admin dan Personal Trainer yang bisa mengakses.
     */
    public function create()
    {
        $userRole = Auth::user()->role;
        if (!in_array($userRole, ['admin', 'personal_trainer'])) {
            abort(403, 'Akses Dilarang. Anda tidak memiliki izin untuk menambah Kartu.');
        }

        $pelangganList = Pelanggan::all(); // Ambil daftar pelanggan
        return view('kartu.create', compact('pelangganList'));
    }

    /**
     * Simpan Kartu baru.
     * Hanya Admin dan Personal Trainer yang bisa mengakses.
     */
    public function store(Request $request)
    {
        $userRole = Auth::user()->role;
        if (!in_array($userRole, ['admin', 'personal_trainer'])) {
            abort(403, 'Akses Dilarang. Anda tidak memiliki izin untuk menyimpan Kartu.');
        }

        $request->validate([
            'id_pelanggan' => 'required|exists:pelanggan,id_pelanggan',
            'tanggal_latihan' => 'required|date',
            'kegiatan_latihan' => 'required|string|max:255',
            'catatan_latihan' => 'nullable|string',
        ]);

        // Otomatis set id_personal_trainer dari user yang sedang login
        $request->merge(['id_personal_trainer' => Auth::user()->personalTrainer->id_personal_trainer]);

        Kartu::create($request->all());

        return redirect()->route('trainer.kartu.index')
                         ->with('success', 'Kartu latihan berhasil ditambahkan!');
    }

    // ... method show, edit, update, destroy lainnya dengan pengecekan serupa ...
    // Pastikan saat update/destroy, user (trainer) yang bersangkutan hanya bisa mengubah/menghapus kartu yang mereka buat.
    public function edit(Kartu $kartu)
    {
        $userRole = Auth::user()->role;
        if (!in_array($userRole, ['admin', 'personal_trainer'])) {
            abort(403, 'Akses Dilarang.');
        }

        // Tambahan: Pastikan trainer hanya mengedit kartu miliknya
        if ($userRole === 'personal_trainer' && $kartu->id_personal_trainer !== Auth::user()->personalTrainer->id_personal_trainer) {
            abort(403, 'Akses Dilarang. Anda hanya dapat mengedit kartu yang Anda buat.');
        }

        return view('kartu.edit', compact('kartu'));
    }

    public function update(Request $request, Kartu $kartu)
    {
        $userRole = Auth::user()->role;
        if (!in_array($userRole, ['admin', 'personal_trainer'])) {
            abort(403, 'Akses Dilarang.');
        }

        // Tambahan: Pastikan trainer hanya mengupdate kartu miliknya
        if ($userRole === 'personal_trainer' && $kartu->id_personal_trainer !== Auth::user()->personalTrainer->id_personal_trainer) {
            abort(403, 'Akses Dilarang. Anda hanya dapat mengupdate kartu yang Anda buat.');
        }

        $request->validate([
            'id_pelanggan' => 'required|exists:pelanggan,id_pelanggan',
            'tanggal_latihan' => 'required|date',
            'kegiatan_latihan' => 'required|string|max:255',
            'catatan_latihan' => 'nullable|string',
        ]);

        $kartu->update($request->all());

        return redirect()->route('trainer.kartu.index')
                         ->with('success', 'Kartu latihan berhasil diperbarui!');
    }

    public function destroy(Kartu $kartu)
    {
        $userRole = Auth::user()->role;
        if (!in_array($userRole, ['admin', 'personal_trainer'])) {
            abort(403, 'Akses Dilarang.');
        }

        // Tambahan: Pastikan trainer hanya menghapus kartu miliknya
        if ($userRole === 'personal_trainer' && $kartu->id_personal_trainer !== Auth::user()->personalTrainer->id_personal_trainer) {
            abort(403, 'Akses Dilarang. Anda hanya dapat menghapus kartu yang Anda buat.');
        }

        $kartu->delete();

        return redirect()->route('trainer.kartu.index')
                         ->with('success', 'Kartu latihan berhasil dihapus!');
    }
}
