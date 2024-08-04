<?php

namespace App\View\Components;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class Blobs extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct() {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $colors = collect(config('colors'))->except('color-neutral-100');
        $with = [];

        for ($i = 1; $i <= 3; $i++) {
            $color = $colors->shuffle()->pop();
            $key = $colors->search($color);
            [$r,$g,$b] = sscanf($color, "#%02x%02x%02x");
            $with["color".$i] = 'vec3('.($r / 255).','.($g / 255).','.($b / 255).')';
        }

        return view('components.blobs', $with);
    }
}
