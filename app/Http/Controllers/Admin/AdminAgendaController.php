<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agenda;
use Illuminate\Http\Request;

class AdminAgendaController extends Controller
{
    public function index()
    {
        $agendas = Agenda::with('creator')->latest('tanggal')->paginate(15);
        return view('admin.agendas.index', compact('agendas'));
    }

    public function create()
    {
        return view('admin.agendas.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tanggal' => 'required|date',
            'lokasi' => 'required|string|max:255',
        ]);

        $validated['created_by'] = auth()->id();

        Agenda::create($validated);

        return redirect()->route('admin.agendas.index')->with('success', 'Agenda berhasil dibuat');
    }

    public function show(Agenda $agenda)
    {
        return view('admin.agendas.show', compact('agenda'));
    }

    public function edit(Agenda $agenda)
    {
        return view('admin.agendas.edit', compact('agenda'));
    }

    public function update(Request $request, Agenda $agenda)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tanggal' => 'required|date',
            'lokasi' => 'required|string|max:255',
        ]);

        $agenda->update($validated);

        return redirect()->route('admin.agendas.index')->with('success', 'Agenda berhasil diperbarui');
    }

    public function destroy(Agenda $agenda)
    {
        $agenda->delete();

        return redirect()->route('admin.agendas.index')->with('success', 'Agenda berhasil dihapus');
    }
}