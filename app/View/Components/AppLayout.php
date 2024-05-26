<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class AppLayout extends Component
{
    /**
     * Create the component instance.
     */
    public function __construct(
        public mixed $title = null,
    ) {
        if (is_array($title)) {
            $title = array_merge($title, [config('app.name')]);
            $this->title = implode(' | ', $title);
        } elseif ($title) {
            $this->title = $title . ' | ' . config('app.name');
        } else {
            $this->title = config('app.name');
        }
    }

    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        return view('layouts.app');
    }
}
