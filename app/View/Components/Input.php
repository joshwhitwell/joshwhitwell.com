<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Input extends Component
{
    public string $id = '';

    public string $name = '';

    public string $type = '';

    public bool $autofocus = false;

    public string $autocomplete = '';

    public bool $required = false;

    public string $label = '';

    public string $helpText = '';

    public string $errorMessage = '';

    public bool $data1pIgnore = true;

    public mixed $value = null;

    /**
     * Create a new component instance.
     */
    public function __construct(
        string $id = '',
        string $name = '',
        string $type = 'text',
        bool $autofocus = false,
        string $autocomplete = 'off',
        bool $required = false,
        string $label = '',
        string $helpText = '',
        string $errorMessage = '',
        bool $data1pIgnore = true,
        mixed $value = null,
    ) {
        $this->id = $id ?: $name;
        $this->name = $name;
        $this->type = $type;
        $this->autofocus = (bool) $autofocus;
        $this->autocomplete = $autocomplete;
        $this->required = (bool) $required;
        $this->label = $label;
        $this->helpText = $helpText;
        $this->errorMessage = $errorMessage ?: (session()->has('errors') ? session()->get('errors')->first($name) : '');
        $this->data1pIgnore = $data1pIgnore;
        $this->value = isset($value) ? $value : old($name, $value);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.input');
    }
}
