@if($alerts = getAlertsForPage())
    @foreach($alerts as $alert)
    <div class="container alert-shop text-center py-1" style="background-color: {{ $alert->background_color }};color: {{ $alert->text_color }};">
           
           {{ $alert->text }}
        </div>
    @endforeach
@endif