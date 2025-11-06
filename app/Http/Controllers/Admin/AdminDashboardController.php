<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Konseling;
use App\Models\Message;
use App\Models\Article;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_siswa' => User::where('role', 'siswa')->count(),
            'total_pengajuan' => Konseling::count(),
            'pengajuan_menunggu' => Konseling::menunggu()->count(),
            'pengajuan_diproses' => Konseling::diproses()->count(),
            'pengajuan_selesai' => Konseling::selesai()->count(),
            'total_chat' => Message::count(),
            'total_artikel' => Article::count(),
            'chat_belum_dibaca' => Message::where('receiver_id', auth()->id())->unread()->count(),
        ];

        $recent_konselings = Konseling::with('user')
            ->latest()
            ->take(5)
            ->get();

        $siswa_aktif = User::where('role', 'siswa')
            ->withCount(['sentMessages', 'konselings'])
            ->orderBy('sent_messages_count', 'desc')
            ->take(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'recent_konselings', 'siswa_aktif'));
    }
}