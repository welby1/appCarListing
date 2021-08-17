<?php

namespace App\Http\Controllers\Api\Chat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Events\NewChatMessage;

class MessageController extends Controller
{
    public function broadcast(Request $request){
        
        if (! $request->filled('text')) {
            return response()->json([
                'message' => 'No message to send'
            ], 422);
        }

        event(new NewChatMessage($request->text, $request->userId, $request->userName));

        return response()->json([], 200);
    }
}
