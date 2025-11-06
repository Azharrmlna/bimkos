@extends('layouts.public')

@section('title', 'Agenda - Bimbingan Konseling')

@section('content')
<!-- Header -->
<div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-4xl font-bold mb-4">Agenda Kegiatan</h1>
        <p class="text-xl text-blue-100">Jadwal kegiatan dan acara bimbingan konseling</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Agenda Mendatang -->
    <div class="mb-16">
        <h2 class="text-3xl font-bold mb-8 text-gray-800 flex items-center">
            <i class="fas fa-calendar-plus text-blue-600 mr-3"></i>
            Agenda Mendatang
        </h2>
        
        @if($upcoming_agendas->count() > 0)
            <div class="space-y-6">
                @foreach($upcoming_agendas as $agenda)
                <div class="bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition">
                    <div class="flex flex-col md:flex-row md:items-center">
                        <!-- Date Box -->
                        <div class="bg-gradient-to-br from-blue-500 to-blue-700 text-white rounded-lg p-6 text-center mb-4 md:mb-0 md:mr-6 md:w-32 flex-shrink-0">
                            <div class="text-3xl font-bold">{{ $agenda->date->format('d') }}</div>
                            <div class="text-lg">{{ $agenda->date->format('M') }}</div>
                            <div class="text-sm">{{ $agenda->date->format('Y') }}</div>
                        </div>
                        
                        <!-- Content -->
                        <div class="flex-1">
                            <h3 class="text-2xl font-bold mb-2 text-gray-800">{{ $agenda->title }}</h3>
                            <p class="text-gray-600 mb-4">{{ $agenda->description }}</p>
                            
                            <div class="flex flex-wrap gap-4 text-sm text-gray-600">
                                <div class="flex items-center">
                                    <i class="far fa-clock mr-2 text-blue-600"></i>
                                    <span>{{ $agenda->time }}</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-map-marker-alt mr-2 text-blue-600"></i>
                                    <span>{{ $agenda->location }}</span>
                                </div>
                                @if($agenda->date->isToday())
                                <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full font-semibold">
                                    Hari Ini
                                </span>
                                @elseif($agenda->date->isTomorrow())
                                <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full font-semibold">
                                    Besok
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="mt-8">
                {{ $upcoming_agendas->links() }}
            </div>
        @else
            <div class="bg-white rounded-lg shadow p-12 text-center">
                <i class="fas fa-calendar-times text-gray-300 text-6xl mb-4"></i>
                <h3 class="text-xl font-bold text-gray-600 mb-2">Tidak Ada Agenda Mendatang</h3>
                <p class="text-gray-500">Belum ada agenda yang dijadwalkan</p>
            </div>
        @endif
    </div>

    <!-- Agenda yang Sudah Lewat -->
    <div>
        <h2 class="text-3xl font-bold mb-8 text-gray-800 flex items-center">
            <i class="fas fa-calendar-check text-gray-600 mr-3"></i>
            Agenda Sebelumnya
        </h2>
        
        @if($past_agendas->count() > 0)
            <div class="space-y-4">
                @foreach($past_agendas as $agenda)
                <div class="bg-gray-50 rounded-lg shadow p-6 hover:shadow-md transition opacity-75">
                    <div class="flex flex-col md:flex-row md:items-center">
                        <!-- Date Box -->
                        <div class="bg-gray-400 text-white rounded-lg p-4 text-center mb-4 md:mb-0 md:mr-6 md:w-24 flex-shrink-0">
                            <div class="text-2xl font-bold">{{ $agenda->date->format('d') }}</div>
                            <div class="text-sm">{{ $agenda->date->format('M Y') }}</div>
                        </div>
                        
                        <!-- Content -->
                        <div class="flex-1">
                            <h3 class="text-xl font-bold mb-2 text-gray-700">{{ $agenda->title }}</h3>
                            <p class="text-gray-600 mb-3">{{ Str::limit($agenda->description, 150) }}</p>
                            
                            <div class="flex flex-wrap gap-4 text-sm text-gray-500">
                                <div class="flex items-center">
                                    <i class="far fa-clock mr-2"></i>
                                    <span>{{ $agenda->time }}</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-map-marker-alt mr-2"></i>
                                    <span>{{ $agenda->location }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="mt-8">
                {{ $past_agendas->links() }}
            </div>
        @else
            <div class="bg-gray-50 rounded-lg shadow p-12 text-center">
                <i class="fas fa-calendar-check text-gray-300 text-6xl mb-4"></i>
                <h3 class="text-xl font-bold text-gray-600 mb-2">Belum Ada Agenda Sebelumnya</h3>
                <p class="text-gray-500">Belum ada agenda yang telah dilaksanakan</p>
            </div>
        @endif
    </div>
</div>
@endsection