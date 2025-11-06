<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\User;
use App\Events\MessageSent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminMessageController extends Controller
{
    public function index()
    {
        // Get list of siswa who have chatted with admin
        $siswaList = User::where('role', 'siswa')
            ->whereHas('sentMessages', function ($query) {
                $query->where('receiver_id', auth()->id());
            })
            ->orWhereHas('receivedMessages', function ($query) {
                $query->where('sender_id', auth()->id());
            })
            ->withCount([
                'receivedMessages as unread_count' => function ($query) {
                    $query->where('sender_id', auth()->id())
                        ->where('is_read', false);
                }
            ])
            ->get();

        return view('admin.messages.index', compact('siswaList'));
    }

    public function show(User $siswa)
    {
        // Get conversation between admin and siswa
        $messages = Message::between(auth()->id(), $siswa->id)
            ->with(['sender', 'receiver'])
            ->orderBy('created_at', 'asc')
            ->get();

        // Mark messages as read
        Message::where('sender_id', $siswa->id)
            ->where('receiver_id', auth()->id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return view('admin.messages.show', compact('siswa', 'messages'));
    }

    public function store(Request $request, User $siswa)
    {
        $validated = $request->validate([
            'message' => 'required|string',
        ]);

        $message = Message::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $siswa->id,
            'message' => $validated['message'],
        ]);

        // Broadcast event for real-time chat
        broadcast(new MessageSent($message))->toOthers();

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message->load(['sender', 'receiver']),
            ]);
        }

        return redirect()->back()->with('success', 'Pesan berhasil dikirim');
    }

    public function getMessages(User $siswa)
    {
        $messages = Message::between(auth()->id(), $siswa->id)
            ->with(['sender', 'receiver'])
            ->orderBy('created_at', 'asc')
            ->get();

        // Mark as read
        Message::where('sender_id', $siswa->id)
            ->where('receiver_id', auth()->id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json($messages);
    }
}