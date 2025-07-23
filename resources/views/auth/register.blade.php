<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi - GYMATE</title>
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
<body class="bg-gray-300 min-h-screen flex items-center justify-center p-4">
    <div class="bg-white flex flex-col p-10 gap-10 rounded-2xl shadow-2xl w-full max-w-2xl">
        <h2 class="text-3xl font-bold text-center text-gray-900">Formulir Pendafataran</h2>
        
        {{-- Menampilkan pesan error dari Laravel --}}
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative mb-6" role="alert">
                <strong class="font-bold">Oops!</strong>
                <ul class="mt-2 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}" class="flex flex-col">
            @csrf
            
            <div class="flex-row flex gap-10">
                <div class="w-full flex flex-col gap-5">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                        <input type="text" name="name" id="name" 
                            class="w-full px-4 py-3 bg-gray-100 border-0 rounded-lg focus:ring-2 focus:ring-gym-red focus:bg-white transition-colors @error('name') ring-2 ring-red-500 @enderror" 
                            value="{{ old('name') }}" required autofocus autocomplete="name">
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="username" class="block text-sm font-medium text-gray-700 mb-2">Username</label>
                        <input type="text" name="username" id="username" 
                            class="w-full px-4 py-3 bg-gray-100 border-0 rounded-lg focus:ring-2 focus:ring-gym-red focus:bg-white transition-colors @error('username') ring-2 ring-red-500 @enderror" 
                            value="{{ old('username') }}" required autocomplete="username">
                        @error('username')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="phone_number" class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon</label>
                        <input type="text" name="phone_number" id="phone_number" 
                            class="w-full px-4 py-3 bg-gray-100 border-0 rounded-lg focus:ring-2 focus:ring-gym-red focus:bg-white transition-colors @error('phone_number') ring-2 ring-red-500 @enderror" 
                            value="{{ old('phone_number') }}" autocomplete="tel">
                        @error('phone_number')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                        <input type="password" name="password" id="password" 
                            class="w-full px-4 py-3 bg-gray-100 border-0 rounded-lg focus:ring-2 focus:ring-gym-red focus:bg-white transition-colors @error('password') ring-2 ring-red-500 @enderror" 
                            required autocomplete="new-password">
                        @error('password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" 
                            class="w-full px-4 py-3 bg-gray-100 border-0 rounded-lg focus:ring-2 focus:ring-gym-red focus:bg-white transition-colors" 
                            required autocomplete="new-password">
                    </div>
                </div>
                <div class="w-full flex flex-col gap-5">
                    <div>
                        <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700 mb-2">Jenis Kelamin</label>
                        <select name="jenis_kelamin" id="jenis_kelamin" 
                                class="w-full px-4 py-3 bg-gray-100 border-0 rounded-lg focus:ring-2 focus:ring-gym-red focus:bg-white transition-colors @error('jenis_kelamin') ring-2 ring-red-500 @enderror" 
                                required>
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('jenis_kelamin')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="paket_layanan" class="block text-sm font-medium text-gray-700 mb-2">Paket Layanan</label>
                        <select name="paket_layanan" id="paket_layanan" 
                                class="w-full px-4 py-3 bg-gray-100 border-0 rounded-lg focus:ring-2 focus:ring-gym-red focus:bg-white transition-colors @error('paket_layanan') ring-2 ring-red-500 @enderror" 
                                required>
                            <option value="">Pilih Paket Layanan</option>
                            <option value="biasa" {{ old('paket_layanan') == 'biasa' ? 'selected' : '' }}>Biasa</option>
                            <option value="premium" {{ old('paket_layanan') == 'premium' ? 'selected' : '' }}>Premium</option>
                        </select>
                        @error('paket_layanan')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div id="personal_trainer_selection" class="hidden">
                        <label for="id_personal_trainer" class="block text-sm font-medium text-gray-700 mb-2">Pilih Personal Trainer</label>
                        <select name="id_personal_trainer" id="id_personal_trainer" 
                                class="w-full px-4 py-3 bg-gray-100 border-0 rounded-lg focus:ring-2 focus:ring-gym-red focus:bg-white transition-colors @error('id_personal_trainer') ring-2 ring-red-500 @enderror">
                            <option value="">Pilih Personal Trainer</option>
                            @foreach ($personalTrainers as $trainer)
                                <option value="{{ $trainer->id_personal_trainer }}" {{ old('id_personal_trainer') == $trainer->id_personal_trainer ? 'selected' : '' }}>
                                    {{ $trainer->nama_personal_trainer }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_personal_trainer')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="berat_badan" class="block text-sm font-medium text-gray-700 mb-2">Berat Badan (kg)</label>
                        <input type="number" name="berat_badan" id="berat_badan" 
                            class="w-full px-4 py-3 bg-gray-100 border-0 rounded-lg focus:ring-2 focus:ring-gym-red focus:bg-white transition-colors @error('berat_badan') ring-2 ring-red-500 @enderror" 
                            value="{{ old('berat_badan') }}" step="0.1" min="1" required>
                        @error('berat_badan')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="tinggi_badan" class="block text-sm font-medium text-gray-700 mb-2">Tinggi Badan (cm)</label>
                        <input type="number" name="tinggi_badan" id="tinggi_badan" 
                            class="w-full px-4 py-3 bg-gray-100 border-0 rounded-lg focus:ring-2 focus:ring-gym-red focus:bg-white transition-colors @error('tinggi_badan') ring-2 ring-red-500 @enderror" 
                            value="{{ old('tinggi_badan') }}" step="0.1" min="1" required>
                        @error('tinggi_badan')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <button type="submit" 
                    class="w-full bg-gym-red text-white py-3 px-4 rounded-lg font-semibold text-lg hover:bg-red-600 transition-colors focus:ring-2 focus:ring-gym-red focus:ring-offset-2 mt-8">
                Daftar
            </button>

            <p class="text-center text-gray-600 mt-6">
                Sudah punya akun? 
                <a href="{{ route('login') }}" class="text-blue-500 hover:text-blue-600 transition-colors">
                    Login di sini
                </a>
            </p>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var paketLayananSelect = document.getElementById('paket_layanan');
            var trainerFieldDiv = document.getElementById('personal_trainer_selection');
            var personalTrainerSelect = document.getElementById('id_personal_trainer');
            
            function toggleTrainerField() {
                if (paketLayananSelect.value === 'premium') {
                    trainerFieldDiv.classList.remove('hidden');
                    personalTrainerSelect.setAttribute('required', 'required');
                } else {
                    trainerFieldDiv.classList.add('hidden');
                    personalTrainerSelect.removeAttribute('required');
                    personalTrainerSelect.value = '';
                }
            }
            
            // Panggil saat halaman dimuat (untuk kasus old() value)
            toggleTrainerField();
            
            // Panggil setiap kali pilihan paket layanan berubah
            paketLayananSelect.addEventListener('change', toggleTrainerField);
        });
    </script>
</body>
</html>