<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\Controller;
use App\Models\Message;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;

class ChatAdminController extends controller
{
    public function checkNewMessages()
    {
        // Ambil pesan terbaru dari pelanggan yang belum dibaca
        $latestMessage = Message::where('receiver_type', 'App\\Models\\Admin')
            ->where('is_read', false)
            ->latest()
            ->first();

        if ($latestMessage) {
            return response()->json([
                'newMessage' => true,
                'message' => $latestMessage,
            ]);
        } else {
            return response()->json([
                'newMessage' => false,
            ]);
        }
    }

    public function showChat(Request $request, $userId)
{
    // Logika untuk mengambil detail pengguna dan pesan
    $user = User::find($userId);
    $messages = Message::where('receiver_id', $userId)->orWhere('sender_id', $userId)->get();

    return view('chat', compact('user', 'messages'));
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

        return redirect()->route('chat', ['userId' => $request->receiver_id]);
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
