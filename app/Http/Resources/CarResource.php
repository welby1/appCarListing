<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CarResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'make' => $this->make,
            'model' => $this->model,
            'year' => $this->year,
            'body_type' => $this->body_type,
            'fuel_type' => $this->fuel_type,
            'engine_displ' => $this->engine_displ,
            'transmission_type' => $this->transmission_type,
            'price' => $this->price,
            'description' => $this->description,
            'photos' => PhotoResource::collection($this->whenLoaded('photos')),
            'user' => (new UserResource($this->whenLoaded('user')))
        ];
    }
}
