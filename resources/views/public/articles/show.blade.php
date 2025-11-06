@extends('layouts.public')

@section('title', $article->title . ' - Bimbingan Konseling')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Breadcrumb -->
    <nav class="mb-8">
        <ol class="flex items-center space-x-2 text-sm text-gray-500">
            <li><a href="{{ route('home') }}" class="hover:text-blue-600">Beranda</a></li>
            <li><i class="fas fa-chevron-right text-xs"></i></li>
            <li><a href="{{ route('articles.index') }}" class="hover:text-blue-600">Artikel</a></li>
            <li><i class="fas fa-chevron-right text-xs"></i></li>
            <li class="text-gray-700">{{ Str::limit($article->title, 50) }}</li>
        </ol>
    </nav>

    <!-- Article Header -->
    <article class="bg-white rounded-lg shadow-lg overflow-hidden">
        @if($article->image)
        <img src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->title }}" class="w-full h-96 object-cover">
        @else
        <div class="w-full h-96 bg-gradient-to-r from-blue-400 to-blue-600 flex items-center justify-center">
            <i class="fas fa-newspaper text-white text-6xl"></i>
        </div>
        @endif

        <div class="p-8">
            <h1 class="text-4xl font-bold mb-4 text-gray-800">{{ $article->title }}</h1>
            
            <div class="flex items-center text-gray-600 mb-6 pb-6 border-b">
                <div class="flex items-center mr-6">
                    <i class="fas fa-user-circle text-2xl mr-3 text-blue-600"></i>
                    <div>
                        <div class="text-sm text-gray-500">Ditulis oleh</div>
                        <div class="font-semibold">{{ $article->creator->name }}</div>
                    </div>
                </div>
                <div class="flex items-center">
                    <i class="far fa-calendar text-xl mr-3 text-blue-600"></i>
                    <div>
                        <div class="text-sm text-gray-500">Dipublikasikan</div>
                        <div class="font-semibold">{{ $article->created_at->format('d M Y') }}</div>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="prose prose-lg max-w-none text-gray-700">
                {!! nl2br(e($article->content)) !!}
            </div>
        </div>
    </article>

    <!-- Related Articles -->
    @if($related_articles->count() > 0)
    <div class="mt-16">
        <h2 class="text-3xl font-bold mb-8 text-gray-800">Artikel Terkait</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($related_articles as $related)
            <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition">
                @if($related->image)
                <img src="{{ asset('storage/' . $related->image) }}" alt="{{ $related->title }}" class="w-full h-40 object-cover">
                @else
                <div class="w-full h-40 bg-gradient-to-r from-blue-400 to-blue-600 flex items-center justify-center">
                    <i class="fas fa-newspaper text-white text-3xl"></i>
                </div>
                @endif
                
                <div class="p-4">
                    <div class="text-xs text-gray-500 mb-2">
                        {{ $related->created_at->format('d M Y') }}
                    </div>
                    <h3 class="text-lg font-bold mb-2 text-gray-800 line-clamp-2">
                        <a href="{{ route('articles.show', $related->slug) }}" class="hover:text-blue-600">
                            {{ $related->title }}
                        </a>
                    </h3>
                    <a href="{{ route('articles.show', $related->slug) }}" class="text-blue-600 hover:text-blue-700 text-sm font-semibold">
                        Baca Artikel <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Back Button -->
    <div class="mt-12">
        <a href="{{ route('articles.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-700 font-semibold">
            <i class="fas fa-arrow-left mr-2"></i>
            Kembali ke Daftar Artikel
        </a>
    </div>
</div>
@endsection