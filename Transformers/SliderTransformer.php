<?php

namespace Modules\Slider\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;

class SliderTransformer extends JsonResource
{

    /**
    * Transform the resource into an array.
    *
    * @param Request  $request
    * @return array
    */

    public function toArray($request): array
    {

        $data = [
            'id' => $this->when($this->id, $this->id),
            'name' => $this->when($this->name, $this->name),
            'system_name' => $this->when($this->system_name, $this->system_name),
            'active' => $this->when($this->active, $this->active),
            'slides'=> SlideSmallTransformer::collection($this->whenLoaded('slides')),
            'created_at' => $this->when($this->created_at, $this->created_at),
            'updated_at' => $this->when($this->updated_at, $this->updated_at),
        ];

        return $data;

    }
}
