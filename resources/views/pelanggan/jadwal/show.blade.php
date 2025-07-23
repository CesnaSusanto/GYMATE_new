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
<body class="flex items-center justify-center">
    <div class="flex flex-col h-screen justify-center w-full">
        <div class="bg-gym-red text-white text-center py-4">
            <h1 class="text-2xl font-bold tracking-wider">GYMATE</h1>
        </div>
        <div class="flex flex-col h-full p-8 justify-center items-center">
            <div class="bg-white p-8 rounded-lg shadow-xl max-w-2xl w-full flex flex-col justify-center items-center gap-8 ">
            
                <h1 class="text-2xl font-semibold uppercase text-gray-800">Detail Jadwal Latihan</h1>

                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative " role="alert">
                        {{ session('success') }}
                    </div>
                @endif
                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative " role="alert">
                        <strong class="font-bold">Oops!</strong>
                        <ul class="2 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="border-t border-gray-200 pt-9 w-full">
                    <div class="flex flex-col gap-6">
                        <div class="flex flex-row justify-between gap-4">
                            @if($kartu->personalTrainer)
                            <div class="flex flex-col gap-2 rounded-lg">
                                <p class="text-sm font-medium text-gray-500">Personal Trainer</p>
                                <p class="text-lg font-semibold text-gray-900">{{ $kartu->personalTrainer->nama_personal_trainer }}</p>
                            </div>
                            @endif
                            <div class="flex flex-col gap-2 rounded-lg justify-center items-center">
                                <p class="text-sm font-medium text-gray-500">Tanggal Latihan</p>
                                <p class="text-lg font-semibold text-gray-900">{{ $kartu->tanggal_latihan->format('d M Y') }}</p>
                            </div>
                        </div>
                        <div class="flex flex-col gap-2">
                            <p class="text-sm font-medium  text-gray-500">Kegiatan Latihan:</p>
                            <p class="text-lg font-semibold text-gray-900 bg-gray-100 h-36 overflow-auto p-4 rounded-lg">{{ $kartu->kegiatan_latihan }}</p>
                        </div>
                        <div class="flex flex-col gap-2">
                            <p class="text-sm font-medium text-gray-500">Catatan Trainer:</p>
                            <p class="text-lg font-semibold text-gray-900 bg-gray-100 h-36 overflow-auto p-4 rounded-lg">
                                {{ $kartu->catatan_latihan }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class=" flex justify-end">
                    <a href="{{ route('pelanggan.dashboard', ['tab' => 'mySchedule']) }}" class="bg-[#656565] hover:bg-gray-400 text-white font-semibold py-2 px-5 rounded-md shadow transition duration-300 ease-in-out">
                        Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
