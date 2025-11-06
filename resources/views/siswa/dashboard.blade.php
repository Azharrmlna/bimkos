@extends('layouts.siswa')

@section('title', 'Dashboard Siswa')
@section('page-title', 'Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Welcome Card -->
    <div class="bg-gradient-to-r from-green-600 to-green-700 rounded-lg shadow-lg p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold mb-2">Selamat Datang, {{ auth()->user()->name }}!</h2>
                <p class="text-green-100">Semoga harimu menyenangkan. Jangan ragu untuk berkonsultasi dengan kami.</p>
            </div>
            <div class="hidden md:block">
                <i class="fas fa-user-graduate text-6xl opacity-50"></i>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Pengajuan -->
        <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Total Pengajuan</p>
                    <p class="text-3xl font-bold text-gray-800 mt-2">{{ $stats['total_pengajuan'] }}</p>
                </div>
                <div class="bg-blue-100 p-4 rounded-full">
                    <i class="fas fa-clipboard-list text-blue-600 text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Menunggu -->
        <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Menunggu</p>
                    <p class="text-3xl font-bold text-yellow-600 mt-2">{{ $stats['pengajuan_menunggu'] }}</p>
                </div>
                <div class="bg-yellow-100 p-4 rounded-full">
                    <i class="fas fa-clock text-yellow-600 text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Diproses -->
        <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Diproses</p>
                    <p class="text-3xl font-bold text-blue-600 mt-2">{{ $stats['pengajuan_diproses'] }}</p>
                </div>
                <div class="bg-blue-100 p-4 rounded-full">
                    <i class="fas fa-spinner text-blue-600 text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Selesai -->
        <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Selesai</p>
                    <p class="text-3xl font-bold text-green-600 mt-2">{{ $stats['pengajuan_selesai'] }}</p>
                </div>
                <div class="bg-green-100 p-4 rounded-full">
                    <i class="fas fa-check-circle text-green-600 text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <a href="{{ route('siswa.konseling.create') }}" class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition group">
            <div class="flex items-center">
                <div class="bg-green-100 p-4 rounded-full group-hover:bg-green-600 transition">
                    <i class="fas fa-plus text-green-600 text-2xl group-hover:text-white transition"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-800">Ajukan Konseling</h3>
                    <p class="text-gray-600 text-sm">Buat pengajuan konseling baru</p>
                </div>
            </div>
        </a>

        <a href="{{ route('siswa.messages.index') }}" class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition group">
            <div class="flex items-center">
                <div class="bg-blue-100 p-4 rounded-full group-hover:bg-blue-600 transition relative">
                    <i class="fas fa-comments text-blue-600 text-2xl group-hover:text-white transition"></i>
                    @if($stats['unread_messages'] > 0)
                        <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs w-5 h-5 rounded-full flex items-center justify-center">
                            {{ $stats['unread_messages'] }}
                        </span>
                    @endif
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-800">Pesan</h3>
                    <p class="text-gray-600 text-sm">Chat dengan Guru BK</p>
                </div>
            </div>
        </a>

        <a href="{{ route('articles.index') }}" class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition group">
            <div class="flex items-center">
                <div class="bg-purple-100 p-4 rounded-full group-hover:bg-purple-600 transition">
                    <i class="fas fa-newspaper text-purple-600 text-2xl group-hover:text-white transition"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-800">Artikel</h3>
                    <p class="text-gray-600 text-sm">Baca artikel bermanfaat</p>
                </div>
            </div>
        </a>
    </div>

    <!-- Recent Konselings & Articles -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Konselings -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-gradient-to-r from-green-600 to-green-700 px-6 py-4">
                <h3 class="text-lg font-bold text-white">Konseling Terbaru</h3>
            </div>
            <div class="p-6">
                @forelse($recent_konselings as $konseling)
                    <div class="mb-4 pb-4 border-b last:border-b-0 last:mb-0 last:pb-0">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <h4 class="font-semibold text-gray-800">{{ $konseling->topik }}</h4>
                                <p class="text-sm text-gray-600 mt-1">{{ Str::limit($konseling->deskripsi, 60) }}</p>
                                <div class="flex items-center mt-2 text-xs text-gray-500">
                                    <i class="fas fa-calendar mr-1"></i>
                                    {{ $konseling->created_at->format('d M Y') }}
                                </div>
                            </div>
                            <div class="ml-4">
                                @if($konseling->status == 'menunggu')
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        Menunggu
                                    </span>
                                @elseif($konseling->status == 'diproses')
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                        Diproses
                                    </span>
                                @else
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                        Selesai
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8">
                        <i class="fas fa-clipboard text-gray-300 text-4xl mb-3"></i>
                        <p class="text-gray-500">Belum ada pengajuan konseling</p>
                        <a href="{{ route('siswa.konseling.create') }}" class="text-green-600 hover:text-green-700 text-sm mt-2 inline-block">
                            <i class="fas fa-plus mr-1"></i>Buat Pengajuan
                        </a>
                    </div>
                @endforelse

                @if($recent_konselings->count() > 0)
                    <div class="mt-4 text-center">
                        <a href="{{ route('siswa.konseling.index') }}" class="text-green-600 hover:text-green-700 text-sm font-medium">
                            Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Recent Articles -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-gradient-to-r from-purple-600 to-purple-700 px-6 py-4">
                <h3 class="text-lg font-bold text-white">Artikel Terbaru</h3>
            </div>
            <div class="p-6">
                @forelse($recent_articles as $article)
                    <div class="mb-4 pb-4 border-b last:border-b-0 last:mb-0 last:pb-0">
                        <a href="{{ route('articles.show', $article) }}" class="block group">
                            <h4 class="font-semibold text-gray-800 group-hover:text-purple-600 transition">
                                {{ $article->title }}
                            </h4>
                            <p class="text-sm text-gray-600 mt-1">{{ Str::limit(strip_tags($article->content), 80) }}</p>
                            <div class="flex items-center mt-2 text-xs text-gray-500">
                                <i class="fas fa-calendar mr-1"></i>
                                {{ $article->published_at->format('d M Y') }}
                            </div>
                        </a>
                    </div>
                @empty
                    <div class="text-center py-8">
                        <i class="fas fa-newspaper text-gray-300 text-4xl mb-3"></i>
                        <p class="text-gray-500">Belum ada artikel</p>
                    </div>
                @endforelse

                @if($recent_articles->count() > 0)
                    <div class="mt-4 text-center">
                        <a href="{{ route('articles.index') }}" class="text-purple-600 hover:text-purple-700 text-sm font-medium">
                            Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Info Card -->
    <div class="bg-blue-50 border-l-4 border-blue-600 rounded-lg p-6">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <i class="fas fa-info-circle text-blue-600 text-2xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-lg font-semibold text-blue-900 mb-2">Informasi Penting</h3>
                <p class="text-blue-800 text-sm">
                    Jika kamu memiliki masalah atau ingin berkonsultasi, jangan ragu untuk mengajukan konseling. 
                    Guru BK siap membantu dan mendengarkan keluh kesahmu dengan penuh perhatian dan kerahasiaan terjamin.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
