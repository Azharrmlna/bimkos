<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\User;
use App\Events\MessageSent;
use Illuminate\Http\Request;

class SiswaMessageController extends Controller
{
    public function index()
    {
        // Get all guru BK
        $guruBK = User::where('role', 'guru_bk')->get();

        return view('siswa.messages.index', compact('guruBK'));
    }

    public function show(User $guruBk)
    {
        // Ensure the user is a guru BK
        if (!$guruBk->isGuruBK()) {
            abort(404);
        }

        // Get conversation between siswa and guru BK
        $messages = Message::between(auth()->id(), $guruBk->id)
            ->with(['sender', 'receiver'])
            ->orderBy('created_at', 'asc')
            ->get();

        // Mark messages as read
        Message::where('sender_id', $guruBk->id)
            ->where('receiver_id', auth()->id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return view('siswa.messages.show', compact('guruBk', 'messages'));
    }

    public function store(Request $request, User $guruBk)
    {
        // Ensure the user is a guru BK
        if (!$guruBk->isGuruBK()) {
            abort(404);
        }

        $validated = $request->validate([
            'message' => 'required|string',
        ]);

        $message = Message::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $guruBk->id,
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

    public function getMessages(User $guruBk)
    {
        // Ensure the user is a guru BK
        if (!$guruBk->isGuruBK()) {
            abort(404);
        }

        $messages = Message::between(auth()->id(), $guruBk->id)
            ->with(['sender', 'receiver'])
            ->orderBy('created_at', 'asc')
            ->get();

        // Mark as read
        Message::where('sender_id', $guruBk->id)
            ->where('receiver_id', auth()->id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json($messages);
    }
}