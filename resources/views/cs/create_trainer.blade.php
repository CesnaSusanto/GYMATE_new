<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GYMATE - Tambah Personal Trainer</title>
    {{-- Menggunakan CDN Tailwind CSS dengan JIT mode untuk kustomisasi --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'gym-red': '#E53E3E', // Menambahkan warna kustom 'gym-red'
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-300 font-sans h-screen flex flex-col items-center justify-center">
    <div class="flex flex-col justify-center items-center h-dvh w-full">
        <div class="bg-gym-red text-white text-center flex justify-center w-full py-4">
            <h1 class="text-2xl font-bold tracking-wider">GYMATE</h1>
        </div>

        <div class="flex flex-1 w-full justify-center items-center">
            <div class="p-8 flex flex-col items-center justify-center w-full">
                <div class="bg-white p-8 rounded-2xl shadow-2xl max-w-4xl mx-auto flex flex-col w-full">
                    <h1 class="text-3xl font-bold mb-8 text-center text-gray-900">Tambah Personal Trainer Baru</h1>

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

                    <form action="{{ route('cs.trainer.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- Informasi Akun --}}
                            <div>
                                <h2 class="text-xl font-semibold mb-4 text-gray-700 border-b pb-2">Informasi Akun Login</h2>
                                <div class="mb-4">
                                    <label for="username" class="block text-sm font-medium text-gray-700 mb-2">Username:</label>
                                    <input type="text" name="username" id="username"
                                            class="w-full px-4 py-3 bg-gray-100 border-0 rounded-lg focus:ring-2 focus:ring-gym-red focus:bg-white transition-colors @error('username') ring-2 ring-red-500 @enderror"
                                            value="{{ old('username') }}" required autofocus autocomplete="off">
                                    @error('username')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password:</label>
                                    <input type="password" name="password" id="password"
                                            class="w-full px-4 py-3 bg-gray-100 border-0 rounded-lg focus:ring-2 focus:ring-gym-red focus:bg-white transition-colors @error('password') ring-2 ring-red-500 @enderror"
                                            required autocomplete="new-password">
                                    @error('password')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-6">
                                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password:</label>
                                    <input type="password" name="password_confirmation" id="password_confirmation"
                                            class="w-full px-4 py-3 bg-gray-100 border-0 rounded-lg focus:ring-2 focus:ring-gym-red focus:bg-white transition-colors"
                                            required autocomplete="new-password">
                                </div>
                            </div>

                            {{-- Data Personal Trainer --}}
                            <div>
                                <h2 class="text-xl font-semibold mb-4 text-gray-700 border-b pb-2">Detail Personal Trainer</h2>
                                <div class="mb-4">
                                    <label for="nama_personal_trainer" class="block text-sm font-medium text-gray-700 mb-2">Nama Personal Trainer:</label>
                                    <input type="text" name="nama_personal_trainer" id="nama_personal_trainer"
                                            class="w-full px-4 py-3 bg-gray-100 border-0 rounded-lg focus:ring-2 focus:ring-gym-red focus:bg-white transition-colors @error('nama_personal_trainer') ring-2 ring-red-500 @enderror"
                                            value="{{ old('nama_personal_trainer') }}" required autocomplete="off">
                                    @error('nama_personal_trainer')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700 mb-2">Jenis Kelamin:</label>
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

                                <div class="mb-6">
                                    <label for="no_telp" class="block text-sm font-medium text-gray-700 mb-2">No. Telepon:</label>
                                    <input type="text" name="no_telp" id="no_telp"
                                            class="w-full px-4 py-3 bg-gray-100 border-0 rounded-lg focus:ring-2 focus:ring-gym-red focus:bg-white transition-colors @error('no_telp') ring-2 ring-red-500 @enderror"
                                            value="{{ old('no_telp') }}" required autocomplete="off">
                                    @error('no_telp')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="md:col-span-2 mb-6">
                                    <label for="foto_trainer" class="block text-sm font-medium text-gray-700 mb-2">Foto Profile Trainer (Opsional):</label>
                                    <input type="file" name="foto_trainer" id="foto_trainer" accept="image/*"
                                        class="w-full px-4 py-3 bg-gray-100 border-0 rounded-lg focus:ring-2 focus:ring-gym-red focus:bg-white transition-colors @error('foto_trainer') ring-2 ring-red-500 @enderror">
                                    @error('foto_trainer')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                    <p class="text-xs text-gray-500 mt-2">Format yang didukung: JPG, JPEG, PNG. Maksimal 2MB.</p>
                                </div>
                            </div>
                            
                        </div>

                        <div class="flex justify-end gap-4 mt-8 pt-6 border-t border-gray-200">
                            <a href="{{ route('cs.dashboard', ['tab' => 'trainerList']) }}"
                               class="px-6 py-3 bg-gray-500 text-white rounded-lg font-semibold hover:bg-gray-600 transition-colors">
                                Batal
                            </a>
                            <button type="submit"
                                    class="px-6 py-3 bg-gym-red text-white rounded-lg font-semibold hover:bg-red-600 transition-colors focus:ring-2 focus:ring-gym-red focus:ring-offset-2">
                                Tambah Trainer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>