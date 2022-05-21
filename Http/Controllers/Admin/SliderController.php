<?php

namespace Modules\Slider\Http\Controllers\Admin;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Slider\Entities\Slider;
use Modules\Slider\Http\Requests\CreateSliderRequest;
use Modules\Slider\Http\Requests\UpdateSliderRequest;
use Modules\Slider\Repositories\SlideRepository;
use Modules\Slider\Repositories\SliderRepository;
use Modules\Slider\Services\SliderRenderer;

class SliderController extends AdminBaseController
{
    /**
     * @var SliderRepository
     */
    private SliderRepository $slider;

    /**
     * @var SlideRepository
     */
    private SlideRepository $slide;

    /**
     * @var SliderRenderer
     */
    private SliderRenderer $sliderRenderer;

    public function __construct(
        SliderRepository $slider,
        SlideRepository $slide,
        SliderRenderer $sliderRenderer
    )
    {
        parent::__construct();
        $this->slider = $slider;
        $this->slide = $slide;
        $this->sliderRenderer = $sliderRenderer;
    }

    public function index(): Factory|View|Application
    {
        $sliders = $this->slider->all();

        return view('slider::admin.sliders.index')
            ->with([
                'sliders' => $sliders
            ]);
    }

    public function create(): Factory|View|Application
    {
        return view('slider::admin.sliders.create');
    }

    public function store(CreateSliderRequest $request): Redirector|RedirectResponse
    {
        $this->slider->create($request->all());

        return redirect()->route('admin.slider.slider.index')->withSuccess(trans('slider::messages.slider created'));
    }

    public function edit(Slider $slider): Factory|View|Application
    {
        $slides = $slider->slides;
        $sliderStructure = $this->sliderRenderer->renderForSlider($slider, $slides);

        return view('slider::admin.sliders.edit')
            ->with([
                'slider' => $slider,
                'slides' => $sliderStructure
            ]);

    }

    public function update(Slider $slider, UpdateSliderRequest $request): Redirector|RedirectResponse
    {
        $this->slider->update($slider, $request->all());

        return redirect()->route('admin.slider.slider.index')->withSuccess(trans('slider::messages.slider updated'));
    }

    public function destroy(Slider $slider): Redirector|RedirectResponse
    {
        $this->slider->destroy($slider);

        return redirect()->route('admin.slider.slider.index')->withSuccess(trans('slider::messages.slider deleted'));
    }
}
