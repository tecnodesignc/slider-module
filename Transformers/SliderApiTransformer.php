<?php

namespace Modules\Slider\Transformers;

use Illuminate\Http\Resources\Json\Resource;
use Modules\User\Transformers\UserProfileTransformer;

class SliderApiTransformer extends Resource
{
  public function toArray($request)
  {
    return [
      'id' => $this->id,
      'title' => $this->title,
      'caption' => $this->caption,
      'customHtml' => $this->custom_html,
      'imageUrl' => $this->getImageUrl()
    ];
  }
}