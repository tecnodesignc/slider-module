<?php namespace Modules\Slider\Repositories\Cache;

use Modules\Core\Repositories\Cache\BaseCacheDecorator;
use Modules\Slider\Repositories\SlideApiRepository;

class CacheSlideApiDecorator extends BaseCacheDecorator implements SlideApiRepository
{
    /**
     * @var SliderRepository
     */
    protected $repository;

    public function __construct(SliderRepository $slider)
    {
        parent::__construct();
        $this->entityName = 'sliders';
        $this->repository = $slider;
    }

    /**
     * Get all online sliders
     * @return object
     */
    public function allOnline()
    {
        return $this->cache
            ->tags($this->entityName, 'global')
            ->remember("{$this->locale}.{$this->entityName}.allOnline", $this->cacheTime,
                function () {
                    return $this->repository->allOnline();
                }
            );
    }

    public function index($page, $take, $filter, $include)
    {
        return $this->remember(function () use ($page, $take, $filter, $include) {
            return $this->repository->index($page, $take, $filter, $include);
        });
    }

    public function show($id, $include)
    {
        return $this->remember(function () use ($id, $include) {
            return $this->repository->show($id, $include);
        });
    }
}
