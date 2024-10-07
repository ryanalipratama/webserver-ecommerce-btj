<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Messege;
use Illuminate\Support\Facades\Validator;

class GetUserController extends Controller
{
    public function getUser()
    {
        $getuser = User::get();

        return view('getuser', compact('getuser'));
    }

    public function checkNewMessages()
{
    $adminId = Auth::id();

    $latestMessage = Message::where('receiver_id', $adminId)
        ->where('sender_type', 'App\\Models\\User')
        ->latest()
        ->first();

    if ($latestMessage) {
        $messageData = [
            'newMessage' => true,
            'message' => [
                'id' => $latestMessage->id,
                'message' => $latestMessage->message,
                'sender' => [
                    'id' => $latestMessage->sender->id,
                    'name' => $latestMessage->sender->name,
                ],
                'created_at' => $latestMessage->created_at->format('Y-m-d H:i:s'),
            ],
        ];
    } else {
        $messageData = ['newMessage' => false];
    }

    return response()->json($messageData);
}
}
