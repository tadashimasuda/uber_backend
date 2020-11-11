<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Comment extends JsonResource
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
            "id" => $this->id,
            "comment" => $this->comment,
            'created_at' => $this->created_at->format('Y年m月d日'),
            'user' =>[
                'user_id'=>$this->user->id,
                'username'=>$this->user->name,
                'user_img_path'=>$this->user->img_path,
            ]
        ];
    }
}
