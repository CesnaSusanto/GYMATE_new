<?php

// app/Http/Controllers/PelangganController.php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\User; // Digunakan untuk relasi user_id
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Import Auth Facade
use Illuminate\Validation\Rule; // Untuk validasi

// app/Http/Controllers/PelangganController.php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\User;
use App\Models\Catatan;
use App\Models\Kartu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PelangganController extends Controller
{
    public function dashboard(Request $request)
    {
        $user = Auth::user();
        if ($user->role !== 'pelanggan') {
            abort(403, 'Akses Dilarang. Anda tidak memiliki izin untuk melihat halaman ini.');
        }
        $pelanggan = $user->pelanggan; // Ini akan memuat data pelanggan jika relasi sudah didefinisikan di model User
        if (!$pelanggan) {
            return redirect()->route('login')->withErrors('Data pelanggan tidak ditemukan.');
        }

        // Kirim data pelanggan ke view
        return view('pelanggan.dashboard', compact('pelanggan'));
    }
    public function showJadwalDetail(Kartu $kartu)
    {
        $user = Auth::user();
        $pelanggan = $user->pelanggan;

        // Pastikan kartu ini milik pelanggan yang sedang login
        if (!$pelanggan || $kartu->id_pelanggan !== $pelanggan->id_pelanggan) {
            abort(403, 'Akses Dilarang. Anda tidak memiliki izin untuk melihat jadwal ini.');
        }

        // Pastikan pelanggan adalah premium untuk melihat detail jadwal
        if ($pelanggan->paket_layanan !== 'premium') {
            return redirect()->route('pelanggan.dashboard', ['tab' => 'mySchedule'])->withErrors('Anda harus memiliki paket premium untuk melihat detail jadwal.');
        }

        // Muat relasi personalTrainer untuk kartu
        $kartu->load('personalTrainer');

        return view('pelanggan.jadwal.show', compact('kartu'));
    }
}