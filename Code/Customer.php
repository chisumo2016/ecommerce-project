<?php


use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class Customer extends JsonResource
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
            'id'          =>  $this->id,
            'email'       =>  $this->email,
            'first_name'  =>  $this->first_name,
            'last_name'   =>  $this->last_name,
            'phone'       =>  $this->phone,
            'user' => new User($this->whenLoaded('user')),
        ];
    }
}
