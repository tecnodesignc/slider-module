<?php

namespace Modules\Slider\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class SlideTransformer extends JsonResource
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
            'slider_id' => $this->when($this->slider_id, $this->slider_id),
            'page_id' => $this->when($this->page_id, $this->page_id),
            'position' => $this->position,
            'target' => $this->when($this->target, $this->target),
            'title' => $this->when($this->title, $this->title),
            'caption' => $this->when($this->caption, $this->caption),
            'uri' => $this->when($this->uri, $this->uri),
            'url' => $this->when($this->url, $this->url),
            'active' => $this->when($this->active, $this->active),
            'external_image_url' => $this->when($this->external_image_url, $this->external_image_url),
            'custom_html' => $this->when($this->custom_html, $this->custom_html),
            'created_at' => $this->when($this->created_at, $this->created_at),
            'update_at' => $this->when($this->created_at, $this->created_at),
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
