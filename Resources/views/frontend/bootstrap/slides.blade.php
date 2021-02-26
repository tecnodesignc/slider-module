@foreach($slider->slides as $index => $slide)
    @if($slide->active)
    <div class="item @if($index === 0) active @endif ">
        @if(!empty($slide->external_image_url))
            @if(strpos($slide->external_image_url,"youtube.com"))
                <iframe width="100%" src="{{$slide->external_image_url }}"
                        frameborder="0" allowfullscreen></iframe>
            @else
                @if(strpos($slide->external_image_url,".mp4"))
                    <video class="img-responsive center-block" loop controls="false">
                        <source src="{{$slide->external_image_url}}" type="video/mp4">
                    </video>
                @else
                    <img class="img-responsive" src="{!! $slide->external_image_url!!}" alt="{{ $slide->title }}">
                @endif
            @endif
        @else
            <img class="img-responsive" src="{!! $slide->getImageUrl() !!}" alt="{{ $slide->title }}">
        @endif
        @if(!empty($slide->getLinkUrl()))
            <a href="{{ $slide->getLinkUrl() }}" target="{{ $slide->target }}">
                @endif
                @if(isset($slide->title) && !empty($slide->title))
                <h1>{{$slide->title}}</h1>
                @endif
                @if(isset($slide->caption) && !empty($slide->caption))
                <span>
                {{$slide->caption}}
            </span>
                @endif
                @if(isset($slide->custom_html) && !empty($slide->custom_html))
                    <div class="custom_html">
                        {!!$slide->custom_html!!}
                    </div>
                @endif
                @if(!empty($slide->getLinkUrl()))
            </a>
        @endif
    </div>
    @endif
@endforeach