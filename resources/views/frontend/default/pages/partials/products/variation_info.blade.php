<div>
    <button type="button" id="close-info-description"><i class="fa-regular fa-circle-xmark"></i></button>
    <div id="info-description-content">
       
        @if($info_video_url)
            <div class="row">
                <div class="{{ $info_description ? 'col-md-6' : 'col-12' }} video-column">
                    <!-- Video embed -->
                    <div class="ratio ratio-16x9">
                        <iframe class="ratio-item" src="{{ str_replace('watch?v=', 'embed/', $info_video_url) }}" allowfullscreen></iframe>
                    </div>
                </div>
                @if($info_description)
                    <div class="col-md-6 text-column mt-3 mt-md-0">
                        <div class="h5 font-weight-bold">{{$info_name}}</div>
                        {!! $info_description !!}
                    </div>
                @endif
            </div>
        @elseif($info_image_id || $info_slider_image_ids)
            <div class="row">
                <div class="{{ $info_description ? 'col-md-6' : 'col-12' }} image-column">
                    @if($info_slider_image_ids)
                        <!-- Slider con Swiper -->
                        <div class="overflow-hidden position-relative">
                            <div class="swiper-container info-swiper">
                                <div class="swiper-wrapper">
                                    @foreach(explode(',', $info_slider_image_ids) as $image_id)
                                        <div class="swiper-slide">
                                            <img src="{{ uploadedAsset($image_id) }}" class="img-fluid" alt="Slide Image">
                                        </div>
                                    @endforeach
                                </div>
                                <div class="swiper-button-next"></div>
                                <div class="swiper-button-prev"></div>
                            </div>
                        </div>
                    @elseif($info_image_id)
                        <img src="{{ uploadedAsset($info_image_id) }}" class="img-fluid" alt="Info Image">
                    @endif
                </div>
                @if($info_description)
                    <div class="col-md-6 text-column mt-3 mt-md-0">
                        <div class="h5 font-weight-bold">{{$info_name}}</div>
                        {!! $info_description !!}
                    </div>
                @endif
            </div>
        @else
            <div class="full-text-column">
                <div class="h5 font-weight-bold">{{$info_name}}</div>
                {!! $info_description !!}
            </div>
        @endif
    </div>
</div>
