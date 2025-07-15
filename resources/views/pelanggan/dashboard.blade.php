<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GYMATE - Dashboard Pelanggan</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6; /* Light gray background */
        }
        /* Sembunyikan semua content-section secara default, kecuali yang aktif dikelola JS */
        .content-section {
            display: none;
        }
        .content-section.active {
            display: block; /* Tampilkan yang aktif */
        }
        /* Style untuk item sidebar yang aktif */
        .sidebar-item.active-link {
            background-color: #f7fafc; /* bg-gray-100 */
            color: #2d3748; /* text-gray-800 */
            font-weight: 600; /* font-semibold */
        }
    </style>
</head>
<body class="bg-gray-100 font-sans">
    <div class="flex h-screen">

        {{-- Sidebar --}}
        <div class="w-64 bg-gray-800 text-white flex flex-col justify-between">
            <div>
                <div class="bg-red-600 p-4 text-center text-xl font-bold">GYMATE</div>
                <div class="p-4">
                    {{-- Sidebar Item: Informasi Akun Pelanggan --}}
                    <a href="?tab=accountInfo" id="showAccountInfo"
                       class="sidebar-item block py-3 px-4 rounded hover:bg-gray-700 mb-2"
                       data-target="accountInfo">
                        <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        Informasi Akun
                    </a>
                    {{-- Sidebar Item: Jadwal Latihan Anda (Hanya untuk Premium) --}}
                    @if($pelanggan->paket_layanan === 'premium')
                    <a href="?tab=mySchedule" id="showMySchedule"
                       class="sidebar-item block py-3 px-4 rounded hover:bg-gray-700 mb-2"
                       data-target="mySchedule">
                        <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        Jadwal Latihan
                    </a>
                    @endif
                    {{-- Sidebar Item: Catatan Latihan Anda --}}
                    <a href="?tab=myNotes" id="showMyNotes"
                       class="sidebar-item block py-3 px-4 rounded hover:bg-gray-700"
                       data-target="myNotes">
                        <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Catatan Latihan
                    </a>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST" class="w-full">
                @csrf
                <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white py-4 px-6 text-lg font-bold flex items-center justify-center gap-2">
                    LOG OUT
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                    </svg>
                </button>
            </form>
        </div>

        {{-- Main Content Area --}}
        <div class="flex-1 p-8 overflow-y-auto">
            <div class="bg-white p-8 rounded-lg shadow-md">
                <h1 class="text-3xl font-bold mb-6 text-gray-800">Dashboard Pelanggan</h1>

                {{-- Pesan Sukses atau Error (jika ada) --}}
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

                {{-- SECTION INFORMASI AKUN PELANGGAN --}}
                <div id="accountInfo" class="content-section">
                    <h2 class="text-2xl font-semibold mb-4 text-blue-800">Informasi Akun Anda</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                            <p class="text-sm font-medium text-gray-500">Nama Pelanggan:</p>
                            <p class="text-lg font-semibold text-gray-900">{{ $pelanggan->nama_pelanggan }}</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                            <p class="text-sm font-medium text-gray-500">Username:</p>
                            <p class="text-lg font-semibold text-gray-900">{{ $pelanggan->user->username }}</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                            <p class="text-sm font-medium text-gray-500">Jenis Kelamin:</p>
                            <p class="text-lg font-semibold text-gray-900">{{ $pelanggan->jenis_kelamin }}</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                            <p class="text-sm font-medium text-gray-500">No. Telepon:</p>
                            <p class="text-lg font-semibold text-gray-900">{{ $pelanggan->no_telp ?? '-' }}</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                            <p class="text-sm font-medium text-gray-500">Tanggal Bergabung:</p>
                            <p class="text-lg font-semibold text-gray-900">{{ $pelanggan->tanggal_bergabung->format('d M Y') }}</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                            <p class="text-sm font-medium text-gray-500">Paket Layanan:</p>
                            <p class="text-lg font-semibold text-gray-900 capitalize">{{ $pelanggan->paket_layanan }}</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                            <p class="text-sm font-medium text-gray-500">Berat Badan:</p>
                            <p class="text-lg font-semibold text-gray-900">{{ $pelanggan->berat_badan }} kg</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                            <p class="text-sm font-medium text-gray-500">Tinggi Badan:</p>
                            <p class="text-lg font-semibold text-gray-900">{{ $pelanggan->tinggi_badan }} cm</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                            <p class="text-sm font-medium text-gray-500">Status:</p>
                            <p class="text-lg font-semibold text-gray-900">{{ $pelanggan->status }}</p>
                        </div>
                        @if($pelanggan->paket_layanan === 'premium' && $pelanggan->personalTrainer)
                        <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                            <p class="text-sm font-medium text-gray-500">Personal Trainer:</p>
                            <p class="text-lg font-semibold text-gray-900">{{ $pelanggan->personalTrainer->nama_personal_trainer }}</p>
                        </div>
                        @endif
                    </div>
                    {{-- Anda bisa menambahkan tombol edit profil di sini jika diinginkan --}}
                    {{-- <a href="{{ route('pelanggan.profile.edit') }}" class="mt-4 inline-block bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700">Edit Profil</a> --}}
                </div>

                {{-- SECTION JADWAL LATIHAN ANDA (Hanya untuk pelanggan premium) --}}
                @if($pelanggan->paket_layanan === 'premium')
                <div id="mySchedule" class="content-section">
                    <h2 class="text-2xl font-semibold mb-4 text-green-800">Jadwal Latihan Anda</h2>
                    <p class="text-gray-600 mb-4">Berikut adalah jadwal latihan yang telah dibuat untuk Anda.</p>
                    {{-- Placeholder untuk menampilkan jadwal latihan --}}
                    {{-- Anda perlu memastikan controller mengirimkan data jadwal (kartu) ke view --}}
                    @if(isset($pelanggan->kartu) && $pelanggan->kartu->isNotEmpty())
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-sm">
                                <thead>
                                    <tr class="bg-gray-50 text-gray-600 uppercase text-sm leading-normal">
                                        <th class="py-3 px-6 text-left">Tanggal Latihan</th>
                                        <th class="py-3 px-6 text-left">Kegiatan Latihan</th>
                                        <th class="py-3 px-6 text-left">Catatan Trainer</th>
                                        <th class="py-3 px-6 text-left">Personal Trainer</th>
                                    </tr>
                                </thead>
                                <tbody class="text-gray-600 text-sm font-light">
                                    @foreach($pelanggan->kartu as $kartu)
                                        <tr class="border-b border-gray-200 hover:bg-gray-100">
                                            <td class="py-3 px-6 text-left whitespace-nowrap">{{ $kartu->tanggal_latihan->format('d M Y') }}</td>
                                            <td class="py-3 px-6 text-left">{{ $kartu->kegiatan_latihan }}</td>
                                            <td class="py-3 px-6 text-left">{{ $kartu->catatan_latihan ?? '-' }}</td>
                                            <td class="py-3 px-6 text-left">{{ $kartu->personalTrainer->nama_personal_trainer ?? 'N/A' }}</td>
                                            <td>
                                                <a href="{{ route('pelanggan.jadwal.show', $kartu->id_kartu) }}">liaht detail</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-gray-600">Belum ada jadwal latihan yang tercatat untuk Anda.</p>
                    @endif
                </div>
                @endif

                {{-- SECTION CATATAN LATIHAN ANDA --}}
                <div id="myNotes" class="content-section">
                    <h2 class="text-2xl font-semibold mb-4 text-purple-800">Catatan Latihan Anda</h2>
                    <p class="text-gray-600 mb-4">Berikut adalah catatan latihan yang telah dibuat oleh Personal Trainer Anda.</p>

                    {{-- Tombol untuk Menambah Catatan Baru --}}
                    <div class="mb-6">
                        <a href="{{ route('pelanggan.catatan.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Tambah Catatan Baru
                        </a>
                    </div>

                    {{-- Tabel untuk Menampilkan Catatan --}}
                    @if(isset($pelanggan->catatan) && $pelanggan->catatan->isNotEmpty())
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-sm">
                                <thead>
                                    <tr class="bg-gray-50 text-gray-600 uppercase text-sm leading-normal">
                                        <th class="py-3 px-6 text-left">Tanggal Catatan</th>
                                        <th class="py-3 px-6 text-left">Kegiatan Latihan</th>
                                        <th class="py-3 px-6 text-left">Catatan</th>
                                        <th class="py-3 px-6 text-center">Aksi</th> {{-- Kolom Aksi --}}
                                    </tr>
                                </thead>
                                <tbody class="text-gray-600 text-sm font-light">
                                    @foreach($pelanggan->catatan as $catatan)
                                        <tr class="border-b border-gray-200 hover:bg-gray-100">
                                            <td class="py-3 px-6 text-left whitespace-nowrap">{{ $catatan->tanggal_latihan->format('d M Y') }}</td>
                                            <td class="py-3 px-6 text-left">{{ $catatan->kegiatan_latihan }}</td>
                                            <td class="py-3 px-6 text-left">{{ $catatan->catatan_latihan }}</td>
                                            <td class="py-3 px-6 text-center">
                                                <a href="{{ route('pelanggan.catatan.edit', $catatan->id_catatan) }}" class="text-yellow-600 hover:underline text-xs mr-2">Edit</a>
                                                <form action="{{ route('pelanggan.catatan.destroy', $catatan->id_catatan) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus catatan ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:underline text-xs">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-gray-600">Belum ada catatan latihan yang tercatat untuk Anda.</p>
                    @endif
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
                    item.classList.remove('active-link'); // Menggunakan kelas yang lebih spesifik
                    item.classList.add('text-white'); // Kembali ke warna default
                });

                // Tambahkan kelas aktif ke item sidebar yang sesuai
                const activeItem = document.querySelector(`.sidebar-item[data-target="${targetId}"]`);
                if (activeItem) {
                    activeItem.classList.add('active-link'); // Menambahkan kelas aktif baru
                    activeItem.classList.remove('text-white'); // Hapus warna default
                }
            }

            // Tambahkan event listener untuk setiap item sidebar
            sidebarItems.forEach(item => {
                item.addEventListener('click', function(e) {
                    e.preventDefault(); // Mencegah reload halaman penuh
                    const targetId = this.dataset.target;

                    // Update URL dengan parameter 'tab' baru
                    const newUrl = new URL(window.location.href);
                    newUrl.searchParams.set('tab', targetId);
                    window.history.pushState({}, '', newUrl.toString()); // Gunakan pushState

                    showSection(targetId);
                });
            });

            // Panggil saat halaman dimuat untuk menampilkan section yang benar
            showSection(activeTabParam);
        });
    </script>
</body>
</html>
