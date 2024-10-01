<?php

namespace App\Observers;

use App\Models\Product;
use App\Models\Variation;
use App\Models\VariationValue;
use App\Models\Material;
use App\Models\Template;
use App\Models\QuantityDiscount;
use App\Events\ProductUpdated;

class PriceRelatedObserver
{
    /**
     * Handle the updated event for all models.
     */
    public function updated($model)
    {
        // Gestione per il prodotto - solo il prodotto specifico viene aggiornato
        if ($model instanceof Product) {
            event(new ProductUpdated($model));
        }

        // Per tutti gli altri modelli (Material, Template, QuantityDiscount), aggiorna tutti i prodotti
        if ($model instanceof Material || $model instanceof Template || $model instanceof QuantityDiscount || $model instanceof Variation || $model instanceof VariationValue) {
            
            // Aggiorna tutti i prodotti (per ora)
            $this->updateAllProducts();
        }
    }

    /**
     * Handle the created event for all models.
     */
    public function created($model)
    {
        // Stessa logica per la creazione
        if ($model instanceof Product) {
            event(new ProductUpdated($model));
        }

        // Per tutti gli altri modelli, aggiorna tutti i prodotti
        if ($model instanceof Material || $model instanceof Template || $model instanceof QuantityDiscount || $model instanceof Variation || $model instanceof VariationValue) {
            $this->updateAllProducts();
        }
    }

    /**
     * Handle the deleted event for all models.
     */
    public function deleted($model)
    {
        // Stessa logica per la cancellazione - aggiorniamo tutti i prodotti
        if ($model instanceof Material || $model instanceof Template || $model instanceof QuantityDiscount || $model instanceof Variation || $model instanceof VariationValue) {
            $this->updateAllProducts();
        }
    }


    /**
     * Metodo per aggiornare tutti i prodotti
     */
    protected function updateAllProducts()
    {
        $products = Product::all();  // Prendi tutti i prodotti

        foreach ($products as $product) {
            event(new ProductUpdated($product));  // Lancia l'evento per ogni prodotto
        }
    }
}


