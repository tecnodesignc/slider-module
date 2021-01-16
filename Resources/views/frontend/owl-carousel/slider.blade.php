
<div id="{{$slider->system_name}}" class="owl-carousel owl-theme">
	@include('slider::frontend.owl-carousel.slides', ['slider' => $slider, 'options'=>$options])
</div>
@section('scripts-owl')

    <script type="text/javascript">
	  	$(document).ready(function() {
	        var owl = $('#{{$slider->system_name}}');
	        owl.owlCarousel({
	        margin: 10,
	        nav: true,
	        loop: true,
            dots: false,
	        lazyContent: true,
	        autoplay: true,
	        autoplayHoverPause: true,
	        navText: ['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>'],
	        responsive: {
	          0: {
	            items: 2
	          },
	          768: {
	            items: {{ $options['nitems'] }}
	          },
	          1024: {
	            items: {{ $options['nitems'] }}
	          }
	        }
	      })
	    })
	</script>
	@parent
@stop