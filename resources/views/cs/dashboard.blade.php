<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GYMATE - CS Management</title>

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
        .sidebar-item.active-link-cs { /* Gunakan nama kelas yang berbeda agar tidak konflik */
            background-color: #f7fafc; /* bg-gray-100 */
            color: #2d3748; /* text-gray-800 */
            font-weight: 600; /* font-semibold */
        }
    </style>
</head>
<body class="bg-gray-100 font-sans">
    <div class="flex h-screen">

        <div class="w-64 bg-gray-800 text-white flex flex-col justify-between">
            <div>
                <div class="bg-red-600 p-4 text-center text-xl font-bold">GYMATE</div>
                <div class="p-4">
                    {{-- Ubah href menjadi dinamis dengan parameter tab --}}
                    <a href="?tab=memberList" id="showMembers" class="sidebar-item block py-3 px-4 rounded hover:bg-gray-700 mb-2" data-target="memberList">
                        List Member
                    </a>
                    <a href="?tab=trainerList" id="showTrainers" class="sidebar-item block py-3 px-4 rounded hover:bg-gray-700" data-target="trainerList">
                        List Trainer
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

        <div class="flex-1 p-8 overflow-y-auto">
            <div class="bg-white p-8 rounded-lg shadow-md">

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

                {{-- SECTION LIST MEMBER --}}
                <div id="memberList" class="content-section">
                    <h1 class="text-3xl font-bold mb-6 text-gray-800">List Member</h1>
                    <form action="{{ route('cs.dashboard') }}" method="GET" class="mb-6 flex gap-4">
                        <input type="hidden" name="tab" value="memberList"> {{-- Tambahkan hidden input untuk mempertahankan tab --}}
                        <input type="text" name="member_search" placeholder="CARI MEMBER BERDASARKAN NAMA / USERNAME"
                               class="flex-1 p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                               value="{{ request('member_search') }}">
                        <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">CARI</button>
                    </form>

                    <div class="space-y-4">
                        @forelse($members as $member)
                            <div class="flex items-center justify-between bg-gray-50 border border-gray-200 p-4 rounded-md shadow-sm">
                                <div>
                                    <p class="font-semibold text-lg text-gray-900">Nama: {{ $member->nama_pelanggan }}</p>
                                    @if($member->user)
                                        <p class="text-sm text-gray-600">Username: {{ $member->user->username }}</p>
                                    @endif
                                    <p class="text-sm text-gray-600">Jenis Pelayanan: {{ $member->paket_layanan }}</p>
                                    {{-- Tampilkan Personal Trainer jika ada --}}
                                    @if($member->personalTrainer)
                                        <p class="text-sm text-gray-600">Personal Trainer: {{ $member->personalTrainer->nama_personal_trainer }}</p>
                                    @else
                                        <p class="text-sm text-gray-600 italic">Belum ada Personal Trainer</p>
                                    @endif
                                </div>
                                <div class="flex space-x-2">
                                    <a href="{{ route('cs.members.edit', $member->id_pelanggan) }}"
                                    class="bg-green-500 flex items-center justify-center p-2 rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>
                                    <form action="{{ route('cs.members.destroy', $member->id_pelanggan) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus member ini? Ini akan menghapus akun user terkait juga.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 bg-red-500 text-white rounded-md hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500">
                                            <p>hapus</p>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-600">Tidak ada member yang ditemukan.</p>
                        @endforelse
                    </div>
                </div>

                {{-- SECTION LIST PERSONAL TRAINER --}}
                <div id="trainerList" class="content-section">
                    <h1 class="text-3xl font-bold mb-6 text-gray-800">List Personal Trainer</h1>
                    {{-- Form pencarian trainer --}}
                    <form action="{{ route('cs.dashboard') }}" method="GET" class="mb-6 flex gap-4">
                        <input type="hidden" name="tab" value="trainerList"> {{-- Tambahkan hidden input untuk mempertahankan tab --}}
                        <input type="text" name="trainer_search" placeholder="CARI TRAINER BERDASARKAN NAMA / USERNAME"
                                class="flex-1 p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                value="{{ request('trainer_search') }}">
                        <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">CARI</button>
                    </form>

                    <a href="{{ route('cs.trainer.create') }}" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-md inline-flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        Tambah Personal Trainer
                    </a>

                    <div class="space-y-4 mt-4">
                        @forelse($trainers as $trainer)
                            <div class="flex items-center justify-between bg-gray-50 border border-gray-200 p-4 rounded-md shadow-sm">
                                <div>
                                    <p class="font-semibold text-lg text-gray-900">Nama: {{ $trainer->nama_personal_trainer }}</p>
                                    @if($trainer->user)
                                        <p class="text-sm text-gray-600">Username: {{ $trainer->user->username }}</p>
                                    @endif
                                    <p class="text-sm text-gray-600">Jenis Kelamin: {{ $trainer->jenis_kelamin ?? 'N/A' }}</p>
                                    <p class="text-sm text-gray-600">No. Telepon: {{ $trainer->no_telp }}</p>
                                </div>
                                <div class="flex space-x-2">
                                    <a href="{{ route('cs.trainer.edit', $trainer->id_personal_trainer) }}"
                                    class="p-2 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>
                                    <form action="{{ route('cs.trainer.destroy', $trainer->id_personal_trainer) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus personal trainer ini? Ini akan menghapus akun user terkait juga.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 bg-red-500 text-white rounded-md hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500">
                                            <p>hapus</p>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-600">Tidak ada personal trainer yang ditemukan.</p>
                        @endforelse
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
            const activeTabParam = urlParams.get('tab'); // Ambil parameter 'tab'
            const memberSearchParam = urlParams.get('member_search');
            const trainerSearchParam = urlParams.get('trainer_search');

            // Fungsi untuk menampilkan section yang dipilih dan mengupdate kelas aktif sidebar
            function showSection(targetId) {
                contentSections.forEach(section => {
                    section.classList.remove('active');
                });
                document.getElementById(targetId).classList.add('active');

                sidebarItems.forEach(item => {
                    item.classList.remove('active-link-cs'); // Hapus kelas aktif khusus CS
                    item.classList.add('text-white'); // Kembali ke warna default
                });
                const activeItem = document.querySelector(`.sidebar-item[data-target="${targetId}"]`);
                if (activeItem) {
                    activeItem.classList.add('active-link-cs'); // Tambahkan kelas aktif khusus CS
                    activeItem.classList.remove('text-white'); // Hapus warna default
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
                    // Hapus parameter pencarian saat berpindah tab
                    newUrl.searchParams.delete('member_search');
                    newUrl.searchParams.delete('trainer_search');
                    window.history.pushState({}, '', newUrl.toString());

                    showSection(targetId);
                });
            });

            // Logika untuk menampilkan section yang benar saat halaman dimuat
            // Prioritaskan tab yang ditentukan oleh parameter 'tab' di URL
            // Jika tidak ada parameter 'tab', cek parameter pencarian
            if (activeTabParam) {
                showSection(activeTabParam);
            } else if (trainerSearchParam) {
                showSection('trainerList');
            } else if (memberSearchParam) {
                showSection('memberList');
            } else {
                // Tampilkan "List Member" secara default jika tidak ada parameter apa pun
                showSection('memberList');
            }
        });
    </script>
</body>
</html>