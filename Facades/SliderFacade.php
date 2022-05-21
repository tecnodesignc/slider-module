<?php

namespace Modules\Slider\Facades;

use Illuminate\Support\Facades\Facade;
use Modules\Slider\Presenters\SliderPresenter;


class SliderFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return SliderPresenter::class;
    }

}
