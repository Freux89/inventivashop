<section class="blog-section pb-120">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-5">
                <div class="section-title text-center">
                    <h2 class="mb-3">{{ localize('Browse Recent Post') }}</h2>
                    <p class="mb-0">{{ localize('Learn More About Our Recent Exclusive News, Updates & Articles') }}
                    </p>
                </div>
            </div>
        </div>
        <div class="row g-4 mt-3">
            @foreach ($blogs as $blog)
                <div class="col-xl-4 col-md-6">
                    <article class="blog-card rounded-2 overflow-hidden bg-white">
                        <div class="thumbnail overflow-hidden">
                            <img src="{{ uploadedAsset($blog->thumbnail_image) }}"
                                alt="{{ $blog->collectLocalization('title') }}" class="img-fluid">
                        </div>
                        <div class="blog-card-content">
                            <div class="blog-meta d-flex align-items-center gap-3 mb-1">
                                <span class="fs-xs fw-medium"><i
                                        class="fa-solid fa-tags me-1"></i>{{ optional($blog->blog_category)->name }}</span>
                                <span class="fs-xs fw-medium"><i
                                        class="fa-regular fa-clock me-1"></i>{{ date('M d, Y', strtotime($blog->created_at)) }}</span>
                            </div>
                            <a href="{{ route('home.blogs.show', $blog->slug) }}">
                                <h3 class="mb-3 h5">{{ $blog->collectLocalization('title') }}</h3>
                            </a>
                            <p class="mb-0 mb-5">{{ $blog->collectLocalization('short_description') }}
                            </p>
                            <a href="{{ route('home.blogs.show', $blog->slug) }}"
                                class="btn btn-primary-light btn-md">{{ localize('Explore More') }}<span
                                    class="ms-2"><i class="fas fa-arrow-right"></i></span></a>
                        </div>
                    </article>
                </div>
            @endforeach

        </div>
    </div>
</section>
