<?php namespace Modules\Slider\Services;

use Illuminate\Support\Facades\URL;
use Modules\Slider\Entities\Slider;

class SliderRenderer
{
    /**
     * @var int Id of the slider to render
     */
    protected int $sliderId;
    /**
     * @var string
     */
    private string $startTag = '<div class="dd">';
    /**
     * @var string
     */
    private string $endTag = '</div>';
    /**
     * @var string
     */
    private string $slides = '';

    /**
     * @param Slider $slider
     * @param $slides
     * @return string
     */
    public function renderForSlider(Slider $slider, $slides): string
    {
        $this->sliderId = $slider->id;

        $this->slides .= $this->startTag;
        $this->generateHtmlFor($slides);
        $this->slides .= $this->endTag;

        return $this->slides;
    }

    /**
     * Generate the html for the given items
     * @param $slides
     */
    private function generateHtmlFor($slides): void
    {
        $this->slides .= '<ol class="dd-list">';
        foreach ($slides as $slide) {
            $this->slides .= "<li class='dd-item' data-id='{$slide->id}'>";
            $editLink = URL::route('dashboard.slide.edit', [$this->sliderId, $slide->id]);
            $this->slides .= <<<HTML
<div class="btn-group" role="group" aria-label="Action buttons" style="display: inline">
    <a class="btn btn-sm btn-info" style="float:left;" href="{$editLink}">
        <i class="fa fa-pencil"></i>
    </a>
    <a class="btn btn-sm btn-danger jsDeleteSlide" style="float:left; margin-right: 15px;" data-item-id="{$slide->id}">
       <i class="fa fa-times"></i>
    </a>
</div>
HTML;
            $this->slides .= "<div class='dd-handle'>{$slide->title}</div>";
            $this->slides .= "<div><img class='img-responsive' src='".$slide->getImageUrl()."' /></div>";
            $this->slides .= '</li>';
        }
        $this->slides .= '</ol>';
    }

}
