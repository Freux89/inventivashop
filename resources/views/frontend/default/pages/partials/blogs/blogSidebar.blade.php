@php
    
    $recentBlogs = \App\Models\Blog::latest()
        ->take(4)
        ->get(['title', 'thumbnail_image', 'slug', 'created_at']);
    $categories = \App\Models\BlogCategory::latest()->get(['id', 'name']);
@endphp
<div class="gshop-sidebar">
    <div class="sidebar-widget search-widget bg-white py-5 px-4">
        <div class="widget-title d-flex">
            <h6 class="mb-0 flex-shrink-0">{{ localize('Search Now') }}</h6>
            <span class="hr-line w-100 position-relative d-block align-self-end ms-1"></span>
        </div>
        <form class="search-form d-flex align-items-center mt-4" action="{{ route('home.blogs') }}">
            <input type="text" name="search" placeholder="{{ localize('Search') }}"
                @isset($searchKey)
            value="{{ $searchKey }}"
            @endisset>
            <button type="submit" class="submit-icon-btn-secondary"><i
                    class="fa-solid fa-magnifying-glass"></i></button>
        </form>
    </div>

    <!-- Recent Blogs -->
    <div class="sidebar-widget search-widget bg-white pt-5 pb-4 px-4 border-top">
        <div class="widget-title d-flex mb-3">
            <h6 class="mb-0 flex-shrink-0">{{ localize('Recent Post') }}</h6>
            <span class="hr-line w-100 position-relative d-block align-self-end ms-1"></span>
        </div>
        <ul class="sidebar-posts">
            @foreach ($recentBlogs as $recentBlog)
                <li class="d-flex align-items-center gap-3">
                    <div class="thumbnail rounded-2 overflow-hidden">
                        <a href="{{ route('home.blogs.show', $recentBlog->slug) }}"><img
                                src="{{ uploadedAsset($recentBlog->thumbnail_image) }}"
                                alt="{{ $recentBlog->collectLocalization('title') }}" class="img-fluid"></a>
                    </div>
                    <div class="posts-content">
                        <span class="date d-block fw-medium fs-xs"><i
                                class="fa-regular fa-clock me-2"></i>{{ date('M d, Y', strtotime($recentBlog->created_at)) }}</span>
                        <a href="{{ route('home.blogs.show', $recentBlog->slug) }}"
                            class="fw-bold d-block mt-2 blog-title">{{ $recentBlog->collectLocalization('title') }}</a>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
    <!-- Recent Blogs -->

    <div class="sidebar-widget category-widget bg-white py-5 px-4 border-top">
        <div class="widget-title d-flex">
            <h6 class="mb-0 flex-shrink-0">{{ localize('Categories') }}</h6>
            <span class="hr-line w-100 position-relative d-block align-self-end ms-1"></span>
        </div>
        <ul class="widget-nav mt-4">
            @foreach ($categories as $category)
                @php
                    $countBlogs = \App\Models\Blog::where('blog_category_id', $category->id)->count();
                @endphp
                <li><a href="{{ route('home.blogs') }}?category_id={{ $category->id }}"
                        class="d-flex justify-content-between align-items-center">{{ $category->name }}<span
                            class="fw-bold fs-xs total-count">{{ $countBlogs }}</span></a></li>
            @endforeach

        </ul>
    </div>
</div>
