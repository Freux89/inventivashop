<?php

namespace App\Observers;

use App\Models\Product;
use App\Models\Variation;
use App\Models\VariationValue;
use App\Models\Material;
use App\Models\Template;
use App\Models\QuantityDiscount;
use App\Models\QuantityDiscountTier;
use App\Events\ProductUpdated;
use App\Models\ProductVariation;

class PriceRelatedObserver
{
    /**
     * Intercetta il salvataggio di tutti i modelli, anche quando non ci sono modifiche.
     */
    public function saved($model)
    {
        // Se il modello è uno dei seguenti, lancia il ricalcolo per tutti i prodotti
        if ($model instanceof ProductVariation || $model instanceof Material || $model instanceof Template || 
            $model instanceof QuantityDiscount || $model instanceof QuantityDiscountTier || 
            $model instanceof Variation || $model instanceof VariationValue) {

            // Lancia l'evento per aggiornare tutti i prodotti
            event(new ProductUpdated(null));
        }
    }

    /**
     * Intercetta la creazione di nuovi modelli
     */
    public function created($model)
    {
        // Logica per la creazione, uguale a quella del salvataggio
        $this->saved($model);
    }

    /**
     * Intercetta la cancellazione di modelli
     */
    public function deleted($model)
    {
        // Lancia l'evento per aggiornare tutti i prodotti in caso di cancellazione
        event(new ProductUpdated(null));
    }
}
