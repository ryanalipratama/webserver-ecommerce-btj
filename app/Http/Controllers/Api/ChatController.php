<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\Controller;
use App\Models\Message;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Kreait\Firebase\Factory;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Kreait\Firebase\Storage as FirebaseStorage;
use Illuminate\Support\Str;

class ChatController extends Controller
{
    private $firebase;
    private $database;

    public function __construct()
    {
        $this->firebase = (new Factory)
            ->withServiceAccount(storage_path(env('FIREBASE_CREDENTIALS')))
            ->withDatabaseUri(env('FIREBASE_DATABASE_URL'));
        $this->database = $this->firebase->createDatabase();
    }

    public function uploadFileToFirebase(Request $request)
    {
        // Validasi file
        $validatedData = $request->validate([
            'file' => 'required|file|mimes:jpg,jpeg,png,pdf,docx|max:10240', // Batasi tipe dan ukuran file
        ]);

        // Ambil file yang diunggah
        $file = $request->file('file');

        // Tentukan path file untuk Firebase Storage
        $filePath = 'chat_files/' . Str::random(40) . '.' . $file->getClientOriginalExtension();

        // Upload file ke Firebase Storage
        $firebaseStorage = $this->firebase->createStorage();
        $storageReference = $firebaseStorage->getBucket()->upload(
            fopen($file->getPathname(), 'r'),
            [
                'name' => $filePath
            ]
        );

        // Ambil URL unduhan file yang berlaku selama 1 jam
        $fileUrl = $storageReference->signedUrl(new \DateTime('+1 hour'));

        return response()->json(['file_url' => $fileUrl], 200);
    }


    private function saveMessageToFirebase($chatPath, $messageData)
    {
        $chatRef = $this->database->getReference($chatPath);
        $chatRef->push($messageData);
    }

    private function getMessagesFromFirebase($chatPath)
    {
        $chatRef = $this->database->getReference($chatPath);
        // Mengambil data dan mengurutkan berdasarkan timestamp
        $messages = $chatRef->orderByChild('timestamp')->getValue();

        return $messages ?: [];
    }

    private function formatMessages(array $messages): array
{
    $formattedMessages = [];

    foreach ($messages as $messageId => $message) {
        $formattedMessages[] = [
            'message_id' => $messageId,
            'sender_id' => (int)($message['sender_id'] ?? 0), // Default 0 jika tidak ada
            'receiver_id' => (int)($message['receiver_id'] ?? 0), // Default 0 jika tidak ada
            'message' => $message['message'] ?? null, // Default null jika tidak ada
            'file_url' => $message['file_url'] ?? null, // Default null jika tidak ada
            'sender_type' => $message['sender_type'] ?? null, // Default null jika tidak ada
            'receiver_type' => $message['receiver_type'] ?? null, // Default null jika tidak ada
            'timestamp' => isset($message['timestamp']) 
                ? Carbon::createFromTimestamp($message['timestamp'])->toDateTimeString() 
                : null, // Default null jika tidak ada
        ];
    }

    return $formattedMessages;
}


