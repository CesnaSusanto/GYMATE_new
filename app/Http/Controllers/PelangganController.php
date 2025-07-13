<?php

// app/Http/Controllers/PelangganController.php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\User; // Digunakan untuk relasi user_id
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Import Auth Facade
use Illuminate\Validation\Rule; // Untuk validasi

class PelangganController extends Controller
{
    /**
     * Tampilkan daftar Pelanggan.
     * Hanya Admin dan Customer Service yang bisa mengakses.
     */
    public function index()
    {
        $userRole = Auth::user()->role;
        if (!in_array($userRole, ['admin', 'customer_service', 'personal_trainer'])) { // Trainer mungkin juga perlu melihat daftar pelanggan
            abort(403, 'Akses Dilarang. Anda tidak memiliki izin untuk melihat daftar Pelanggan.');
        }

        $pelangganList = Pelanggan::all();
        return view('pelanggan.index', compact('pelangganList'));
    }

    /**
     * Tampilkan form untuk membuat Pelanggan baru.
     * Hanya Admin dan Customer Service yang bisa mengakses.
     * Catatan: Pelanggan biasanya mendaftar sendiri, jadi ini untuk admin/cs membuat manual.
     */
    public function create()
    {
        $userRole = Auth::user()->role;
        if (!in_array($userRole, ['admin', 'customer_service'])) {
            abort(403, 'Akses Dilarang. Anda tidak memiliki izin untuk menambah Pelanggan.');
        }

        // Ambil user yang belum terhubung dengan CS, PT, atau Pelanggan
        $availableUsers = User::doesntHave('customerService')
                            ->doesntHave('personalTrainer')
                            ->doesntHave('pelanggan')
                            ->get();

        return view('pelanggan.create', compact('availableUsers'));
    }

    /**
     * Simpan Pelanggan yang baru dibuat.
     * Hanya Admin dan Customer Service yang bisa mengakses.
     */
    public function store(Request $request)
    {
        $userRole = Auth::user()->role;
        if (!in_array($userRole, ['admin', 'customer_service'])) {
            abort(403, 'Akses Dilarang. Anda tidak memiliki izin untuk menyimpan Pelanggan.');
        }

        $request->validate([
            'user_id' => 'required|exists:users,user_id|unique:pelanggan,user_id',
            'nama_pelanggan' => 'required|string|max:255',
            'jenis_kelamin' => 'nullable|string|max:20',
            'no_telp' => 'nullable|string|max:20',
            'tanggal_bergabung' => 'required|date',
            'paket_layanan' => 'required|string|max:50',
            'berat_badan' => 'nullable|numeric',
            'tinggi_badan' => 'nullable|numeric',
            'status' => 'required|string|max:50',
        ]);

        // Opsional: Perbarui role user menjadi 'pelanggan'
        $user = User::find($request->user_id);
        if ($user) {
            $user->role = 'pelanggan';
            $user->save();
        }

        Pelanggan::create($request->all());

        return redirect()->route('admin.pelanggan.index')
                         ->with('success', 'Pelanggan berhasil ditambahkan!');
    }

    /**
     * Tampilkan detail Pelanggan.
     * Admin, CS, PT (jika terkait), dan Pelanggan itu sendiri bisa melihat.
     */
    public function show(Pelanggan $pelanggan)
    {
        $userRole = Auth::user()->role;
        // Admin dan CS bisa melihat semua detail
        // Trainer bisa melihat detail pelanggan yang terkait dengan kartu mereka (logic ini perlu diperluas)
        // Pelanggan hanya bisa melihat detail profilnya sendiri
        if ($userRole === 'pelanggan' && Auth::user()->pelanggan->id_pelanggan !== $pelanggan->id_pelanggan) {
            abort(403, 'Akses Dilarang. Anda hanya dapat melihat profil Anda sendiri.');
        }
        // Untuk Trainer, Anda perlu menambahkan logic di sini jika mereka hanya boleh melihat pelanggan yang punya kartu dari mereka

        if (!in_array($userRole, ['admin', 'customer_service', 'personal_trainer', 'pelanggan'])) {
             abort(403, 'Akses Dilarang.');
        }

        return view('pelanggan.show', compact('pelanggan'));
    }

    /**
     * Tampilkan form untuk mengedit Pelanggan.
     * Hanya Admin dan Customer Service yang bisa mengakses.
     * Pelanggan juga bisa edit profil mereka sendiri.
     */
    public function edit(Pelanggan $pelanggan)
    {
        $userRole = Auth::user()->role;
        // Admin dan CS bisa edit semua
        // Pelanggan hanya bisa edit profil mereka sendiri
        if ($userRole === 'pelanggan' && Auth::user()->pelanggan->id_pelanggan !== $pelanggan->id_pelanggan) {
            abort(403, 'Akses Dilarang. Anda hanya dapat mengedit profil Anda sendiri.');
        }

        if (!in_array($userRole, ['admin', 'customer_service', 'pelanggan'])) {
            abort(403, 'Akses Dilarang.');
        }


        return view('pelanggan.edit', compact('pelanggan'));
    }

    /**
     * Update data Pelanggan.
     * Hanya Admin dan Customer Service yang bisa mengakses.
     * Pelanggan juga bisa update profil mereka sendiri.
     */
    public function update(Request $request, Pelanggan $pelanggan)
    {
        $userRole = Auth::user()->role;
        // Admin dan CS bisa update semua
        // Pelanggan hanya bisa update profil mereka sendiri
        if ($userRole === 'pelanggan' && Auth::user()->pelanggan->id_pelanggan !== $pelanggan->id_pelanggan) {
            abort(403, 'Akses Dilarang. Anda hanya dapat mengupdate profil Anda sendiri.');
        }

        if (!in_array($userRole, ['admin', 'customer_service', 'pelanggan'])) {
            abort(403, 'Akses Dilarang.');
        }

        $request->validate([
            'nama_pelanggan' => 'required|string|max:255',
            'jenis_kelamin' => 'nullable|string|max:20',
            'no_telp' => 'nullable|string|max:20',
            'tanggal_bergabung' => 'required|date',
            'paket_layanan' => 'required|string|max:50',
            'berat_badan' => 'nullable|numeric',
            'tinggi_badan' => 'nullable|numeric',
            'status' => 'required|string|max:50',
        ]);

        $pelanggan->update($request->all());

        // Redirect sesuai role atau ke halaman detail
        if ($userRole === 'pelanggan') {
             return redirect()->route('pelanggan.dashboard')->with('success', 'Profil Anda berhasil diperbarui!');
        }
        return redirect()->route('admin.pelanggan.index')->with('success', 'Pelanggan berhasil diperbarui!');
    }

    /**
     * Hapus Pelanggan.
     * Hanya Admin yang bisa mengakses.
     */
    public function destroy(Pelanggan $pelanggan)
    {
        $userRole = Auth::user()->role;
        if ($userRole !== 'admin') {
            abort(403, 'Akses Dilarang. Anda tidak memiliki izin untuk menghapus Pelanggan.');
        }

        // Opsional: Hapus juga user terkait
        // if ($pelanggan->user) {
        //     $pelanggan->user->delete();
        // }

        $pelanggan->delete();

        return redirect()->route('admin.pelanggan.index')
                         ->with('success', 'Pelanggan berhasil dihapus!');
    }
}
