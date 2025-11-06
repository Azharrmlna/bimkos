@extends('layouts.public')

@section('title', 'Artikel - Bimbingan Konseling')

@section('content')
<!-- Header -->
<div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-4xl font-bold mb-4">Artikel Bimbingan Konseling</h1>
        <p class="text-xl text-blue-100">Baca artikel dan tips seputar perkembangan diri dan kesehatan mental</p>
    </div>
</div>

<!-- Articles Grid -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    @if($articles->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($articles as $article)
            <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition">
                @if($article->image)
                <img src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->title }}" class="w-full h-48 object-cover">
                @else
                <div class="w-full h-48 bg-gradient-to-r from-blue-400 to-blue-600 flex items-center justify-center">
                    <i class="fas fa-newspaper text-white text-5xl"></i>
                </div>
                @endif
                
                <div class="p-6">
                    <div class="flex items-center text-sm text-gray-500 mb-3">
                        <i class="far fa-calendar mr-2"></i>
                        <span>{{ $article->created_at->format('d M Y') }}</span>
                        <span class="mx-2">•</span>
                        <i class="fas fa-user mr-2"></i>
                        <span>{{ $article->creator->name }}</span>
                    </div>
                    
                    <h3 class="text-xl font-bold mb-3 text-gray-800 hover:text-blue-600 transition">
                        <a href="{{ route('articles.show', $article->slug) }}">
                            {{ $article->title }}
                        </a>
                    </h3>
                    
                    <p class="text-gray-600 mb-4 line-clamp-3">
                        {{ Str::limit(strip_tags($article->content), 150) }}
                    </p>
                    
                    <a href="{{ route('articles.show', $article->slug) }}" class="text-blue-600 hover:text-blue-700 font-semibold inline-flex items-center">
                        Baca Selengkapnya 
                        <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-12">
            {{ $articles->links() }}
        </div>
    @else
        <div class="text-center py-16">
            <i class="fas fa-newspaper text-gray-300 text-6xl mb-4"></i>
            <h3 class="text-2xl font-bold text-gray-600 mb-2">Belum Ada Artikel</h3>
            <p class="text-gray-500">Artikel akan segera ditambahkan</p>
        </div>
    @endif
</div>
@endsection