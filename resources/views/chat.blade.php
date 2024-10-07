@extends('layout.main')

@section('content')
<style>
    h1 {
        color: #0f0;
        font-weight: 600;
    }
    .container {
        padding-left: 30%;
        padding-right: 10%;
    }
    .chat-container {
        border: 1px solid #0f0;
        border-radius: 8px;
        padding: 15px;
        background-color: #f9f9f9;
        overflow-y: auto; /* Enable vertical scrolling */
    }
    .message-container {
        border: 1px solid #ccc; /* Add border style */
        border-radius: 8px;
        padding: 10px;
        margin-bottom: 10px;
        background-color: #fff; /* Set background color */
    }
    .profile-picture {
        margin-right: 10px;
    }
    .message-content {
        width: 90%; /* Adjust the width as needed */
    }
    .message-body {
        border-radius: 8px;
        word-wrap: break-word; /* Force text to wrap */
    }
</style>

<div class="container d-flex flex-column align-items-center mt-2 pt-2">
    <h1>Chat dengan {{ $user->name }}</h1>
    
    <!-- Daftar pesan -->
    <div id="chat-messages" class="chat-container w-100 mt-1" style="max-height: 60vh;">
        @foreach($messages as $message)
        <div class="message-container">
            <div class="message d-flex justify-content-start mb-3">
                @if($message->sender_id == auth()->id())
                <!-- Jika pengirim pesan adalah pengguna, tampilkan foto profil pengguna -->
                <div class="profile-picture mr-3">
                    <img src="{{ asset('uploads/profile_image/' . $message->sender->foto_profil) }}" alt="{{ $message->sender->name }}" class="rounded-circle" width="50" height="50">
                </div>
                @endif
                <div class="message-content">
                    <div class="message-body bg-light p-2 rounded">
                        <p class="mb-0">{{ $message->message }}</p> <!-- Add mb-0 class to remove bottom margin -->
                    </div>
                    <div class="message-meta">
                        <span class="message-sender font-weight-bold">{{ $message->sender->name }}</span>
                        <span class="message-time text-muted">{{ $message->created_at->format('H:i') }}</span>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Form untuk membalas pesan -->
    <form id="send-message-form" action="{{ route('sendMessageAdmin') }}" method="post" class="w-100 h-25 mt-4">
        @csrf
        <input type="hidden" name="receiver_id" value="{{ $user->id }}">
        <div class="form-group">
            <textarea name="message" id="message" rows="3" class="form-control" placeholder="Ketik pesan Anda di sini"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Kirim</button>
    </form>
</div>
@endsection
