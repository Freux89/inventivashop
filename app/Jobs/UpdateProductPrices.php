<?php

namespace App\Jobs;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateProductPrices implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     */
    public function handle()
    {
        // Prendi tutti i prodotti da aggiornare (puoi modificare questa logica per filtrare i prodotti rilevanti)
        $products = Product::all();
        
        foreach ($products as $product) {
            // Logica per calcolare il prezzo di partenza del prodotto

            // 1. Ottenere le varianti combinate e ordinate del prodotto
            $productVariations = $product->combinedOrderedVariations;

            $productVariationIds = [];
            $processedVariationIds = [];
            $variationsSel = [];

            foreach ($productVariations as $variation) {
                // Estrarre l'id della variante dalla chiave di variazione
                $variationKeyParts = explode(':', rtrim($variation->variation_key, '/'));
                $variationId = $variationKeyParts[0];

                // Se questa variante non è ancora stata processata, aggiungiamo il suo valore
                if (!in_array($variationId, $processedVariationIds)) {
                    $productVariationIds[] = $variation->id;
                    $processedVariationIds[] = $variationId;
                    $variationsSel[] = $variation;
                }
            }

            // 2. Applicare le condizioni per disabilitare certe varianti
            $conditionEffects = prepareConditionsForVariations($product, $variationsSel);

            // 3. Filtrare le varianti in base alle condizioni
            $filteredProductVariations = $productVariations->reject(function ($variation) use ($conditionEffects) {
                return in_array($variation->variation_value_id, $conditionEffects['valuesToDisable']);
            });

            // 4. Estrarre i valori varianti unici e filtrati
            $uniqueFilteredVariations = collect();
            $uniqueFilteredVariationValues = collect();
            $processedVariationIds = [];

            foreach ($filteredProductVariations as $variation) {
                $variationKeyParts = explode(':', rtrim($variation->variation_key, '/'));
                $variationId = $variationKeyParts[0];

                if (!in_array($variationId, $processedVariationIds)) {
                    $uniqueFilteredVariations->push($variation);
                    $uniqueFilteredVariationValues->push($variation->variation_value_id);
                    $processedVariationIds[] = $variationId;
                }
            }

            // 5. Calcolare il prezzo usando la funzione variationPrice
            $priceWithTax = variationPrice($product, $uniqueFilteredVariations);
            $product_tax =  $product->taxes[0]['tax_value'] / 100;  // Assicurati di ottenere questo valore correttamente nel tuo contesto

            $netPrice = $priceWithTax / (1 + $product_tax);
               // 6. Ottenere gli sconti per quantità (tiers) e applicare il più alto, se esiste
        $tiers = $product->quantityDiscount->tiers ?? collect();

        if ($tiers->isNotEmpty()) {
            // Trova il tier con il valore di 'discount_percentage' più alto
            $highestDiscountTier = $tiers->sortByDesc('discount_percentage')->first();
            
            if ($highestDiscountTier) {
                // Calcola il prezzo con lo sconto applicato
                $discountPercentage = $highestDiscountTier->discount_percentage;
                $discountedPrice = $netPrice - ($netPrice * ($discountPercentage / 100));

                // Aggiorna il prezzo con lo sconto
                $netPrice = $discountedPrice;
            }
        }
            
            $product->updateQuietly(['starting_price' => $netPrice]);
        }
    }

    /**
     * Logica per calcolare il prezzo del prodotto
     * (puoi adattare questa funzione alla logica che usi per calcolare i prezzi).
     */
    private function calculateProductPrice($product)
    {
        $basePrice = $product->price;

        // Logica aggiuntiva per varianti, materiali, sconti, ecc.
        // Aggiungi qui la tua logica complessa per calcolare il prezzo del prodotto
        return $basePrice;
    }
}
