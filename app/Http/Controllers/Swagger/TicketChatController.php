<?php

namespace App\Http\Controllers\Swagger;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TicketChatController extends Controller
{
    /**
     * @OA\Post(
     *     path="/tickets/{id}/send-message",
     *     operationId="sendTicketMessage",
     *     tags={"TicketChat"},
     *     summary="Send a message in a ticket chat",
     *     description="Sends a new message associated with a ticket by the authenticated user",
     *     @OA\RequestBody(
     *         required=true,
     *         description="Message data",
     *         @OA\JsonContent(
     *             required={"ticket_id", "text"},
     *             @OA\Property(property="ticket_id", type="integer", example=1, description="The ID of the ticket"),
     *             @OA\Property(property="text", type="string", example="Hello, I need more details on this issue.", description="The content of the message to be sent")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Message sent successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="Message Sent!")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Not found")
     *         )
     *     ),
     *     security={
     *         {"bearerAuth": {}}
     *     }
     * )
     */
    public function sendMessage(Request $request)
    {
        // Your existing method implementation
    }
}
