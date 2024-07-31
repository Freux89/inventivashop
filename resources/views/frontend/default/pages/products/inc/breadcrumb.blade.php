<div class="breadcrumb-content">
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item fw-bold" aria-current="page">
                <a href="{{ route('home') }}">{{ localize('Home') }}</a>
            </li>
            @if($breadcrumbs->isEmpty())
                <li class="breadcrumb-item active fw-bold" aria-current="page">{{ $product->name }}</li>
            @else
                @php
                    // Inizializza il percorso breadcrumb come stringa vuota
                    $breadcrumbPath = '';
                @endphp
                @foreach ($breadcrumbs as $index => $breadcrumb)
                    @php
                        // Aggiungi uno slash solo se non è il primo slug
                        if ($breadcrumbPath !== '') {
                            $breadcrumbPath .= '/';
                        }
                        
                        // Aggiungi lo slug della categoria corrente al percorso breadcrumb
                        $breadcrumbPath .= $breadcrumb->slug;
                    
                        // Genera l'URL utilizzando il percorso breadcrumb costruito finora
                        $url = route('category.breadcrumb.show', ['any' => $breadcrumbPath, 'categorySlug' => '/']);
                    @endphp
                    <li class="breadcrumb-item fw-bold" aria-current="page">
                        <a href="{{ $url }}">{{ $breadcrumb->name }}</a>
                    </li>
                @endforeach
                <li class="breadcrumb-item active fw-bold" aria-current="page">{{ $product->name }}</li>
            @endif
        </ol>
    </nav>
</div>
