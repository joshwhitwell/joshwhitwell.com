<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Input extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $id = '',
        public string $name = '',
        public string $type = 'text',
        public string $label = '',
        public string $helpText = '',
        public mixed $value = null,
        public string $placeholder = '',
        public string $autocomplete = '',
        public bool $checked = false,
        public bool $required = false,
        public bool $disabled = false,
        public bool $autofocus = false,
    )
    {
        $this->id = $id ?: $name;

        if ($this->type !== 'checkbox') {
            $this->checked = false;
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.input');
    }
}
