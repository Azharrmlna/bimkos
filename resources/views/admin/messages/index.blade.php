@extends('layouts.admin')

@section('title', 'Pesan')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Pesan</h1>
        <p class="text-gray-600 mt-2">Kelola percakapan dengan siswa</p>
    </div>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Daftar Percakapan</h2>
            
            @if($siswaList->isEmpty())
                <div class="text-center py-12">
                    <i class="fas fa-comments text-gray-400 text-6xl mb-4"></i>
                    <p class="text-gray-500 text-lg">Belum ada percakapan</p>
                    <p class="text-gray-400 text-sm mt-2">Percakapan akan muncul ketika siswa mengirim pesan</p>
                </div>
            @else
                <div class="space-y-2">
                    @foreach($siswaList as $siswa)
                        <a href="{{ route('admin.messages.show', $siswa) }}" 
                           class="block p-4 rounded-lg border border-gray-200 hover:bg-blue-50 hover:border-blue-300 transition">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center flex-1">
                                    <div class="flex-shrink-0 h-12 w-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center shadow-md">
                                        <span class="text-white font-bold text-lg">
                                            {{ strtoupper(substr($siswa->name, 0, 1)) }}
                                        </span>
                                    </div>
                                    <div class="ml-4 flex-1">
                                        <div class="flex items-center justify-between">
                                            <h3 class="text-lg font-semibold text-gray-900">{{ $siswa->name }}</h3>
                                            @if($siswa->unread_count > 0)
                                                <span class="ml-2 px-2 py-1 bg-red-500 text-white text-xs font-bold rounded-full">
                                                    {{ $siswa->unread_count }}
                                                </span>
                                            @endif
                                        </div>
                                        <p class="text-sm text-gray-600">{{ $siswa->email }}</p>
                                        @if($siswa->kelas)
                                            <p class="text-xs text-gray-500 mt-1">
                                                <i class="fas fa-school mr-1"></i>{{ $siswa->kelas }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <i class="fas fa-chevron-right text-gray-400"></i>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
