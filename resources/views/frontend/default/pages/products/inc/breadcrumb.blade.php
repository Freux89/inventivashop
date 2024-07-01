<div class="breadcrumb-content">
   
    <nav>
        <ol class="breadcrumb">
        <li class="breadcrumb-item fw-bold" aria-current="page">
        <a href="{{ route('home') }}">{{ localize('Home') }}</a>
    </li>
    @foreach ($breadcrumbs as $breadcrumb)
        <li class="breadcrumb-item fw-bold" aria-current="page">
            <a href="{{ route('category.show', ['categorySlug' => $breadcrumb->slug]) }}">{{ $breadcrumb->name }}</a>
        </li>
    @endforeach
    <li class="breadcrumb-item active fw-bold" aria-current="page">{{ $product->name }}</li>
        </ol>
    </nav>

</div>