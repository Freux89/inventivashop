@extends('frontend.default.layouts.master')

@section('title')
    {{ localize('Blog Details') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
@endsection

@section('breadcrumb-contents')
    <div class="breadcrumb-content">
        <h2 class="mb-2 text-center">{{ $blog->collectLocalization('title') }}</h2>
        <nav>
            <ol class="breadcrumb justify-content-center">
                <li class="breadcrumb-item fw-bold" aria-current="page"><a
                        href="{{ route('home') }}">{{ localize('Home') }}</a></li>
                <li class="breadcrumb-item fw-bold" aria-current="page"><a
                        href="{{ route('home.blogs') }}">{{ localize('Blogs') }}</a></li>
                <li class="breadcrumb-item fw-bold" aria-current="page">{{ localize('Blog Details') }}</li>
            </ol>
        </nav>
    </div>
@endsection

@section('contents')
    <!--breadcrumb-->
    @include('frontend.default.inc.breadcrumb')
    <!--breadcrumb-->

    <!--blog details start-->
    <section class="blog-details ptb-120">
        <div class="container">
            <div class="row g-4">
                <div class="col-xl-8">
                    <div class="blog-details-content bg-white rounded-2 py-6 px-5">
                        <div class="thumbnail rounded-2 overflow-hidden">
                            <img src="{{ uploadedAsset($blog->banner) }}" alt="{{ $blog->collectLocalization('title') }}"
                                class="img-fluid">
                        </div>
                        <div class="blog-meta d-flex align-items-center gap-3 flex-wrap mt-5">
                            <span class="fs-xs fw-medium"><i
                                    class="fa-solid fa-tags me-1"></i>{{ optional($blog->blog_category)->name }}</span>
                            <span class="fs-xs fw-medium"><i
                                    class="fa-regular fa-clock me-1"></i>{{ date('M d, Y', strtotime($blog->created_at)) }}</span>

                        </div>
                        <span class="hr-line w-100 position-relative d-block my-4"></span>

                        {!! $blog->collectLocalization('description') !!}

                        <div class="tags-social d-flex align-items-center justify-content-between flex-wrap gap-4 mt-6">
                            <div class="tags-list d-flex align-items-center gap-2 flex-wrap">
                                <span class="title text-secondary fw-bold me-2">Tags:</span>

                                @foreach ($blog->tags as $tag)
                                    <a href="javacript:void(0);">{{ $tag->name }}</a>
                                @endforeach
                            </div>
                            <div class="bs_social_share d-none">
                                <a href="#"><i class="fab fa-facebook-f"></i></a>
                                <a href="#"><i class="fab fa-linkedin-in"></i></a>
                                <a href="#"><i class="fab fa-twitter"></i></a>
                                <a href="#"><i class="fab fa-behance"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4">
                    @include('frontend.default.pages.partials.blogs.blogSidebar')
                </div>
            </div>

        </div>
    </section>
    <!--blog details end-->
@endsection
