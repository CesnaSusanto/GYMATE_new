<?php

namespace App\Http\Controllers;
use Illuminate\Validation\Rules;
use App\Models\Pelanggan;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        // Jika user sudah login, arahkan ke dashboard
        if (Auth::check()) {
            return redirect('/');
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

        // Jika autentikasi gagal
        return back()->withErrors([
            'username' => 'Kredensial yang diberikan tidak cocok dengan catatan kami.',
        ])->onlyInput('username'); // Hanya tampilkan input email yang salah
    }

    public function showRegistrationForm(): \Illuminate\View\View | RedirectResponse
    {
        // Jika user sudah login, arahkan ke dashboard
        if (Auth::check()) {
            return redirect('/');
        }
        return view('auth.register');
    }

    public function register(Request $request): RedirectResponse
    {
        // dd($request->all());
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users,username'], // Username harus unik
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'phone_number' => ['nullable', 'string', 'max:20'], // Jika ada field ini
        
            'jenis_kelamin' => ['required', 'string', 'in:Laki-laki,Perempuan'],
            'paket_layanan' => ['required', 'string', 'max:50'],
            'berat_badan' => ['required', 'numeric', 'min:1'],
            'tinggi_badan' => ['required', 'numeric', 'min:1'],
        ]);

        // Buat user baru dengan role 'pelanggan'
        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => 'pelanggan', // HANYA PELANGGAN YANG BISA REGISTER PUBLIK
        ]);

        // Buat profil Pelanggan terkait secara otomatis
        // Pastikan tabel 'pelanggan' ada dan kolom 'user_id' cocok
        Pelanggan::create([
            'user_id' => $user->user_id,
            'nama_pelanggan' => $request->name, // Menggunakan 'name' dari form user untuk 'nama_pelanggan'
            'jenis_kelamin' => $request->jenis_kelamin,
            'no_telp' => $request->phone_number, // Menggunakan 'phone_number' dari form user
            'tanggal_bergabung' => now(), // Otomatis mengisi tanggal saat ini
            'paket_layanan' => $request->paket_layanan,
            'berat_badan' => $request->berat_badan,
            'tinggi_badan' => $request->tinggi_badan,
            'status' => 'Aktif', // Nilai default untuk status pelanggan baru
        ]);

        Auth::login($user); // Login user setelah registrasi

        $request->session()->regenerate(); // Regenerasi sesi

        return $this->redirectToDashboard(); // Redirect ke dashboard berdasarkan role
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout(); // Logout user

        $request->session()->invalidate(); // Invalidasi sesi
        $request->session()->regenerateToken(); // Regenerasi token CSRF

        return redirect('login'); // Arahkan ke halaman utama
    }

    /**
     * Helper method untuk redirect ke dashboard berdasarkan role.
     */
    protected function redirectToDashboard(): RedirectResponse
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
