<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\TicketMessage;
use App\Events\TicketMessageSent;


class TicketChatController extends Controller
{
    public function sendMessage(Request $request)
    {
        $user = User::find(auth()->id()); 

        if (null === $user) {
            return response()->json(['message' => 'Not found'], 404);
        }
        
        $message = TicketMessage::create([
            'user_id' => $user->id,
            'ticket_id' => $request->ticket_id,
            'text' => $request->text,
        ]);
            
        broadcast(new TicketMessageSent($message))->toOthers();

        return ['status' => 'Message Sent!'];
    }
}
