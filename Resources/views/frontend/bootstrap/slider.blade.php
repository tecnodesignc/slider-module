<div id="{{$slider->system_name}}" class="carousel slide" data-ride="carousel" >
    {{--@include('slider.main.indicators', ['slider' => $slider])--}}
    <div class="carousel-inner">
        @include('slider::frontend.bootstrap4.slides', ['slider' => $slider])
    </div>
    @include('slider::frontend.bootstrap4.controls', ['slider' => $slider])
</div>