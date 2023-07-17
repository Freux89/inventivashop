@extends('backend.layouts.master')

@section('title')
    {{ localize('Blogs') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
@endsection

@section('contents')
    <section class="tt-section pt-4">
        <div class="container">
            <div class="row mb-3">
                <div class="col-12">
                    <div class="card tt-page-header">
                        <div class="card-body d-lg-flex align-items-center justify-content-lg-between">
                            <div class="tt-page-title">
                                <h2 class="h5 mb-lg-0">{{ localize('Blogs') }}</h2>
                            </div>
                            <div class="tt-action">
                                @can('add_blogs')
                                    <a href="{{ route('admin.blogs.create') }}" class="btn btn-primary"><i
                                            data-feather="plus"></i> {{ localize('Add Blog') }}</a>
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-12">
                    <div class="card mb-4" id="section-1">
                        <form class="app-search" action="{{ Request::fullUrl() }}" method="GET">
                            <div class="card-header border-bottom-0">
                                <div class="row justify-content-between g-3">
                                    <div class="col-auto flex-grow-1">
                                        <div class="tt-search-box">
                                            <div class="input-group">
                                                <span class="position-absolute top-50 start-0 translate-middle-y ms-2"> <i
                                                        data-feather="search"></i></span>
                                                <input class="form-control rounded-start w-100" type="text"
                                                    id="search" name="search" placeholder="{{ localize('Search') }}"
                                                    @isset($searchKey)
                                                value="{{ $searchKey }}"
                                            @endisset>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <div class="input-group">
                                            <select class="form-select select2" name="is_published"
                                                data-minimum-results-for-search="Infinity">
                                                <option value="">{{ localize('Select status') }}</option>
                                                <option value="1"
                                                    @isset($is_published)
                                                     @if ($is_published == 1) selected @endif
                                                    @endisset>
                                                    {{ localize('Active') }}</option>
                                                <option value="0"
                                                    @isset($is_published)
                                                     @if ($is_published == 0) selected @endif
                                                    @endisset>
                                                    {{ localize('Hidden') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <button type="submit" class="btn btn-secondary">
                                            <i data-feather="search" width="18"></i>
                                            {{ localize('Search') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <table class="table tt-footable border-top" data-use-parent-width="true">
                            <thead>
                                <tr>
                                    <th class="text-center">{{ localize('S/L') }}</th>
                                    <th>{{ localize('Title') }}</th>
                                    <th data-breakpoints="xs sm">{{ localize('Category') }}</th>
                                    <th data-breakpoints="xs sm md">{{ localize('Tags') }}</th>
                                    <th data-breakpoints="xs sm">{{ localize('Active') }}</th>
                                    <th data-breakpoints="xs sm" class="text-end">{{ localize('Action') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($blogs as $key => $blog)
                                    <tr>
                                        <td class="text-center">
                                            {{ $key + 1 + ($blogs->currentPage() - 1) * $blogs->perPage() }}</td>
                                        <td>
                                            <a href="{{ route('home.blogs.show', $blog->slug) }}"
                                                class="d-flex align-items-center" target="_blank">
                                                <div class="avatar avatar-sm">
                                                    <img class="rounded-circle"
                                                        src="{{ uploadedAsset($blog->thumbnail_image) }}" alt="avatar" />
                                                </div>
                                                <h6 class="fs-sm mb-0 ms-2">
                                                    {{ $blog->collectLocalization('title') }}
                                                </h6>
                                            </a>
                                        </td>

                                        <td>
                                            @if ($blog->blog_category != null)
                                                <span
                                                    class="badge bg-secondary  rounded-pill">{{ $blog->blog_category->name }}
                                                </span>
                                            @else
                                                {{ localize('n/a') }}
                                            @endif
                                        </td>

                                        <td>
                                            @forelse ($blog->tags as $tag)
                                                <span class="badge bg-secondary rounded-pill">{{ $tag->name }}</span>
                                            @empty
                                                {{ localize('n/a') }}
                                            @endforelse
                                        </td>

                                        <td>
                                            @can('publish_blogs')
                                                <div class="form-check form-switch">
                                                    <input type="checkbox" onchange="updateStatus(this)"
                                                        class="form-check-input"
                                                        @if ($blog->is_active) checked @endif
                                                        value="{{ $blog->id }}">
                                                </div>
                                            @endcan
                                        </td>

                                        <td class="text-end">
                                            <div class="dropdown tt-tb-dropdown">
                                                <button type="button" class="btn p-0" data-bs-toggle="dropdown"
                                                    aria-expanded="false">
                                                    <i data-feather="more-vertical"></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-end shadow">

                                                    @can('edit_blogs')
                                                        <a class="dropdown-item"
                                                            href="{{ route('admin.blogs.edit', ['id' => $blog->id, 'lang_key' => env('DEFAULT_LANGUAGE')]) }}&localize">
                                                            <i data-feather="edit-3" class="me-2"></i>{{ localize('Edit') }}
                                                        </a>
                                                    @endcan

                                                    <a class="dropdown-item"
                                                        href="{{ route('home.blogs.show', $blog->slug) }}" target="_blank">
                                                        <i data-feather="eye" class="me-2"></i>{{ localize('View') }}
                                                    </a>

                                                    @can('delete_blogs')
                                                        <a href="#" class="dropdown-item confirm-delete"
                                                            data-href="{{ route('admin.blogs.delete', $blog->id) }}"
                                                            title="{{ localize('Delete') }}">
                                                            <i data-feather="trash-2" class="me-2"></i>
                                                            {{ localize('Delete') }}
                                                        </a>
                                                    @endcan
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!--pagination start-->
                        <div class="d-flex align-items-center justify-content-between px-4 pb-4">
                            <span>{{ localize('Showing') }}
                                {{ $blogs->firstItem() }}-{{ $blogs->lastItem() }} {{ localize('of') }}
                                {{ $blogs->total() }} {{ localize('results') }}</span>
                            <nav>
                                {{ $blogs->appends(request()->input())->links() }}
                            </nav>
                        </div>
                        <!--pagination end-->
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        "use strict";

        function updatePopular(el) {
            if (el.checked) {
                var is_popular = 1;
            } else {
                var is_popular = 0;
            }
            $.post('{{ route('admin.blogs.updatePopular') }}', {
                    _token: '{{ csrf_token() }}',
                    id: el.value,
                    is_popular: is_popular
                },
                function(data) {
                    if (data == 1) {
                        notifyMe('success', '{{ localize('Status updated successfully') }}');
                    } else {
                        notifyMe('danger', '{{ localize('Something went wrong') }}');
                    }
                });
        }

        function updateStatus(el) {
            if (el.checked) {
                var is_active = 1;
            } else {
                var is_active = 0;
            }
            $.post('{{ route('admin.blogs.updateStatus') }}', {
                    _token: '{{ csrf_token() }}',
                    id: el.value,
                    is_active: is_active
                },
                function(data) {
                    if (data == 1) {
                        notifyMe('success', '{{ localize('Status updated successfully') }}');
                    } else {
                        notifyMe('danger', '{{ localize('Something went wrong') }}');
                    }
                });
        }
    </script>
@endsection
