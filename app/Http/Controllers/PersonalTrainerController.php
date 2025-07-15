<?php

namespace App\Http\Controllers;

use App\Models\PersonalTrainer;
use App\Models\User;
use App\Models\Pelanggan;
use App\Models\Catatan; // Pastikan ini di-import
use App\Models\Kartu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PersonalTrainerController extends Controller
{
    
    public function dashboard(Request $request)
    {
        $user = Auth::user();
        $userRole = Auth::user()->role;
        if ($userRole !== 'personal_trainer') {
            abort(403, 'Akses Dilarang. Anda tidak memiliki izin untuk melihat daftar ini.');
        }

        $personalTrainer = $user->personalTrainer;

        if (!$personalTrainer) {
            Log::error('Personal Trainer data not found for user_id: ' . $user->user_id);
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect('/login')->withErrors(['error' => 'Data profil Personal Trainer Anda tidak ditemukan. Silakan hubungi administrator.']);
        }

        $pelanggan = $personalTrainer->pelanggan()->with('user')->get();

        return view('trainer.dashboard', compact('user', 'personalTrainer', 'pelanggan'));
    }

    
}