<?php

namespace Modules\Slider\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class SlideSmallTransformer extends JsonResource
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
            'title' => $this->title,
            'caption' => $this->caption,
            'custom_html' => $this->custom_html,
            'image_url' => $this->getImageUrl(),
            'created_at' => $this->when($this->created_at, $this->created_at),
            'updated_at' => $this->when($this->updated_at, $this->updated_at),
        ];

        foreach (LaravelLocalization::getSupportedLocales() as $locale => $supportedLocale) {
            $data[$locale] = [];
            foreach ($this->translatedAttributes as $translatedAttribute) {
                $data[$locale][$translatedAttribute] = $this->translateOrNew($locale)->$translatedAttribute;
            }
        }
        return $data;

    }
}
