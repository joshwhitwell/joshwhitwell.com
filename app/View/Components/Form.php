<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Form extends Component
{
    public string $id = '';

    public string $action = '';

    public string $method = '';

    public bool $useCsrf = true;

    public string $methodSpoof = '';

    /**
     * Create a new component instance.
     */
    public function __construct(string $id = '', string $action = '', string $method = 'post')
    {
        $this->id = $id;
        $this->action = $action;
        $this->method = $method === 'get' ? $method : 'post';
        $this->useCsrf = $method !== 'get';
        $this->methodSpoof = !in_array($method, ['get', 'post']) ? $method : '';
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.form');
    }
}
