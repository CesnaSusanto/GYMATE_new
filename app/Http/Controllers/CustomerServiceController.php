<?php

// app/Http/Controllers/CustomerServiceController.php

namespace App\Http\Controllers;
use App\Models\Pelanggan;
use App\Models\User;
use App\Models\CustomerService;
use App\Models\PersonalTrainer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class CustomerServiceController extends Controller
{
    public function index()
    {
        // Metode ini mungkin kosong atau memiliki logika lain
    }

    // SHOW MEMBER AND TRAINER
    public function showManagementLists(Request $request)
    {

        $memberSearch = $request->input('member_search');
        $trainerSearch = $request->input('trainer_search');

        $userRole = Auth::user()->role;
        if ($userRole !== 'customer_service') {
            abort(403, 'Akses Dilarang. Anda tidak memiliki izin untuk melihat daftar ini.');
        }

        // --- Logic untuk Pelanggan ---

        $membersQuery = Pelanggan::query();
        $membersQuery->whereHas('user', function ($query) {
            $query->where('role', 'pelanggan');
        });

        if ($memberSearch) {
            $membersQuery->where(function ($query) use ($memberSearch) {
                $query->where('nama_pelanggan', 'like', '%' . $memberSearch . '%');
                $query->orWhereHas('user', function ($userQuery) use ($memberSearch) {
                    $userQuery->where('username', 'like', '%' . $memberSearch . '%');
                });
            });
        }

        $members = $membersQuery->get();

        // --- Logic untuk Personal Trainers ---
        $trainersQuery = PersonalTrainer::query();

        $trainersQuery->whereHas('user', function ($query) {
            $query->where('role', 'personal_trainer');
        });

        if ($trainerSearch) {
            $trainersQuery->where(function ($query) use ($trainerSearch) {
                $query->where('nama_personal_trainer', 'like', '%' . $trainerSearch . '%');
                $query->orWhereHas('user', function ($userQuery) use ($trainerSearch) {
                    $userQuery->where('username', 'like', '%' . $trainerSearch . '%');
                });
            });
        }
        $trainers = $trainersQuery->get();

        return view('cs.dashboard', compact('members', 'trainers', 'memberSearch', 'trainerSearch')); // Pastikan nama view ini 'cs.management'
    }


    // EDIT MEMBER
    public function editMember($id)
    {
        $userRole = Auth::user()->role;
        if ($userRole !== 'customer_service') {
            abort(403, 'Akses Dilarang. Anda tidak memiliki izin untuk mengedit member.');
        }
        $trainersQuery = PersonalTrainer::query();
        $personalTrainers = $trainersQuery->get();
        // Temukan pelanggan berdasarkan id_pelanggan dan muat relasi user-nya
        $member = Pelanggan::with('user')->find($id);

        // Jika member tidak ditemukan, redirect atau tampilkan error 404
        if (!$member) {
            abort(404, 'Member tidak ditemukan.');
        }

        // Pastikan user yang terkait dengan member memiliki role 'pelanggan'
        if (!$member->user || $member->user->role !== 'pelanggan') {
             abort(403, 'Akses Dilarang. Ini bukan member yang valid.');
        }

        return view('cs.edit_member', compact('member','personalTrainers'));
    }

    /**
     * Memperbarui data member (pelanggan) di database.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id ID pelanggan
     * @return \Illuminate\Http\RedirectResponse
     */

    
    //  UPDATE MEMBER
    public function updateMember(Request $request, $id)
    {
        $userRole = Auth::user()->role;
        if ($userRole !== 'customer_service') {
            abort(403, 'Akses Dilarang. Anda tidak memiliki izin untuk memperbarui member.');
        }

        // Temukan pelanggan berdasarkan id_pelanggan
        $member = Pelanggan::with('user')->find($id);

        if (!$member) {
            return redirect()->route('cs.dashboard')->with('error', 'Member tidak ditemukan.');
        }

        // Validasi data input
        $request->validate([
            'nama_pelanggan' => 'required|string|max:255',
            'username' => [
                'required',
                'string',
                'min:3',
                'max:255',
                Rule::unique('users')->ignore($member->user->user_id, 'user_id'),
            ],

            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan', // Sesuaikan dengan opsi yang Anda miliki
            'no_telp' => 'nullable|string|max:20',
            'paket_layanan' => 'required|string|max:255',
            'berat_badan' => 'nullable|numeric|min:1',
            'tinggi_badan' => 'nullable|numeric|min:1',
            'status' => 'required|in:Aktif,Tidak Aktif,Beku', // Sesuaikan dengan opsi status yang Anda miliki
            // 'password' => 'nullable|string|min:8|confirmed', // Jika ingin memungkinkan perubahan password
        ]);

        if ($member->user) {
            $member->user->username = $request->username;
            $member->user->save();
        }

        // Update data di tabel `pelanggan`
        $member->nama_pelanggan = $request->nama_pelanggan;
        $member->jenis_kelamin = $request->jenis_kelamin;
        $member->no_telp = $request->no_telp;
        $member->paket_layanan = $request->paket_layanan;
        $member->berat_badan = $request->berat_badan;
        $member->tinggi_badan = $request->tinggi_badan;
        $member->status = $request->status;
        $member->save();

        // Redirect kembali ke halaman daftar member dengan pesan sukses
        return redirect()->route('cs.dashboard')->with('success', 'Data member berhasil diperbarui.');
    }



    // DELETE MEMBER
    public function deleteMember($id)
    {
        $userRole = Auth::user()->role;
        if ($userRole !== 'customer_service') {
            abort(403, 'Akses Dilarang. Anda tidak memiliki izin untuk menghapus member.');
        }

        $member = Pelanggan::find($id);

        if (!$member) {
            return redirect()->route('cs.dashboard')->with('error', 'Member tidak ditemukan.');
        }

        $member->delete(); // Ini akan menghapus member dan, karena onDelete('cascade'), user terkait juga

        if ($member->user) {
            $member->user->delete();
        }

        return redirect()->route('cs.dashboard')->with('success', 'Member berhasil dihapus.');
    }


    // EDIT TRAINER
    public function editTrainer($id)
    {
        $userRole = Auth::user()->role;
        if ($userRole !== 'customer_service') {
            abort(403, 'Akses Dilarang. Anda tidak memiliki izin untuk mengedit personal trainer.');
        }

        $trainer = PersonalTrainer::with('user')->find($id);

        if (!$trainer) {
            abort(404, 'Personal Trainer tidak ditemukan.');
        }

        if (!$trainer->user || $trainer->user->role !== 'personal_trainer') {
             abort(403, 'Akses Dilarang. Ini bukan personal trainer yang valid.');
        }

        return view('cs.edit_trainer', compact('trainer'));
    }

    /**
     * Memperbarui data personal trainer di database.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id ID personal trainer
     * @return \Illuminate\Http\RedirectResponse
     */

    
    // CREATE TRAINER
    public function createTrainer()
    {
        // Pastikan hanya customer_service yang bisa mengakses
        if (Auth::user()->role !== 'customer_service') {
            abort(403, 'Akses Dilarang.');
        }
        return view('cs.create_trainer');
    }


    // UPDATE TRAINER
    public function updateTrainer(Request $request, $id)
    {
        $userRole = Auth::user()->role;
        if ($userRole !== 'customer_service') {
            abort(403, 'Akses Dilarang. Anda tidak memiliki izin untuk memperbarui personal trainer.');
        }

        $trainer = PersonalTrainer::with('user')->find($id);

        if (!$trainer) {
            return redirect()->route('cs.dashboard')->with('error', 'Personal Trainer tidak ditemukan.');
        }

        // Validasi data input
        $request->validate([
            'nama_personal_trainer' => 'required|string|max:255',
            'username' => [
                'required',
                'string',
                'min:3',
                'max:255',
                Rule::unique('users')->ignore($trainer->user->user_id, 'user_id'),
            ],
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'no_telp' => 'nullable|string|max:20',
        ]);

        if ($trainer->user) {
            $trainer->user->username = $request->username;
            $trainer->user->save();
        }

        $trainer->nama_personal_trainer = $request->nama_personal_trainer;
        $trainer->jenis_kelamin = $request->jenis_kelamin;
        $trainer->no_telp = $request->no_telp;
        $trainer->save();

        return redirect()->route('cs.dashboard')->with('success', 'Data Personal Trainer berhasil diperbarui.');
    }


    // STORE TRAINER
    public function storeTrainer(Request $request)
    {
        // Pastikan hanya customer_service yang bisa mengakses
    if (Auth::user()->role !== 'customer_service') {
        abort(403, 'Akses Dilarang.');
    }

    // Validasi data input
    // dd($request->all());
    $validatedData = $request->validate([
        'username' => ['required', 'string', 'max:255', 'unique:users'],
        'password' => ['required', 'string', 'min:8', 'confirmed'],
        'nama_personal_trainer' => ['required', 'string', 'max:255'],
        'jenis_kelamin' => ['required', 'string', Rule::in(['Laki-laki', 'Perempuan'])],
        'no_telp' => ['required', 'string', 'max:15'],
    ]);
    // dd($validatedData);

    // 1. Buat user baru dengan role 'personal_trainer'
    // DI SINI Anda menetapkan role-nya!
    $user = User::create([
        'username' => $validatedData['username'],
        'password' => Hash::make($validatedData['password']),
        'role' => 'personal_trainer', // <--- BARIS INI PENTING!
    ]);
    // dd($user);

    // 2. Buat personal trainer baru dan hubungkan dengan user yang baru dibuat
    PersonalTrainer::create([
        'user_id' => $user->user_id, // Menggunakan ID dari user yang baru dibuat
        'nama_personal_trainer' => $validatedData['nama_personal_trainer'],
        'jenis_kelamin' => $validatedData['jenis_kelamin'],
        'no_telp' => $validatedData['no_telp'],
    ]);

    return redirect()->route('cs.dashboard')->with('success', 'Personal Trainer berhasil ditambahkan.');
    }


    // DELETE TRAINER
    public function deleteTrainer($id)
    {
        $userRole = Auth::user()->role;
        if ($userRole !== 'customer_service') {
            abort(403, 'Akses Dilarang. Anda tidak memiliki izin untuk menghapus personal trainer.');
        }

        $trainer = PersonalTrainer::find($id);

        if (!$trainer) {
            return redirect()->route('cs.dashboard')->with('error', 'Personal Trainer tidak ditemukan.');
        }

        // Jika Anda memiliki onDelete('cascade') di migrasi foreign key user_id,
        // maka menghapus trainer akan otomatis menghapus user terkait.
        // Jika tidak, Anda perlu menghapus user secara manual seperti ini:
        if ($trainer->user) {
            $trainer->user->delete();
        }

        $trainer->delete(); // Ini akan menghapus trainer dan, karena onDelete('cascade'), user terkait juga

        return redirect()->route('cs.dashboard')->with('success', 'Personal Trainer berhasil dihapus.');
    }
}