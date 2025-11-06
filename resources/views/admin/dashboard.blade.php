@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard')

@section('content')
<!-- Welcome Banner -->
<div class="bg-gradient-to-r from-blue-600 to-blue-800 rounded-lg shadow-lg p-6 mb-6 text-white">
    <h2 class="text-2xl font-bold mb-2">Selamat Datang, {{ auth()->user()->name }}!</h2>
    <p class="text-blue-100">Kelola sistem bimbingan konseling dengan mudah dan efisien</p>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <!-- Total Siswa -->
    <div class="bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm font-semibold uppercase">Total Siswa</p>
                <p class="text-3xl font-bold text-gray-800 mt-2">{{ $stats['total_siswa'] }}</p>
            </div>
            <div class="bg-blue-100 rounded-full p-4">
                <i class="fas fa-users text-blue-600 text-2xl"></i>
            </div>
        </div>
    </div>

    <!-- Total Pengajuan -->
    <div class="bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm font-semibold uppercase">Total Pengajuan</p>
                <p class="text-3xl font-bold text-gray-800 mt-2">{{ $stats['total_pengajuan'] }}</p>
            </div>
            <div class="bg-purple-100 rounded-full p-4">
                <i class="fas fa-clipboard-list text-purple-600 text-2xl"></i>
            </div>
        </div>
    </div>

    <!-- Pengajuan Menunggu -->
    <div class="bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm font-semibold uppercase">Menunggu</p>
                <p class="text-3xl font-bold text-gray-800 mt-2">{{ $stats['pengajuan_menunggu'] }}</p>
            </div>
            <div class="bg-yellow-100 rounded-full p-4">
                <i class="fas fa-clock text-yellow-600 text-2xl"></i>
            </div>
        </div>
        @if($stats['pengajuan_menunggu'] > 0)
        <a href="{{ route('admin.konseling.index', ['status' => 'menunggu']) }}" class="text-yellow-600 text-sm mt-2 inline-block hover:text-yellow-700">
            Lihat Detail <i class="fas fa-arrow-right ml-1"></i>
        </a>
        @endif
    </div>

    <!-- Pesan Belum Dibaca -->
    <div class="bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm font-semibold uppercase">Pesan Baru</p>
                <p class="text-3xl font-bold text-gray-800 mt-2">{{ $stats['chat_belum_dibaca'] }}</p>
            </div>
            <div class="bg-green-100 rounded-full p-4">
                <i class="fas fa-envelope text-green-600 text-2xl"></i>
            </div>
        </div>
        @if($stats['chat_belum_dibaca'] > 0)
        <a href="{{ route('admin.messages.index') }}" class="text-green-600 text-sm mt-2 inline-block hover:text-green-700">
            Buka Pesan <i class="fas fa-arrow-right ml-1"></i>
        </a>
        @endif
    </div>
</div>

<!-- Status Overview -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
    <div class="bg-white rounded-lg shadow-lg p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-bold text-gray-800">Status Konseling</h3>
            <i class="fas fa-chart-pie text-blue-600"></i>
        </div>
        <div class="space-y-3">
            <div class="flex items-center justify-between">
                <span class="text-gray-600">Menunggu</span>
                <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm font-semibold">
                    {{ $stats['pengajuan_menunggu'] }}
                </span>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-gray-600">Diproses</span>
                <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-semibold">
                    {{ $stats['pengajuan_diproses'] }}
                </span>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-gray-600">Selesai</span>
                <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-semibold">
                    {{ $stats['pengajuan_selesai'] }}
                </span>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-lg p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-bold text-gray-800">Konten</h3>
            <i class="fas fa-file-alt text-purple-600"></i>
        </div>
        <div class="space-y-3">
            <div class="flex items-center justify-between">
                <span class="text-gray-600">Artikel</span>
                <span class="bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-sm font-semibold">
                    {{ $stats['total_artikel'] }}
                </span>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-gray-600">Total Pesan</span>
                <span class="bg-indigo-100 text-indigo-800 px-3 py-1 rounded-full text-sm font-semibold">
                    {{ $stats['total_chat'] }}
                </span>
            </div>
        </div>
        <a href="{{ route('admin.articles.create') }}" class="mt-4 inline-block text-purple-600 hover:text-purple-700 text-sm font-semibold">
            Buat Artikel Baru <i class="fas fa-plus ml-1"></i>
        </a>
    </div>

    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow-lg p-6 text-white">
        <h3 class="text-lg font-bold mb-4">Quick Actions</h3>
        <div class="space-y-2">
            <a href="{{ route('admin.konseling.index') }}" class="block bg-white bg-opacity-20 hover:bg-opacity-30 rounded-lg p-3 transition">
                <i class="fas fa-clipboard-list mr-2"></i>Kelola Konseling
            </a>
            <a href="{{ route('admin.messages.index') }}" class="block bg-white bg-opacity-20 hover:bg-opacity-30 rounded-lg p-3 transition">
                <i class="fas fa-comments mr-2"></i>Lihat Pesan
            </a>
            <a href="{{ route('admin.articles.create') }}" class="block bg-white bg-opacity-20 hover:bg-opacity-30 rounded-lg p-3 transition">
                <i class="fas fa-plus mr-2"></i>Buat Artikel
            </a>
        </div>
    </div>
