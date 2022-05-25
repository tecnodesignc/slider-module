<?php namespace Modules\Slider\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Media\Support\Traits\MediaRelation;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\App;
use Modules\Page\Entities\Page;

/**
 *
 */
class Slide extends Model
{
    use Translatable, MediaRelation;

    public $translatedAttributes = [
        'title',
        'caption',
        'uri',
        'url',
        'active',
        'custom_html',
    ];

    protected $fillable = [
        'slider_id',
        'page_id',
        'position',
        'target',
        'title',
        'caption',
        'uri',
        'url',
        'active',
        'external_image_url',
        'custom_html',
    ];
    protected $table = 'slider__slides';

    /**
     * @var ?string
     */
    private ?string $linkUrl=null;

    /**
     * @var ?string
     */
    private ?string $imageUrl=null;

    /**
     * @return BelongsTo
     */
    public function slider(): BelongsTo
    {
        return $this->belongsTo(Slider::class);
    }

    /**
     * Check if page_id is empty and returning null instead empty string
     * @param $value
     * @return void
     */
    public function setPageIdAttribute($value): void
    {
        $this->attributes['page_id'] = !empty($value) ? $value : null;
    }

    /**
     * @return BelongsTo
     */
    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }

    /**
     * returns slider image src
     * @return string|null full image path if image exists or null if no image is set
     */
    public function getImageUrl(): ?string
    {
        if($this->imageUrl === null) {
            if (!empty($this->external_image_url)) {
                $this->imageUrl = $this->external_image_url;
            } elseif (isset($this->files[0]) && !empty($this->files[0]->path)) {
                $this->imageUrl = $this->filesByZone('slideImage')->first()->path_string;
            }
        }

        return $this->imageUrl;
    }


    /**
     * returns slider link URL
     * @return string|null
     */
    public function getLinkUrl(): ?string
    {
        if ($this->linkUrl === null) {
            if (!empty($this->url)) {
                $this->linkUrl = $this->url;
            } elseif (!empty($this->uri)) {
                $this->linkUrl = '/' . locale() . '/' . $this->uri;
            } elseif (!empty($this->page)) {
                $this->linkUrl = route('page', ['uri' => $this->page->slug]);
            }
        }

        return $this->linkUrl;
    }
}
