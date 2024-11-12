<?php

namespace App\Domain\Api\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'code' => $this->code,
            'product_name' => $this->product_name,
            'status' => $this->status,
            'quantity' => $this->quantity,
            'brands' => $this->brands,
            'categories' => $this->categories,
        ];
    }
}
