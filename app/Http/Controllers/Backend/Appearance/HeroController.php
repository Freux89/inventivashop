<?php

namespace App\Http\Controllers\Backend\Appearance;

use App\Http\Controllers\Controller;
use App\Models\MediaManager;
use App\Models\SystemSetting;
use Illuminate\Http\Request;

class HeroController extends Controller
{
    # construct
    public function __construct()
    {
        $this->middleware(['permission:homepage'])->only(['hero', 'edit', 'delete']);
    }

    # get the sliders
    private function getSliders()
    {
        $sliders = [];

        if (getSetting('hero_sliders') != null) {
            $sliders = json_decode(getSetting('hero_sliders'));
        }
        return $sliders;
    }

    # homepage hero configuration
    public function hero()
    {
        $sliders = $this->getSliders();
        return view('backend.pages.appearance.homepage.hero', compact('sliders'));
    }

    # store homepage hero configuration
    public function storeHero(Request $request)
    {
        $sliderImage = SystemSetting::where('entity', 'hero_sliders')->first();
        if (!is_null($sliderImage)) {
            if (!is_null($sliderImage->value) && $sliderImage->value != '') {
                $sliders            = json_decode($sliderImage->value);
                $newSlider          = new MediaManager; //temp obj
                $newSlider->id      = rand(100000, 999999);
                $newSlider->sub_title   = $request->sub_title ? $request->sub_title : '';
                $newSlider->title       = $request->title ? $request->title : '';
                $newSlider->text        = $request->text ? $request->text : '';
                $newSlider->image       = $request->image ? $request->image : '';
                $newSlider->link        = $request->link ? $request->link : '';

                array_push($sliders, $newSlider);
                $sliderImage->value = json_encode($sliders);
                $sliderImage->save();
            } else {
                $value                  = [];
                $newSlider              = new MediaManager; //temp obj
                $newSlider->id          = rand(100000, 999999);
                $newSlider->sub_title   = $request->sub_title ? $request->sub_title : '';
                $newSlider->title       = $request->title ? $request->title : '';
                $newSlider->text        = $request->text ? $request->text : '';
                $newSlider->image       = $request->image ? $request->image : '';
                $newSlider->link        = $request->link ? $request->link : '';

                array_push($value, $newSlider);
                $sliderImage->value = json_encode($value);
                $sliderImage->save();
            }
        } else {
            $sliderImage = new SystemSetting;
            $sliderImage->entity = 'hero_sliders';

            $value              = [];
            $newSlider          = new MediaManager; //temp obj
            $newSlider->id      = rand(100000, 999999);
            $newSlider->sub_title   = $request->sub_title ? $request->sub_title : '';
            $newSlider->title       = $request->title ? $request->title : '';
            $newSlider->text        = $request->text ? $request->text : '';
            $newSlider->image       = $request->image ? $request->image : '';
            $newSlider->link        = $request->link ? $request->link : '';

            array_push($value, $newSlider);
            $sliderImage->value = json_encode($value);
            $sliderImage->save();
        }
        cacheClear();
        flash(localize('Slider image added successfully'))->success();
        return back();
    }

    # edit hero slider
    public function edit($id)
    {
        $sliders = $this->getSliders();
        
        return view('backend.pages.appearance.homepage.heroEdit', compact('sliders', 'id'));
    }

    # update hero slider
    public function update(Request $request)
{
    // Recupera la riga che contiene gli slider
    $sliderImage = SystemSetting::where('entity', 'hero_sliders')->first();

    // Decodifica il valore JSON degli slider esistenti
    $sliders = $this->getSliders();
    $tempSliders = [];

    // Cicla tra gli slider per aggiornare quello con l'ID corrispondente
    foreach ($sliders as $slider) {
        if ($slider->id == $request->id) {
            // Aggiorna i campi normali
            $slider->sub_title  = $request->sub_title;
            $slider->title      = $request->title;
            $slider->text       = $request->text;
            $slider->image      = $request->image;
             // Resetta i campi link
             $slider->link = null;
             $slider->product_id = null;
             $slider->category_id = null;
             switch ($request->input('slider_type')) {
                case 'url':
                    $slider->link = $request->input('slider_url');
                    break;
                case 'product':
                    $slider->product_id = $request->input('slider_product_id');
                    break;
                case 'category':
                    $slider->category_id = $request->input('slider_category_id');
                    break;
            }
            // Aggiungi gli stili come JSON per ogni campo
            $slider->sub_title_style = [
                'font_size' => $request->input('sub_title_style.font_size'),
                'is_bold' => $request->input('sub_title_style.is_bold'),
                'tag' => $request->input('sub_title_style.tag'),
                'color' => $request->input('sub_title_style.color'),
                'margin_top' => $request->input('sub_title_style.margin_top'),
                'margin_bottom' => $request->input('sub_title_style.margin_bottom'),
            ];

            $slider->title_style = [
                'font_size' => $request->input('title_style.font_size'),
                'is_bold' => $request->input('title_style.is_bold'),
                'tag' => $request->input('title_style.tag'),
                'color' => $request->input('title_style.color'),
                'margin_top' => $request->input('title_style.margin_top'),
                'margin_bottom' => $request->input('title_style.margin_bottom'),
            ];

            $slider->link_style = [
                'font_size' => $request->input('link_style.font_size'),
                'button_color' => $request->input('link_style.button_color'),
            ];

            // Aggiorna anche i campi del testo e titolo del link
            $slider->link_text = $request->link_text;
            $slider->link_title = $request->link_title;

            // Aggiungi i nuovi campi per lo stile del box di testo
            $slider->box_style = [
                'background_color' => $request->input('box_style.background_color'),
                'gradient_color2' => $request->input('box_style.gradient_color2'),
            ];

            // Aggiungi il dato relativo alla disposizione delle colonne (column_layout)
            $slider->column_layout = $request->input('column_layout');

            array_push($tempSliders, $slider);
        } else {
            // Mantieni gli slider non modificati
            array_push($tempSliders, $slider);
        }
    }

    // Salva il nuovo JSON con gli slider aggiornati
    $sliderImage->value = json_encode($tempSliders);
    $sliderImage->save();

    // Pulisci la cache
    cacheClear();

    flash(localize('Slider updated successfully'))->success();

    return redirect()->route('admin.appearance.homepage.hero');
}



    # delete hero slider
    public function delete($id)
    {
        $sliderImage = SystemSetting::where('entity', 'hero_sliders')->first();

        $sliders = $this->getSliders();
        $tempSliders = [];

        foreach ($sliders as $slider) {
            if ($slider->id != $id) {
                array_push($tempSliders, $slider);
            }
        }

        $sliderImage->value = json_encode($tempSliders);
        $sliderImage->save();

        cacheClear();
        flash(localize('Slider deleted successfully'))->success();
        return redirect()->route('admin.appearance.homepage.hero');
    }
}
