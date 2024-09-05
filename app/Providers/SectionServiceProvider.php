<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\SectionPosition;
use App\Models\Category;
use App\Models\Product;
use App\Models\Page;

class SectionServiceProvider extends ServiceProvider
{
    public function boot()
    {
        View::composer('*', function ($view) {
            $currentRouteName = request()->route()->getName();
            $currentRouteParameters = request()->route()->parameters();
    // migliorare meglio  currentRouteName perchè non restituisce il fatto che sia una home, product o category
            // Determina il tipo di pagina e l'ID o slug da route name o parameters
            $positionableType = $this->determineType($currentRouteName);
            
            // Assicurati di ottenere il parametro corretto in base al tipo di pagina
            $positionableId = $this->getPositionableId($positionableType, $currentRouteParameters);
           
            $sections = SectionPosition::with('section')
                ->where('positionable_type', $positionableType)
                ->where(function ($query) use ($positionableId) {
                    $query->whereDoesntHave('positionables')
                          ->orWhereHas('positionables', function ($q) use ($positionableId) {
                              $q->where('positionable_id', $positionableId);
                          });
                })
                ->get();
               
               // Inizializza le variabili per ogni hook
        $hook_after_content_sections = [];
        $hook_before_content_sections = [];
        $hook_home_sections = [];

        // Popola le variabili con gli ID delle sezioni
        foreach ($sections as $section) {
            switch ($section->hook_name) {
                case 'hook_after_content':
                    $hook_after_content_sections[] = $section;
                    break;
                case 'hook_before_content':
                    $hook_before_content_sections[] = $section;
                    break;
                case 'hook_home':
                    $hook_home_sections[] = $section;
                    break;
            }
        }

        // Passa le variabili alla vista
        $view->with(compact('hook_after_content_sections', 'hook_before_content_sections', 'hook_home_sections'));
    
        });
    }

    private function determineType($routeName)
{
    // Mappa i nomi delle rotte ai tipi posizionabili
    $typeMap = [
        'category.show' => 'Category',
        'products.show' => 'Product',
        'home.pages.show' => 'Page'
    ];

    // Controlla se il nome della rotta esiste nella mappa e restituisci il tipo corrispondente
    return $typeMap[$routeName] ?? 'Home';
}

    private function getPositionableId($positionableType, $parameters)
{
    switch ($positionableType) {
        case 'Category':
            // Recupera la categoria dallo slug e restituisci il suo ID
            $category = Category::where('slug', $parameters['categorySlug'] ?? '')->first();
            return $category ? $category->id : null;
        case 'Product':
            // Recupera il prodotto dallo slug e restituisci il suo ID
            $product = Product::where('slug', $parameters['slug'] ?? '')->first();
            return $product ? $product->id : null;
        case 'Page':
            // Recupera la pagina dallo slug e restituisci il suo ID
            $page = Page::where('slug', $parameters['slug'] ?? '')->first();
            return $page ? $page->id : null;
        default:
            return null;
    }
}

}
