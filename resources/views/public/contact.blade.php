@extends('layouts.public')

@section('title', 'Kontak - Bimbingan Konseling')

@section('content')
<!-- Header -->
<div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-4xl font-bold mb-4">Hubungi Kami</h1>
        <p class="text-xl text-blue-100">Kami siap membantu Anda. Jangan ragu untuk menghubungi kami</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
        <!-- Contact Form -->
        <div>
            <div class="bg-white rounded-lg shadow-lg p-8">
                <h2 class="text-2xl font-bold mb-6 text-gray-800">Kirim Pesan</h2>
                
                @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    <i class="fas fa-check-circle mr-2"></i>
                    {{ session('success') }}
                </div>
                @endif

                <form action="{{ route('contact.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-4">
                        <label for="name" class="block text-gray-700 font-semibold mb-2">
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               value="{{ old('name') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror" 
                               required>
                        @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="email" class="block text-gray-700 font-semibold mb-2">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               value="{{ old('email') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('email') border-red-500 @enderror" 
                               required>
                        @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="subject" class="block text-gray-700 font-semibold mb-2">
                            Subjek <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="subject" 
                               name="subject" 
                               value="{{ old('subject') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('subject') border-red-500 @enderror" 
                               required>
                        @error('subject')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="message" class="block text-gray-700 font-semibold mb-2">
                            Pesan <span class="text-red-500">*</span>
                        </label>
                        <textarea id="message" 
                                  name="message" 
                                  rows="6" 
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('message') border-red-500 @enderror" 
                                  required>{{ old('message') }}</textarea>
                        @error('message')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
                        <i class="fas fa-paper-plane mr-2"></i>
                        Kirim Pesan
                    </button>
                </form>
            </div>
        </div>

        <!-- Contact Info & Guru BK -->
        <div>
            <!-- Contact Info -->
            <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
                <h2 class="text-2xl font-bold mb-6 text-gray-800">Informasi Kontak</h2>
                
                <div class="space-y-4">
                    <div class="flex items-start">
                        <div class="bg-blue-100 rounded-lg p-3 mr-4">
                            <i class="fas fa-map-marker-alt text-blue-600 text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-800 mb-1">Alamat</h3>
                            <p class="text-gray-600">Jl. Sukamenak<br>Sukamenak Mangprang, DKI Curdog 12345</p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="bg-blue-100 rounded-lg p-3 mr-4">
                            <i class="fas fa-phone text-blue-600 text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-800 mb-1">Telepon</h3>
                            <p class="text-gray-600">(021) 1234-5678</p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="bg-blue-100 rounded-lg p-3 mr-4">
                            <i class="fas fa-envelope text-blue-600 text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-800 mb-1">Email</h3>
                            <p class="text-gray-600">bk@sekolah.sch.id</p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="bg-blue-100 rounded-lg p-3 mr-4">
                            <i class="fas fa-clock text-blue-600 text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-800 mb-1">Jam Operasional</h3>
                            <p class="text-gray-600">Senin - Jumat: 07:00 - 16:00<br>Sabtu: 07:00 - 12:00</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Guru BK -->
            @if($guruBK->count() > 0)
            <div class="bg-white rounded-lg shadow-lg p-8">
                <h2 class="text-2xl font-bold mb-6 text-gray-800">Tim Guru BK</h2>
                
                <div class="space-y-4">
                    @foreach($guruBK as $guru)
                    <div class="flex items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                        <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mr-4">
                            <i class="fas fa-user-tie text-blue-600 text-2xl"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-bold text-gray-800">{{ $guru->name }}</h3>
                            <p class="text-sm text-gray-600">{{ $guru->email }}</p>
                        </div>
                        @auth
                            @if(auth()->user()->role === 'siswa')
                            <a href="{{ route('siswa.messages.show', $guru->id) }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition text-sm">
                                <i class="fas fa-comment mr-1"></i> Chat
                            </a>
                            @endif
                        @endauth
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Map Section (Optional) -->
<div class="bg-gray-100 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold mb-8 text-center text-gray-800">Lokasi Kami</h2>
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="w-full h-96 bg-gray-200 flex items-center justify-center">
                <div class="text-center">
                    <i class="fas fa-map-marked-alt text-gray-400 text-6xl mb-4"></i>
                    <p class="text-gray-600">Peta lokasi akan ditampilkan di sini</p>
                    <p class="text-sm text-gray-500 mt-2">Integrasikan dengan Google Maps API</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection