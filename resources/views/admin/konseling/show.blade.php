@extends('layouts.admin')

@section('title', 'Detail Konseling')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <a href="{{ route('admin.konseling.index') }}" class="text-blue-600 hover:text-blue-800">
            <i class="fas fa-arrow-left mr-2"></i>Kembali ke Daftar Konseling
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Konseling Detail Card -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
                    <h2 class="text-xl font-bold text-white">Detail Konseling</h2>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Topik Konseling</label>
                            <p class="text-lg font-semibold text-gray-900">{{ $konseling->topik }}</p>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Konseling</label>
                                <span class="px-3 py-1 inline-flex text-sm font-semibold rounded-full 
                                    {{ $konseling->jenis_konseling == 'individu' ? 'bg-purple-100 text-purple-800' : 'bg-indigo-100 text-indigo-800' }}">
                                    {{ ucfirst($konseling->jenis_konseling) }}
                                </span>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                                @if($konseling->status == 'menunggu')
                                    <span class="px-3 py-1 inline-flex text-sm font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        <i class="fas fa-clock mr-1"></i> Menunggu
                                    </span>
                                @elseif($konseling->status == 'diproses')
                                    <span class="px-3 py-1 inline-flex text-sm font-semibold rounded-full bg-blue-100 text-blue-800">
                                        <i class="fas fa-spinner mr-1"></i> Diproses
                                    </span>
                                @else
                                    <span class="px-3 py-1 inline-flex text-sm font-semibold rounded-full bg-green-100 text-green-800">
                                        <i class="fas fa-check-circle mr-1"></i> Selesai
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Masalah</label>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="text-gray-800 whitespace-pre-line">{{ $konseling->deskripsi }}</p>
                            </div>
                        </div>

                        @if($konseling->catatan_guru)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Catatan Guru BK</label>
                                <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
                                    <p class="text-gray-800 whitespace-pre-line">{{ $konseling->catatan_guru }}</p>
                                </div>
                            </div>
                        @endif

                        <div class="border-t pt-4">
                            <p class="text-sm text-gray-600">
                                <i class="fas fa-calendar mr-2"></i>Diajukan pada: {{ $konseling->created_at->format('d M Y, H:i') }}
                            </p>
                            @if($konseling->updated_at != $konseling->created_at)
                                <p class="text-sm text-gray-600 mt-1">
                                    <i class="fas fa-edit mr-2"></i>Terakhir diupdate: {{ $konseling->updated_at->format('d M Y, H:i') }}
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Student Info Card -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="bg-gradient-to-r from-purple-600 to-purple-700 px-6 py-4">
                    <h3 class="text-lg font-bold text-white">Informasi Siswa</h3>
                </div>
                <div class="p-6">
                    <div class="flex items-center mb-4">
                        <div class="flex-shrink-0 h-16 w-16 bg-purple-100 rounded-full flex items-center justify-center">
                            <span class="text-purple-600 font-bold text-2xl">
                                {{ strtoupper(substr($konseling->user->name, 0, 1)) }}
                            </span>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-lg font-semibold text-gray-900">{{ $konseling->user->name }}</h4>
                            <p class="text-sm text-gray-600">{{ $konseling->user->email }}</p>
                        </div>
                    </div>
                    @if($konseling->user->kelas)
                        <div class="border-t pt-4">
                            <p class="text-sm text-gray-600">
                                <i class="fas fa-school mr-2"></i>Kelas: {{ $konseling->user->kelas }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Update Status Card -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="bg-gradient-to-r from-green-600 to-green-700 px-6 py-4">
                    <h3 class="text-lg font-bold text-white">Update Status</h3>
                </div>
                <div class="p-6">
                    <form action="{{ route('admin.konseling.update', $konseling) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-4">
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                                Status Konseling
                            </label>
                            <select name="status" id="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" required>
                                <option value="menunggu" {{ $konseling->status == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                                <option value="diproses" {{ $konseling->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                                <option value="selesai" {{ $konseling->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="catatan_guru" class="block text-sm font-medium text-gray-700 mb-2">
                                Catatan Guru BK
                            </label>
                            <textarea name="catatan_guru" id="catatan_guru" rows="4" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                placeholder="Masukkan catatan atau hasil konseling...">{{ old('catatan_guru', $konseling->catatan_guru) }}</textarea>
                        </div>

                        <button type="submit" class="w-full bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                            <i class="fas fa-save mr-2"></i>Simpan Perubahan
                        </button>
                    </form>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Aksi Cepat</h3>
                <div class="space-y-2">
                    <a href="mailto:{{ $konseling->user->email }}" class="block w-full bg-blue-600 text-white text-center px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                        <i class="fas fa-envelope mr-2"></i>Email Siswa
                    </a>
                    <form action="{{ route('admin.konseling.destroy', $konseling) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus konseling ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition">
                            <i class="fas fa-trash mr-2"></i>Hapus Konseling
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection