@if($type == 'image-content')
@include('backend.pages.sections.items.partials.imageContent')

@elseif($type == 'only-image')

@include('backend.pages.sections.items.partials.image')

@elseif($type == 'only-content')

@include('backend.pages.sections.items.partials.content')

@elseif($type == 'video')

@include('backend.pages.sections.items.partials.video')

@elseif($type == 'card')

@include('backend.pages.sections.items.partials.card')

@elseif($type == 'accordion')

@include('backend.pages.sections.items.partials.accordion')

@endif