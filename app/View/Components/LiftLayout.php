<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class LiftLayout extends Component
{
    /**
     * Create the component instance.
     */
    public function __construct(
        public mixed $title = null,
    ) {
        $parts = array_merge(
            is_array($title) ? $title : [$title],
            ['Lift', config('app.name')],
        );
        
        $this->title = implode(' | ', $parts);
    }

    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        return view('layouts.lift');
    }
}
