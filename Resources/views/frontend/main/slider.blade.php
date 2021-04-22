<div id="{{$slider->system_name}}" class="carousel slide" data-ride="carousel" >
    {{--@include('slider.main.indicators', ['slider' => $slider])--}}
    <div class="carousel-inner">
        @include('slider::frontend.main.slides', ['slider' => $slider])
    </div>
    @include('slider::frontend.main.controls', ['slider' => $slider])
</div>