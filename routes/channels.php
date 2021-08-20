<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('chat', function ($user) {
    return !is_null($user);
});

Broadcast::channel('message-{conversation_id}', function ($user, $conversation_id) {
    //return Thread::find(threadId)->participants->containts($user->id);
    return Message::where('conversation_id', 'like', $conversation_id)
    ->orWhere('sender_id','=', $user->id)
    ->orWhere('recipient_id','=', $user->id);
});

// todo.  1 write to 3 (3 get real time messages)
//        when 3 write to 1 (1 doesnt get real time messages from 3) (plus user 3 get his mesaages twice... todo use toOthers() )