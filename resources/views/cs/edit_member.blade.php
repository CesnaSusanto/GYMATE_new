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
    <a href="{{ route('cs.dashboard', ['tab' => 'memberList']) }}"
       class="flex items-center gap-2 px-5 py-3 bg-gradient-to-r from-indigo-600 to-blue-500 text-white font-semibold rounded-lg shadow-md hover:from-indigo-700 hover:to-blue-600 transition duration-200 ease-in-out">
        <svg class="w-5 h-5" fill="none" stroke="currentColor"
             viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
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

                <form action="{{ route('cs.members.update', $member->id_pelanggan) }}" method="POST" class="max-w-5xl mx-auto bg-white shadow-xl rounded-xl p-8 mt-6">
    @csrf
    @method('PUT')

    <h1 class="text-3xl font-bold text-indigo-500 mb-8 border-b pb-3">Perbarui Profil Member</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        {{-- Username --}}
        <div>
            <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Username</label>
            <input type="text" name="username" id="username"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 @error('username') border-red-500 @enderror"
                value="{{ old('username', $member->user->username ?? '') }}" required>
            @error('username')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Nama --}}
        <div>
            <label for="nama_pelanggan" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
            <input type="text" name="nama_pelanggan" id="nama_pelanggan"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 @error('nama_pelanggan') border-red-500 @enderror"
                value="{{ old('nama_pelanggan', $member->nama_pelanggan) }}" required>
            @error('nama_pelanggan')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Jenis Kelamin --}}
        <div>
            <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin</label>
            <select name="jenis_kelamin" id="jenis_kelamin"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500"
                required>
                <option value="">Pilih Jenis Kelamin</option>
                <option value="Laki-laki" {{ old('jenis_kelamin', $member->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                <option value="Perempuan" {{ old('jenis_kelamin', $member->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
            </select>
        </div>

        {{-- No Telepon --}}
        <div>
            <label for="no_telp" class="block text-sm font-medium text-gray-700 mb-1">No. Telepon</label>
            <input type="text" name="no_telp" id="no_telp"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500"
                value="{{ old('no_telp', $member->no_telp) }}">
        </div>

        {{-- Paket Layanan --}}
        <div>
            <label for="paket_layanan" class="block text-sm font-medium text-gray-700 mb-1">Paket Layanan</label>
            <select name="paket_layanan" id="paket_layanan"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500"
                required>
                <option value="">Pilih Paket Layanan</option>
                <option value="biasa" {{ old('paket_layanan', $member->paket_layanan) == 'biasa' ? 'selected' : '' }}>Biasa</option>
                <option value="premium" {{ old('paket_layanan', $member->paket_layanan) == 'premium' ? 'selected' : '' }}>Premium</option>
            </select>
        </div>

        {{-- Personal Trainer --}}
        <div id="personal_trainer_selection" class="{{ old('paket_layanan', $member->paket_layanan) == 'premium' ? '' : 'hidden' }}">
            <label for="id_personal_trainer" class="block text-sm font-medium text-gray-700 mb-1">Personal Trainer</label>
            <select name="id_personal_trainer" id="id_personal_trainer"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500">
                <option value="">Pilih Personal Trainer</option>
                @foreach ($personalTrainers as $trainer)
                    <option value="{{ $trainer->id_personal_trainer }}"
                        {{ old('id_personal_trainer', $member->id_personal_trainer) == $trainer->id_personal_trainer ? 'selected' : '' }}>
                        {{ $trainer->nama_personal_trainer }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Berat --}}
        <div>
            <label for="berat_badan" class="block text-sm font-medium text-gray-700 mb-1">Berat (kg)</label>
            <input type="number" step="0.1" name="berat_badan" id="berat_badan"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500"
                value="{{ old('berat_badan', $member->berat_badan) }}" required>
        </div>

        {{-- Tinggi --}}
        <div>
            <label for="tinggi_badan" class="block text-sm font-medium text-gray-700 mb-1">Tinggi (cm)</label>
            <input type="number" step="0.1" name="tinggi_badan" id="tinggi_badan"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500"
                value="{{ old('tinggi_badan', $member->tinggi_badan) }}" required>
        </div>

        {{-- Status --}}
        <div>
            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status Akun</label>
            <select name="status" id="status"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500"
                required>
                <option value="Aktif" {{ old('status', $member->status) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="Tidak Aktif" {{ old('status', $member->status) == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                <option value="Beku" {{ old('status', $member->status) == 'Beku' ? 'selected' : '' }}>Beku</option>
            </select>
        </div>

        {{-- Tanggal Bergabung --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Bergabung</label>
            <p class="text-sm text-gray-600 bg-gray-100 px-4 py-2 rounded-md">
                {{ \Carbon\Carbon::parse($member->tanggal_bergabung)->translatedFormat('d F Y') }}
            </p>
        </div>
    </div>

    {{-- Tombol --}}
    <div class="flex justify-end gap-3 mt-10">
        <a href="{{ route('cs.dashboard', ['tab' => 'memberList']) }}"
           class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-600 bg-gray-200 hover:bg-gray-300 rounded-md">
            Batal
        </a>
        <button type="submit"
            class="inline-flex items-center px-6 py-2.5 bg-indigo-600 text-white text-sm font-semibold rounded-md shadow hover:bg-indigo-700 transition duration-200">
            Simpan Perubahan
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
