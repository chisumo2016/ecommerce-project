<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserCustomerResource extends JsonResource
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
            'id'    => $this->id,
            'first_name'  => $this->customer->first_name,
            'last_name'   => $this->customer->last_name,
            'email'      => $this->email,
            'phone'      => $this->customer->phone, //Informationn on the list
            'shippingAddress'  => $this->customer->shippingAddress,
            'BillingAddress'  => $this->customer->billingAddress
        ];
    }
}
