<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GYMATE - Dashboard Personal Trainer</title>
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
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
                    {{-- Sidebar Item: Informasi Akun --}}
                    {{-- Perhatikan href yang diubah agar JS bisa membaca parameter tab --}}
                    <a href="?tab=accountInfo" id="showAccountInfo"
                       class="sidebar-item block py-3 px-4 rounded hover:bg-gray-700 mb-2"
                       data-target="accountInfo">
                        <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        Informasi Akun
                    </a>
                    {{-- Sidebar Item: List Member --}}
                    <a href="?tab=memberList" id="showpelanggan"
                       class="sidebar-item block py-3 px-4 rounded hover:bg-gray-700"
                       data-target="memberList">
                        <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h2a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2h2m3-4H9V8h4m-4 0v4m4-4h2"></path></svg>
                        List Member
                    </a>
                    {{-- Sidebar Item: Catat Kegiatan Latihan --}}
                    <a href="?tab=addSession" id="showAddSession"
                       class="sidebar-item block py-3 px-4 rounded hover:bg-gray-700 mt-2"
                       data-target="addSession">
                        <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Catat Kegiatan Latihan
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
                <h1 class="text-3xl font-bold mb-6 text-gray-800">Dashboard Personal Trainer</h1>

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

                {{-- SECTION INFORMASI AKUN --}}
                <div id="accountInfo" class="content-section">
                    <h2 class="text-2xl font-semibold mb-4 text-blue-800">Informasi Akun</h2>
                    <div class="space-y-4">
                        <div class="bg-gray-50 border border-gray-200 p-4 rounded-md shadow-sm">
                            <p class="font-semibold text-lg text-gray-900">Nama: {{ $personalTrainer->nama_trainer }}</p>
                            <p class="text-sm text-gray-600">Username: {{ $user->username }}</p>
                            <p class="text-sm text-gray-600">Jenis Kelamin: {{ $personalTrainer->jenis_kelamin }}</p>
                            <p class="text-sm text-gray-600">No. Telepon: {{ $personalTrainer->no_telp }}</p>
                        </div>
                        {{-- Anda bisa menambahkan tombol edit profil di sini jika diinginkan --}}
                        {{-- <a href="{{ route('trainer.profile.edit') }}" class="mt-4 inline-block bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700">Edit Profil</a> --}}
                    </div>
                </div>

                {{-- SECTION LIST MEMBER --}}
                <div id="memberList" class="content-section">
                    <h2 class="text-2xl font-semibold mb-4 text-green-800">Daftar Member Saya</h2>
                    {{-- Form Pencarian Member (Opsional, jika ingin ada pencarian di sini) --}}
                    {{-- Jika Anda mengaktifkan ini, pastikan controller juga menangani query pencarian --}}
                    {{-- <form action="{{ route('trainer.dashboard') }}" method="GET" class="mb-6 flex gap-4">
                        <input type="hidden" name="tab" value="memberList">
                        <input type="text" name="member_search" placeholder="CARI MEMBER BERDASARKAN NAMA / USERNAME"
                               class="flex-1 p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                               value="{{ request('member_search') }}">
                        <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">CARI</button>
                    </form> --}}

                    @if($pelanggan->isEmpty())
                        <p class="text-gray-600">Anda belum memiliki member yang memilih Anda sebagai Personal Trainer mereka.</p>
                        <p class="text-sm text-gray-500 mt-2">Member yang memilih paket premium dengan Anda akan muncul di sini.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-sm">
                                <thead>
                                    <tr class="bg-gray-50 text-gray-600 uppercase text-sm leading-normal">
                                        <th class="py-3 px-6 text-left">No.</th>
                                        <th class="py-3 px-6 text-left">Nama Member</th>
                                        <th class="py-3 px-6 text-left">Username Member</th>
                                        <th class="py-3 px-6 text-left">Paket Layanan</th>
                                        <th class="py-3 px-6 text-left">Status</th>
                                        <th class="py-3 px-6 text-center">Aksi</th> {{-- Tambahkan kolom aksi --}}
                                    </tr>
                                </thead>
                                <tbody class="text-gray-600 text-sm font-light">
                                    @foreach($pelanggan as $index => $member)
                                        <tr class="border-b border-gray-200 hover:bg-gray-100">
                                            <td class="py-3 px-6 text-left whitespace-nowrap">{{ $index + 1 }}</td>
                                            <td class="py-3 px-6 text-left">{{ $member->nama_pelanggan }}</td>
                                            <td class="py-3 px-6 text-left">{{ $member->user->username ?? 'N/A' }}</td>
                                            <td class="py-3 px-6 text-left">{{ ucfirst($member->paket_layanan) }}</td>
                                            <td class="py-3 px-6 text-left">
                                                <span class="relative inline-block px-3 py-1 font-semibold leading-tight">
                                                    <span aria-hidden class="absolute inset-0 {{ $member->status == 'Aktif' ? 'bg-green-200' : ($member->status == 'Tidak Aktif' ? 'bg-red-200' : 'bg-yellow-200') }} opacity-50 rounded-full"></span>
                                                    <span class="relative text-xs {{ $member->status == 'Aktif' ? 'text-green-900' : ($member->status == 'Tidak Aktif' ? 'text-red-900' : 'text-yellow-900') }}">{{ $member->status }}</span>
                                                </span>
                                            </td>
                                            <td class="py-3 px-6 text-center">
                                                <a href="{{ route('trainer.show_jadwal', $member->id_pelanggan) }}" class="text-blue-600 hover:underline text-xs mr-2">Lihat Jadwal</a>
                                                <a href="?tab=addSession&member_id={{ $member->id_pelanggan }}" class="text-purple-600 hover:underline text-xs">Catat kegiatan</a>
                                            </td>               
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
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
            let memberIdParam = urlParams.get('member_id'); // Ambil parameter member_id

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

                // Jika tab adalah 'addSession' dan ada member_id di URL, pilih member tersebut di dropdown
                if (targetId === 'addSession' && memberIdParam) {
                    const pelangganelect = document.getElementById('member_for_session');
                    if (pelangganelect) {
                        pelangganelect.value = memberIdParam;
                    }
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
                    // Hapus member_id param jika pindah tab selain 'addSession'
                    if (targetId !== 'addSession') {
                        newUrl.searchParams.delete('member_id');
                    }
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