@section('extra-head')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css">
<script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.min.js"></script>
@endsection




<div class="row">
    <div class="col-12">
        <strong>{{ localize('Categorie') }}</strong>
    </div>
    <div class="col-md-12 mb-3">
        <label for="categories" class="form-label">{{ localize('Categorie per filtrare gli elementi') }}</label>
        <input name='settings[categories]' class="form-control" placeholder='Inserisci le categorie e premi invio' value="{{ old('settings.categories', $section->settings['categories'] ?? '') }}">
       
    </div>
</div>

<script>
    // Riferimento all'input
    var input = document.querySelector('input[name="settings\\[categories\\]"]');


    // Inizializzazione di Tagify
    var tagify = new Tagify(input, {
        originalInputValueFormat: valuesArr => valuesArr.map(item => item.value).join(',')
    });

</script>