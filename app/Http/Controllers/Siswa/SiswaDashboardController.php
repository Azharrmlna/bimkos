<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Konseling;
use App\Models\Article;
use App\Models\Message;
use Illuminate\Http\Request;

class SiswaDashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $stats = [
            'total_pengajuan' => $user->konselings()->count(),
            'pengajuan_menunggu' => $user->konselings()->menunggu()->count(),
            'pengajuan_diproses' => $user->konselings()->diproses()->count(),
            'pengajuan_selesai' => $user->konselings()->selesai()->count(),
            'unread_messages' => Message::where('receiver_id', $user->id)->unread()->count(),
        ];

        $recent_konselings = $user->konselings()
            ->latest()
            ->take(5)
            ->get();

        $recent_articles = Article::published()
            ->latest()
            ->take(3)
            ->get();

        return view('siswa.dashboard', compact('stats', 'recent_konselings', 'recent_articles'));
    }
}