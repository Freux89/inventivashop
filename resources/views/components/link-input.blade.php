<div class="mb-3">
    <label class="form-label">{{ $label ?? localize('Tipo di Collegamento') }}</label>
    <select class="form-select" id="{{ $name }}_type" name="{{ $name }}_type">
        <option value="">{{ localize('Seleziona un tipo di collegamento') }}</option>
        <option value="url" {{ !empty($value['url']) ? 'selected' : '' }}>{{ localize('URL Personalizzato') }}</option>
        <option value="product" {{ !empty($value['product_id']) ? 'selected' : '' }}>{{ localize('Prodotto') }}</option>
        <option value="category" {{ !empty($value['category_id']) ? 'selected' : '' }}>{{ localize('Categoria') }}</option>
    </select>
</div>

<!-- Campo URL -->
<div class="mb-3 link-type-field" id="{{ $name }}_url_field" style="display: none;">
    <label for="{{ $name }}_url" class="form-label">{{ localize('URL') }}</label>
    <input type="text" class="form-control" id="{{ $name }}_url" name="{{ $name }}_url" value="{{ $value['url'] ?? '' }}">
</div>

<!-- Campo Prodotto -->
<div class="mb-3 link-type-field" id="{{ $name }}_product_field" style="display: none;">
    <label for="{{ $name }}_product_id" class="form-label">{{ localize('Collega a Prodotto') }}</label>
    <select class="form-select" id="{{ $name }}_product_id" name="{{ $name }}_product_id">
        <option value="">{{ localize('Seleziona un prodotto') }}</option>
        @foreach ($products as $product)
            <option value="{{ $product->id }}" {{ ($value['product_id'] ?? '') == $product->id ? 'selected' : '' }}>{{ $product->name }}</option>
        @endforeach
    </select>
</div>

<!-- Campo Categoria -->
<div class="mb-3 link-type-field" id="{{ $name }}_category_field" style="display: none;">
    <label for="{{ $name }}_category_id" class="form-label">{{ localize('Collega a Categoria') }}</label>
    <select class="form-select" id="{{ $name }}_category_id" name="{{ $name }}_category_id">
        <option value="">{{ localize('Seleziona una categoria') }}</option>
        @foreach ($categories as $category)
            <option value="{{ $category->id }}" {{ ($value['category_id'] ?? '') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
        @endforeach
    </select>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const linkTypeField = document.getElementById('{{ $name }}_type');
        const urlField = document.getElementById('{{ $name }}_url_field');
        const productField = document.getElementById('{{ $name }}_product_field');
        const categoryField = document.getElementById('{{ $name }}_category_field');

        function toggleFields() {
            const selectedType = linkTypeField.value;
            urlField.style.display = selectedType === 'url' ? 'block' : 'none';
            productField.style.display = selectedType === 'product' ? 'block' : 'none';
            categoryField.style.display = selectedType === 'category' ? 'block' : 'none';
        }

        linkTypeField.addEventListener('change', toggleFields);

        // Imposta il campo visibile all'inizio in base ai valori
        if ("{{ $value['url'] ?? '' }}") {
            linkTypeField.value = 'url';
        } else if ("{{ $value['product_id'] ?? '' }}") {
            linkTypeField.value = 'product';
        } else if ("{{ $value['category_id'] ?? '' }}") {
            linkTypeField.value = 'category';
        }
        toggleFields(); // Mostra correttamente il campo al caricamento della pagina
    });
</script>
