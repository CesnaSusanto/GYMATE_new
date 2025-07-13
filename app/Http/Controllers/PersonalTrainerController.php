<?php
// app/Http/Controllers/PersonalTrainerController.php

namespace App\Http\Controllers;

use App\Models\PersonalTrainer;
use App\Models\User; // Digunakan untuk relasi user_id
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Import Auth Facade
use Illuminate\Validation\Rule; // Untuk validasi enum role

class PersonalTrainerController extends Controller
{
    /**
     * Tampilkan daftar Personal Trainer.
     * Hanya Admin dan Customer Service yang bisa mengakses.
     */
    public function index()
    {
        $userRole = Auth::user()->role;
        if (!in_array($userRole, ['admin', 'customer_service'])) {
            abort(403, 'Akses Dilarang. Anda tidak memiliki izin untuk melihat daftar Personal Trainer.');
        }

        $personalTrainers = PersonalTrainer::all();
        return view('personal_trainer.index', compact('personalTrainers'));
    }

    /**
     * Tampilkan form untuk membuat Personal Trainer baru.
     * Hanya Admin dan Customer Service yang bisa mengakses.
     */
    public function create()
    {
        $userRole = Auth::user()->role;
        if (!in_array($userRole, ['admin', 'customer_service'])) {
            abort(403, 'Akses Dilarang. Anda tidak memiliki izin untuk menambah Personal Trainer.');
        }

        // Anda mungkin perlu mengambil daftar user yang belum jadi PT/CS/Pelanggan untuk dipilih
        $availableUsers = User::doesntHave('personalTrainer')
                            ->doesntHave('customerService')
                            ->doesntHave('pelanggan')
                            ->get();

        return view('personal_trainer.create', compact('availableUsers'));
    }

    /**
     * Simpan Personal Trainer yang baru dibuat.
     * Hanya Admin dan Customer Service yang bisa mengakses.
     */
    public function store(Request $request)
    {
        $userRole = Auth::user()->role;
        if (!in_array($userRole, ['admin', 'customer_service'])) {
            abort(403, 'Akses Dilarang. Anda tidak memiliki izin untuk menyimpan Personal Trainer.');
        }

        $request->validate([
            'user_id' => 'required|exists:users,user_id|unique:personal_trainer,user_id',
            'nama_personal_trainer' => 'required|string|max:255',
            'jenis_kelamin' => 'nullable|string|max:20',
            'no_telp' => 'nullable|string|max:20',
        ]);

        // Opsional: Pastikan user_id yang dipilih memiliki role yang cocok (misal: 'pelanggan' yang akan diubah role-nya)
        // Atau Anda bisa update role user setelah PT dibuat
        $user = User::find($request->user_id);
        if ($user) {
            $user->role = 'personal_trainer'; // Ubah role user menjadi personal_trainer
            $user->save();
        }

        PersonalTrainer::create($request->all());

        return redirect()->route('admin.personal-trainer.index')
                         ->with('success', 'Personal Trainer berhasil ditambahkan!');
    }

    /**
     * Tampilkan form untuk mengedit Personal Trainer.
     * Hanya Admin dan Customer Service yang bisa mengakses.
     */
    public function edit(PersonalTrainer $personal_trainer)
    {
        $userRole = Auth::user()->role;
        if (!in_array($userRole, ['admin', 'customer_service'])) {
            abort(403, 'Akses Dilarang. Anda tidak memiliki izin untuk mengedit Personal Trainer.');
        }

        return view('personal_trainer.edit', compact('personal_trainer'));
    }

    /**
     * Update data Personal Trainer.
     * Hanya Admin dan Customer Service yang bisa mengakses.
     */
    public function update(Request $request, PersonalTrainer $personal_trainer)
    {
        $userRole = Auth::user()->role;
        if (!in_array($userRole, ['admin', 'customer_service'])) {
            abort(403, 'Akses Dilarang. Anda tidak memiliki izin untuk mengupdate Personal Trainer.');
        }

        $request->validate([
            // user_id tidak boleh diubah jika sudah ada
            'nama_personal_trainer' => 'required|string|max:255',
            'jenis_kelamin' => 'nullable|string|max:20',
            'no_telp' => 'nullable|string|max:20',
        ]);

        $personal_trainer->update($request->all());

        return redirect()->route('admin.personal-trainer.index')
                         ->with('success', 'Personal Trainer berhasil diperbarui!');
    }

    /**
     * Hapus Personal Trainer.
     * Hanya Admin yang bisa mengakses.
     */
    public function destroy(PersonalTrainer $personal_trainer)
    {
        $userRole = Auth::user()->role;
        if ($userRole !== 'admin') { // Hanya admin yang bisa menghapus
            abort(403, 'Akses Dilarang. Anda tidak memiliki izin untuk menghapus Personal Trainer.');
        }

        // Opsional: Hapus juga user terkait jika relasinya onDelete('cascade') tidak diatur
        // if ($personal_trainer->user) {
        //     $personal_trainer->user->delete();
        // }

        $personal_trainer->delete();

        return redirect()->route('admin.personal-trainer.index')
                         ->with('success', 'Personal Trainer berhasil dihapus!');
    }
}
