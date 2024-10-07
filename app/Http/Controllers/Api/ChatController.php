<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\Controller;
use App\Models\Message;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    // Metode untuk pengguna mengirim pesan ke admin
    public function sendMessageFromUser(Request $request)
    {
        $user = Auth::user();

        if (get_class($user) !== User::class) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validatedData = $request->validate([
            'receiver_id' => 'required|exists:admins,id',
            'message' => 'required|string',
        ]);

        $message = Message::create([
            'sender_id' => $user->id,
            'sender_type' => User::class,
            'receiver_id' => $validatedData['receiver_id'],
            'receiver_type' => Admin::class,
            'message' => $validatedData['message'],
        ]);

        return response()->json($message, 201);
    }

    // Metode untuk admin mengirim pesan ke pengguna
    public function sendMessageFromAdmin(Request $request)
    {
        // $admin = Auth::admin();

        // if (get_class($admin) !== Admin::class) {
        //     return response()->json(['error' => 'Unauthorized'], 403);
        // }
        $adminId = 1;

        $validatedData = $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string',
        ]);

        $message = Message::create([
            'sender_id' => $adminId,
            'sender_type' => Admin::class,
            'receiver_id' => $validatedData['receiver_id'],
            'receiver_type' => User::class,
            'message' => $validatedData['message'],
        ]);

        return response()->json($message, 201);
    }

    // Metode untuk user mendapatkan pesan mereka dengan admin
    public function getUserMessages()
    {
        // Dapatkan informasi pengguna yang sedang diautentikasi
        $user = Auth::user();
        
        // Pastikan pengguna yang diautentikasi adalah instance dari model User
        if (!($user instanceof User)) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        
        // Dapatkan ID pengguna dari informasi pengguna
        $userId = $user->id;

        \Log::info("Fetching messages for user with ID: $userId");

        // Asumsikan admin ID adalah 1
        $adminId = 1;

        // Ambil pesan antara pengguna dan admin dengan ID $userId
        $messages = Message::where(function ($query) use ($userId, $adminId) {
            $query->where('sender_id', $userId)
                ->where('sender_type', User::class)
                ->where('receiver_id', $adminId)
                ->where('receiver_type', Admin::class);
        })->orWhere(function ($query) use ($userId, $adminId) {
            $query->where('sender_id', $adminId)
                ->where('sender_type', Admin::class)
                ->where('receiver_id', $userId)
                ->where('receiver_type', User::class);
        })->orderBy('created_at', 'asc')->get();

        \Log::info('Messages found: ' . $messages->count());

        return response()->json($messages);
    }

    // Metode untuk admin mendapatkan semua pesan dengan user
    public function getAdminMessages()
    {
        // $admin = Auth::user();

        // if (get_class($admin) !== Admin::class) {
        //     return response()->json(['error' => 'Unauthorized'], 403);
        // }

        \Log::info("Fetching all messages for admin");

        $adminId = 1; // Menggunakan ID admin yang sedang login

        $messages = Message::where(function ($query) use ($adminId) {
            $query->where('sender_id', $adminId)
                ->where('sender_type', Admin::class);
        })->orWhere(function ($query) use ($adminId) {
            $query->where('receiver_id', $adminId)
                ->where('receiver_type', Admin::class);
        })->orderBy('created_at', 'asc')->get();

        \Log::info('Messages found: ' . $messages->count());

        return response()->json($messages);
    }
}
