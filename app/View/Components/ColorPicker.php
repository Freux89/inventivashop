<?php
namespace App\View\Components;

use Illuminate\View\Component;

class ColorPicker extends Component
{
    public $id;
    public $name;
    public $value;
    public $label;
    public $defaultColors;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($id, $name, $value = '#105862', $label = 'Scegli un colore:')
    {
        $this->id = $id;
        $this->name = $name;
        $this->value = $value;
        $this->label = $label;

        // Definisci i colori predefiniti qui
        $this->defaultColors = [
            '#C9AC20', '#4E838E', '#289BB1', '#801854',
            '#D4F3F9', '#EAEAEA', '#DADADA', '#FFF2CE',
            '#98C0C6', '#9BA3A4', '#DAD0A6', '#9A7785', '#e7eeef',
            '#580830', '#a18110', '#105862', '#007480',
            '#404647', '#f4f8f8', '#ffffff', '#000000'
        ];
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.color-picker');
    }
}

