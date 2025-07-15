<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Sesi Latihan</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 font-sans">
    <div class="container mx-auto p-8">
        <div class="bg-white p-8 rounded-lg shadow-md">
            <h1 class="text-3xl font-bold text-gray-800 mb-6">Edit Sesi Latihan untuk {{ $pelanggan->nama_pelanggan }}</h1>

            <form action="{{ route('trainer.jadwal.update', $kartu->id_kartu) }}" method="POST">
                @csrf
                @method('PUT') {{-- Penting untuk metode UPDATE --}}

                <div class="mb-4">
                    <label for="session_date" class="block text-gray-700 text-sm font-bold mb-2">Tanggal Latihan:</label>
                    <input type="date" name="session_date" id="session_date"
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                           value="{{ old('session_date', \Carbon\Carbon::parse($kartu->tanggal_latihan)->format('Y-m-d')) }}" required>
                    @error('session_date')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="kegiatan_latihan" class="block text-gray-700 text-sm font-bold mb-2">Kegiatan Latihan:</label>
                    <input type="text" name="kegiatan_latihan" id="kegiatan_latihan"
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                           value="{{ old('kegiatan_latihan', $kartu->kegiatan_latihan) }}" required>
                    @error('kegiatan_latihan')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="catatan_latihan" class="block text-gray-700 text-sm font-bold mb-2">Catatan Latihan (Opsional):</label>
                    <textarea name="catatan_latihan" id="catatan_latihan" rows="4"
                              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('catatan_latihan', $kartu->catatan_latihan) }}</textarea>
                    @error('catatan_latihan')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Simpan Perubahan
                    </button>
                    <a href="{{ route('trainer.show_jadwal', $kartu->id_pelanggan) }}" class="inline-block align-baseline font-bold text-sm text-gray-600 hover:text-gray-800">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>