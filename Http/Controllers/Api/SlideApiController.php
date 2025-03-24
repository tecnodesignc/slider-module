<?php

namespace Modules\Slider\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Mockery\CountValidator\Exception;
use Modules\Slider\Entities\Slide;
use Modules\Slider\Http\Requests\CreateSlideRequest;
use Modules\Slider\Http\Requests\UpdateSlideRequest;
use Modules\Slider\Repositories\SlideRepository;
use Modules\Slider\Transformers\SlideTransformer;
use Modules\Core\Http\Controllers\Api\BaseApiController;
use Modules\User\Contracts\Authentication;

class SlideApiController extends BaseApiController
{
    /**
     * @var SlideRepository
     */
    private SlideRepository $slide;

    public function __construct(SlideRepository $slide)
    {
        parent::__construct();

        $this->slide = $slide;
         $this->auth = app(Authentication::class);
    }

    /**
    * Get listing of the resource
    *
    * @return JsonResponse
    */
    public function index(Request $request): JsonResponse
    {
        try {

          $params = $this->getParamsRequest($request);

          $slides = $this->slide->getItemsBy($params);

          $response = ["data" => SlideTransformer::collection($slides)];

          $params->page ? $response["meta"] = ["page" => $this->pageTransformer($slides)] : false;

        } catch (Exception $e) {

            \Log::Error($e);
            $status = $this->getStatusError($e->getCode());
            $response = ["error" => $e->getMessage()];

        }

        return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
    }
    /**
    * Show resource item.
    * @param Slide $slide
    * @return JsonResponse
    */
    public function show(Slide $slide): JsonResponse
    {
        try {

          $response = ["data" => new SlideTransformer($slide)];

        } catch (Exception $e) {

            \Log::Error($e);
            $status = $this->getStatusError($e->getCode());
            $response = ["errors" => $e->getMessage()];

        }

        return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param Request $request
    * @return JsonResponse
    */
    public function store(CreateSlideRequest $request): JsonResponse
    {
        \DB::beginTransaction();

        try {
            $data = $request->all();
            $slide = $this->slide->create($data);

            $response = ["data" => new SlideTransformer($slide)];

            \DB::commit();

        } catch (Exception $e) {

            \Log::Error($e);
            \DB::rollback();
            $status = $this->getStatusError($e->getCode());
            $response = ["errors" => $e->getMessage()];

        }

        return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);

    }

    /**
    * Update the specified resource in storage..
    *
    * @param  Slide $slide
    * @param  UpdateSlideRequest $request
    * @return JsonResponse
    */
    public function update(Slide $slide, UpdateSlideRequest $request): JsonResponse
    {
        \DB::beginTransaction();

        try {

            $this->slide->update($slide, $request->all());

            $response = ["data" => trans('core::core.messages.resource updated', ['name' => trans('slider::slides.title.slides')])];

            \DB::commit();

        } catch (Exception $e) {

            \Log::Error($e);
            \DB::rollback();
            $status = $this->getStatusError($e->getCode());
            $response = ["errors" => $e->getMessage()];

        }

        return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);

    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  Slide $slide
    * @return JsonResponse
    */
    public function destroy(Slide $slide): JsonResponse
    {
        \DB::beginTransaction();

        try {
            $this->slide->destroy($slide);

            $response = ["data" => trans('core::core.messages.resource deleted', ['name' => trans('slider::slides.title.slides')])];

            \DB::commit();

        } catch (Exception $e) {

            \Log::Error($e);
            \DB::rollback();
            $status = $this->getStatusError($e->getCode());
            $response = ["errors" => $e->getMessage()];

        }

        return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);

    }
}
