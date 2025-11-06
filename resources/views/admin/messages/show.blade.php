@extends('layouts.admin')

@section('title', 'Chat dengan ' . $siswa->name)

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-6">
        <a href="{{ route('admin.messages.index') }}" class="text-blue-600 hover:text-blue-800 inline-flex items-center">
            <i class="fas fa-arrow-left mr-2"></i>Kembali ke Daftar Pesan
        </a>
    </div>

    <!-- Chat Container -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden" style="height: calc(100vh - 250px); min-height: 500px;">
        <div class="flex flex-col h-full">
            <!-- Chat Header -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4 flex items-center">
                <div class="flex-shrink-0 h-12 w-12 bg-white rounded-full flex items-center justify-center shadow-md">
                    <span class="text-blue-600 font-bold text-lg">
                        {{ strtoupper(substr($siswa->name, 0, 1)) }}
                    </span>
                </div>
                <div class="ml-4">
                    <h2 class="text-xl font-bold text-white">{{ $siswa->name }}</h2>
                    <p class="text-blue-100 text-sm">{{ $siswa->email }}</p>
                </div>
            </div>

            <!-- Messages Area -->
            <div id="messages-container" class="flex-1 overflow-y-auto p-6 bg-gray-50" style="max-height: calc(100% - 180px);">
                @forelse($messages as $message)
                    @if($message->sender_id == auth()->id())
                        <!-- Admin Message (Right) -->
                        <div class="flex justify-end mb-4">
                            <div class="max-w-xs lg:max-w-md">
                                <div class="bg-blue-600 text-white rounded-lg rounded-tr-none px-4 py-3 shadow">
                                    <p class="text-sm">{{ $message->message }}</p>
                                </div>
                                <p class="text-xs text-gray-500 mt-1 text-right">
                                    {{ $message->created_at->format('H:i') }}
                                </p>
                            </div>
                        </div>
                    @else
                        <!-- Siswa Message (Left) -->
                        <div class="flex justify-start mb-4">
                            <div class="max-w-xs lg:max-w-md">
                                <div class="bg-white text-gray-800 rounded-lg rounded-tl-none px-4 py-3 shadow">
                                    <p class="text-sm">{{ $message->message }}</p>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">
                                    {{ $message->created_at->format('H:i') }}
                                </p>
                            </div>
                        </div>
                    @endif
                @empty
                    <div class="text-center py-12">
                        <i class="fas fa-comments text-gray-300 text-6xl mb-4"></i>
                        <p class="text-gray-500">Belum ada pesan</p>
                        <p class="text-gray-400 text-sm mt-2">Mulai percakapan dengan mengirim pesan</p>
                    </div>
                @endforelse
            </div>

            <!-- Message Input -->
            <div class="border-t bg-white p-4">
                <form id="message-form" action="{{ route('admin.messages.store', $siswa) }}" method="POST" class="flex items-center gap-3">
                    @csrf
                    <textarea 
                        name="message" 
                        id="message-input"
                        rows="1"
                        class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none"
                        placeholder="Ketik pesan..."
                        required
                        style="min-height: 48px; max-height: 120px;"
                    ></textarea>
                    <button 
                        type="submit" 
                        class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition flex items-center justify-center"
                        style="height: 48px; min-width: 100px;"
                    >
                        <i class="fas fa-paper-plane mr-2"></i>
                        <span>Kirim</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Auto-resize textarea
    const textarea = document.getElementById('message-input');
    textarea.addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = Math.min(this.scrollHeight, 120) + 'px';
    });

    // Auto-scroll to bottom on load
    const messagesContainer = document.getElementById('messages-container');
    if (messagesContainer) {
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }

    // Handle form submission with AJAX
    const messageForm = document.getElementById('message-form');
    messageForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const messageText = textarea.value.trim();
        
        if (!messageText) return;

        try {
            const response = await fetch(this.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
                body: formData
            });

            if (response.ok) {
                const data = await response.json();
                
                // Add message to UI
                const messageHTML = `
                    <div class="flex justify-end mb-4">
                        <div class="max-w-xs lg:max-w-md">
                            <div class="bg-blue-600 text-white rounded-lg rounded-tr-none px-4 py-3 shadow">
                                <p class="text-sm">${messageText}</p>
                            </div>
                            <p class="text-xs text-gray-500 mt-1 text-right">
                                ${new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' })}
                            </p>
                        </div>
                    </div>
                `;
                
                messagesContainer.insertAdjacentHTML('beforeend', messageHTML);
                messagesContainer.scrollTop = messagesContainer.scrollHeight;
                
                // Clear form
                textarea.value = '';
                textarea.style.height = 'auto';
            }
        } catch (error) {
            console.error('Error sending message:', error);
            alert('Gagal mengirim pesan. Silakan coba lagi.');
        }
    });

    // Optional: Auto-refresh messages every 5 seconds
    setInterval(async function() {
        try {
            const response = await fetch('{{ route("admin.messages.getMessages", $siswa) }}', {
                headers: {
                    'Accept': 'application/json',
                }
            });
            
            if (response.ok) {
                const messages = await response.json();
                
                // Check if there are new messages
                const currentMessageCount = messagesContainer.querySelectorAll('.flex.justify-start, .flex.justify-end').length;
                
                if (messages.length > currentMessageCount) {
                    // Refresh the page to show new messages
                    location.reload();
                }
            }
        } catch (error) {
            console.error('Error fetching messages:', error);
        }
    }, 5000);

    // Handle Enter key to send message (Shift+Enter for new line)
    textarea.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            messageForm.dispatchEvent(new Event('submit'));
        }
    });
</script>
@endpush
@endsection
