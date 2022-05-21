<?php namespace Modules\Slider\Services;

use Modules\Slider\Entities\Slide;
use Modules\Slider\Repositories\SlideRepository;

class SlideOrderer
{
    /**
     * @var SlideRepository
     */
    private $slideRepository;

    /**
     * @param SlideRepository $slide
     */
    public function __construct(SlideRepository $slide)
    {
        $this->slideRepository = $slide;
    }

    /**
     * @param $data
     */
    public function handle($data): void
    {
        $data = $this->convertToArray(json_decode($data));

        foreach ($data as $position => $item) {
            $this->order($position, $item);
        }
    }

    /**
     * Order recursively the slider items
     * @param int $position
     * @param array $item
     */
    private function order(int $position, array $item): void
    {
        $slide = $this->slideRepository->find($item['id']);
        $this->savePosition($slide, $position);
    }

    /**
     * Save the given position on the slider item
     * @param Slide $slide
     * @param int $position
     */
    private function savePosition(Slide $slide, int $position): void
    {
        $this->slideRepository->update($slide, ['position' => $position]);
    }

    /**
     * Convert the object to array
     * @param $data
     * @return array
     */
    private function convertToArray($data): array
    {
        $data = json_decode(json_encode($data), true);

        return $data;
    }
}
