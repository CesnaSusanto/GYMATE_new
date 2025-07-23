<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Personal Trainer - {{ $trainer->nama_personal_trainer }}</title>
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
<body class="bg-gray-300 font-sans h-screen flex flex-col">
    <div class="bg-gym-red text-white text-center flex justify-center w-full py-4">
        <h1 class="text-2xl font-bold tracking-wider">GYMATE</h1>
    </div>

    <div class="flex flex-1 w-full">
        <!-- <div class="w-56 bg-gray-300 flex flex-col py-4 border-r border-gray-400">
            <div class="flex-1">
                {{-- Link kembali ke dashboard CS, mengaktifkan tab trainerList --}}
                <a href="{{ route('cs.dashboard', ['tab' => 'trainerList']) }}"
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

        <div class="flex-1 p-8 flex items-center justify-center overflow-y-auto">
            <div class="bg-white p-8 rounded-2xl shadow-2xl max-w-4xl w-full">
                <h1 class="text-3xl font-bold mb-8 text-center text-gray-900">Edit Personal Trainer: {{ $trainer->nama_personal_trainer }}</h1>

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

                <form action="{{ route('cs.trainer.update', $trainer->id_personal_trainer) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Data User --}}
                        <div>
                            <h2 class="text-xl font-semibold mb-4 text-gray-700 border-b pb-2">Informasi Akun Login</h2>
                            <div class="mb-4">
                                <label for="username" class="block text-sm font-medium text-gray-700 mb-2">Username:</label>
                                <input type="text" name="username" id="username"
                                       class="w-full px-4 py-3 bg-gray-100 border-0 rounded-lg focus:ring-2 focus:ring-gym-red focus:bg-white transition-colors @error('username') ring-2 ring-red-500 @enderror"
                                       value="{{ old('username', $trainer->user->username ?? '') }}" required autocomplete="off">
                                @error('username')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            {{-- Password tidak ditampilkan di sini untuk alasan keamanan,
                                 jika ingin mengubah password, buat form terpisah. --}}
                        </div>

                        {{-- Data Personal Trainer --}}
                        <div>
                            <h2 class="text-xl font-semibold mb-4 text-gray-700 border-b pb-2">Detail Personal Trainer</h2>
                            <div class="mb-4">
                                <label for="nama_personal_trainer" class="block text-sm font-medium text-gray-700 mb-2">Nama Personal Trainer:</label>
                                <input type="text" name="nama_personal_trainer" id="nama_personal_trainer"
                                       class="w-full px-4 py-3 bg-gray-100 border-0 rounded-lg focus:ring-2 focus:ring-gym-red focus:bg-white transition-colors @error('nama_personal_trainer') ring-2 ring-red-500 @enderror"
                                       value="{{ old('nama_personal_trainer', $trainer->nama_personal_trainer) }}" required autocomplete="off">
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
                                    <option value="Laki-laki" {{ old('jenis_kelamin', $trainer->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="Perempuan" {{ old('jenis_kelamin', $trainer->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                                @error('jenis_kelamin')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-6">
                                <label for="no_telp" class="block text-sm font-medium text-gray-700 mb-2">No. Telepon:</label>
                                <input type="text" name="no_telp" id="no_telp"
                                       class="w-full px-4 py-3 bg-gray-100 border-0 rounded-lg focus:ring-2 focus:ring-gym-red focus:bg-white transition-colors @error('no_telp') ring-2 ring-red-500 @enderror"
                                       value="{{ old('no_telp', $trainer->no_telp) }}" autocomplete="off">
                                @error('no_telp')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
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
                            Perbarui Trainer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>