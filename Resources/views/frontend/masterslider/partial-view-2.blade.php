<div class="video-embed-container fit-embed-vid-yes">
    <!-- template -->
    <div class="ms-partialview-template" id="{{ $slider->system_name }}partial-view-1">
        <!-- masterslider -->
        <div class="master-slider ms-skin-default" id="{{ $slider->system_name }}">
            @include('slider::frontend.masterslider.slides', ['slider' => $slider,'options'=>$options])
        </div>
        <!-- end of masterslider -->
    </div>
    <!-- end of template -->
</div>


@section('scripts')

    <link rel="stylesheet" href="themes/imagina2017/vendor/masterslider/css/masterslider.main.css" />
    <script src="themes/imagina2017/vendor/masterslider/js/masterslider.min.js"></script>
    <script src="themes/imagina2017/vendor/masterslider/js/masterslider.partialview.js"></script>



    <script>
        $(document).ready(function(){
            var slider = new MasterSlider();
            slider.setup('{{ $slider->system_name }}' , {
                width:{{ $options['width'] or '400' }},
                height:{{ $options['height'] or '300' }},
                space:10,
                loop:true,
                view:'prtialwave2'
            });

            slider.control('arrows');
            slider.control('slideinfo',{insertTo:"#{{ $slider->system_name }}partial-view-1" , autohide:false});
            slider.control('circletimer' , {color:"#FFFFFF" , stroke:9});
        });
    </script>

    <style>
        .ms-partialview-template .ms-view {
            overflow: visible;
            background-color: transparent;
        }
    </style>

@endsection