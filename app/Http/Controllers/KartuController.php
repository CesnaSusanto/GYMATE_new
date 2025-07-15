<?php

namespace App\Http\Controllers;

use App\Models\Kartu;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class KartuController extends Controller
{
    public function showJadwal(Pelanggan $pelanggan) // Menggunakan route model binding
    {
        $personalTrainer = Auth::user()->personalTrainer;

        if (!$personalTrainer || $pelanggan->id_personal_trainer !== $personalTrainer->id_personal_trainer) {
            abort(403, 'ANDA TIDAK BERHAK MELIHAT DETAIL PELANGGAN INI.');
        }

        // Ambil semua catatan latihan untuk pelanggan ini, diurutkan berdasarkan tanggal terbaru
        $jadwalLatihan = Kartu::where('id_pelanggan', $pelanggan->id_pelanggan)
                                ->orderBy('tanggal_latihan', 'desc')
                                ->get();

        // Pastikan nama view ini sesuai dengan lokasi file Blade Anda
        return view('trainer.list_jadwal', compact('pelanggan', 'jadwalLatihan'));
    }
    
     public function createJadwal(Request $request, Pelanggan $pelanggan = null)
    {
        $user = Auth::user();
        if ($user->role !== 'personal_trainer') {
            abort(403, 'Akses Dilarang. Anda tidak memiliki izin untuk melihat daftar ini.');
        }

        $personalTrainer = $user->personalTrainer;
        if (!$personalTrainer) {
            Log::error('Personal Trainer data not found for user_id: ' . $user->user_id . ' during createSession.');
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect('/login')->withErrors(['error' => 'Data profil Personal Trainer Anda tidak ditemukan. Silakan hubungi administrator.']);
        }

        // Ambil daftar pelanggan yang terkait dengan Personal Trainer ini
        $pelanggans = Pelanggan::where('id_personal_trainer', $personalTrainer->id_personal_trainer)
                                ->with('user')
                                ->get();
        // Tentukan pelanggan mana yang harus dipilih di dropdown
        $selectedPelangganId = null;
        if ($pelanggan) { // Jika ada pelanggan dari route parameter (e.g., /sessions/create/123)
            $selectedPelangganId = $pelanggan->id_pelanggan;
        } elseif ($request->has('id_pelanggan')) { // Jika ada id_pelanggan dari query string (e.g., /sessions/create?id_pelanggan=123)
            $selectedPelangganId = $request->input('id_pelanggan');
        }

        $jadwalLatihan = Kartu::where('id_pelanggan', $pelanggan->id_pelanggan)
                                ->orderBy('tanggal_latihan', 'desc')
                                ->get();
        
        

        return view('trainer.create_jadwal', compact('pelanggans', 'selectedPelangganId', 'jadwalLatihan'));
    }

    // Metode storeSession (jika belum ada, tambahkan dari jawaban sebelumnya)
    public function storeJadwal(Request $request)
{       

        // dd($request->all());
        if (!Auth::check()) {
        abort(403, 'Anda harus login untuk melakukan tindakan ini.');
    }

    $user = Auth::user(); // Dapatkan objek user yang sedang login

    // Dapatkan objek PersonalTrainer yang terkait dengan user ini
    $personalTrainer = $user->personalTrainer;

    // Periksa apakah profil Personal Trainer ditemukan
    if (!$personalTrainer) {
        abort(403, 'Profil Personal Trainer tidak ditemukan.');
    }

    $validated = $request->validate([
        'id_pelanggan' => 'required|exists:pelanggan,id_pelanggan',
        'tanggal_latihan' => 'required|date',
        'kegiatan_latihan' => 'required|string|max:255',
        'catatan_latihan' => 'nullable|string',
    ]);

    Kartu::create([
        'id_pelanggan' => $validated['id_pelanggan'],
        'id_personal_trainer' => $personalTrainer->id_personal_trainer, // Baris ini yang menambahkan id_personal_trainer
        'tanggal_latihan' => $validated['tanggal_latihan'],
        'kegiatan_latihan' => $validated['kegiatan_latihan'],
        'catatan_latihan' => $validated['catatan_latihan'] ?? null,
    ]);

    return redirect()->back()->with('success', 'Sesi latihan berhasil dicatat!');
}

    public function editJadwal(Kartu $kartu)
    {
        // Otorisasi: Pastikan PT yang login adalah PT yang terkait dengan kartu ini
        $personalTrainer = Auth::user()->personalTrainer;

        if (!$personalTrainer || $kartu->id_personal_trainer !== $personalTrainer->id_personal_trainer) {
            abort(403, 'Anda tidak berhak mengedit sesi latihan ini.');
        }

        // Ambil data pelanggan terkait untuk ditampilkan di form edit
        $pelanggan = $kartu->pelanggan;

        return view('trainer.edit_jadwal', compact('kartu', 'pelanggan'));
    }

    /**
     * Update the specified session (Kartu) in storage.
     */
    public function updateJadwal(Request $request, Kartu $kartu)
    {
        // Otorisasi seperti di editSession
        $personalTrainer = Auth::user()->personalTrainer;
        if (!$personalTrainer || $kartu->id_personal_trainer !== $personalTrainer->id_personal_trainer) {
            abort(403, 'Anda tidak berhak memperbarui sesi latihan ini.');
        }

        $validated = $request->validate([
            'session_date' => 'required|date',
            'kegiatan_latihan' => 'required|string|max:255',
            'catatan_latihan' => 'nullable|string',
        ]);

        $kartu->update([
            'tanggal_latihan' => $validated['session_date'],
            'kegiatan_latihan' => $validated['kegiatan_latihan'],
            'catatan_latihan' => $validated['catatan_latihan'] ?? null,
        ]);

        // Redirect kembali ke halaman jadwal setelah update
        return redirect()->route('trainer.show_jadwal', $kartu->id_pelanggan)
                         ->with('success', 'Sesi latihan berhasil diperbarui.');
    }

    /**
     * Remove the specified session (Kartu) from storage.
     */
    public function destroyJadwal(Kartu $kartu)
    {
        // Otorisasi seperti di editSession
        $personalTrainer = Auth::user()->personalTrainer;
        if (!$personalTrainer || $kartu->id_personal_trainer !== $personalTrainer->id_personal_trainer) {
            abort(403, 'Anda tidak berhak menghapus sesi latihan ini.');
        }

        $pelangganId = $kartu->id_pelanggan; // Simpan ID pelanggan sebelum dihapus

        $kartu->delete();

        return redirect()->route('trainer.show_jadwal', $pelangganId)
                         ->with('success', 'Sesi latihan berhasil dihapus.');
    }
}
