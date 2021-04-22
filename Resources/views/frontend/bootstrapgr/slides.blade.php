<?php
    if($options['nitems']!=5){
        $item=$options['nitems'];
    }
    else{
        $item=6;
    }
$col=12/$item;
?>

<?php $cont=1?>

<div class="item active ">
@foreach($slider->slides as $index => $slide)
        <div class="col-xs-{{$item>4?"6":"12"}} col-sm-{{$col}}">

            @if(!empty($slide->external_image_url))
                    @if(strpos($slide->external_image_url,"youtube.com"))
                        <iframe width="100%" height="{{$item>4?"350":"250"}}" src="{{ $slide->external_image_url }}" frameborder="0" allowfullscreen></iframe>
                        @else
                    <img src="{!! $slide->external_image_url !!}" alt="{{ $slide->title }}">
                        @endif
              @else
                <img src="{!! $slide->getImageUrl() !!}" alt="{{ $slide->title }}">
            @endif
            @if(!empty($slide->getLinkUrl()))
            <a href="{{ $slide->getLinkUrl() }}" target="{{ $slide->target }}">
        @endif
        <div class="carousel-caption">
            <h1>{{ $slide->title }}</h1>
            <span>
                {{ $slide->caption }}
            </span>
        </div>
        @if(!empty($slide->getLinkUrl()))
            </a>
        @endif
        </div>

        @if($cont%($item+1)==0)
            </div>
            <div class="item">
        @endif
        <?php $cont++?>
@endforeach
    </div>