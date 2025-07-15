<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi - Aplikasi Fitness</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    {{-- Anda bisa mengganti CDN ini jika Anda menggunakan proses build Tailwind CSS --}}
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
        <h2 class="text-2xl font-bold mb-6 text-center">Registrasi (Khusus Pelanggan)</h2>

        {{-- Menampilkan pesan error dari Laravel --}}
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Oops!</strong>
                <ul class="mt-2 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-4">
                <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Nama Lengkap</label>
                <input type="text" name="name" id="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('name') border-red-500 @enderror" value="{{ old('name') }}" required autofocus autocomplete="name">
                @error('name')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="username" class="block text-gray-700 text-sm font-bold mb-2">Username</label>
                <input type="text" name="username" id="username" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('username') border-red-500 @enderror" value="{{ old('username') }}" required autocomplete="username">
                @error('username')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="phone_number" class="block text-gray-700 text-sm font-bold mb-2">Nomor Telepon</label>
                <input type="text" name="phone_number" id="phone_number" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('phone_number') border-red-500 @enderror" value="{{ old('phone_number') }}" autocomplete="tel">
                @error('phone_number')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                <input type="password" name="password" id="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('password') border-red-500 @enderror" required autocomplete="new-password">
                @error('password')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="password_confirmation" class="block text-gray-700 text-sm font-bold mb-2">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required autocomplete="new-password">
                {{-- Error untuk password_confirmation biasanya ditangani oleh error 'password' karena aturan 'confirmed' --}}
            </div>

            <hr class="my-6 border-gray-300">
            <h3 class="text-xl font-bold mb-4 text-center">Data Diri Pelanggan</h3>

            <div class="mb-4">
                <label for="jenis_kelamin" class="block text-gray-700 text-sm font-bold mb-2">Jenis Kelamin</label>
                <select name="jenis_kelamin" id="jenis_kelamin" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('jenis_kelamin') border-red-500 @enderror" required>
                    <option value="">Pilih Jenis Kelamin</option>
                    <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                </select>
                @error('jenis_kelamin')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="paket_layanan" class="block text-gray-700 text-sm font-bold mb-2">Paket Layanan</label>
                <select name="paket_layanan" id="paket_layanan" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('paket_layanan') border-red-500 @enderror" required>
                    <option value="">Pilih Paket Layanan</option>
                    <option value="biasa" {{ old('paket_layanan') == 'biasa' ? 'selected' : '' }}>Biasa</option>
                    {{-- Pastikan "Premium" menggunakan huruf kapital P seperti di AuthController atau disesuaikan --}}
                    <option value="premium" {{ old('paket_layanan') == 'premium' ? 'selected' : '' }}>Premium</option>
                </select>
                @error('paket_layanan')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            {{-- ID div ini diubah menjadi 'personal_trainer_selection' agar konsisten dengan JS Anda sebelumnya --}}
            {{-- Name dan ID select ini diubah menjadi 'id_personal_trainer' agar konsisten dengan backend --}}
            <div id="personal_trainer_selection" class="mb-4 hidden">
                <label for="id_personal_trainer" class="block text-gray-700 text-sm font-bold mb-2">Pilih Personal Trainer</label>
                <select name="id_personal_trainer" id="id_personal_trainer" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('id_personal_trainer') border-red-500 @enderror">
                    <option value="">Pilih Personal Trainer</option>
                    @foreach ($personalTrainers as $trainer)
                        <option value="{{ $trainer->id_personal_trainer }}" {{ old('id_personal_trainer') == $trainer->id_personal_trainer ? 'selected' : '' }}>
                            {{ $trainer->nama_personal_trainer }}
                        </option>
                    @endforeach
                </select>
                @error('id_personal_trainer')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="berat_badan" class="block text-gray-700 text-sm font-bold mb-2">Berat Badan (kg)</label>
                <input type="number" name="berat_badan" id="berat_badan" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('berat_badan') border-red-500 @enderror" value="{{ old('berat_badan') }}" step="0.1" min="1" required>
                @error('berat_badan')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="tinggi_badan" class="block text-gray-700 text-sm font-bold mb-2">Tinggi Badan (cm)</label>
                <input type="number" name="tinggi_badan" id="tinggi_badan" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('tinggi_badan') border-red-500 @enderror" value="{{ old('tinggi_badan') }}" step="0.1" min="1" required>
                @error('tinggi_badan')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-full">
                    Daftar
                </button>
            </div>

            <p class="text-center text-sm text-gray-600 mt-4">
                Sudah punya akun? <a href="{{ route('login') }}" class="text-blue-500 hover:text-blue-800">Login di sini</a>
            </p>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var paketLayananSelect = document.getElementById('paket_layanan');
            var trainerFieldDiv = document.getElementById('personal_trainer_selection');
            var personalTrainerSelect = document.getElementById('id_personal_trainer'); // Menggunakan ID yang konsisten

            function toggleTrainerField() {
                if (paketLayananSelect.value === 'premium') {
                    trainerFieldDiv.classList.remove('hidden');
                    personalTrainerSelect.setAttribute('required', 'required'); // Menjadikan required
                } else {
                    trainerFieldDiv.classList.add('hidden');
                    personalTrainerSelect.removeAttribute('required'); // Menghapus required
                    personalTrainerSelect.value = ''; // Reset nilai pilihan Personal Trainer
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