<?php

namespace Modules\Slider\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Modules\Slider\Entities\Slider;
use Modules\Slider\Repositories\SliderRepository;

class EloquentSliderRepository extends EloquentBaseRepository implements SliderRepository
{


    /**
     * @param int $id
     * @return Model|Collection|Builder|array|null
     */
    public function find(int $id): Model|Collection|Builder|array|null
    {
        if (method_exists($this->model, 'translations')) {
            return $this->model->with('translations')->find($id);
        }
        return $this->model->with('slides')->find($id);
    }

    /**
     * Create a resource
     * @param  $data
     * @return Model|Collection|Builder|array|null
     */
    public function create($data): Model|Collection|Builder|array|null
    {
        $slider = $this->model->create($data);

        return $slider;
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
     * Count all records
     * @return int
     */
    public function countAll(): int
    {
        return $this->model->count();
    }

    /**
     * Get all available sliders
     * @return Collection
     */
    public function allOnline(): Collection
    {
        return $this->model->where('active', '=', true)
            ->orderBy('created_at', 'DESC')
            ->get();
    }


    /**
     * @param string $systemName
     * @return Model|Collection|Builder|array|null
     */
    public function findBySystemName(string $systemName): Model|Collection|Builder|array|null
    {
        return $this->model->where('system_name', '=', $systemName)->first();
    }
}
