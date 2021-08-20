<?php

namespace App\Http\Controllers\Api\PrivateMessage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\Message;
use App\Events\NewPrivateMessage;

class MessageController extends Controller
{
    public function sendMessage(Request $request){

        $request->validate([
            'message' => 'required',
            'sender_id' => ['required'],
            'recipient_id' => ['required'],
            'conversation_id' => ['required'],
            'subject_id' => ['required']
        ]);

        $message = Message::create([
            'body' => $request->message,
            'sender_id' => $request->sender_id,
            'recipient_id' => $request->recipient_id,
            'conversation_id' => $request->conversation_id,
            'subject_id' => $request->subject_id
        ]);

        broadcast(new NewPrivateMessage($message))->toOthers();

        return response()->json($message, 200);
    }

    public function getMessages(Request $request){
        return Message::where('conversation_id', 'like', $request->conversation_id)
            ->orderBy('created_at', 'ASC')
            ->get();

        // return response()->json([
        //     'message' => $massages,
        // ], 200);
    }

    public function getConversations(){
        // get user's conversations
        $conversations = Message::select('conversation_id', 'sender_id', 'subject_id', 'recipient_id')
            ->where('recipient_id', Auth::id())
            ->groupBy('conversation_id','sender_id', 'subject_id', 'recipient_id')
            ->get();

        // $conversations = Message::selectRaw('conversation_id, sender_id, max(created_at) as created_at')
        // ->where('recipient_id', Auth::id())
        // ->groupBy('conversation_id','sender_id')
        // ->get();
        
        return response()->json($conversations, 200);
    }

}