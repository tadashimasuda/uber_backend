<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Comment as CommentResorse;
use App\Http\Resources\User as UserResorse;


class PostShow extends JsonResource
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
            'post' =>[
                'id' => $this->id,
                'img_path' => $this->img_path,
                'message' => $this->message,
                'created_at' => $this->created_at->format('Y年m月d日'),
                'like_count' => $this->likes->count(),
            ],
            'likes_user_id'=> $this->likes->pluck('user_id'),
            'user' =>[
                'user_id'=>$this->user->id,
                'username'=>$this->user->name,
                'user_img_path'=>$this->user->img_path,
            ],
            'comments' => CommentResorse::collection($this->comment),
        ];
    }
}
