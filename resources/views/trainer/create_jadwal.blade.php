<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GYMATE - Tambah Jadwal Latihan</title>
    {{-- Menggunakan Tailwind CSS dari CDN dengan konfigurasi custom color --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'gym-red': '#E53E3E', // Menambahkan warna custom 'gym-red'
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-300 font-sans h-screen flex flex-col">

    {{-- Header seperti contoh --}}
    <div class="bg-gym-red text-white text-center flex justify-center w-full py-4">
        <h1 class="text-2xl font-bold tracking-wider">GYMATE</h1>
    </div>

    <div class="flex flex-1 w-full p-8 items-center justify-center overflow-y-auto">
        <div class="bg-white p-8 rounded-2xl shadow-2xl max-w-2xl w-full"> {{-- Menyesuaikan max-w agar tidak terlalu lebar --}}
            <h1 class="text-2xl uppercase font-bold py-4 text-center text-gray-900">Catat Kegiatan Latihan Baru</h1>
            {{-- Hapus <p>Pilih member untuk mencatat kegiatan latihan baru:</p> jika tidak diperlukan di sini --}}

            {{-- Menampilkan pesan sukses atau error dari session --}}
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative mb-6" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            @if($errors->any())
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

            <form action="{{ route('trainer.jadwal.store') }}" method="POST" class="space-y-6">
                @csrf
                <div class="mb-4">
                    <label for="member_for_session" class="block text-sm font-medium text-gray-700 mb-2">Pilih Member:</label>
                    <select name="id_pelanggan" id="member_for_session"
                            class="w-full px-4 py-3 bg-gray-100 border-0 rounded-lg focus:ring-2 focus:ring-gym-red focus:bg-white transition-colors @error('id_pelanggan') ring-2 ring-red-500 @enderror" required>
                        <option value="">-- Pilih Member --</option>
                        @foreach($pelanggans as $member)
                            <option value="{{ $member->id_pelanggan }}"
                                {{ old('id_pelanggan') == $member->id_pelanggan ? 'selected' : '' }}
                                {{ (isset($selectedPelangganId) && $selectedPelangganId == $member->id_pelanggan) ? 'selected' : '' }}>
                                {{ $member->nama_pelanggan }} ({{ $member->user->username ?? 'N/A' }})
                            </option>
                        @endforeach
                    </select>
                    @error('id_pelanggan')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="tanggal_latihan" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Kegiatan:</label>
                    <input type="date" name="tanggal_latihan" id="tanggal_latihan"
                           class="w-full px-4 py-3 bg-gray-100 border-0 rounded-lg focus:ring-2 focus:ring-gym-red focus:bg-white transition-colors @error('tanggal_latihan') ring-2 ring-red-500 @enderror"
                           value="{{ old('tanggal_latihan', date('Y-m-d')) }}" required>
                    @error('tanggal_latihan')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-6">
                    <label for="kegiatan_latihan" class="block text-sm font-medium text-gray-700 mb-2">Kegiatan Latihan:</label>
                    <textarea name="kegiatan_latihan" id="kegiatan_latihan" rows="5"
                              class="resize-y w-full px-4 py-3 bg-gray-100 border-0 rounded-lg focus:ring-2 focus:ring-gym-red focus:bg-white transition-colors @error('kegiatan_latihan') ring-2 ring-red-500 @enderror"
                              placeholder="Detail latihan, progres, rekomendasi, dll." required>{{ old('kegiatan_latihan') }}</textarea>
                    @error('kegiatan_latihan')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-6">
                    <label for="catatan_latihan" class="block text-sm font-medium text-gray-700 mb-2">Catatan Latihan (Opsional):</label>
                    <textarea name="catatan_latihan" id="catatan_latihan" rows="5"
                              class="resize-y w-full px-4 py-3 bg-gray-100 border-0 rounded-lg focus:ring-2 focus:ring-gym-red focus:bg-white transition-colors @error('catatan_latihan') ring-2 ring-red-500 @enderror"
                              placeholder="Catatan tambahan seperti kondisi fisik member, hal yang perlu diperhatikan, dll.">{{ old('catatan_latihan') }}</textarea>
                    @error('catatan_latihan')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex justify-end gap-4 mt-8 pt-6 border-t border-gray-200">
                    <a href="{{ route('trainer.show_jadwal', $selectedPelangganId ?? '') }}"
                       class="px-6 py-3 bg-gray-500 text-white rounded-lg font-semibold hover:bg-gray-600 transition-colors">
                        Batal
                    </a>
                    <button type="submit"
                            class="px-6 py-3 bg-gym-red text-white rounded-lg font-semibold hover:bg-red-600 transition-colors focus:ring-2 focus:ring-gym-red focus:ring-offset-2">
                        Simpan Kegiatan
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>