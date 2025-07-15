<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Jadwal Latihan</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6; /* Light gray background */
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-lg shadow-xl max-w-2xl w-full mx-4">
        <h1 class="text-3xl font-bold mb-6 text-gray-800">Detail Jadwal Latihan</h1>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                {{ session('success') }}
            </div>
        @endif
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

        <div class="border-t border-gray-200 pt-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                    <p class="text-sm font-medium text-gray-500">Tanggal Latihan:</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $kartu->tanggal_latihan->format('d M Y') }}</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                    <p class="text-sm font-medium text-gray-500">Kegiatan Latihan:</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $kartu->kegiatan_latihan }}</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg shadow-sm md:col-span-2">
                    <p class="text-sm font-medium text-gray-500">Catatan Trainer:</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $kartu->catatan_latihan ?? 'Tidak ada catatan.' }}</p>
                </div>
                @if($kartu->personalTrainer)
                <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                    <p class="text-sm font-medium text-gray-500">Personal Trainer:</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $kartu->personalTrainer->nama_personal_trainer }}</p>
                </div>
                @endif
            </div>
        </div>

        <div class="mt-8 flex justify-end">
            <a href="{{ route('pelanggan.dashboard', ['tab' => 'mySchedule']) }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded-md shadow transition duration-300 ease-in-out">
                Kembali ke Jadwal
            </a>
        </div>
    </div>
</body>
</html>
