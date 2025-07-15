<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Rules;
use App\Models\Pelanggan;
use App\Models\User;
use App\Models\PersonalTrainer; // <--- Tambahkan ini
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\QueryException; // <--- Tambahkan ini untuk error handling
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            return $this->redirectToDashboard(); // Gunakan helper redirect
        }
        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::attempt(['username' => $credentials['username'], 'password' => $credentials['password']], $request->boolean('remember'))) {
            $request->session()->regenerate(); // Regenerasi sesi untuk keamanan

            return $this->redirectToDashboard(); // Redirect ke dashboard berdasarkan role
        }

        return back()->withErrors([
            'username' => 'Kredensial yang diberikan tidak cocok dengan catatan kami.',
        ])->onlyInput('username'); // Hanya tampilkan input username yang salah
    }

    public function showRegistrationForm(): \Illuminate\View\View | RedirectResponse
    {
        if (Auth::check()) {
            return $this->redirectToDashboard(); // Gunakan helper redirect
        }
        $personalTrainers = PersonalTrainer::all();
        return view('auth.register', compact('personalTrainers'));
    }

    public function register(Request $request): RedirectResponse
    {
        // Untuk debugging, uncomment baris ini untuk melihat semua data yang dikirim dari form
        // dd($request->all());

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users,username'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'phone_number' => ['nullable', 'string', 'max:20'],
            'jenis_kelamin' => ['required', 'string', 'in:Laki-laki,Perempuan'],
            'paket_layanan' => ['required', 'string', 'in:biasa,premium'],
            'berat_badan' => ['required', 'numeric', 'min:1'],
            'tinggi_badan' => ['required', 'numeric', 'min:1'],
            'id_personal_trainer' => ['nullable', 'exists:personal_trainer,id_personal_trainer'],
        ];

        // Jika paket layanan adalah 'premium', maka id_personal_trainer menjadi wajib
        if ($request->paket_layanan === 'premium') {
            $rules['id_personal_trainer'] = ['required', 'exists:personal_trainer,id_personal_trainer'];
        }

        $request->validate($rules, [
            'id_personal_trainer.required' => 'Silakan pilih Personal Trainer untuk paket Premium.',
            'id_personal_trainer.exists' => 'Personal Trainer yang dipilih tidak valid.',
        ]);

        try {
            // Buat user baru
            $user = User::create([
                'username' => $request->username,
                'password' => Hash::make($request->password), // Password akan di-hash oleh cast di model User
                'role' => 'pelanggan',
            ]);

            // Buat data pelanggan baru
            Pelanggan::create([
                'user_id' => $user->user_id, // Menggunakan user_id dari objek $user yang baru dibuat
                'nama_pelanggan' => $request->name,
                'jenis_kelamin' => $request->jenis_kelamin,
                'no_telp' => $request->phone_number,
                'tanggal_bergabung' => now(),
                'paket_layanan' => $request->paket_layanan,
                'berat_badan' => $request->berat_badan,
                'tinggi_badan' => $request->tinggi_badan,
                'status' => 'Aktif',
                // Menggunakan id_personal_trainer dari request yang sudah divalidasi
                'id_personal_trainer' => $request->id_personal_trainer,
            ]);

            // Login user yang baru terdaftar
            Auth::login($user);
            $request->session()->regenerate(); // Regenerasi sesi untuk keamanan

            // Redirect ke dashboard berdasarkan role
            return $this->redirectToDashboard();

        } catch (QueryException $e) {
            // Log error database untuk debugging lebih lanjut
            Log::error('Registration Query Error: ' . $e->getMessage());
            // Jika user sudah terbuat tapi pelanggan gagal, hapus user untuk rollback
            if (isset($user) && $user->exists) {
                $user->delete();
            }
            return redirect()->back()->withInput()->withErrors(['registration_failed' => 'Pendaftaran gagal. Terjadi masalah database. Silakan coba lagi.']);
        } catch (\Exception $e) {
            // Log error tak terduga
            Log::error('Registration Unexpected Error: ' . $e->getMessage());
            // Jika user sudah terbuat tapi pelanggan gagal, hapus user untuk rollback
            if (isset($user) && $user->exists) {
                $user->delete();
            }
            return redirect()->back()->withInput()->withErrors(['registration_failed' => 'Pendaftaran gagal. Terjadi kesalahan tak terduga. Silakan hubungi administrator.']);
        }
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken(); 

        return redirect('login');
    }


    public function redirectToDashboard(): RedirectResponse
    {
        $userRole = Auth::user()->role;
        switch ($userRole) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'customer_service':
                return redirect()->route('cs.dashboard');
            case 'personal_trainer':
                return redirect()->route('trainer.dashboard');
            case 'pelanggan':
                return redirect()->route('pelanggan.dashboard');
            default:
                return redirect()->route('login');
        }
    }
}
