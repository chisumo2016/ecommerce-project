<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderListResource extends JsonResource
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
            'id'                => $this->id ,
            'status'            => $this->status ,
            'total_price'       => $this->total_price,
            'number_of_items'   => $this->items()->count(),
            'customer'          => new UserCustomerListResource( $this->user),
            'created_at'        => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at'        => $this->updated_at->format('Y-m-d H:i:s'),
            //'updated_at'    => (new \DateTime($this->updated_at))->format('Y-m-d H:i:s'),

        ];
    }
}
