<?php

namespace Modules\Slider\Events;

use Illuminate\Database\Eloquent\Model;
use Modules\Media\Contracts\StoringMedia;

class SlideWasCreated implements StoringMedia
{

    /**
     * @var array
     */
    public array $data;

    /**
     * @var Model
     */
    public Model $slide;


    public function __construct($slide, array $data)
    {
        $this->data = $data;
        $this->slide = $slide;
    }


    /**
     * Return the entity
     * @return Model
     */
    public function getEntity(): Model
    {
        return $this->slide;
    }


    /**
     * Return the ALL data sent
     * @return array
     */
    public function getSubmissionData(): array
    {
        return $this->data;
    }
}
