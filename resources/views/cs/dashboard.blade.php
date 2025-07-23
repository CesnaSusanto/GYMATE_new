<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GYMATE - CS Management</title>
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
        .content-section {
            display: none;
        }
        .content-section.active {
            display: flex;
        }
        .sidebar-item.active-link-cs {
            background-color: #CFCECE;
            color: #374151;
            font-weight: 600;
        }
    </style>
</head>
<body class="bg-gray-200 font-sans">
    <div class="flex flex-col h-screen">
        <!-- Header -->
        <div class="bg-gym-red text-white text-center py-4">
            <h1 class="text-2xl font-bold tracking-wider">GYMATE</h1>
        </div>
        
        <div class="flex flex-1">
            <!-- Sidebar -->
            <div class="w-56 bg-white flex flex-col">
                <div class="flex-1">
                    <a href="?tab=memberList" id="showMembers" class="sidebar-item flex items-center px-6 py-5 gap-3 text-gray-700 hover:bg-[#CFCECE] border-b border-gray-400" data-target="memberList">
                        <svg class="size-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                        </svg>
                        List Member
                    </a>
                    <a href="?tab=trainerList" id="showTrainers" class="sidebar-item flex items-center px-6 py-5 gap-3 text-gray-700 hover:bg-[#CFCECE] border-b border-gray-400" data-target="trainerList">
                        <svg class="size-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                        </svg>
                        List Trainer
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

            <!-- Main Content -->
            <div class="flex-1 bg-[#EDEDED] overflow-y-auto">
                {{-- Success/Error Messages --}}
                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative m-6 mb-4" role="alert">
                        {{ session('success') }}
                    </div>
                @endif
                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative m-6 mb-4" role="alert">
                        <strong class="font-bold">Oops!</strong>
                        <ul class="mt-2 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- SECTION LIST MEMBER --}}
                <div id="memberList" class="content-section flex-col gap-8 p-8">
                    <h1 class="text-4xl font-bold text-gray-800">List Member</h1>
                    
                    <!-- Search Form -->
                    <form action="{{ route('cs.dashboard') }}" method="GET" class= "flex gap-4">
                        <input type="hidden" name="tab" value="memberList">
                        <input type="text" name="member_search" placeholder="CARI MEMBER"
                               class="flex-1 p-4 border-0 bg-white rounded-lg focus:ring-2 focus:ring-gray-400 text-gray-700"
                               value="{{ request('member_search') }}">
                        <button type="submit" class="px-8 py-4 bg-gray-500 text-white rounded-lg hover:bg-gray-600 font-semibold">CARI</button>
                    </form>

                    <!-- Member List -->
                    <div class="flex flex-col flex-wrap gap-5">
                        @forelse($members as $member)
                            <div class="flex flex-row justify-between bg-white rounded-lg shadow-sm overflow-hidden">
                                <div class="flex flex-col justify-center pl-6 py-4 gap-1">
                                    <p class="font-bold text-lg text-gray-900">Nama: {{ $member->nama_pelanggan }}</p>
                                    @if($member->user)
                                        <p class="text-gray-600">Username: {{ $member->user->username }}</p>
                                    @endif
                                    <!-- <p class="text-gray-600">
                                        Jenis Pelayanan: {{ $member->paket_layanan }}
                                        @if($member->personalTrainer)

                                        @endif
                                    </p> -->
                                    <!-- @if($member->personalTrainer)
                                        <p class="text-gray-600">Personal Trainer: {{ $member->personalTrainer->nama_personal_trainer }}</p>
                                    @endif -->
                                </div>
                                <div class="flex  flex-row justify-center">
                                    <div class="flex justify-center items-center px-6">
                                        <a href="{{ route('cs.members.edit', $member->id_pelanggan) }}"
                                       class="">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>
                                    </div>
                                    <form action="{{ route('cs.members.destroy', $member->id_pelanggan) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus member ini?');" class="flex">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-6 bg-gym-red text-white hover:bg-red-600 transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5-4h4m-4 0a1 1 0 00-1 1v1h6V4a1 1 0 00-1-1m-4 0h4" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-600 text-center py-8">Tidak ada member yang ditemukan.</p>
                        @endforelse
                    </div>
                </div>

                {{-- SECTION LIST PERSONAL TRAINER --}}
                <div id="trainerList" class="content-section flex-col gap-8 p-8">
                    <h1 class="text-4xl font-bold text-gray-800">List Personal Trainer</h1>
                    
                    <!-- Search Form -->
                    <form action="{{ route('cs.dashboard') }}" method="GET" class= "flex gap-4">
                        <input type="hidden" name="tab" value="trainerList">
                        <input type="text" name="trainer_search" placeholder="CARI TRAINER"
                               class="flex-1 p-4 border-0 bg-white rounded-lg focus:ring-2 focus:ring-gray-400 text-gray-700"
                               value="{{ request('trainer_search') }}">
                        <button type="submit" class="px-8 py-4 bg-gray-500 text-white rounded-lg hover:bg-gray-600 font-semibold">CARI</button>
                    </form>

                    <a href="{{ route('cs.trainer.create') }}" class="bg-[#CFCECE] text-zinc-500 justify-center font-bold py-4 hover:bg-zinc-300 border-2 border-zinc-500 w-full rounded-lg flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Tambah Personal Trainer
                    </a>

                    <!-- Trainer List -->
                    <div class="flex flex-col flex-wrap gap-5">
                        @forelse($trainers as $trainer)
                            <div class="flex flex-row justify-between bg-white rounded-lg shadow-sm overflow-hidden">
                                <div class="flex flex-col justify-center pl-6 py-4 gap-1">
                                    <p class="font-bold text-lg text-gray-900">Nama: {{ $trainer->nama_personal_trainer }}</p>
                                    @if($trainer->user)
                                        <p class="text-gray-600">Username: {{ $trainer->user->username }}</p>
                                    @endif
                                    <p class="text-gray-600">Jenis Kelamin: {{ $trainer->jenis_kelamin ?? 'N/A' }}</p>
                                    <p class="text-gray-600">No. Telepon: {{ $trainer->no_telp }}</p>
                                </div>
                                <div class="flex  flex-row justify-center">
                                    <div class="flex justify-center items-center px-6">
                                        <a href="{{ route('cs.trainer.edit', $trainer->id_personal_trainer) }}">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </a>
                                    </div>
                                    <form action="{{ route('cs.trainer.destroy', $trainer->id_personal_trainer) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus trainer ini?');" class="flex">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-6 bg-gym-red text-white hover:bg-red-600 transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5-4h4m-4 0a1 1 0 00-1 1v1h6V4a1 1 0 00-1-1m-4 0h4" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-600 text-center py-8">Tidak ada personal trainer yang ditemukan.</p>
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
            const activeTabParam = urlParams.get('tab');
            const memberSearchParam = urlParams.get('member_search');
            const trainerSearchParam = urlParams.get('trainer_search');

            function showSection(targetId) {
                contentSections.forEach(section => {
                    section.classList.remove('active');
                });
                document.getElementById(targetId).classList.add('active');

                sidebarItems.forEach(item => {
                    item.classList.remove('active-link-cs');
                });

                const activeItem = document.querySelector(`.sidebar-item[data-target="${targetId}"]`);
                if (activeItem) {
                    activeItem.classList.add('active-link-cs');
                }
            }

            sidebarItems.forEach(item => {
                item.addEventListener('click', function(e) {
                    e.preventDefault();
                    const targetId = this.dataset.target;
                    const newUrl = new URL(window.location.href);
                    newUrl.searchParams.set('tab', targetId);
                    newUrl.searchParams.delete('member_search');
                    newUrl.searchParams.delete('trainer_search');
                    window.history.pushState({}, '', newUrl.toString());
                    showSection(targetId);
                });
            });

            if (activeTabParam) {
                showSection(activeTabParam);
            } else if (trainerSearchParam) {
                showSection('trainerList');
            } else if (memberSearchParam) {
                showSection('memberList');
            } else {
                showSection('memberList');
            }
        });
    </script>
</body>
</html>