@if($type == 'content-static')
@include('backend.pages.sections.items.partials.contentStatic')

@elseif($type == 'category')

@include('backend.pages.sections.items.partials.category')

@elseif($type == 'product')

@include('backend.pages.sections.items.partials.product')


@endif