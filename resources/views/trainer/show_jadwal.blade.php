<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Latihan {{ $pelanggan->nama_pelanggan }}</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 font-sans">
    <div class="container mx-auto p-8">
        <div class="bg-white p-8 rounded-lg shadow-md">
            <div class="flex items-center mb-6">
                {{-- Tombol KEMBALI --}}
                <a href="{{ route('trainer.dashboard') }}?tab=memberList" class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-800 font-semibold rounded-md hover:bg-gray-300 transition duration-300">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    KEMBALI
                </a>
                <h1 class="text-3xl font-bold text-gray-800 ml-4">Jadwal Latihan {{ $pelanggan->nama_pelanggan }}</h1>
            </div>

            <div class="flex justify-end mb-6">
                {{-- Tombol TAMBAH --}}
                <a href="{{ route('trainer.dashboard') }}?tab=addSession&member_id={{ $pelanggan->id_pelanggan }}"
                   class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700 transition duration-300">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    TAMBAH
                </a>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            @if($jadwalLatihan->isEmpty())
                <p class="text-gray-600">Belum ada jadwal latihan yang dicatat untuk member ini.</p>
            @else
                <div class="space-y-4">
                    @foreach($jadwalLatihan as $index => $kartu) {{-- Ubah $catatan menjadi $kartu sesuai model --}}
                    <div class="flex items-center justify-between bg-gray-100 border border-gray-300 rounded-lg p-4 shadow-sm">
                        <div class="flex-1">
                            <p class="font-bold text-gray-900">Pertemuan Ke {{ $loop->iteration }}</p>
                            <p class="text-sm text-gray-700 mt-1">Tanggal: {{ \Carbon\Carbon::parse($kartu->tanggal_latihan)->format('d/m/Y') }}</p>
                            <p class="text-sm text-gray-700">Kegiatan: {{ $kartu->kegiatan_latihan }}</p>
                            @if($kartu->catatan_latihan) {{-- Sesuaikan dengan nama kolom di model Kartu --}}
                                <p class="text-xs text-gray-600 italic">Catatan: {{ $kartu->catatan_latihan }}</p>
                            @endif
                        </div>
                        <div class="flex-shrink-0 flex items-center space-x-2 ml-4">
                            {{-- Tombol Edit --}}
                            <a href="{{ route('trainer.sessions.edit', $kartu->id_kartu) }}" class="text-blue-600 hover:text-blue-800 transition duration-300">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            </a>
                            {{-- Tombol Delete --}}
                            <form action="{{ route('trainer.sessions.destroy', $kartu->id_kartu) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus sesi latihan ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 transition duration-300">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</body>
</html> -->