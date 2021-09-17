<?php

namespace App\Http\Controllers\Api\PrivateMessage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use DB;
use App\Models\Message;
use App\Models\User;
use App\Models\Notification;
use App\Events\NewPrivateMessage;
use App\Notifications\NewPrivateMessage as NewPrivateMessageNotification;

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

        // broadcast new message
        broadcast(new NewPrivateMessage($message))->toOthers();

        // send notification to recipient
        $userToNotify = User::find($request->recipient_id);
        $sender = User::find($request->sender_id);
        $userToNotify->notify(new NewPrivateMessageNotification($userToNotify, $sender, $request->conversation_id, $message->id));

        // mark unread messages as read for user that sends new message
        $unseenMessages = auth()->user()->unreadNotifications()->where('data->conversation_id', '=', $request->conversation_id)->get();
        if($unseenMessages){
            foreach ( $unseenMessages as $notification) {
                $notification->markAsRead();
            }
        }
        
        return response()->json($message, 200);
    }

    public function getMessages(Request $request){
        $messages = Message::where('conversation_id', 'like', $request->conversation_id)
            ->orderBy('created_at', 'ASC')
            ->get();

        // getting user's unseen message for scrolling to it
        $message = Notification::select('data->message_id as message_id')
            ->where('notifiable_id', '=', Auth::id())
            ->where('data->conversation_id', '=', $request->conversation_id)
            ->whereNull('read_at')
            ->orderBy('created_at', 'asc')
            ->first();

        if(!$message){
            return response()->json([
                'messages' => $messages
            ], 200); 
        }

        return response()->json([
            'messages' => $messages, 
            'messageToScroll' => $message->message_id
        ], 200);
    }

    public function getConversations(){
        // get user's conversations
        $conversations = Message::select('conversation_id', 'sender_id', 'subject_id', 'recipient_id')
            ->where('recipient_id', Auth::id())
            ->groupBy('conversation_id','sender_id', 'subject_id', 'recipient_id')
            ->get();
        
        $unreadMessages = Notification::select('data->conversation_id as conversation_id', DB::raw('count(*) as unreadMessages'))
            ->where('notifiable_id', '=', Auth::id())
            ->whereNull('read_at')
            ->groupBy('data->conversation_id')
            ->get();

        $response = $conversations->each(function($conversation) use($unreadMessages){
            $unreadMessages->map(function($unreadMessage) use($conversation){
                if($conversation['conversation_id'] == $unreadMessage['conversation_id']){
                    return $conversation['unread'] = $unreadMessage['unreadMessages'];
                }
            });
        })->sortByDesc([['unread', 'desc']]);
        

        // $conversations = Message::selectRaw('conversation_id, sender_id, max(created_at) as created_at')
        // ->where('recipient_id', Auth::id())
        // ->groupBy('conversation_id','sender_id')
        // ->get();
        
        return response()->json($response, 200);
    }

}