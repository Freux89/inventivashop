@if(isset($menu) && $menu->items->isNotEmpty())
<nav class="position-absolute position-md-relative d-inline-block w-100 mt-4 mb-2 start-0">
    <div class="mega-menu menuClass responsive-menu">
        <div class="main-links">
            <ul>
                @foreach($menu->items as $item)
                <li>
                    @if($item->url || $item->product_id || $item->category_id)
                    <a data-submenu="{{ str_replace(' ', '-', strtolower($item->title)) }}" href="{{ $item->url ?? ($item->product_id ? route('product.show', $item->product->slug) : route('category.show', $item->category->slug)) }}">
                        {{ $item->title }}
                    </a>
                    @else
                    <div data-submenu="{{ str_replace(' ', '-', strtolower($item->title)) }}">
                        <span>{{ $item->title }}</span>
                    </div>
                    @endif
                </li>
                @endforeach
            </ul>
        </div>
        <div class="menu-dropdown">
            @foreach($menu->items as $item)
            @if($item->columns->isNotEmpty())

            <!-- Sottomenù con ID dinamico corrispondente al data-submenu -->
            <div class="menu-item-wrapper" id="{{ str_replace(' ', '-', strtolower($item->title)) }}">
                <div class="menu-columns-wrapper row">
                    @foreach($item->columns as $column)
                    @php
                    $columnWidthClass = 'col-12 col-md-' . $column->column_width;
                    $borderStyles = [];
                    $paddingClasses = [];

                    // Gestione del bordo sinistro e destro
                    if ($column->border_left) {
                    $borderStyles[] = 'border-left: 1px solid #eaeaea';
                    }
                    if ($column->border_right) {
                    $borderStyles[] = 'border-right: 1px solid #eaeaea';
                    }

                    // Gestione del padding sinistro e destro con le classi Bootstrap
                    if ($column->padding_left) {
                    $paddingClasses[] = 'ps-' . $column->padding_left;
                    }
                    if ($column->padding_right) {
                    $paddingClasses[] = 'pe-' . $column->padding_right;
                    }

                    // Unire le classi padding in un'unica stringa
                    $paddingClass = implode(' ', $paddingClasses);
                    // Unire gli stili di bordo in un'unica stringa
                    $borderStyle = implode(';', $borderStyles);
                    @endphp
                    <div class="{{ $columnWidthClass }} {{ $paddingClass }} mb-5 mb-md-0 " style="{{ $borderStyle }}">
                        @foreach($column->items as $columnItem)
                        @php
                        $marginTopClass = $columnItem->margin_top ? 'mt-' . $columnItem->margin_top : '';
                        $marginBottomClass = $columnItem->margin_bottom ? 'mb-' . $columnItem->margin_bottom : '';
                        $styles = [];
                        if ($columnItem->font_size) $styles[] = 'font-size:' . $columnItem->font_size . 'px';
                        if ($columnItem->title_color) $styles[] = 'color:' . $columnItem->title_color;
                        if ($columnItem->is_bold) $styles[] = 'font-weight:bold';

                        // Condizionale per lo stile dell'immagine
                        $imageStyles = $columnItem->title ? 'display: block; margin-top: 10px;' : '';
                        @endphp

                        <div class="{{ $marginTopClass }} {{ $marginBottomClass }}">
                            <!-- Visualizzazione del titolo, se presente -->
                            @if($columnItem->title)
                            @if($columnItem->url || $columnItem->product_id || $columnItem->category_id)
                            <a href="{{ $columnItem->url ?? ($columnItem->product_id ? route('products.show', $columnItem->product->slug) : route('category.show', $columnItem->category->slug)) }}" style="{{ implode(';', $styles) }}" title="{{ $columnItem->link_title ?? $columnItem->title }}">
                                {{ $columnItem->title }}
                            </a>
                            @else
                            <span style="{{ implode(';', $styles) }}">{{ $columnItem->title }}</span>
                            @endif
                            @endif

                            <!-- Visualizzazione dell'immagine, se presente -->
                            @if($columnItem->image_id)
                            @if($columnItem->apply_link_to_image && ($columnItem->url || $columnItem->product_id || $columnItem->category_id))
                            <a href="{{ $columnItem->url ?? ($columnItem->product_id ? route('products.show', $columnItem->product->slug) : route('category.show', $columnItem->category->slug)) }}" title="{{ $columnItem->link_title ?? $columnItem->title }}">
                                <img src="{{ uploadedAsset($columnItem->image_id) }}" alt="{{ $columnItem->title }}" class="img-fluid" style="{{$imageStyles}}">
                            </a>
                            @else
                            <img src="{{ uploadedAsset($columnItem->image_id) }}" alt="{{ $columnItem->title }}" class="img-fluid" style="{{$imageStyles}}">
                            @endif
                            @endif

                            <!-- Visualizzazione della descrizione, se presente -->
                            @if($columnItem->description)
                            <div class="description" style="margin-top: 10px;">
                                {!! $columnItem->description !!}
                            </div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                    @endforeach
                </div>
            </div>

            @endif
            @endforeach
        </div>
    </div>
</nav>
@endif