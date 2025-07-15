<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Catatan Latihan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6;
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-lg shadow-xl max-w-lg w-full mx-4">
        <h1 class="text-3xl font-bold mb-6 text-gray-800">Edit Catatan Latihan</h1>

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

        <form action="{{ route('pelanggan.catatan.update', $catatan->id_catatan) }}" method="POST">
            @csrf
            @method('PUT') {{-- Penting untuk metode PUT --}}

            <div class="mb-4">
                <label for="tanggal_latihan" class="block text-sm font-medium text-gray-700">Tanggal Latihan:</label>
                <input type="date" name="tanggal_latihan" id="tanggal_latihan" value="{{ old('tanggal_latihan', $catatan->tanggal_latihan->format('Y-m-d')) }}" class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
            </div>
            <div class="mb-4">
                <label for="kegiatan_latihan" class="block text-sm font-medium text-gray-700">Kegiatan Latihan:</label>
                <input type="text" name="kegiatan_latihan" id="kegiatan_latihan" value="{{ old('kegiatan_latihan', $catatan->kegiatan_latihan) }}" placeholder="Contoh: Latihan Dada & Trisep" class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
            </div>
            <div class="mb-6">
                <label for="catatan_latihan" class="block text-sm font-medium text-gray-700">Catatan:</label>
                <textarea name="catatan_latihan" id="catatan_latihan" rows="3" placeholder="Catatan detail tentang latihan (opsional)" class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('catatan_latihan', $catatan->catatan_latihan) }}</textarea>
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('pelanggan.dashboard', ['tab' => 'myNotes']) }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded-md shadow transition duration-300 ease-in-out">
                    Batal
                </a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-md shadow transition duration-300 ease-in-out">
                    Perbarui Catatan
                </button>
            </div>
        </form>
    </div>
</body>
</html>