<?php namespace Modules\Slider\Repositories\Eloquent;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\App;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Modules\Slider\Entities\Slider;
use Modules\Slider\Repositories\SlideApiRepository;

class EloquentSlideApiRepository extends EloquentBaseRepository implements SlideApiRepository
{
  public function index ($page, $take, $filter, $include): Collection|LengthAwarePaginator|array
  {
    //Initialize Query
    $query = $this->model->query();

    /*== RELATIONSHIPS ==*/
    if (count($include)) {
      //Include relationships for default
      $includeDefault = [];
      $query->with(array_merge($includeDefault, $include));
    }

    /*== FILTER ==*/
    if ($filter) {
      //Filter by slug
      if (isset($filter->sliderId)) {
        $query->where('slider_id', $filter->sliderId);
      }
    }

    /*=== REQUEST ===*/
    if ($page) {//Return request with pagination
      $take ? true : $take = 12; //If no specific take, query default take is 12
      return $query->paginate($take);
    } else {//Return request without pagination
      $take ? $query->take($take) : false; //Set parameter take(limit) if is requesting
      return $query->get();
    }
  }

  public function show($id,$include): Collection|array
  {
    //Initialize Query
    $query = $this->model->query();

    /*== RELATIONSHIPS ==*/
    if (count($include)) {
      //Include relationships for default
      $includeDefault = [];
      $query->with(array_merge($includeDefault, $include));
    }

    $query->where('slider_id',$id);

    /*=== REQUEST ===*/
    return $query->get();
  }
}
