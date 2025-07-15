<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GYMATE - Tambah Jadwal Latihan</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 font-sans">
    <div class="container mx-auto p-8">
        <div class="bg-white p-8 rounded-lg shadow-md">
            <h2 class="text-2xl font-semibold mb-4 text-purple-800">Catat Kegiatan Latihan Baru</h2>
            <p class="text-gray-600 mb-4">Pilih member untuk mencatat kegiatan latihan baru:</p>

            {{-- Menampilkan pesan sukses atau error dari session --}}
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('trainer.jadwal.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="member_for_session" class="block text-gray-700 text-sm font-bold mb-2">Pilih Member</label>
                    <select name="id_pelanggan" id="member_for_session" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('id_pelanggan') border-red-500 @enderror" required>
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
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="tanggal_latihan" class="block text-gray-700 text-sm font-bold mb-2">Tanggal Kegiatan</label>
                    <input type="date" name="tanggal_latihan" id="tanggal_latihan" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('tanggal_latihan') border-red-500 @enderror" value="{{ old('tanggal_latihan', date('Y-m-d')) }}" required>
                    @error('tanggal_latihan')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-6">
                    <label for="kegiatan_latihan" class="block text-gray-700 text-sm font-bold mb-2">Kegiatan Latihan</label>
                    <textarea name="kegiatan_latihan" id="kegiatan_latihan" rows="5" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('kegiatan_latihan') border-red-500 @enderror" placeholder="Detail latihan, progres, rekomendasi, dll." required>{{ old('kegiatan_latihan') }}</textarea>
                    @error('kegiatan_latihan')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-6">
                    <label for="catatan_latihan" class="block text-gray-700 text-sm font-bold mb-2">Catatan Latihan</label>
                    <textarea name="catatan_latihan" id="catatan_latihan" rows="5" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('catatan_latihan') border-red-500 @enderror" placeholder="Detail latihan, progres, rekomendasi, dll.">{{ old('catatan_latihan') }}</textarea> {{-- Hilangkan 'required' jika catatan_latihan nullable --}}
                    @error('catatan_latihan')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex items-center justify-between">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Simpan Kegiatan
                    </button>
                    {{-- Tambahkan tombol kembali --}}
                    <a href="{{ route('trainer.show_jadwal', $selectedPelangganId) }}" class="inline-block align-baseline font-bold text-sm text-gray-600 hover:text-gray-800">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>