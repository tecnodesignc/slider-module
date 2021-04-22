<?php namespace Modules\Slider\Repositories;

use Modules\Core\Repositories\BaseRepository;

interface SlideApiRepository extends BaseRepository
{
    public function index($page, $take, $filter, $include);

    public function show($id,$include);
}
