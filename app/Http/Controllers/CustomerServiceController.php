<?php

// app/Http/Controllers/CustomerServiceController.php

namespace App\Http\Controllers;

use App\Models\CustomerService;
use App\Models\User; // Digunakan untuk mencari user_id yang tersedia
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Import Auth Facade
use Illuminate\Validation\Rule; // Untuk validasi jika ada enum atau unique

class CustomerServiceController extends Controller
{
    /**
     * Tampilkan daftar Customer Service.
     * Hanya Admin yang bisa mengakses.
     */
    public function index()
    {
        $userRole = Auth::user()->role;
        if ($userRole !== 'admin') {
            abort(403, 'Akses Dilarang. Anda tidak memiliki izin untuk melihat daftar Customer Service.');
        }

        $customerServices = CustomerService::all();
        return view('cs.dashboard', compact('customerServices'));
    }

    /**
     * Tampilkan form untuk membuat Customer Service baru.
     * Hanya Admin yang bisa mengakses.
     */
    public function create()
    {
        $userRole = Auth::user()->role;
        if ($userRole !== 'admin') {
            abort(403, 'Akses Dilarang. Anda tidak memiliki izin untuk menambah Customer Service.');
        }

        // Ambil user yang belum terhubung dengan CS, PT, atau Pelanggan
        $availableUsers = User::doesntHave('customerService')
                            ->doesntHave('personalTrainer')
                            ->doesntHave('pelanggan')
                            ->get();

        return view('customer_service.create', compact('availableUsers'));
    }

    /**
     * Simpan Customer Service yang baru dibuat.
     * Hanya Admin yang bisa mengakses.
     */
    public function store(Request $request)
    {
        $userRole = Auth::user()->role;
        if ($userRole !== 'admin') {
            abort(403, 'Akses Dilarang. Anda tidak memiliki izin untuk menyimpan Customer Service.');
        }

        $request->validate([
            'user_id' => 'required|exists:users,user_id|unique:customer_service,user_id',
            'nama_cs' => 'required|string|max:255',
        ]);

        // Opsional: Perbarui role user menjadi 'customer_service'
        $user = User::find($request->user_id);
        if ($user) {
            $user->role = 'customer_service';
            $user->save();
        }

        CustomerService::create($request->all());

        return redirect()->route('admin.customer-service.index')
                         ->with('success', 'Customer Service berhasil ditambahkan!');
    }

    /**
     * Tampilkan detail Customer Service.
     * Hanya Admin yang bisa mengakses.
     */
    public function show(CustomerService $customer_service)
    {
        $userRole = Auth::user()->role;
        if ($userRole !== 'admin') {
            abort(403, 'Akses Dilarang. Anda tidak memiliki izin untuk melihat detail Customer Service.');
        }

        return view('customer_service.show', compact('customer_service'));
    }

    /**
     * Tampilkan form untuk mengedit Customer Service.
     * Hanya Admin yang bisa mengakses.
     */
    public function edit(CustomerService $customer_service)
    {
        $userRole = Auth::user()->role;
        if ($userRole !== 'admin') {
            abort(403, 'Akses Dilarang. Anda tidak memiliki izin untuk mengedit Customer Service.');
        }

        return view('customer_service.edit', compact('customer_service'));
    }

    /**
     * Update data Customer Service.
     * Hanya Admin yang bisa mengakses.
     */
    public function update(Request $request, CustomerService $customer_service)
    {
        $userRole = Auth::user()->role;
        if ($userRole !== 'admin') {
            abort(403, 'Akses Dilarang. Anda tidak memiliki izin untuk mengupdate Customer Service.');
        }

        $request->validate([
            'nama_cs' => 'required|string|max:255',
            // user_id tidak boleh diubah setelah dibuat
        ]);

        $customer_service->update($request->all());

        return redirect()->route('admin.customer-service.index')
                         ->with('success', 'Customer Service berhasil diperbarui!');
    }

    /**
     * Hapus Customer Service.
     * Hanya Admin yang bisa mengakses.
     */
    public function destroy(CustomerService $customer_service)
    {
        $userRole = Auth::user()->role;
        if ($userRole !== 'admin') {
            abort(403, 'Akses Dilarang. Anda tidak memiliki izin untuk menghapus Customer Service.');
        }

        // Opsional: Jika Anda ingin menghapus user terkait juga (jika tidak ada onDelete('cascade'))
        // if ($customer_service->user) {
        //     $customer_service->user->delete();
        // }

        $customer_service->delete();

        return redirect()->route('admin.customer-service.index')
                         ->with('success', 'Customer Service berhasil dihapus!');
    }
}