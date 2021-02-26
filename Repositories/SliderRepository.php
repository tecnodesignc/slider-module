<?php namespace Modules\Slider\Repositories;

use Modules\Core\Repositories\BaseRepository;

interface SliderRepository extends BaseRepository
{
    /**
     * Get all online sliders
     * @return object
     */
    public function allOnline();

    /**
     * @param string $systemName
     * @return Object
     */
    public function findBySystemName(string $systemName);
}
