<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Events\MessageSent;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function sendMessage(Request $request)
    {   
        try {
            $user = auth()->user();

        // Create the chat message
        $chat = Chat::create([
            'sender_id' => $user->user_id,
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
        ]);

        // Load the sender and receiver details
        $chat->load('sender', 'receiver');
        

        // Broadcast the message to the receiver's channel
        broadcast(new MessageSent($chat->message, $chat->sender_id, $chat->receiver_id))->toOthers();

        return response()->json($chat, status: 201);
        } catch (\Exception $e) {
            \Log::error('Error sending message: ' . $e->getMessage());
    
            return response()->json(['error' => $e->getMessage()], 500);
        }
        

    }
 

public function listChatRooms()
    {
        try {
            $user = auth()->user();
            $userId = $user->user_id;
            // Fetch distinct chat rooms involving the authenticated user
            $chatRooms = Chat::where('sender_id', $userId)
                ->orWhere('receiver_id', $userId)
                ->selectRaw('
                    CASE
                        WHEN sender_id = ? THEN receiver_id
                        ELSE sender_id
                    END as user_id', [$userId])
                ->groupBy('user_id')
                ->with([
                    'sender:user_id,name', 
                    'receiver:user_id,name', 
                ]) // Load only 'id' and 'name' of sender and receiver
                ->get();
    
            return response()->json($chatRooms);
        }  catch (\Exception $e) {
            \Log::error(message: 'Error listing chat rooms: ' . $e->getMessage());
            
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


public function getMessages($userId)
    {

        try {
            $messages = Chat::where(function ($query) use ($userId) {
                $query->where('sender_id', auth()->user_id())
                    ->where('receiver_id', $userId);
            })
            ->orWhere(function ($query) use ($userId) {
                $query->where('sender_id', $userId)
                    ->where('receiver_id', auth()->user_id());
            })
            ->orderBy('created_at', 'asc')
            ->with(['sender:id,name', 'receiver:id,name']) // Load only 'id' and 'name' of sender and receiver
            ->get();

            return response()->json($messages);
        } catch (\Exception $e) {
            \Log::error('Error fetching messages: ' . $e->getMessage());
    
            return response()->json(['error' => $e->getMessage()], 500);
        }
       
    }
}
