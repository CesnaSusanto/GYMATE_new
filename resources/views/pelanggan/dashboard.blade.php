<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GYMATE - Dashboard Pelanggan</title>
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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .content-section {
            display: none;
        }
        .content-section.active {
            display: flex;
        }
        .sidebar-item.active-link {
            background-color: #CFCECE;
            color: #374151;
            font-weight: 600;
        }
    </style>
</head>
<body class="bg-gray-300 font-sans">
    <div class="flex flex-col h-screen">
        <!-- Header -->
        <div class="bg-gym-red text-white text-center py-4">
            <h1 class="text-2xl font-bold tracking-wider">GYMATE</h1>
        </div>
        
        <div class="flex flex-row h-full">
            <!-- Sidebar -->
            <div class="w-64 bg-white flex flex-col">
                <div class="flex-1">
                    <!-- Sidebar Item: Informasi Akun Pelanggan -->
                    <a href="?tab=accountInfo" id="showAccountInfo"
                       class="sidebar-item flex items-center px-6 py-3 text-gray-700 hover:bg-gray-400 border-b border-gray-400"
                       data-target="accountInfo">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Informasi Akun
                    </a>
                    
                    <!-- Sidebar Item: Jadwal Latihan Anda (Hanya untuk Premium) -->
                    @if($pelanggan->paket_layanan === 'premium')
                    <a href="?tab=mySchedule" id="showMySchedule"
                       class="sidebar-item flex items-center px-6 py-3 text-gray-700 hover:bg-gray-400 border-b border-gray-400"
                       data-target="mySchedule">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        Jadwal Latihan
                    </a>
                    @endif
                    
                    <!-- Sidebar Item: Catatan Latihan Anda -->
                    <a href="?tab=myNotes" id="showMyNotes"
                       class="sidebar-item flex items-center px-6 py-3 text-gray-700 hover:bg-gray-400 border-b border-gray-400"
                       data-target="myNotes">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Catatan Latihan
                    </a>
                </div>
                
                <!-- Logout Button -->
                <form action="{{ route('logout') }}" method="POST" class="w-full">
                    @csrf
                    <button type="submit" class="w-full bg-gym-red hover:bg-red-600 text-white py-4 px-6 text-lg font-bold flex items-center justify-center gap-2">
                        LOG OUT
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                    </button>
                </form>
            </div>

            <!-- Main Content Area -->
            <div class="flex w-full bg-gray-300 overflow-auto p-8">
                <div class="bg-white w-full p-8 rounded-2xl shadow-2xl flex flex-col">
                    <!-- <h1 class="text-4xl font-bold text-center text-gray-900">Dashboard Pelanggan</h1> -->
                    
                    <!-- Success/Error Messages -->
                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative" role="alert">
                            <strong class="font-bold">Oops!</strong>
                            <ul class="mt-2 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- SECTION INFORMASI AKUN PELANGGAN -->
                    <div id="accountInfo" class="content-section flex-col gap-8 items-center justify-center">
                        <h2 class="text-2xl font-semibold text-gray-800 uppercase">Informasi Akun Anda</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 w-full">
                            <div class="bg-gray-50 px-6 py-4 rounded-lg shadow-sm border border-gray-200">
                                <p class="text-sm font-medium text-gray-500">Nama Pelanggan:</p>
                                <p class="text-md font-bold text-gray-900">{{ $pelanggan->nama_pelanggan }}</p>
                            </div>
                            <div class="bg-gray-50 px-6 py-4 rounded-lg shadow-sm border border-gray-200">
                                <p class="text-sm font-medium text-gray-500">Username:</p>
                                <p class="text-md font-bold text-gray-900">{{ $pelanggan->user->username }}</p>
                            </div>
                            <div class="bg-gray-50 px-6 py-4 rounded-lg shadow-sm border border-gray-200">
                                <p class="text-sm font-medium text-gray-500">Jenis Kelamin:</p>
                                <p class="text-md font-bold text-gray-900">{{ $pelanggan->jenis_kelamin }}</p>
                            </div>
                            <div class="bg-gray-50 px-6 py-4 rounded-lg shadow-sm border border-gray-200">
                                <p class="text-sm font-medium text-gray-500">No. Telepon:</p>
                                <p class="text-md font-bold text-gray-900">{{ $pelanggan->no_telp ?? '-' }}</p>
                            </div>
                            <div class="bg-gray-50 px-6 py-4 rounded-lg shadow-sm border border-gray-200">
                                <p class="text-sm font-medium text-gray-500">Tanggal Bergabung:</p>
                                <p class="text-md font-bold text-gray-900">{{ $pelanggan->tanggal_bergabung->format('d M Y') }}</p>
                            </div>
                            <div class="bg-gray-50 px-6 py-4 rounded-lg shadow-sm border border-gray-200">
                                <p class="text-sm font-medium text-gray-500">Paket Layanan:</p>
                                <p class="text-md font-bold text-gray-900 capitalize">{{ $pelanggan->paket_layanan }}</p>
                            </div>
                            <div class="bg-gray-50 px-6 py-4 rounded-lg shadow-sm border border-gray-200">
                                <p class="text-sm font-medium text-gray-500">Berat Badan:</p>
                                <p class="text-md font-bold text-gray-900">{{ $pelanggan->berat_badan }} kg</p>
                            </div>
                            <div class="bg-gray-50 px-6 py-4 rounded-lg shadow-sm border border-gray-200">
                                <p class="text-sm font-medium text-gray-500">Tinggi Badan:</p>
                                <p class="text-md font-bold text-gray-900">{{ $pelanggan->tinggi_badan }} cm</p>
                            </div>
                            <div class="bg-gray-50 px-6 py-4 rounded-lg shadow-sm border border-gray-200">
                                <p class="text-sm font-medium text-gray-500">Status:</p>
                                <p class="text-md font-bold text-gray-900">{{ $pelanggan->status }}</p>
                            </div>
                            @if($pelanggan->paket_layanan === 'premium' && $pelanggan->personalTrainer)
                            <div class="bg-gray-50 px-6 py-4 rounded-lg shadow-sm border border-gray-200">
                                <p class="text-sm font-medium text-gray-500">Personal Trainer:</p>
                                <p class="text-md font-bold text-gray-900">{{ $pelanggan->personalTrainer->nama_personal_trainer }}</p>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- SECTION JADWAL LATIHAN ANDA (Hanya untuk pelanggan premium) -->
                    @if($pelanggan->paket_layanan === 'premium')
                    <div id="mySchedule" class="content-section flex-col items-center h-full w-full gap-8">
                        <h2 class="text-2xl font-semibold uppercase text-gray-800">Jadwal Latihan Anda</h2>                        
                        @if(isset($pelanggan->kartu) && $pelanggan->kartu->isNotEmpty())
                            <div class="overflow-auto flex flex-col h-full bg-white rounded-lg shadow-sm border border-gray-200 w-full">
                                <table class="min-w-full">
                                    <thead class="bg-gray-50">
                                        <tr class="text-gray-700 text-sm font-semibold">
                                            <th class="py-4 px-6 text-left">Tanggal Latihan</th>
                                            <th class="py-4 px-6 text-left">Kegiatan Latihan</th>
                                            <th class="py-4 px-6 text-left">Catatan Trainer</th>
                                            <th class="py-4 px-6 text-left">Personal Trainer</th>
                                            <th class="py-4 px-6 text-center"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($pelanggan->kartu as $kartu)
                                            <tr class="border-b border-gray-200 hover:bg-gray-50">
                                                <td class="py-4 px-6 font-semibold text-gray-900">{{ $kartu->tanggal_latihan->format('d M Y') }}</td>
                                                <td class="py-4 px-6 font-semiboldtext-gray-700 flex-col justify-center items-center">
                                                    <p class="line-clamp-2">{{ $kartu->kegiatan_latihan }}</p>
                                                </td>
                                                <td class=" text-gray-700 flex-col justify-center items-center max-w-96 py-4">
                                                    <p class="line-clamp-2">{{ $kartu->catatan_latihan ?? '-' }}</p>
                                                </td>
                                                <td class="py-4 px-6 text-gray-700">{{ $kartu->personalTrainer->nama_personal_trainer ?? 'N/A' }}</td>
                                                <td class="py-4 px-6 text-center">
                                                    <a href="{{ route('pelanggan.jadwal.show', $kartu->id_kartu) }}"
                                                       class="flex flex-col w-auto">
                                                        <p class=" bg-gym-red hover:bg-red-600 text-white text-sm font-semibold py-2 px-3 rounded-lg transition-colors ">Lihat Detail</p>
                                                    </a>
                                                </td>
                                            </tr>
                                            
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-12">
                                <p class="text-gray-600 text-lg">Belum ada jadwal latihan yang tercatat untuk Anda.</p>
                            </div>
                        @endif
                    </div>
                    @endif

                    <!-- SECTION CATATAN LATIHAN ANDA -->
                    <div id="myNotes" class="content-section flex-col items-center w-full gap-8 h-full">
                        <h2 class="text-2xl font-bold text-gray-800">Catatan Latihan Anda</h2>
                        <!-- <p class="text-gray-600">Berikut adalah catatan latihan yang telah dibuat oleh Personal Trainer Anda.</p> -->
                        
                        <!-- Tombol untuk Menambah Catatan Baru -->
                        <div class="flex flex-col w-full">
                            <a href="{{ route('pelanggan.catatan.create') }}"
                               class="flex flex-row w-full justify-center items-center px-6 py-3 bg-gym-red text-white font-semibold rounded-lg hover:bg-red-600 transition-colors">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Tambah Catatan Baru
                            </a>
                        </div>

                        <!-- Tabel untuk Menampilkan Catatan -->
                        @if(isset($pelanggan->catatan) && $pelanggan->catatan->isNotEmpty())
                        <div class="border-gray-200 shadow-sm flex flex-col overflow-auto max-h-full">
                                <table class="w-full bg-white border-2 ">
                                    <thead class="bg-gray-50 ">
                                        <tr class="text-gray-700 text-sm font-semibold">
                                            <th class="py-4 px-6 text-center">Tanggal Catatan</th>
                                            <th class="py-4 px-6 text-center">Kegiatan Latihan</th>
                                            <th class="py-4 px-6 text-center">Catatan</th>
                                            <th class="py-4 px-6 text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="">
                                        @foreach($pelanggan->catatan as $catatan)
                                            <tr class="border-b border-gray-200 hover:bg-gray-50">
                                                <td class="py-4 px-6 font-semibold text-gray-900 w-auto text-center">{{ $catatan->tanggal_latihan->format('d M Y') }}</td>
                                                <td class="text-gray-700 flex-col justify-center items-center w-1/3 px-6 py-4">
                                                    <p class="line-clamp-2">{{ $catatan->kegiatan_latihan }}</p>
                                                </td>
                                                <td class="text-gray-700 flex-col justify-center items-center w-1/2 px-6 py-4">
                                                    <p class="line-clamp-2">{{ $catatan->catatan_latihan }}</p>
                                                </td>
                                                <td class="py-4 px-6 text-center">
                                                    <div class="flex justify-center items-center gap-4 px-6">
                                                        <a href="{{ route('pelanggan.catatan.edit', $catatan->id_catatan) }}" 
                                                           class="flex">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                            </svg>
                                                        </a>
                                                        <form action="{{ route('pelanggan.catatan.destroy', $catatan->id_catatan) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus catatan ini?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="bg-gym-red hover:bg-red-600 text-white px-3 py-1 rounded text-sm font-semibold transition-colors">
                                                                Hapus
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @else
                            <div class="text-center py-12">
                                <p class="text-gray-600 text-lg">Belum ada catatan latihan yang tercatat untuk Anda.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarItems = document.querySelectorAll('.sidebar-item');
            const contentSections = document.querySelectorAll('.content-section');
            const urlParams = new URLSearchParams(window.location.search);
            let activeTabParam = urlParams.get('tab');
            
            // Default ke 'accountInfo' jika tidak ada parameter 'tab'
            if (!activeTabParam) {
                activeTabParam = 'accountInfo';
            }

            function showSection(targetId) {
                // Sembunyikan semua section
                contentSections.forEach(section => {
                    section.classList.remove('active');
                });
                
                // Tampilkan section yang dituju
                const targetSection = document.getElementById(targetId);
                if (targetSection) {
                    targetSection.classList.add('active');
                } else {
                    console.error('Section with ID ' + targetId + ' not found.');
                    // Fallback ke accountInfo jika target tidak ditemukan
                    document.getElementById('accountInfo').classList.add('active');
                    targetId = 'accountInfo';
                }

                // Hapus kelas aktif dari semua item sidebar
                sidebarItems.forEach(item => {
                    item.classList.remove('active-link');
                });

                // Tambahkan kelas aktif ke item sidebar yang sesuai
                const activeItem = document.querySelector(`.sidebar-item[data-target="${targetId}"]`);
                if (activeItem) {
                    activeItem.classList.add('active-link');
                }
            }

            // Tambahkan event listener untuk setiap item sidebar
            sidebarItems.forEach(item => {
                item.addEventListener('click', function(e) {
                    e.preventDefault();
                    const targetId = this.dataset.target;
                    
                    // Update URL dengan parameter 'tab' baru
                    const newUrl = new URL(window.location.href);
                    newUrl.searchParams.set('tab', targetId);
                    window.history.pushState({}, '', newUrl.toString());
                    
                    showSection(targetId);
                });
            });

            // Panggil saat halaman dimuat untuk menampilkan section yang benar
            showSection(activeTabParam);
        });
    </script>
</body>
</html>