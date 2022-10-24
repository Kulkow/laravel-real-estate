<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TopicResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        $result = parent::toArray($request);
        if($this->resource->picture){
            $result['picture_view'] = [
                'src' => $this->resource->picture->link(),
                'alt' => $this->resource->picture->title(),
            ];
        }
        return $result;
    }
}
