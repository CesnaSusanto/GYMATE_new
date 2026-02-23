<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Latihan {{ $pelanggan->nama_pelanggan }} - GYMATE</title>
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
    <style>
    /* 1. Paksa background putih dan teks gelap untuk semua kotak paginasi (termasuk ikon panah) */
    nav[role="navigation"] a, 
    nav[role="navigation"] span[aria-disabled="true"] > span {
        background-color: #ffffff !important;
        color: #4b5563 !important; /* Warna teks abu-abu agar kontras dan mudah dibaca */
        border-color: #d1d5db !important;
    }

    /* 2. Warna untuk tombol halaman yang SEDANG AKTIF (misal sedang di halaman 1) */
    nav[role="navigation"] span[aria-current="page"] > span {
        background-color: #E53E3E !important; /* Warna merah gym-red */
        color: #ffffff !important; /* Teks putih */
        border-color: #E53E3E !important;
    }

    /* 3. Efek warna saat tombol ditunjuk oleh mouse (Hover) */
    nav[role="navigation"] a:hover {
        background-color: #f3f4f6 !important; /* Abu-abu sangat terang */
        color: #E53E3E !important; /* Teks berubah menjadi merah */
    }
</style>
</head>
<body class="bg-gray-300 font-sans">
    <div class="flex flex-col h-screen">
        <div class="bg-gym-red text-white text-center py-4">
            <h1 class="text-2xl font-bold tracking-wider">GYMATE</h1>
        </div>
        
        <div class="flex flex-row h-full ">
            <div class="w-64 bg-white flex flex-col">
                <div class="flex-1">
                    <a href="{{ route('trainer.dashboard') }}?tab=accountInfo" id="showAccountInfo"
                       class="sidebar-item flex items-center px-6 py-3 text-gray-700 hover:bg-gray-400 border-b border-gray-400"
                       data-target="accountInfo">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        Informasi Akun
                    </a>
                    <a href="{{ route('trainer.dashboard') }}?tab=memberList" id="showpelanggan"
                       class="sidebar-item flex items-center px-6 py-3 text-gray-700 hover:bg-gray-400 border-b border-gray-400"
                       data-target="memberList">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h2a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2h2m3-4H9V8h4m-4 0v4m4-4h2"></path></svg>
                        List Member
                    </a>
                    {{-- Anda bisa menambahkan item sidebar lain di sini --}}
                </div>
                <form action="{{ route('logout') }}" method="POST" class="w-full">
                    @csrf
                    <button type="submit" class="w-full bg-gym-red hover:bg-red-600 text-white py-4 px-6 text-lg font-bold flex items-center justify-center gap-2">
                        LOG OUT
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                    </button>
                </form>
            </div>

            <div class="flex flex-col w-full h-full bg-gray-300 overflow-y-auto p-8">
                <div class="bg-white p-8 rounded-2xl shadow-xl flex flex-col gap-6 h-full">
                    <div class="flex flex-col gap-6 items-center justify-between">
                        <h1 class="text-2xl uppercase font-semibold text-gray-900">Jadwal Latihan {{ $pelanggan->nama_pelanggan }}</h1>
                        <div class="flex flex-row gap-4 w-full">
                            <a href="{{ route('trainer.dashboard') }}?tab=memberList" class="bg-gray-500 hover:bg-gray-600 px-6 py-3 text-white rounded-lg">
                                kembali
                            </a>
                            <a href="{{ route('trainer.jadwal.create', ['pelanggan' => $pelanggan->id_pelanggan]) }}"
                            class="flex flex-row justify-center items-center bg-gym-red text-white font-semibold rounded-lg hover:bg-red-600 transition-colors shadow-sm w-full ">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                TAMBAH JADWAL
                            </a>
                        </div>
                    </div>

                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative mb-6" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative mb-6" role="alert">
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif

                    @if($jadwalLatihan->isEmpty())
                        <div class="text-center py-16">
                            <div class="bg-gray-50 p-12 rounded-lg border border-gray-200">
                                <svg class="w-20 h-20 text-gray-400 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <p class="text-gray-600 text-xl mb-4">Belum ada jadwal latihan yang dicatat untuk member ini.</p>
                                <p class="text-gray-500">Mulai tambahkan jadwal latihan untuk member Anda.</p>
                            </div>
                        </div>
                    @else
                        <div class="flex flex-col gap-4 h-full justify-between overflow-auto">
                            <div class="flex flex-col gap-4 overflow-auto max-h-full">
                                @foreach($jadwalLatihan as $index => $kartu)
                                <a href="{{ route('trainer.jadwal.edit', $kartu->id_kartu) }}" class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm hover:shadow-md transition-shadow">
                                    <div class="flex items-center justify-between">
                                        <div class="flex flex-row">
                                            <div class="flex flex-col gap-2">
                                                <p class="text-lg font-semibold text-gray-900 uppercase">{{ $kartu->kegiatan_latihan }}</p>
                                                <div class="flex flex-col ">
                                                    <p class="text-sm font-medium text-gray-500">Tanggal Latihan : {{ \Carbon\Carbon::parse($kartu->tanggal_latihan)->format('d/m/Y') }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="flex items-center space-x-3 ml-6">
                                            <form action="{{ route('trainer.jadwal.destroy', $kartu->id_kartu) }}" method="POST" 
                                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus sesi latihan ini?');" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="bg-gym-red hover:bg-red-600 text-white p-3 rounded-lg transition-colors" 
                                                        title="Hapus Sesi Latihan">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5-4h4m-4 0a1 1 0 00-1 1v1h6V4a1 1 0 00-1-1m-4 0h4"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </a>
                                @endforeach
                            </div>

                            <div class="w-full">
                                {{ $jadwalLatihan->links() }}
                            </div>

                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</body>
</html>