<?php


use Illuminate\Http\Resources\Json\JsonResource;

class Order extends JsonResource
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
            'order_id'=> $this->id,
            'status' => $this->status,
            'total_price' => $this->total_price,
            'items' => new OrderItemCollection($this->whenLoaded('items')),
        ];
    }
}
