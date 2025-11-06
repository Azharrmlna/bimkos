<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Konseling;
use Illuminate\Http\Request;

class SiswaKonselingController extends Controller
{
    public function index()
    {
        $konselings = auth()->user()->konselings()
            ->latest()
            ->paginate(10);

        return view('siswa.konseling.index', compact('konselings'));
    }

    public function create()
    {
        return view('siswa.konseling.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'jenis_masalah' => 'required|string|max:255',
            'deskripsi' => 'required|string',
        ]);

        $validated['user_id'] = auth()->id();

        Konseling::create($validated);

        return redirect()->route('siswa.konseling.index')->with('success', 'Pengajuan konseling berhasil dikirim');
    }

    public function show(Konseling $konseling)
    {
        // Ensure siswa can only view their own konseling
        if ($konseling->user_id !== auth()->id()) {
            abort(403, 'Akses ditolak');
        }

        return view('siswa.konseling.show', compact('konseling'));
    }

    public function edit(Konseling $konseling)
    {
        // Ensure siswa can only edit their own konseling
        if ($konseling->user_id !== auth()->id()) {
            abort(403, 'Akses ditolak');
        }

        // Only allow edit if status is 'menunggu'
        if ($konseling->status !== 'menunggu') {
            return redirect()->back()->with('error', 'Pengajuan yang sudah diproses tidak dapat diubah');
        }

        return view('siswa.konseling.edit', compact('konseling'));
    }

    public function update(Request $request, Konseling $konseling)
    {
        // Ensure siswa can only update their own konseling
        if ($konseling->user_id !== auth()->id()) {
            abort(403, 'Akses ditolak');
        }

        // Only allow update if status is 'menunggu'
        if ($konseling->status !== 'menunggu') {
            return redirect()->back()->with('error', 'Pengajuan yang sudah diproses tidak dapat diubah');
        }

        $validated = $request->validate([
            'jenis_masalah' => 'required|string|max:255',
            'deskripsi' => 'required|string',
        ]);

        $konseling->update($validated);

        return redirect()->route('siswa.konseling.index')->with('success', 'Pengajuan konseling berhasil diperbarui');
    }

    public function destroy(Konseling $konseling)
    {
        // Ensure siswa can only delete their own konseling
        if ($konseling->user_id !== auth()->id()) {
            abort(403, 'Akses ditolak');
        }

        // Only allow delete if status is 'menunggu'
        if ($konseling->status !== 'menunggu') {
            return redirect()->back()->with('error', 'Pengajuan yang sudah diproses tidak dapat dihapus');
        }

        $konseling->delete();

        return redirect()->route('siswa.konseling.index')->with('success', 'Pengajuan konseling berhasil dihapus');
    }
}