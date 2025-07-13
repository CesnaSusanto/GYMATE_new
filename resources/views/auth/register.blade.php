<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi - Aplikasi Fitness</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
        <h2 class="text-2xl font-bold mb-6 text-center">Registrasi (Khusus Pelanggan)</h2>

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
                <input type="text" name="name" id="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('name') }}" required autofocus autocomplete="name">
            </div>

            <div class="mb-4">
                <label for="username" class="block text-gray-700 text-sm font-bold mb-2">Username</label>
                <input type="text" name="username" id="username" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('username') }}" required autocomplete="username">
            </div>

            <!-- <div class="mb-4">
                <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                <input type="email" name="email" id="email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('email') }}" required autocomplete="email">
            </div> -->

            <div class="mb-4">
                <label for="phone_number" class="block text-gray-700 text-sm font-bold mb-2">Nomor Telepon (dari users)</label>
                <input type="text" name="phone_number" id="phone_number" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('phone_number') }}" autocomplete="tel">
            </div>

            <div class="mb-4">
                <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                <input type="password" name="password" id="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required autocomplete="new-password">
            </div>

            <div class="mb-6">
                <label for="password_confirmation" class="block text-gray-700 text-sm font-bold mb-2">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required autocomplete="new-password">
            </div>

            <hr class="my-6 border-gray-300">
            <h3 class="text-xl font-bold mb-4 text-center">Data Diri Pelanggan</h3>

            <div class="mb-4">
                <label for="jenis_kelamin" class="block text-gray-700 text-sm font-bold mb-2">Jenis Kelamin</label>
                <select name="jenis_kelamin" id="jenis_kelamin" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                    <option value="">Pilih Jenis Kelamin</option>
                    <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="paket_layanan" class="block text-gray-700 text-sm font-bold mb-2">Paket Layanan</label>
                <select name="paket_layanan" id="paket_layanan" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                    <option value="">Pilih Paket Layanan</option>
                    <option value="biasa" {{ old('paket_layanan') == 'biasa' ? 'selected' : '' }}>Dasar</option>
                    <option value="Premium" {{ old('paket_layanan') == 'Premium' ? 'selected' : '' }}>Premium</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="berat_badan" class="block text-gray-700 text-sm font-bold mb-2">Berat Badan (kg)</label>
                <input type="number" name="berat_badan" id="berat_badan" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('berat_badan') }}" step="0.1" min="1" required>
            </div>

            <div class="mb-6">
                <label for="tinggi_badan" class="block text-gray-700 text-sm font-bold mb-2">Tinggi Badan (cm)</label>
                <input type="number" name="tinggi_badan" id="tinggi_badan" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('tinggi_badan') }}" step="0.1" min="1" required>
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
</body>
</html>