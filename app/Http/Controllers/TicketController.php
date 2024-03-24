<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\BankLog;
use App\Models\Product;
use App\Models\ProductLog;
use Illuminate\Http\Request;
use App\Models\TicketMessage;
use Illuminate\Support\Facades\Validator;

class TicketController extends Controller
{
    public function index() {
        $tickets = Ticket::latest()->paginate(20);

        return response()->json($tickets);
    }

    public function hot()
    {
        $tickets = Ticket::latest()->limit(20)->get();

        return response()->json($tickets);
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|integer|exists:products,id',
            'subject' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'comment' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $product = Product::find($request->product_id);

        if(null === $product) {
            return response()->json(['message' => 'That Product Not found'], 404);
        }

        $productable = '';

        if($product->productable_type === ProductLog::class) {
            $productable = ProductLog::withoutGlobalScope('available')->find($product->productable_id);
        }

        if($product->productable_type === BankLog::class) {
            $productable = BankLog::withoutGlobalScope('available')->find($product->productable_id);
        } 

        $ticket = Ticket::create([
            'user_id' => $request->user()->id,
            'seller_id' => $productable->seller_id,
            'subject' => $request->subject,
            'amount' => $productable->amount,
        ]);

        $message = TicketMessage::create([
            'user_id' => $request->user()->id,
            'ticket_id' => $ticket->id,
            'text' => $request->comment,
        ]);

        return response()->json([   
            'message' => 'Ticket created successfully',
            'id' => $ticket->id,
        ]);
    }

    public function show(Request $request, $id)
    {
        $ticket = Ticket::find($id);

        if($ticket === null) {
            return response()->json(['message' => 'Not found'], 404);
        }

        $ticket->firstMessage = TicketMessage::where('ticket_id', $ticket->id)->first()->text;
        
        return response()->json($ticket);
    }

    public function close(Request $request, $id)
    {
        $ticket = Ticket::find($id);

        if(null === $ticket) {
            return response()->json(['message' => 'Not found'], 404);
        }

        $ticket->is_opened = false;
        $ticket->save();

        return response()->json(['message' => 'Ticket has been successfully closed']);
    }
}
