<?php


use Illuminate\Http\Resources\Json\JsonResource;

class OrderItem extends JsonResource
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
            'unit_price' => $this->unit_price,
            'quantity' => $this->quantity,
            'product' => new Product($this->whenLoaded('product')),
        ];
    }
}
