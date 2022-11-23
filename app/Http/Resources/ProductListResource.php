<?php
declare(strict_types=1);

namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;


class ProductListResource extends JsonResource
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
            'id'            => $this->id ,
            'title'         => $this->title ,
            'image'         => $this->image ,
            'price'         => $this->price,
            'updated_at'    => $this->updated_at->format('Y-m-d H:i:s'),
            //'updated_at'    => (new \DateTime($this->updated_at))->format('Y-m-d H:i:s'),

        ];
    }
}