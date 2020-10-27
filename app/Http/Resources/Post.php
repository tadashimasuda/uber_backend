<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Post extends JsonResource
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
            'id' => $this->id,
            'img_path' => $this->img_path,
            'created_at' => $this->created_at->diffForHumans(),
            'user_id'=>$this->user->id,
            'username'=>$this->user->name,
            'user_img_path'=>$this->user->img_path,
        ];
    }
}
