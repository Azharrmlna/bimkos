@extends('layouts.public')

@section('title', 'Beranda - Bimbingan Konseling')

@section('content')
<!-- Hero Section -->
<div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="text-center">
            <h1 class="text-4xl md:text-6xl font-bold mb-6">Selamat Datang di Layanan Bimbingan Konseling</h1>
            <p class="text-xl md:text-2xl mb-8 text-blue-100">Kami siap membantu perkembangan dan kesejahteraan siswa</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                @auth
                    @if(auth()->user()->role === 'siswa')
                        <a href="{{ route('siswa.konseling.create') }}" class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-blue-50 transition">
                            Ajukan Konseling
                        </a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-blue-50 transition">
                        Login Siswa
                    </a>
                @endauth
                <a href="{{ route('contact') }}" class="bg-transparent border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-blue-600 transition">
                    Hubungi Kami
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Layanan Section -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <h2 class="text-3xl font-bold text-center mb-12 text-gray-800">Layanan Kami</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="bg-white p-6 rounded-lg shadow-lg hover:shadow-xl transition">
            <div class="text-blue-600 text-4xl mb-4">
                <i class="fas fa-comments"></i>
            </div>
            <h3 class="text-xl font-bold mb-3 text-gray-800">Konseling Pribadi</h3>
            <p class="text-gray-600">Layanan konseling individual untuk membantu mengatasi masalah pribadi dan emosional.</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-lg hover:shadow-xl transition">
            <div class="text-blue-600 text-4xl mb-4">
                <i class="fas fa-users"></i>
            </div>
            <h3 class="text-xl font-bold mb-3 text-gray-800">Konseling Kelompok</h3>
            <p class="text-gray-600">Sesi konseling bersama untuk berbagi pengalaman dan solusi bersama teman sebaya.</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-lg hover:shadow-xl transition">
            <div class="text-blue-600 text-4xl mb-4">
                <i class="fas fa-book-open"></i>
            </div>
            <h3 class="text-xl font-bold mb-3 text-gray-800">Bimbingan Belajar</h3>
            <p class="text-gray-600">Bantuan untuk meningkatkan prestasi akademik dan mengatasi kesulitan belajar.</p>
        </div>
    </div>
</div>

<!-- Guru BK Section -->
@if($guruBK->count() > 0)
<div class="bg-gray-100 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-center mb-12 text-gray-800">Tim Guru BK Kami</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($guruBK as $guru)
            <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition">
                <div class="p-6 text-center">
                    <div class="w-24 h-24 bg-blue-100 rounded-full mx-auto mb-4 flex items-center justify-center">
                        <i class="fas fa-user-tie text-blue-600 text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-2 text-gray-800">{{ $guru->name }}</h3>
                    <p class="text-gray-600 mb-4">{{ $guru->email }}</p>
                    @auth
                        @if(auth()->user()->role === 'siswa')
                            <a href="{{ route('siswa.messages.show', $guru->id) }}" class="inline-block bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                                <i class="fas fa-envelope mr-2"></i>Kirim Pesan
                            </a>
                        @endif
                    @endauth
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif

<!-- Artikel Terbaru -->
@if($recent_articles->count() > 0)
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="flex justify-between items-center mb-8">
        <h2 class="text-3xl font-bold text-gray-800">Artikel Terbaru</h2>
        <a href="{{ route('articles.index') }}" class="text-blue-600 hover:text-blue-700 font-semibold">
            Lihat Semua <i class="fas fa-arrow-right ml-2"></i>
        </a>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        @foreach($recent_articles as $article)
        <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition">
            @if($article->image)
            <img src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->title }}" class="w-full h-48 object-cover">
            @else
            <div class="w-full h-48 bg-gradient-to-r from-blue-400 to-blue-600 flex items-center justify-center">
                <i class="fas fa-newspaper text-white text-5xl"></i>
            </div>
            @endif
            <div class="p-6">
                <div class="text-sm text-gray-500 mb-2">
                    <i class="far fa-calendar mr-2"></i>{{ $article->created_at->format('d M Y') }}
                </div>
                <h3 class="text-xl font-bold mb-3 text-gray-800 line-clamp-2">{{ $article->title }}</h3>
                <p class="text-gray-600 mb-4 line-clamp-3">{{ Str::limit(strip_tags($article->content), 100) }}</p>
                <a href="{{ route('articles.show', $article->slug) }}" class="text-blue-600 hover:text-blue-700 font-semibold">
                    Baca Selengkapnya <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif

<!-- Agenda Mendatang -->
@if($upcoming_agendas->count() > 0)
<div class="bg-gray-100 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-bold text-gray-800">Agenda Mendatang</h2>
            <a href="{{ route('agendas.index') }}" class="text-blue-600 hover:text-blue-700 font-semibold">
                Lihat Semua <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($upcoming_agendas as $agenda)
            <div class="bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition">
                <div class="flex items-start">
                    <div class="bg-blue-100 rounded-lg p-4 mr-4">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-blue-600">{{ $agenda->date->format('d') }}</div>
                            <div class="text-sm text-blue-600">{{ $agenda->date->format('M') }}</div>
                        </div>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-lg font-bold mb-2 text-gray-800">{{ $agenda->title }}</h3>
                        <p class="text-gray-600 text-sm mb-2">{{ Str::limit($agenda->description, 80) }}</p>
                        <div class="flex items-center text-sm text-gray-500">
                            <i class="far fa-clock mr-2"></i>
                            {{ $agenda->time }}
                        </div>
                        <div class="flex items-center text-sm text-gray-500 mt-1">
                            <i class="fas fa-map-marker-alt mr-2"></i>
                            {{ $agenda->location }}
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif

<!-- CTA Section -->
<div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl font-bold mb-4">Butuh Bantuan?</h2>
        <p class="text-xl mb-8 text-blue-100">Jangan ragu untuk menghubungi kami kapan saja</p>
        <a href="{{ route('contact') }}" class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-blue-50 transition inline-block">
            Hubungi Kami Sekarang
        </a>
    </div>
</div>
@endsection