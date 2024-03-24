<?php

namespace App\Http\Controllers\Swagger;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    /**
     * @OA\Get(
     *     path="/tickets",
     *     operationId="getTickets",
     *     tags={"Tickets"},
     *     summary="Get list of tickets",
     *     description="Returns list of tickets with pagination",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Ticket")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     */
    public function index() {
        // Your existing code
    }

    /**
     * @OA\Get(
     *     path="/tickets/hot",
     *     operationId="getHotTickets",
     *     tags={"Tickets"},
     *     summary="Get list of hot tickets",
     *     description="Returns list of last 20 tickets",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Ticket")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     */
    public function hot() {
        // Your existing code
    }

    /**
     * @OA\Post(
     *     path="/tickets",
     *     operationId="storeTicket",
     *     tags={"Tickets"},
     *     summary="Create a new ticket",
     *     description="Create a new ticket with given input",
     *     @OA\RequestBody(
     *         required=true,
     *         description="Ticket data",
     *         @OA\JsonContent(
     *             required={"product_id","subject","amount","comment"},
     *             @OA\Property(property="product_id", type="integer", example=1),
     *             @OA\Property(property="subject", type="string", example="Need assistance"),
     *             @OA\Property(property="amount", type="number", format="float", example=100.50),
     *             @OA\Property(property="comment", type="string", example="Please assist with my issue")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Ticket created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Ticket created successfully"),
     *             @OA\Property(property="id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Product not found"
     *     )
     * )
     */
    public function store(Request $request) {
        // Your existing code
    }

    /**
     * @OA\Get(
     *     path="/tickets/{id}",
     *     operationId="showTicket",
     *     tags={"Tickets"},
     *     summary="Get ticket by ID",
     *     description="Returns a single ticket",
     *     @OA\Parameter(
     *         name="id",
     *         description="Ticket id",
     *         required=true,
     *         in="path",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Ticket")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not found"
     *     )
     * )
     */
    public function show(Request $request, $id) {
        // Your existing code
    }

    /**
     * @OA\Patch(
     *     path="/tickets/{id}/close",
     *     operationId="closeTicket",
     *     tags={"Tickets"},
     *     summary="Close a ticket",
     *     description="Marks a ticket as closed",
     *     @OA\Parameter(
     *         name="id",
     *         description="Ticket id",
     *         required=true,
     *         in="path",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Ticket has been successfully closed")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not found"
     *     )
     * )
     */
    public function close(Request $request, $id) {
        // Your existing code
    }

    
}
