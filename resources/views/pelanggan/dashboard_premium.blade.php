{{-- resources/views/pelanggan/dashboard_premium.blade.php --}}
@extends('layouts.app') {{-- Atau layout utama Anda --}}

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Dashboard Pelanggan Premium</h1>

        <div class="bg-white shadow-md rounded-lg p-6 mb-6">
            <h2 class="text-xl font-semibold mb-3">Informasi Akun Anda</h2>
            <p>Nama: {{ $pelanggan->nama_pelanggan }}</p>
            <p>Username: {{ $pelanggan->user->username }}</p>
            <p>Paket Layanan: {{ $pelanggan->paket_layanan }}</p>
            {{-- Tampilkan info akun lainnya --}}
        </div>

        {{-- Bagian untuk Membuat Catatan Latihan (sama seperti biasa) --}}
        <div class="bg-white shadow-md rounded-lg p-6 mb-6">
            <h2 class="text-xl font-semibold mb-3">Catatan Latihan Anda</h2>
            {{-- Form untuk membuat catatan baru --}}
            <form action="{{ route('pelanggan.catatan.store') }}" method="POST">
                @csrf
                {{-- Input form untuk kegiatan_latihan, catatan_latihan, dll --}}
                <button type="submit" class="bg-blue-500 text-white p-2 rounded">Simpan Catatan</button>
            </form>

            {{-- Daftar catatan latihan --}}
            <h3 class="text-lg font-semibold mt-4 mb-2">Daftar Catatan Anda</h3>
            @forelse($catatanLatihan as $catatan)
                <div class="border-b py-2">
                    <p><strong>Tanggal:</strong> {{ $catatan->tanggal_latihan }}</p>
                    <p><strong>Kegiatan:</strong> {{ $catatan->kegiatan_latihan }}</p>
                    <p><strong>Catatan:</strong> {{ $catatan->catatan_latihan }}</p>
                    {{-- Tambahkan tombol edit/hapus catatan --}}
                </div>
            @empty
                <p>Belum ada catatan latihan.</p>
            @endforelse
        </div>

        {{-- === Tambahan untuk Pelanggan Premium: Catatan dari Personal Trainer === --}}
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-xl font-semibold mb-3">Histori Latihan dengan Personal Trainer</h2>
            @forelse($historiLatihan as $histori)
                <div class="border-b py-2">
                    <p><strong>Tanggal:</strong> {{ $histori->tanggal_latihan }}</p>
                    <p><strong>Kegiatan:</strong> {{ $histori->kegiatan_latihan }}</p>
                    <p><strong>Catatan PT:</strong> {{ $histori->catatan_latihan }}</p>
                    @if($histori->personalTrainer)
                        <p><strong>Personal Trainer:</strong> {{ $histori->personalTrainer->nama_personal_trainer }}</p>
                    @endif
                </div>
            @empty
                <p>Belum ada histori latihan dengan Personal Trainer.</p>
            @endforelse
        </div>
    </div>
@endsection