<?php

namespace Modules\Slider\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Slider\Repositories\SlideApiRepository;
use Modules\Slider\Transformers\SliderApiTransformer;
use Modules\Core\Http\Controllers\Api\BaseApiController;

class SlideApiController extends BaseApiController
{

  private SlideApiRepository $slideApi;

  public function __construct(SlideApiRepository $sliderApi)
  {
    $this->slideApi = $sliderApi;
  }

    /**
     * Get slide by parameters
     *
     * @param Request $request
     * @return JsonResponse
     */
  public function index(Request $request): JsonResponse
  {
    try {
      //Get Parameters from URL.
      $p = $this->parametersUrl(false, false, false, []);

      //Request to Repository
      $slides = $this->slideApi->index($p->page, $p->take, $p->filter, $p->include);

      //Response
      $response = ["data" => SliderApiTransformer::collection($slides)];

      //If request pagination add meta-page
      $p->page ? $response["meta"] = ["page" => $this->pageTransformer($slides)] : false;
    } catch (\Exception $e) {
      //Message Error
      $status = 500;
      $response = [
        "errors" => $e->getMessage()
      ];
    }

    return response()->json($response, $status ?? 200);
  }

    /**
     * Show slide by id
     * @param  $id
     * @return JsonResponse
     */
  public function show($id): JsonResponse
  {
    try {
      //Get Parameters from URL.
      $p = $this->parametersUrl(false, false, false, []);

      //Request to Repository
      $slider = $this->slideApi->show($id,$p->include);

      //Response
      $response = [
        "data" => is_null($slider) ?
          false : SliderApiTransformer::collection($slider)
      ];
    } catch (\Exception $e) {
      //Message Error
      $status = 500;
      $response = [
        "errors" => $e->getMessage()
      ];
    }

    return response()->json($response, $status ?? 200);
  }
}
