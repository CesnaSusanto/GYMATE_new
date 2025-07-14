<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Member - {{ $member->nama_pelanggan }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans">
    <div class="flex h-screen">
        <div class="w-64 bg-gray-800 text-white flex flex-col justify-between">
            <div>
                <div class="bg-red-600 p-4 text-center text-xl font-bold">GYMATE</div>
                
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

        <div class="flex-1 p-8 overflow-y-auto">
            <div class="bg-white p-8 rounded-lg shadow-md">
                <h1 class="text-3xl font-bold mb-6 text-gray-800">Edit Member: {{ $member->nama_pelanggan }}</h1>

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

                    <div class="flex flex-col">
                        {{-- Data User --}}
                        <div>
                            <h2 class="text-xl font-semibold mb-4 text-gray-700">Informasi Akun</h2>
                            <div class="mb-4">
                                <label for="username" class="block text-gray-700 text-sm font-bold mb-2">Username:</label>
                                <input type="text" name="username" id="username"
                                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                       value="{{ old('username', $member->user->username) }}" required>
                            </div>
                        </div>

                        {{-- Data Pelanggan --}}
                        <div>
                            <div class="mb-4">
                                <label for="nama_pelanggan" class="block text-gray-700 text-sm font-bold mb-2">Nama Pelanggan:</label>
                                <input type="text" name="nama_pelanggan" id="nama_pelanggan"
                                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                       value="{{ old('nama_pelanggan', $member->nama_pelanggan) }}" required>
                            </div>

                            <div class="mb-4">
                                <label for="jenis_kelamin" class="block text-gray-700 text-sm font-bold mb-2">Jenis Kelamin:</label>
                                <select name="jenis_kelamin" id="jenis_kelamin"
                                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                        required>
                                    <option value="Laki-laki" {{ old('jenis_kelamin', $member->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="Perempuan" {{ old('jenis_kelamin', $member->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label for="no_telp" class="block text-gray-700 text-sm font-bold mb-2">No. Telepon:</label>
                                <input type="text" name="no_telp" id="no_telp"
                                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                       value="{{ old('no_telp', $member->no_telp) }}">
                            </div>

                            {{-- --- PERUBAHAN INI UNTUK PAKET LAYANAN --- --}}
                            <div class="mb-4">
                                <label for="paket_layanan" class="block text-gray-700 text-sm font-bold mb-2">Paket Layanan:</label>
                                <select name="paket_layanan" id="paket_layanan"
                                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                        required>
                                    <option value="Biasa" {{ old('paket_layanan', $member->paket_layanan) == 'Biasa' ? 'selected' : '' }}>Biasa</option>
                                    <option value="Premium" {{ old('paket_layanan', $member->paket_layanan) == 'Premium' ? 'selected' : '' }}>Premium</option>
                                </select>
                            </div>
                            {{-- --------------------------------------- --}}

                            <div class="mb-4">
                                <label for="berat_badan" class="block text-gray-700 text-sm font-bold mb-2">Berat Badan (kg):</label>
                                <input type="number" step="0.1" name="berat_badan" id="berat_badan"
                                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                       value="{{ old('berat_badan', $member->berat_badan) }}">
                            </div>

                            <div class="mb-4">
                                <label for="tinggi_badan" class="block text-gray-700 text-sm font-bold mb-2">Tinggi Badan (cm):</label>
                                <input type="number" step="0.1" name="tinggi_badan" id="tinggi_badan"
                                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                       value="{{ old('tinggi_badan', $member->tinggi_badan) }}">
                            </div>

                            <div class="mb-4">
                                <label for="status" class="block text-gray-700 text-sm font-bold mb-2">Status Akun:</label>
                                <select name="status" id="status"
                                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                        required>
                                    <option value="Aktif" {{ old('status', $member->status) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                    <option value="Tidak Aktif" {{ old('status', $member->status) == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                                    <option value="Beku" {{ old('status', $member->status) == 'Beku' ? 'selected' : '' }}>Beku</option>
                                </select>
                            </div>
                            {{-- Tanggal Bergabung biasanya tidak diedit, hanya ditampilkan --}}
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Tanggal Bergabung:</label>
                                <p class="py-2 px-3 text-gray-700 bg-gray-100 rounded">{{ \Carbon\Carbon::parse($member->tanggal_bergabung)->translatedFormat('d F Y') }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-3">
                        <a href="{{ route('cs.dashboard') }}" class="inline-block align-baseline font-bold text-sm text-blue-600 hover:text-blue-800">
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
</body>
</html>