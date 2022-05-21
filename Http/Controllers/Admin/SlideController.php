<?php

namespace Modules\Slider\Http\Controllers\Admin;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Laracasts\Flash\Flash;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Slider\Entities\Slider;
use Modules\Slider\Entities\Slide;
use Modules\Slider\Http\Requests\CreateSlideRequest;
use Modules\Slider\Http\Requests\UpdateSlideRequest;
use Modules\Slider\Repositories\SlideRepository;
use Modules\Page\Repositories\PageRepository;
use Modules\Media\Repositories\FileRepository;

class SlideController extends AdminBaseController
{
    /**
     * @var SlideRepository
     */
    private SlideRepository $slide;

    /**
     * @var PageRepository
     */
    private PageRepository $page;

    /**
     * @var FileRepository
     */
    private FileRepository $file;

    public function __construct(SlideRepository $slide, PageRepository $page, FileRepository $file)
    {
        parent::__construct();
        $this->slide = $slide;
        $this->page = $page;
        $this->file = $file;
    }

    public function create(Slider $slider): Factory|View|Application
    {
        $pages = $this->page->all();

        return view('slider::admin.slides.create')
            ->with([
                'slider' => $slider,
                'pages' => $pages
            ]);
    }

    public function store(Slider $slider, CreateSlideRequest $request): Redirector|RedirectResponse
    {
        $this->slide->create($this->addSliderId($slider, $request));

        return redirect()
            ->route('admin.slider.slider.edit', [$slider->id])
            ->withSuccess(trans('slider::messages.slide created'));
    }

    public function edit(Slider $slider, Slide $slide): Factory|View|Application
    {
        $pages = $this->page->all();

        return view('slider::admin.slides.edit')
            ->with([
                'slider' => $slider,
                'slide' => $slide,
                'pages' => $pages,
                'slideImage' => $this->file->findFileByZoneForEntity('slideImage', $slide)
            ]);
    }

    public function update(Slider $slider, Slide $slide, UpdateSlideRequest $request): Redirector|RedirectResponse
    {
        $this->slide->update($slide, $this->addSliderId($slider, $request));

        return redirect()
            ->route('admin.slider.slider.edit', [$slider->id])
            ->withSuccess(trans('slider::messages.slide updated'));
    }

    /**
     * @param Slider $slider
     * @param FormRequest $request
     * @return array
     */
    private function addSliderId(Slider $slider, FormRequest $request): array
    {
        return array_merge($request->all(), ['slider_id' => $slider->id]);
    }
}
