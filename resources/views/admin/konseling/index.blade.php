@extends('layouts.admin')

@section('title', 'Kelola Konseling')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Kelola Konseling</h1>
        <p class="text-gray-600 mt-2">Kelola semua pengajuan konseling dari siswa</p>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Filter Section -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <form method="GET" action="{{ route('admin.konseling.index') }}" class="flex flex-wrap gap-4 items-end">
            <div class="flex-1 min-w-[200px]">
                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                    Filter Status
                </label>
                <select name="status" id="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">Semua Status</option>
                    <option value="menunggu" {{ request('status') == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                    <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>Diproses</option>
                    <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                </select>
            </div>
            <div>
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                    <i class="fas fa-filter mr-2"></i>Filter
                </button>
                <a href="{{ route('admin.konseling.index') }}" class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600 transition ml-2">
                    <i class="fas fa-redo mr-2"></i>Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Total Konseling</p>
                    <p class="text-3xl font-bold text-gray-800 mt-2">{{ $konselings->total() }}</p>
                </div>
                <div class="bg-blue-100 p-4 rounded-full">
                    <i class="fas fa-comments text-blue-600 text-2xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Menunggu</p>
                    <p class="text-3xl font-bold text-yellow-600 mt-2">
                        {{ \App\Models\Konseling::where('status', 'menunggu')->count() }}
                    </p>
                </div>
                <div class="bg-yellow-100 p-4 rounded-full">
                    <i class="fas fa-clock text-yellow-600 text-2xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Diproses</p>
                    <p class="text-3xl font-bold text-green-600 mt-2">
                        {{ \App\Models\Konseling::where('status', 'diproses')->count() }}
                    </p>
                </div>
                <div class="bg-green-100 p-4 rounded-full">
                    <i class="fas fa-spinner text-green-600 text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Konseling Table -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Siswa
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Topik
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Jenis
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Tanggal
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($konselings as $konseling)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center">
                                        <span class="text-blue-600 font-semibold">
                                            {{ strtoupper(substr($konseling->user->name, 0, 1)) }}
                                        </span>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $konseling->user->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $konseling->user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900">{{ Str::limit($konseling->topik, 40) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $konseling->jenis_konseling == 'individu' ? 'bg-purple-100 text-purple-800' : 'bg-indigo-100 text-indigo-800' }}">
                                    {{ ucfirst($konseling->jenis_konseling) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($konseling->status == 'menunggu')
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        <i class="fas fa-clock mr-1"></i> Menunggu
                                    </span>
                                @elseif($konseling->status == 'diproses')
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                        <i class="fas fa-spinner mr-1"></i> Diproses
                                    </span>
                                @else
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        <i class="fas fa-check-circle mr-1"></i> Selesai
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $konseling->created_at->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('admin.konseling.show', $konseling) }}" class="text-blue-600 hover:text-blue-900 mr-3">
                                    <i class="fas fa-eye mr-1"></i>Detail
                                </a>
                                <form action="{{ route('admin.konseling.destroy', $konseling) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus konseling ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">
                                        <i class="fas fa-trash mr-1"></i>Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                <i class="fas fa-inbox text-4xl mb-3"></i>
                                <p>Belum ada pengajuan konseling</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($konselings->hasPages())
            <div class="px-6 py-4 border-t">
                {{ $konselings->links() }}
            </div>
        @endif
    </div>
</div>
@endsection