<?php

namespace Modules\Slider\Http\Controllers\Api;

use Illuminate\Contracts\Cache\Repository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Response;
use Modules\Slider\Services\SlideOrderer;
use Modules\Slider\Repositories\SliderRepository;
use Modules\Slider\Transformers\SliderApiTransformer;

class SliderApiController extends Controller
{
  /**
   * @var Repository
   */
  private Repository $cache;
  /**
   * @var SlideOrderer
   */
  private SlideOrderer $slideOrderer;
  /**
   * @var SliderRepository
   */
  private SliderRepository $slider;

  public function __construct(SlideOrderer $slideOrderer, Repository $cache, SliderRepository $slider)
  {
    $this->cache = $cache;
    $this->slideOrderer = $slideOrderer;
    $this->slider = $slider;
  }

  /**
   * Show slide by id
   */
  public function show($id): JsonResponse
  {
    try {
      //Request to Repository
      $slider = $this->slider->find($id);

      //Response
      $response = [
        "data" => is_null($slider) ?
          false : SliderApiTransformer::collection($slider->slides)
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
