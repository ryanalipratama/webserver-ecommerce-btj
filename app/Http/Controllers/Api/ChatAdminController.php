<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\Controller;
use App\Models\Message;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Contract\Database;

class ChatAdminController extends Controller
{
    public function showChat(Request $request, $userId)
    {
        $adminId = 1; // ID admin yang sudah ditentukan
        $user = User::find($userId);

        if (!$user) {
            return redirect()->back()->with('error', 'User not found');
        }

        $firebase = (new Factory)
            ->withServiceAccount(storage_path(env('FIREBASE_CREDENTIALS')))
            ->withDatabaseUri(env('FIREBASE_DATABASE_URL'));

        $database = $firebase->createDatabase();

        $messages = [];

        // Ambil pesan dari user ke admin
        $messagesRefUserToAdmin = $database->getReference('chats/' . $userId . '/' . $adminId)
    ->orderByChild('timestamp'); // Urutkan berdasarkan timestamp
$messagesFromUser = $messagesRefUserToAdmin->getValue();

        if ($messagesFromUser) {
            foreach ($messagesFromUser as $messageId => $message) {
                $messages[] = [
                    'message_id' => $messageId,
                    'sender_id' => (int)$message['sender_id'],
                    'sender_type' => $message['sender_type'],
                    'receiver_id' => (int)$message['receiver_id'],
                    'receiver_type' => $message['receiver_type'],
                    'message' => $message['message'],
                    'timestamp' => $message['timestamp'],
                ];
            }
        }

        // Urutkan pesan berdasarkan timestamp
        usort($messages, function ($a, $b) {
            return $a['timestamp'] <=> $b['timestamp'];
        });

        return view('chat', [
            'adminId' => (int)$adminId,
            'userId' => (int)$userId,
            'user' => $user,
            'messages' => $messages,
        ]);
    }

    public function sendMessageFromAdmin(Request $request)
{
    $adminId = 1; // ID admin yang sudah ditentukan

    $validatedData = $request->validate([
        'receiver_id' => 'required|exists:users,id',
        'message' => 'required_without:file|string', // Pesan wajib ada jika tidak ada file
        'file' => 'nullable|file|mimes:jpg,jpeg,png,pdf,docx,mp4|max:10240', // Validasi file
    ]);

    $receiverId = (int)$validatedData['receiver_id'];
    $user = User::find($receiverId);

    if (!$user) {
        return response()->json(['error' => 'User not found'], 404);
    }

    $messageData = [
        'sender_id' => (int)$adminId,
        'sender_type' => 'admin',
        'receiver_id' => (int)$receiverId,
        'receiver_type' => 'user',
        'message' => $validatedData['message'] ?? null,
        'timestamp' => now()->timestamp,
    ];

    // Jika ada file, upload ke Firebase Storage dan dapatkan URL
    if ($request->hasFile('file')) {
        $file = $request->file('file');
        $firebaseStorage = (new Factory)
            ->withServiceAccount(storage_path(env('FIREBASE_CREDENTIALS')))
            ->createStorage();

        $filePath = 'chats/' . $adminId . '/' . $receiverId . '/' . uniqid() . '.' . $file->getClientOriginalExtension();
        $firebaseStorage->getBucket()->upload(
            fopen($file->getPathname(), 'r'),
            ['name' => $filePath]
        );

        // Dapatkan URL file
        $fileUrl = 'https://firebasestorage.googleapis.com/v0/b/' . env('FIREBASE_STORAGE_BUCKET') . '/o/' . urlencode($filePath) . '?alt=media';

        // Tambahkan URL file ke dalam data pesan
        $messageData['file'] = $fileUrl;
    }

    $firebase = (new Factory)
        ->withServiceAccount(storage_path(env('FIREBASE_CREDENTIALS')))
        ->withDatabaseUri(env('FIREBASE_DATABASE_URL'));

    $database = $firebase->createDatabase();

    // Simpan pesan di Firebase (admin ke user)
    $database->getReference('chats/' . $adminId . '/' . $receiverId)->push($messageData);

    return redirect()->route('chat', ['userId' => $receiverId]);
}
}
