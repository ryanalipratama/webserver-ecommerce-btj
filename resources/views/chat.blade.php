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
        overflow-y: auto;
        max-height: 400px;
    }
    .message-container {
        border: 1px solid #ccc;
        border-radius: 8px;
        padding: 10px;
        margin-bottom: 10px;
        background-color: #fff;
    }
    .file-upload-container {
        display: flex;
        align-items: center;
    }
    .file-upload-container button {
        margin-left: 10px;
    }
    .file-link {
        margin-top: 10px;  /* Menambahkan jarak di atas link */
        font-size: 14px;   /* Ukuran font lebih kecil */
        color: #007bff;    /* Warna biru untuk link */
    }
    .file-link a {
        text-decoration: none; 
        color: red;
    }
    .file-link a:hover {
        text-decoration: underline; /* Menambahkan garis bawah saat link di-hover */
    }
</style>

<div class="container">
    <h1>Chat with {{ $user->name }}</h1>
    
    <div id="chat-messages" class="chat-container">
        @foreach($messages as $message)
            <div class="message-container">
                <div class="message d-flex justify-content-start mb-3">
                    <div class="message-content">
                        <div class="message-body bg-light p-2 rounded">
                            @if(isset($message['file_url']))
                                <div class="file-link">
                                    <a href="{{ $message['file_url'] }}" target="_blank">Lihat File</a>
                                </div>
                            @endif
                            @if(isset($message['message']) && $message['message'])
                                <p>{{ $message['message'] }}</p>
                            @endif
                        </div>
                        <div class="message-meta">
                            <span class="message-sender font-weight-bold">
                                {{ $message['sender_type'] == 'admin' ? 'Admin' : $user->name }}
                            </span>
                            <span class="message-time text-muted">
                                {{ \Carbon\Carbon::createFromTimestamp($message['timestamp'])->format('H:i') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <form id="send-form" method="POST" action="{{ route('sendMessageFromAdmin') }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="receiver_id" value="{{ $userId }}">

        <div class="file-upload-container">
            <!-- Teks Pesan -->
            <textarea name="message" id="message" class="form-control mt-2" placeholder="Tulis pesan..."></textarea>

            <!-- File -->
            <input type="file" id="file" name="file" class="form-control mt-2">

            <button type="submit" class="btn btn-primary mt-2">Kirim</button>
        </div>
    </form>
</div>

<script type="module">
    import { initializeApp } from "https://www.gstatic.com/firebasejs/9.0.0/firebase-app.js";
    import { getDatabase, ref, query, push, onChildAdded } from "https://www.gstatic.com/firebasejs/9.0.0/firebase-database.js";
    import { getStorage, ref as storageRef, uploadBytes, getDownloadURL } from "https://www.gstatic.com/firebasejs/9.0.0/firebase-storage.js";

    // Firebase configuration
    const firebaseConfig = {
        apiKey: "AIzaSyA3Ggw9myqPfvF332L-tDheU6nI2cDX0is",
        authDomain: "authen-login-register.firebaseapp.com",
        databaseURL: "https://authen-login-register-default-rtdb.asia-southeast1.firebasedatabase.app",
        projectId: "authen-login-register",
        storageBucket: "authen-login-register.appspot.com",
        messagingSenderId: "548283472223",
        appId: "1:548283472223:web:5f87cf5793b7a2331a3eea"
    };

    // Initialize Firebase
    const app = initializeApp(firebaseConfig);
    const db = getDatabase(app);
    const storage = getStorage(app);

    const userId = parseInt('{{ $userId }}');
    const adminId = 1;  // Admin ID
    const messagesRef = ref(db, `chats/${adminId}/${userId}`);

    // Mengambil pesan yang sudah ada
    onChildAdded(messagesRef, (snapshot) => {
        const message = snapshot.val();
        console.log('New message received:', message); 
        displayMessage(message);
    });

    const userMessagesRef = ref(db, `chats/${userId}/${adminId}`);

    // Mendengarkan pesan yang dikirim oleh user
    onChildAdded(userMessagesRef, (snapshot) => {
        const message = snapshot.val();
        console.log('New message from user:', message); 
        displayMessage(message);
    });

    // Submit pesan dan file
    document.getElementById('send-form').addEventListener('submit', async function(event) {
        event.preventDefault();

        const messageInput = document.getElementById('message');
        const fileInput = document.getElementById('file');
        const timestamp = Math.floor(Date.now() / 1000);

        let message = messageInput.value || '';
        let fileUrl = null;

        // Cek jika ada file yang diupload
        if (fileInput.files.length > 0) {
            const file = fileInput.files[0];
            const fileRef = storageRef(storage, 'chat_files/' + file.name);
            await uploadBytes(fileRef, file);
            fileUrl = await getDownloadURL(fileRef);
        }

        // Push ke Firebase
        await push(messagesRef, {
            sender_id: adminId,
            sender_type: 'admin',
            receiver_id: userId,
            receiver_type: 'user',
            message: message, // Pesan teks atau kosong
            timestamp: timestamp,
            file_url: fileUrl // URL file jika ada
        });

        // Kirim ke Laravel
        fetch('{{ route("sendMessageFromAdmin") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                sender_id: adminId,
                receiver_id: userId,
                message: message,
                file_url: fileUrl
            })
        });

        // Kosongkan input
        messageInput.value = '';
        fileInput.value = '';
    });

    function displayMessage(message) {
        const chatMessages = document.getElementById('chat-messages');
        const messageContainer = document.createElement('div');
        messageContainer.classList.add('message-container');

        const messageContent = `
            <div class="message d-flex justify-content-start mb-3">
                <div class="message-content">
                    <div class="message-body bg-light p-2 rounded">
                        ${message.file_url ? `<a href="${message.file_url}" target="_blank">Lihat File</a>` : ''}
                        ${message.message ? `<p>${message.message}</p>` : ''}
                    </div>
                    <div class="message-meta">
                        <span class="message-sender font-weight-bold">
                            ${message.sender_type === 'admin' ? 'Admin' : '{{ $user->name }}'}
                        </span>
                        <span class="message-time text-muted">
                            ${new Date(message.timestamp * 1000).toLocaleTimeString([], {hour: '2-digit', minute: '2-digit'})}
                        </span>
                    </div>
                </div>
            </div>
        `;
        
        messageContainer.innerHTML = messageContent;
        chatMessages.appendChild(messageContainer);
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }
</script>
@endsection
