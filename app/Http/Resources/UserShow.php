<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
// use App\Http\Resources\Posts as PostsResorse;

class UserShow extends JsonResource
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
            'id' =>$this->id,
            'name' => $this->name,
            'profile' => $this->profile,
            'twitter_id' => $this->twitter_id,
            'img_path' => $this->img_path,
            'transport' => $this->transport,
            'created_at' => $this->created_at->format('Y年m月d日'),
            'posts' => $this->post,
            // 'posts' =>[
            //     'id'=>$this->post->id,
            //     'img_path'=>$this->post->img_path,
            //     'created_at'=>$this->post->created_at->format('Y年m月d日'),
            // ],
            'chartData' =>[
                'fee'=>$this->post()->LatestFirst()->limit(5)->pluck('fee')->toArray(),
                'created_at'=>$this->post()->LatestFirst()->limit(5)->pluck('created_at')->toArray(),
            ]
        ];
    }
}
