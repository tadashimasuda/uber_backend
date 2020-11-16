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
            'user' => [
                'id' =>$this->id,
                'name' => $this->name,
                'profile' => $this->profile,
                'twitter_id' => $this->twitter_id,
                'img_path' => $this->img_path,
                'transport' => $this->transport,
            ],
            'posts' => $this->post()->LatestFirst()->get(),
            'chartData' =>[
                'total_fee' =>$this->post()->sum("fee"),
                'fee'=>$this->post()->LatestFirst()->limit(5)->pluck('fee')->toArray(),
                'created_at'=>$this->post()->LatestFirst()->limit(5)->pluck('created_at')->toArray(),
            ]
        ];
    }
}
