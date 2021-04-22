@if(count($slider->slides) > 1)
    <a class="carousel-control carousel-control-prev" href="#{{$slider->system_name}}" role="button" data-slide="prev">
        <i class="fa fa-angle-left" aria-hidden="true"></i>
    </a>
    <a class="carousel-control carousel-control-next" href="#{{$slider->system_name}}" role="button" data-slide="next">
        <i class="fa fa-angle-right" aria-hidden="true"></i>
    </a>
@endif