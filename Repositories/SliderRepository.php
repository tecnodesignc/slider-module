<?php namespace Modules\Slider\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Repositories\BaseRepository;

interface SliderRepository extends BaseRepository
{
    /**
     * Get all online sliders
     * @return Collection
     */
    public function allOnline(): Collection;

    /**
     * @param string $systemName
     * @return Model|Collection|Builder|array|null
     */
    public function findBySystemName(string $systemName): Model|Collection|Builder|array|null;
}
