 <!-- Tabella dei livelli di sconto -->
 <div class="discount-tiers mt-5">
     <h5>{{ localize('Seleziona altre quantità') }}</h5>
     <table class="table">
         <thead>
             <tr>
                 <th>{{ localize('Quantità Minima') }}</th>
                 <th>{{ localize('Percentuale di Sconto') }}</th>
                 <th>{{ localize('Prezzo per Unità') }}</th>
             </tr>
         </thead>
         <tbody>
             @foreach ($tiers as $tier)
             <tr class="tier-row" data-quantity="{{ $tier->min_quantity }}">
                 <td>{{ $tier->min_quantity }}</td>
                 <td>{{ $tier->discount_percentage }}% {{ localize('Sconto') }}</td>
                 <td><span class="price">{{ formatPrice($netPriceFloat * (1 - $tier->discount_percentage / 100), 2, ',', '.') }}</span> {{ localize('Cad') }}</td>

             </tr>
             @endforeach
         </tbody>
     </table>
 </div>