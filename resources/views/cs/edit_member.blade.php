<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Member - {{ $member->nama_pelanggan }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'gym-red': '#E53E3E',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-300 font-sans h-screenitems-center justify-center">
    <div class="flex flex-col justify-center items-center h-dvh w-full">
        <!-- Header -->
        <div class="bg-gym-red text-white text-center flex justify-center w-full py-4">
            <h1 class="text-2xl font-bold tracking-wider">GYMATE</h1>
        </div>
        
        <div class="flex flex-1">
            <!-- Sidebar -->
            <!-- <div class="w-56 bg-gray-300 flex flex-col">
                <div class="flex-1 py-4">
                    <a href="{{ route('cs.dashboard', ['tab' => 'memberList']) }}" 
                       class="flex items-center px-6 py-3 text-gray-700 hover:bg-gray-400 border-b border-gray-400">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Kembali ke Dashboard CS
                    </a>
                </div>
                
                <form action="{{ route('logout') }}" method="POST" class="w-full">
                    @csrf
                    <button type="submit" class="w-full bg-gym-red hover:bg-red-600 text-white py-4 px-6 text-lg font-bold flex items-center justify-center gap-2">
                        LOG OUT
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                    </button>
                </form>
            </div> -->

            <!-- Main Content -->
            <div class="p-8 flex flex-col items-center justify-center">
                <div class="bg-white p-8 rounded-2xl shadow-2xl max-w-4xl mx-auto flex flex-col">
                    <h1 class="text-3xl font-bold mb-8 text-center text-gray-900">Edit Member: {{ $member->nama_pelanggan }}</h1>
                    
                    {{-- Display success message --}}
                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative mb-6" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    {{-- Display validation errors --}}
                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative mb-6" role="alert">
                            <strong class="font-bold">Oops!</strong>
                            <span class="block sm:inline">Ada beberapa masalah dengan input Anda:</span>
                            <ul class="mt-3 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('cs.members.update', $member->id_pelanggan) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- Username --}}
                            <div>
                                <label for="username" class="block text-sm font-medium text-gray-700 mb-2">Username</label>
                                <input type="text" name="username" id="username"
                                       class="w-full px-4 py-3 bg-gray-100 border-0 rounded-lg focus:ring-2 focus:ring-gym-red focus:bg-white transition-colors @error('username') ring-2 ring-red-500 @enderror"
                                       value="{{ old('username', $member->user->username ?? '') }}" required>
                                @error('username')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Nama --}}
                            <div>
                                <label for="nama_pelanggan" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                                <input type="text" name="nama_pelanggan" id="nama_pelanggan"
                                       class="w-full px-4 py-3 bg-gray-100 border-0 rounded-lg focus:ring-2 focus:ring-gym-red focus:bg-white transition-colors @error('nama_pelanggan') ring-2 ring-red-500 @enderror"
                                       value="{{ old('nama_pelanggan', $member->nama_pelanggan) }}" required>
                                @error('nama_pelanggan')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Jenis Kelamin --}}
                            <div>
                                <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700 mb-2">Jenis Kelamin</label>
                                <select name="jenis_kelamin" id="jenis_kelamin"
                                        class="w-full px-4 py-3 bg-gray-100 border-0 rounded-lg focus:ring-2 focus:ring-gym-red focus:bg-white transition-colors"
                                        required>
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="Laki-laki" {{ old('jenis_kelamin', $member->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="Perempuan" {{ old('jenis_kelamin', $member->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>

                            {{-- No Telepon --}}
                            <div>
                                <label for="no_telp" class="block text-sm font-medium text-gray-700 mb-2">No. Telepon</label>
                                <input type="text" name="no_telp" id="no_telp"
                                       class="w-full px-4 py-3 bg-gray-100 border-0 rounded-lg focus:ring-2 focus:ring-gym-red focus:bg-white transition-colors"
                                       value="{{ old('no_telp', $member->no_telp) }}">
                            </div>

                            {{-- Paket Layanan --}}
                            <div>
                                <label for="paket_layanan" class="block text-sm font-medium text-gray-700 mb-2">Paket Layanan</label>
                                <select name="paket_layanan" id="paket_layanan"
                                        class="w-full px-4 py-3 bg-gray-100 border-0 rounded-lg focus:ring-2 focus:ring-gym-red focus:bg-white transition-colors"
                                        required>
                                    <option value="">Pilih Paket Layanan</option>
                                    <option value="biasa" {{ old('paket_layanan', $member->paket_layanan) == 'biasa' ? 'selected' : '' }}>Biasa</option>
                                    <option value="premium" {{ old('paket_layanan', $member->paket_layanan) == 'premium' ? 'selected' : '' }}>Premium</option>
                                </select>
                            </div>

                            {{-- Personal Trainer --}}
                            <div id="personal_trainer_selection" class="{{ old('paket_layanan', $member->paket_layanan) == 'premium' ? '' : 'hidden' }}">
                                <label for="id_personal_trainer" class="block text-sm font-medium text-gray-700 mb-2">Personal Trainer</label>
                                <select name="id_personal_trainer" id="id_personal_trainer"
                                        class="w-full px-4 py-3 bg-gray-100 border-0 rounded-lg focus:ring-2 focus:ring-gym-red focus:bg-white transition-colors">
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
                                <label for="berat_badan" class="block text-sm font-medium text-gray-700 mb-2">Berat Badan (kg)</label>
                                <input type="number" step="0.1" name="berat_badan" id="berat_badan"
                                       class="w-full px-4 py-3 bg-gray-100 border-0 rounded-lg focus:ring-2 focus:ring-gym-red focus:bg-white transition-colors"
                                       value="{{ old('berat_badan', $member->berat_badan) }}" required>
                            </div>

                            {{-- Tinggi --}}
                            <div>
                                <label for="tinggi_badan" class="block text-sm font-medium text-gray-700 mb-2">Tinggi Badan (cm)</label>
                                <input type="number" step="0.1" name="tinggi_badan" id="tinggi_badan"
                                       class="w-full px-4 py-3 bg-gray-100 border-0 rounded-lg focus:ring-2 focus:ring-gym-red focus:bg-white transition-colors"
                                       value="{{ old('tinggi_badan', $member->tinggi_badan) }}" required>
                            </div>

                            {{-- Status --}}
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status Akun</label>
                                <select name="status" id="status"
                                        class="w-full px-4 py-3 bg-gray-100 border-0 rounded-lg focus:ring-2 focus:ring-gym-red focus:bg-white transition-colors"
                                        required>
                                    <option value="Aktif" {{ old('status', $member->status) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                    <option value="Tidak Aktif" {{ old('status', $member->status) == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                                    <option value="Beku" {{ old('status', $member->status) == 'Beku' ? 'selected' : '' }}>Beku</option>
                                </select>
                            </div>

                            {{-- Tanggal Bergabung --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Bergabung</label>
                                <div class="w-full px-4 py-3 bg-gray-100 rounded-lg text-gray-600">
                                    {{ \Carbon\Carbon::parse($member->tanggal_bergabung)->translatedFormat('d F Y') }}
                                </div>
                            </div>
                        </div>

                        {{-- Buttons --}}
                        <div class="flex justify-end gap-4 mt-8 pt-6 border-t border-gray-200">
                            <a href="{{ route('cs.dashboard', ['tab' => 'memberList']) }}"
                               class="px-6 py-3 bg-gray-500 text-white rounded-lg font-semibold hover:bg-gray-600 transition-colors">
                                Batal
                            </a>
                            <button type="submit"
                                    class="px-6 py-3 bg-gym-red text-white rounded-lg font-semibold hover:bg-red-600 transition-colors focus:ring-2 focus:ring-gym-red focus:ring-offset-2">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
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
                    personalTrainerSelect.value = '';
                }
            }

            // Call on page load to adjust initial display
            togglePersonalTrainerField();

            // Call whenever service package selection changes
            paketLayananSelect.addEventListener('change', togglePersonalTrainerField);
        });
    </script>
</body>
</html>
