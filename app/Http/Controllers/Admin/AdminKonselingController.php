<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Konseling;
use Illuminate\Http\Request;

class AdminKonselingController extends Controller
{
    public function index(Request $request)
    {
        $query = Konseling::with('user');

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $konselings = $query->latest()->paginate(15);

        return view('admin.konseling.index', compact('konselings'));
    }

    public function show(Konseling $konseling)
    {
        $konseling->load('user');
        return view('admin.konseling.show', compact('konseling'));
    }

    public function update(Request $request, Konseling $konseling)
    {
        $validated = $request->validate([
            'status' => 'required|in:menunggu,diproses,selesai',
            'catatan_guru' => 'nullable|string',
        ]);

        $konseling->update($validated);

        return redirect()->back()->with('success', 'Status konseling berhasil diperbarui');
    }

    public function destroy(Konseling $konseling)
    {
        $konseling->delete();

        return redirect()->route('admin.konseling.index')->with('success', 'Pengajuan konseling berhasil dihapus');
    }
}