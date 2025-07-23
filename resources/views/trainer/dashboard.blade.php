<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GYMATE - Dashboard Personal Trainer</title>
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
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
        /* Sembunyikan semua content-section secara default, kecuali yang aktif dikelola JS */
        .content-section {
            display: none;
        }
        .content-section.active {
            display: flex; /* Menggunakan flex untuk layout internal jika diperlukan */
            flex-direction: column; /* Atur arah flex menjadi kolom */
            gap: 1.5rem; /* Menambahkan gap antar elemen di dalam section, setara dengan space-y-6 */
        }
        /* Style untuk item sidebar yang aktif */
        .sidebar-item.active-link {
            background-color: #CFCECE; /* Warna abu-abu yang lebih terang untuk aktif */
            color: #374151; /* text-gray-700 */
            font-weight: 600; /* font-semibold */
        }
    </style>
</head>
<body class="bg-gray-300 font-sans">
    <div class="flex flex-col h-screen">
        {{-- Header --}}
        <div class="bg-gym-red text-white text-center py-4">
            <h1 class="text-2xl font-bold tracking-wider">GYMATE</h1>
        </div>

        <div class="flex flex-row h-full">
            {{-- Sidebar --}}
            <div class="w-64 bg-white flex flex-col">
                <div class="flex-1">
                    <a href="?tab=accountInfo" id="showAccountInfo"
                       class="sidebar-item flex items-center px-6 py-3 text-gray-700 hover:bg-gray-400 border-b border-gray-400"
                       data-target="accountInfo">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        Informasi Akun
                    </a>
                    <a href="?tab=memberList" id="showpelanggan"
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

            {{-- Main Content Area --}}
            <div class="flex-1 p-8 overflow-y-auto bg-gray-300">
                <div class="bg-white p-8 rounded-2xl shadow-2xl flex flex-col h-full">
                    <!-- <h1 class="text-3xl font-bold mb-6 text-gray-800">Dashboard Personal Trainer</h1> -->

                    {{-- Pesan Sukses atau Error (jika ada) --}}
                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative mb-4" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative mb-4" role="alert">
                            <strong class="font-bold">Oops!</strong>
                            <ul class="mt-2 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- {{-- SECTION INFORMASI AKUN --}} -->
                    <div id="accountInfo" class="content-section flex-col gap-8 items-center justify-center w-full">
                        <h2 class="text-2xl font-semibold text-gray-800 uppercase">Informasi Akun</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 w-full">
                            <div class="bg-gray-50 border border-gray-200 p-4 rounded-lg shadow-sm">
                                <p class="font-medium text-gray-500">Nama:</p>
                                <p class="text-xl font-bold text-gray-900">{{ $personalTrainer->nama_personal_trainer }}</p>
                            </div>
                            <div class="bg-gray-50 border border-gray-200 p-4 rounded-lg shadow-sm">
                                <p class="font-medium text-gray-500">Username:</p>
                                <p class="text-xl font-bold text-gray-900">{{ $user->username }}</p>
                            </div>
                            <div class="bg-gray-50 border border-gray-200 p-4 rounded-lg shadow-sm">
                                <p class="font-medium text-gray-500">Jenis Kelamin:</p>
                                <p class="text-xl font-bold text-gray-900">{{ $personalTrainer->jenis_kelamin }}</p>
                            </div>
                            <div class="bg-gray-50 border border-gray-200 p-4 rounded-lg shadow-sm">
                                <p class="font-medium text-gray-500">No. Telepon:</p>
                                <p class="text-xl font-bold text-gray-900">{{ $personalTrainer->no_telp }}</p>
                            </div>
                        </div>
                        {{-- Anda bisa menambahkan tombol edit profil di sini jika diinginkan --}}
                        {{-- <a href="{{ route('trainer.profile.edit') }}" class="mt-4 inline-block bg-gray-300 text-white py-2 px-4 rounded-md hover:bg-blue-700">Edit Profil</a> --}}
                    </div>

                    {{-- SECTION LIST MEMBER --}}
                    <div id="memberList" class="content-section flex-col gap-8 items-center justify-center w-full">
                        <h2 class="text-2xl font-semibold text-gray-800 uppercase">Daftar Member Saya</h2>
                        {{-- Form Pencarian Member (Opsional, jika ingin ada pencarian di sini) --}}
                        {{-- Jika Anda mengaktifkan ini, pastikan controller juga menangani query pencarian --}}
                        {{-- <form action="{{ route('trainer.dashboard') }}" method="GET" class="mb-6 flex gap-4">
                            <input type="hidden" name="tab" value="memberList">
                            <input type="text" name="member_search" placeholder="CARI MEMBER BERDASARKAN NAMA / USERNAME"
                                   class="flex-1 p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   value="{{ request('member_search') }}">
                            <button type="submit" class="px-6 py-3 bg-red-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">CARI</button>
                        </form> --}}

                        @if($pelanggan->isEmpty())
                            <div class="text-center py-12">
                                <p class="text-gray-600 text-lg">Anda belum memiliki member yang memilih Anda sebagai Personal Trainer mereka.</p>
                                <p class="text-sm text-gray-500 mt-2">Member yang memilih paket premium dengan Anda akan muncul di sini.</p>
                            </div>
                        @else
                            <div class="overflow-auto flex flex-col bg-white h-full rounded-lg shadow-sm border border-gray-200 w-full">
                                <table class="min-w-full">
                                    <thead>
                                        <tr class="bg-gray-50 text-gray-700 uppercase text-sm leading-normal">
                                            <th class="py-4 px-6 text-left">No.</th>
                                            <th class="py-4 px-6 text-left">Nama Member</th>
                                            <th class="py-4 px-6 text-left">Username Member</th>
                                            <!-- <th class="py-4 px-6 text-left">Paket Layanan</th> -->
                                            <th class="py-4 px-6 text-left">Status</th>
                                            <th class="py-4 px-6 text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-gray-600 text-sm font-light">
                                        @foreach($pelanggan as $index => $member)
                                            <tr class="border-b border-gray-200 hover:bg-gray-50">
                                                <td class="py-3 px-6 text-left whitespace-nowrap font-semibold">{{ $index + 1 }}</td>
                                                <td class="py-3 px-6 text-left font-semibold">{{ $member->nama_pelanggan }}</td>
                                                <td class="py-3 px-6 text-left font-semibold">{{ $member->user->username ?? 'N/A' }}</td>
                                                <!-- <td class="py-3 px-6 text-left font-semibold capitalize">{{ ucfirst($member->paket_layanan) }}</td> -->
                                                <td class="py-3 px-6 text-left">
                                                    <span class="relative inline-block px-3 py-1 font-semibold leading-tight">
                                                        <span aria-hidden class="absolute inset-0 {{ $member->status == 'Aktif' ? 'bg-green-200' : ($member->status == 'Tidak Aktif' ? 'bg-red-200' : 'bg-yellow-200') }} opacity-50 rounded-full"></span>
                                                        <span class="relative text-xs {{ $member->status == 'Aktif' ? 'text-green-900' : ($member->status == 'Tidak Aktif' ? 'text-red-900' : 'text-yellow-900') }}">{{ $member->status }}</span>
                                                    </span>
                                                </td>
                                                <td class="py-3 px-6 text-center flex flex-row gap-2 justify-center">
                                                    <a href="{{ route('trainer.show_jadwal', $member->id_pelanggan) }}"
                                                       class="inline-block bg-red-500 hover:bg-red-600 text-white text-xs font-semibold py-2 px-3 rounded-lg transition duration-200 shadow-sm">
                                                        Lihat Jadwal
                                                    </a>
                                                    <!-- <a href="?tab=addSession&member_id={{ $member->id_pelanggan }}"
                                                       class="inline-block bg-red-500 hover:bg-red-600 text-white text-xs font-semibold py-2 px-3 rounded-lg transition duration-200 shadow-sm">
                                                        Catat Kegiatan
                                                    </a> -->
                                                </td>
                                            </tr>
                                            
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>

                    {{-- SECTION CATAT KEGIATAN LATIHAN (This section was hinted in the original JS, but not fully provided in the HTML. I'll include a placeholder.) --}}
                    <div id="addSession" class="content-section flex-grow">
                        <h2 class="text-2xl font-semibold mb-4 text-gray-800">Catat Kegiatan Latihan Member</h2>
                        <div class="bg-gray-50 border border-gray-200 p-6 rounded-lg shadow-sm">
                            <p class="text-gray-700 mb-4">Pilih member untuk mencatat kegiatan latihan:</p>
                            <form action="#" method="POST"> {{-- Replace # with your actual route for adding sessions --}}
                                @csrf
                                <div class="mb-4">
                                    <label for="member_for_session" class="block text-gray-700 text-sm font-bold mb-2">Pilih Member:</label>
                                    <select id="member_for_session" name="member_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                        <option value="">-- Pilih Member --</option>
                                        @foreach($pelanggan as $member)
                                            <option value="{{ $member->id_pelanggan }}">{{ $member->nama_pelanggan }} ({{ $member->user->username ?? 'N/A' }})</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-4">
                                    <label for="tanggal_latihan" class="block text-gray-700 text-sm font-bold mb-2">Tanggal Latihan:</label>
                                    <input type="date" id="tanggal_latihan" name="tanggal_latihan" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                                </div>
                                <div class="mb-4">
                                    <label for="kegiatan_latihan" class="block text-gray-700 text-sm font-bold mb-2">Kegiatan Latihan:</label>
                                    <textarea id="kegiatan_latihan" name="kegiatan_latihan" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Deskripsi kegiatan latihan..." required></textarea>
                                </div>
                                <div class="mb-6">
                                    <label for="catatan_latihan" class="block text-gray-700 text-sm font-bold mb-2">Catatan Trainer (Opsional):</label>
                                    <textarea id="catatan_latihan" name="catatan_latihan" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Tambahkan catatan tambahan..."></textarea>
                                </div>
                                <button type="submit" class="bg-gym-red hover:bg-red-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                    Simpan Catatan Latihan
                                </button>
                            </form>
                        </div>
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
                    item.classList.remove('active-link');
                });

                // Tambahkan kelas aktif ke item sidebar yang sesuai
                const activeItem = document.querySelector(`.sidebar-item[data-target="${targetId}"]`);
                if (activeItem) {
                    activeItem.classList.add('active-link');
                }

                // Jika tab adalah 'addSession' dan ada member_id di URL, pilih member tersebut di dropdown
                if (targetId === 'addSession' && memberIdParam) {
                    const memberSelect = document.getElementById('member_for_session');
                    if (memberSelect) {
                        memberSelect.value = memberIdParam;
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