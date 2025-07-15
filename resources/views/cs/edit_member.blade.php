<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Member - {{ $member->nama_pelanggan }}</title>
    {{-- Jika Anda menggunakan Vite untuk bundling aset, biarkan baris ini. --}}
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
    {{-- Jika tidak, gunakan CDN Tailwind CSS (seperti yang sudah ada) --}}
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 font-sans">
    <div class="flex h-screen">
        <!-- Sidebar - Sesuai dengan dashboard CS Anda -->
        <div class="w-64 bg-gray-800 text-white flex flex-col justify-between">
            <div>
                <div class="bg-red-600 p-4 text-center text-xl font-bold">GYMATE</div>
                <div class="p-4">
                    {{-- Link kembali ke dashboard CS, mengaktifkan tab memberList --}}
                    <a href="{{ route('cs.dashboard', ['tab' => 'memberList']) }}" class="block py-3 px-4 rounded hover:bg-gray-700 text-white font-semibold mb-2">
                        <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Kembali ke Dashboard CS
                    </a>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST" class="w-full">
                @csrf
                <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white py-4 px-6 text-lg font-bold flex items-center justify-center gap-2">
                    LOG OUT
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                    </svg>
                </button>
            </form>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-8 overflow-y-auto">
            <div class="bg-white p-8 rounded-lg shadow-md max-w-2xl mx-auto"> {{-- Menambahkan max-w-2xl mx-auto untuk centering --}}
                <h1 class="text-3xl font-bold mb-6 text-gray-800 text-center">Edit Member: {{ $member->nama_pelanggan }}</h1>

                {{-- Display success message --}}
                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Display validation errors --}}
                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <strong class="font-bold">Oops!</strong>
                        <span class="block sm:inline">Ada beberapa masalah dengan input Anda:</span>
                        <ul class="mt-3 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('cs.members.update', $member->id_pelanggan) }}" method="POST">
                    @csrf
                    @method('PUT') {{-- Penting untuk metode PUT --}}

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6"> {{-- Menggunakan grid untuk layout 2 kolom --}}
                        {{-- Data User --}}
                        <div>
                            <h2 class="text-xl font-semibold mb-4 text-gray-700 border-b pb-2">Informasi Akun Login</h2>
                            <div class="mb-4">
                                <label for="username" class="block text-gray-700 text-sm font-bold mb-2">Username:</label>
                                <input type="text" name="username" id="username"
                                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('username') border-red-500 @enderror"
                                       value="{{ old('username', $member->user->username ?? '') }}" required autocomplete="off">
                                @error('username')
                                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            {{-- Password tidak ditampilkan di sini untuk alasan keamanan,
                                 jika ingin mengubah password, buat form terpisah. --}}
                        </div>

                        {{-- Data Pelanggan --}}
                        <div>
                            <h2 class="text-xl font-semibold mb-4 text-gray-700 border-b pb-2">Detail Pelanggan</h2>
                            <div class="mb-4">
                                <label for="nama_pelanggan" class="block text-gray-700 text-sm font-bold mb-2">Nama Pelanggan:</label>
                                <input type="text" name="nama_pelanggan" id="nama_pelanggan"
                                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('nama_pelanggan') border-red-500 @enderror"
                                       value="{{ old('nama_pelanggan', $member->nama_pelanggan) }}" required autocomplete="off">
                                @error('nama_pelanggan')
                                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="jenis_kelamin" class="block text-gray-700 text-sm font-bold mb-2">Jenis Kelamin:</label>
                                <select name="jenis_kelamin" id="jenis_kelamin"
                                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('jenis_kelamin') border-red-500 @enderror"
                                        required>
                                    <option value="">Pilih Jenis Kelamin</option> {{-- Tambahkan opsi placeholder --}}
                                    <option value="Laki-laki" {{ old('jenis_kelamin', $member->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="Perempuan" {{ old('jenis_kelamin', $member->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                                @error('jenis_kelamin')
                                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="no_telp" class="block text-gray-700 text-sm font-bold mb-2">No. Telepon:</label>
                                <input type="text" name="no_telp" id="no_telp"
                                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('no_telp') border-red-500 @enderror"
                                       value="{{ old('no_telp', $member->no_telp) }}" autocomplete="off"> {{-- no_telp bisa nullable di registrasi, jadi tidak harus required di sini --}}
                                @error('no_telp')
                                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="paket_layanan" class="block text-gray-700 text-sm font-bold mb-2">Paket Layanan:</label>
                                <select name="paket_layanan" id="paket_layanan"
                                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('paket_layanan') border-red-500 @enderror"
                                        required>
                                    <option value="">Pilih Paket Layanan</option> {{-- Tambahkan opsi placeholder --}}
                                    <option value="biasa" {{ old('paket_layanan', $member->paket_layanan) == 'biasa' ? 'selected' : '' }}>Biasa</option>
                                    <option value="premium" {{ old('paket_layanan', $member->paket_layanan) == 'premium' ? 'selected' : '' }}>Premium</option>
                                </select>
                                @error('paket_layanan')
                                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Personal Trainer (hanya muncul jika Premium) --}}
                            {{-- ID div ini diubah menjadi 'personal_trainer_selection' agar konsisten dengan JS --}}
                            <div id="personal_trainer_selection" class="mb-4 {{ old('paket_layanan', $member->paket_layanan) == 'premium' ? '' : 'hidden' }}">
                                <label for="id_personal_trainer" class="block text-gray-700 text-sm font-bold mb-2">Pilih Personal Trainer:</label>
                                <select name="id_personal_trainer" id="id_personal_trainer"
                                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('id_personal_trainer') border-red-500 @enderror">
                                    <option value="">Pilih Personal Trainer</option>
                                    {{-- Pastikan $personalTrainers dikirim dari controller --}}
                                    @foreach ($personalTrainers as $trainer)
                                        <option value="{{ $trainer->id_personal_trainer }}"
                                            {{ old('id_personal_trainer', $member->id_personal_trainer) == $trainer->id_personal_trainer ? 'selected' : '' }}>
                                            {{ $trainer->nama_personal_trainer }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_personal_trainer')
                                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="berat_badan" class="block text-gray-700 text-sm font-bold mb-2">Berat Badan (kg):</label>
                                <input type="number" step="0.1" name="berat_badan" id="berat_badan"
                                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('berat_badan') border-red-500 @enderror"
                                       value="{{ old('berat_badan', $member->berat_badan) }}" required>
                                @error('berat_badan')
                                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="tinggi_badan" class="block text-gray-700 text-sm font-bold mb-2">Tinggi Badan (cm):</label>
                                <input type="number" step="0.1" name="tinggi_badan" id="tinggi_badan"
                                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('tinggi_badan') border-red-500 @enderror"
                                       value="{{ old('tinggi_badan', $member->tinggi_badan) }}" required>
                                @error('tinggi_badan')
                                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="status" class="block text-gray-700 text-sm font-bold mb-2">Status Akun:</label>
                                <select name="status" id="status"
                                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('status') border-red-500 @enderror"
                                        required>
                                    <option value="Aktif" {{ old('status', $member->status) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                    <option value="Tidak Aktif" {{ old('status', $member->status) == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                                    <option value="Beku" {{ old('status', $member->status) == 'Beku' ? 'selected' : '' }}>Beku</option>
                                </select>
                                @error('status')
                                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-6">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Tanggal Bergabung:</label>
                                <p class="py-2 px-3 text-gray-700 bg-gray-100 rounded">{{ \Carbon\Carbon::parse($member->tanggal_bergabung)->translatedFormat('d F Y') }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-3 mt-6 border-t pt-6">
                        <a href="{{ route('cs.dashboard', ['tab' => 'memberList']) }}" class="inline-block align-baseline font-bold text-sm text-gray-500 hover:text-gray-800">
                            Batal
                        </a>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Perbarui Member
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const paketLayananSelect = document.getElementById('paket_layanan');
            const personalTrainerSelectionDiv = document.getElementById('personal_trainer_selection');
            const personalTrainerSelect = document.getElementById('id_personal_trainer');

            function togglePersonalTrainerField() {
                if (paketLayananSelect.value === 'premium') {
                    personalTrainerSelectionDiv.classList.remove('hidden');
                    personalTrainerSelect.setAttribute('required', 'required');
                } else {
                    personalTrainerSelectionDiv.classList.add('hidden');
                    personalTrainerSelect.removeAttribute('required');
                    personalTrainerSelect.value = ''; // Reset pilihan PT saat tidak premium
                }
            }

            // Panggil saat halaman dimuat untuk menyesuaikan tampilan awal
            togglePersonalTrainerField();

            // Panggil setiap kali pilihan paket layanan berubah
            paketLayananSelect.addEventListener('change', togglePersonalTrainerField);
        });
    </script>
</body>
</html>
