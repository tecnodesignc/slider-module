<div id="{{ $slider->system_name }}" class="carousel slide" data-ride="carousel">
    @include('slider::frontend.bootstrapgr.indicators', ['slider' => $slider,'options'=>$options])
    <div class="carousel-inner" role="listbox">
        @include('slider::frontend.bootstrapgr.slides', ['slider' => $slider, 'options'=>$options])
    </div>
    @include('slider::frontend.bootstrapgr.controls', ['slider' => $slider, 'options'=>$options])
</div>