</div>

<!-- Recent Konselings & Active Students -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Recent Konselings -->
    <div class="bg-white rounded-lg shadow-lg">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-bold text-gray-800">Pengajuan Konseling Terbaru</h3>
                <a href="{{ route('admin.konseling.index') }}" class="text-blue-600 hover:text-blue-700 text-sm font-semibold">
                    Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
        </div>
        <div class="p-6">
            @if($recent_konselings->count() > 0)
                <div class="space-y-4">
                    @foreach($recent_konselings as $konseling)
                    <div class="flex items-start space-x-4 p-4 border border-gray-200 rounded-lg hover:border-blue-300 transition">
                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-user text-blue-600"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-start justify-between">
                                <div>
                                    <p class="font-semibold text-gray-800">{{ $konseling->user->name }}</p>
                                    <p class="text-sm text-gray-500">{{ $konseling->user->kelas }}</p>
                                </div>
                                @if($konseling->status === 'menunggu')
                                    <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-xs font-semibold">
                                        Menunggu
                                    </span>
                                @elseif($konseling->status === 'diproses')
                                    <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs font-semibold">
                                        Diproses
                                    </span>
                                @else
                                    <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs font-semibold">
                                        Selesai
                                    </span>
                                @endif
                            </div>
                            <p class="text-sm text-gray-600 mt-1 line-clamp-2">{{ $konseling->masalah }}</p>
                            <p class="text-xs text-gray-400 mt-2">
                                <i class="far fa-clock mr-1"></i>{{ $konseling->created_at->diffForHumans() }}
                            </p>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <i class="fas fa-inbox text-gray-300 text-4xl mb-3"></i>
                    <p class="text-gray-500">Belum ada pengajuan konseling</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Active Students -->
    <div class="bg-white rounded-lg shadow-lg">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-bold text-gray-800">Siswa Teraktif</h3>
            <p class="text-sm text-gray-500">Berdasarkan aktivitas pesan dan konseling</p>
        </div>
        <div class="p-6">
            @if($siswa_aktif->count() > 0)
                <div class="space-y-3">
                    @foreach($siswa_aktif as $index => $siswa)
                    <div class="flex items-center space-x-4">
                        <div class="text-gray-400 font-bold text-lg w-6">
                            #{{ $index + 1 }}
                        </div>
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center text-white font-bold flex-shrink-0">
                            {{ substr($siswa->name, 0, 1) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-gray-800 truncate">{{ $siswa->name }}</p>
                            <p class="text-sm text-gray-500">{{ $siswa->kelas }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-gray-600">
                                <i class="fas fa-comment text-blue-600 mr-1"></i>{{ $siswa->sent_messages_count }}
                            </p>
                            <p class="text-sm text-gray-600">
                                <i class="fas fa-clipboard text-purple-600 mr-1"></i>{{ $siswa->konselings_count }}
                            </p>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <i class="fas fa-users text-gray-300 text-4xl mb-3"></i>
                    <p class="text-gray-500">Belum ada data siswa aktif</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection