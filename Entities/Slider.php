<?php
namespace Modules\Slider\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Slider extends Model
{
    protected $fillable = [
        'name',
        'system_name',
        'active'
    ];

    protected $table = 'slider__sliders';

    /**
     * @return HasMany
     */
    public function slides(): HasMany
    {
        return $this->hasMany(Slide::class)->orderBy('position', 'asc');
    }
}