    public function sendMessageFromUser(Request $request)
{
    $user = Auth::user();

    // Pastikan hanya user yang terautentikasi yang bisa mengirim pesan
    if (get_class($user) !== User::class) {
        return response()->json(['error' => 'Unauthorized'], 403);
    }

    // Validasi input
    $validatedData = $request->validate([
        'receiver_id' => 'required|exists:admins,id', // ID admin yang valid
        'message' => 'nullable|string', // Pesan teks
        'file' => 'nullable|file|mimes:jpg,jpeg,png,pdf,docx|max:10240', // Validasi file
    ]);

    $messageContent = $validatedData['message'] ?? null;

    $fileUrl = null;  // Inisialisasi variabel file_url

    // Jika ada file yang diunggah
    if ($request->hasFile('file')) {
        // Upload file ke Firebase Storage dan dapatkan URL-nya
        $fileUrl = json_decode($this->uploadFileToFirebase($request)->getContent())->file_url;

    }

    // Jika tidak ada pesan teks, gunakan file_url sebagai pesan
    $messageContent = $validatedData['message'] ?? $fileUrl;

    // Simpan pesan ke database
    $message = Message::create([
        'sender_id' => (int)$user->id,
        'sender_type' => User::class,
        'receiver_id' => (int)$validatedData['receiver_id'],
        'receiver_type' => Admin::class,
        'message' => $messageContent,
        'file_url' => $fileUrl,  // Menyimpan URL file jika ada
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    $this->saveMessageToFirebase(
        "chats/{$user->id}/{$validatedData['receiver_id']}",
        [
            'sender_id' => (int)$user->id,
            'sender_type' => 'user',
            'receiver_id' => (int)$validatedData['receiver_id'],
            'receiver_type' => 'admin',
            'message' => $messageContent,
            'file_url' => $fileUrl, // Menyertakan file_url dalam pesan di Firebase
            'timestamp' => now()->timestamp,
        ]
    );

    return response()->json($message, 201);
}


    public function sendMessageFromAdmin(Request $request)
    {
        $adminId = 1; // ID admin default

        $validatedData = $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'nullable|string', // Pesan teks
            'file' => 'nullable|file|mimes:jpg,jpeg,png,pdf,docx|max:10240', // File opsional
        ]);

        $fileUrl = null;
        if ($request->hasFile('file')) {
            // Upload file dan dapatkan URL-nya
            $fileUrl = json_decode($this->uploadFileToFirebase($request)->getContent())->file_url;
        }

        // Jika tidak ada pesan teks, gunakan file_url sebagai pesan
        $messageContent = $validatedData['message'] ?? $fileUrl;

        $message = Message::create([
            'sender_id' => (int)$adminId,
            'sender_type' => Admin::class,
            'receiver_id' => (int)$validatedData['receiver_id'],
            'receiver_type' => User::class,
            'message' => $messageContent, // Teks pesan atau file URL
            'file_url' => $fileUrl, // Menambahkan file_url
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Menyimpan pesan ke Firebase
        $this->saveMessageToFirebase(
            "chats/{$adminId}/{$validatedData['receiver_id']}",
            [
                'sender_id' => (int)$adminId,
                'sender_type' => 'admin',
                'receiver_id' => (int)$validatedData['receiver_id'],
                'receiver_type' => 'user',
                'message' => $messageContent,
                'file_url' => $fileUrl, // Menyertakan file_url dalam pesan di Firebase
                'timestamp' => now()->timestamp,
            ]
        );

        return response()->json($message, 201);
    }



    public function getUserMessages(Request $request)
    {
        $user = Auth::user();
        $userId = (int)$user->id;
        $adminId = 1; // ID admin default

        $messagesFromAdmin = $this->getMessagesFromFirebase("chats/{$adminId}/{$userId}");
        $messagesFromUser = $this->getMessagesFromFirebase("chats/{$userId}/{$adminId}");

        $chatMessages = array_merge(
            $this->formatMessages($messagesFromAdmin),
            $this->formatMessages($messagesFromUser)
        );

        // Urutkan berdasarkan timestamp
        usort($chatMessages, function ($a, $b) {
            return $a['timestamp'] <=> $b['timestamp'];
        });

        return response()->json([
            'userId' => (int)$userId,
            'adminId' => (int)$adminId,
            'messages' => $chatMessages,
        ]);
    }

    public function getAdminMessages(Request $request)
    {
        $adminId = 1; // ID admin default

        $messages = [];
        $allChats = $this->getMessagesFromFirebase('chats');

        foreach ($allChats as $userId => $userChats) {
            $messagesFromUser = $this->getMessagesFromFirebase("chats/{$userId}/{$adminId}");
            $messagesFromAdmin = $this->getMessagesFromFirebase("chats/{$adminId}/{$userId}");

            $messages = array_merge(
                $messages,
                $this->formatMessages($messagesFromUser),
                $this->formatMessages($messagesFromAdmin)
            );
        }

        // Urutkan berdasarkan timestamp
        usort($messages, function ($a, $b) {
            return $a['timestamp'] <=> $b['timestamp'];
        });

        return response()->json([
            'adminId' => (int)$adminId,
            'messages' => $messages,
        ]);
    }
}
