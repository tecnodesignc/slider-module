<?php

namespace Modules\Slider\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Mockery\CountValidator\Exception;
use Modules\Slider\Entities\Slider;
use Modules\Slider\Http\Requests\CreateSliderRequest;
use Modules\Slider\Http\Requests\UpdateSliderRequest;
use Modules\Slider\Repositories\SliderRepository;
use Modules\Slider\Transformers\SliderTransformer;
use Modules\Core\Http\Controllers\Api\BaseApiController;
use Modules\Slider\Entities\Slider as SliderAlias;
use Modules\User\Contracts\Authentication;

class SliderApiController extends BaseApiController
{
    /**
     * @var SliderRepository
     */
    private SliderRepository $slider;

    public function __construct(SliderRepository $slider)
    {
        parent::__construct();

        $this->slider = $slider;
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

          $sliders = $this->slider->getItemsBy($params);

          $response = ["data" => SliderTransformer::collection($sliders)];

          $params->page ? $response["meta"] = ["page" => $this->pageTransformer($sliders)] : false;

        } catch (Exception $e) {

            \Log::Error($e);
            $status = $this->getStatusError($e->getCode());
            $response = ["error" => $e->getMessage()];

        }

        return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
    }
    /**
    * Show resource item.
    * @param Slider $slider
    * @return JsonResponse
    */
    public function show(Slider $slider): JsonResponse
    {
        try {

          $response = ["data" => new SliderTransformer($slider)];

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
    public function store(CreateSliderRequest $request): JsonResponse
    {
        \DB::beginTransaction();

        try {
            $data = $request->all();
            $slider = $this->slider->create($data);

            $response = ["data" => new SliderTransformer($slider)];

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
    * @param  Slider $slider
    * @param  UpdateSliderRequest $request
    * @return JsonResponse
    */
    public function update(Slider $slider, UpdateSliderRequest $request): JsonResponse
    {
        \DB::beginTransaction();

        try {

            $this->slider->update($slider, $request->all());

            $response = ["data" => trans('core::core.messages.resource updated', ['name' => trans('inventory::sliders.title.sliders')])];

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
    * @param SliderAlias $slider
    * @return JsonResponse
    */
    public function destroy(Slider $slider): JsonResponse
    {
        \DB::beginTransaction();

        try {

            $this->slider->destroy($slider);

            $response = ["data" => trans('core::core.messages.resource deleted', ['name' => trans('inventory::sliders.title.sliders')])];

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
