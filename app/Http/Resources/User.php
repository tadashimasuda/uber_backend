<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'name' => $this->name,
            'email' => $this->email,
            'twitter_id' => $this->twitter_id,
            'img_path' => $this->img_path,
            'transport' => $this->transport,
            'created_at' => $this->created_at
        ];
    }
}
