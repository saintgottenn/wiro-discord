<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BankLogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'seller_id' => $this->seller_id,
            'product_id' => $this->product->id,
            'amount' => $this->amount,
            'currency' => $this->currency,
            'balance' => $this->balance,
            'archive_link' => $this->archive_link,
            'image_link' => $this->image_link,
            'bank_link' => $this->bank_link,
            'is_sold' => $this->is_sold,
            'on_sale' => $this->on_sale,
            'created_at' => $this->created_at->format('Y.m.d'),
            'updated_at' => $this->updated_at->format('Y.m.d'),
        ];
    }
}
