<?php

namespace Modules\Slider\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Modules\Slider\Repositories\SlideRepository;
use Modules\Slider\Events\SlideWasCreated;

class EloquentSlideRepository extends EloquentBaseRepository implements SlideRepository
{

    /**
     * Override for add the event on create and link media file
     * @param $data
     * Data from POST request form
     * @return Model|Collection|Builder|array|null The created entity
     */
    public function create($data): Model|Collection|Builder|array|null
    {
        $slide = parent::create($data);

        event(new SlideWasCreated($slide, $data));

        return $slide;
    }
    /**
     * Update a resource
     * @param  $model
     * @param array $data
     * @return Model|Collection|Builder|array|null
     */
    public function update($model, array $data): Model|Collection|Builder|array|null
    {
        $model->update($data);

        return $model;
    }

    /**
     * Get resources by an array of attributes
     * @param bool|object $params
     * @return LengthAwarePaginator|Collection
     */
    public function getItemsBy(bool|object $params = false): Collection|LengthAwarePaginator
    {
        /*== initialize query ==*/
        $query = $this->model->query();

        /*== RELATIONSHIPS ==*/
        if (in_array('*', $params->include)) {//If Request all relationships
            $query->with(['translations']);
        } else {//Especific relationships
            $includeDefault = ['translations'];//Default relationships
            if (isset($params->include))//merge relations with default relationships
                $includeDefault = array_merge($includeDefault, $params->include);
            $query->with($includeDefault);//Add Relationships to query
        }

        /*== FILTERS ==*/
        if (isset($params->filter)) {
            $filter = $params->filter;//Short filter

            if (isset($filter->slider) && !empty($filter->slider)) { //si hay que filtrar por rango de precio

                $query->where('slider_id', $filter->slider);
            }
            if (isset($filter->search) && !empty($filter->search)) { //si hay que filtrar por rango de precio
                $criterion = $filter->search;

                $query->whereHas('translations', function (Builder $q) use ($criterion) {
                    $q->where('title', 'like', "%{$criterion}%");
                });
            }

            //Filter by date
            if (isset($filter->date) && !empty($filter->date)) {
                $date = $filter->date;//Short filter date
                $date->field = $date->field ?? 'created_at';
                if (isset($date->from))//From a date
                    $query->whereDate($date->field, '>=', $date->from);
                if (isset($date->to))//to a date
                    $query->whereDate($date->field, '<=', $date->to);
            }

            //Order by
            if (isset($filter->order) && !empty($filter->order)) {
                $orderByField = $filter->order->field ?? 'created_at';//Default field
                $orderWay = $filter->order->way ?? 'desc';//Default way
                $query->orderBy($orderByField, $orderWay);//Add order to query
            }

            if (isset($filter->status) && !empty($filter->status)) {
                $query->whereStatus($filter->status);
            }

        }

        /*== FIELDS ==*/
        if (isset($params->fields) && count($params->fields))
            $query->select($params->fields);
        /*== REQUEST ==*/
        if (isset($params->page) && $params->page) {
            return $query->paginate($params->take);
        } else {
            if (isset($params->skip) && !empty($params->skip)) {
                $query->skip($params->skip);
            };

            $params->take ? $query->take($params->take) : false;//Take

            return $query->get();
        }
    }

    /**
     * Get resources by an array of attributes
     * @param string $criteria
     * @param bool|object $params
     * @return Model|Collection|Builder|array|null
     */
    public function getItem(string $criteria, $params = false): Model|Collection|Builder|array|null
    {
        //Initialize query
        $query = $this->model->query();

        /*== RELATIONSHIPS ==*/
        if (in_array('*', $params->include)) {//If Request all relationships
            $query->with(['translations']);
        } else {//Especific relationships
            $includeDefault = [];//Default relationships
            if (isset($params->include))//merge relations with default relationships
                $includeDefault = array_merge($includeDefault, $params->include);
            $query->with($includeDefault);//Add Relationships to query
        }

        /*== FILTER ==*/
        if (isset($params->filter)) {
            $filter = $params->filter;

            if (isset($filter->field))//Filter by specific field
                $field = $filter->field;

            // find translatable attributes
            $translatedAttributes = $this->model->translatedAttributes;

            // filter by translatable attributes
            if (isset($field) && in_array($field, $translatedAttributes))//Filter by slug
                $query->whereHas('translations', function ($query) use ($criteria, $filter, $field) {
                    $query->where('locale', $filter->locale)
                        ->where($field, $criteria);
                });
            else
                // find by specific attribute or by id
                $query->where($field ?? 'id', $criteria);
        }

        /*== FIELDS ==*/
        if (isset($params->fields) && count($params->fields))
            $query->select($params->fields);

        /*== REQUEST ==*/
        return $query->first();

    }
}
