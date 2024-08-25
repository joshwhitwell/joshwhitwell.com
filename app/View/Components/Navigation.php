<?php

namespace App\View\Components;

use Closure;
use Illuminate\Support\Arr;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class Navigation extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public array $navItems = []
    ) {
        $navItems = Arr::sort([
            ['href' => route('joshwhitwell'), 'text' => 'Josh Whitwell'],
            ['href' => route('me'), 'text' => 'Me'],
            ['href' => route('my.writings.index'), 'text' => 'Writings'],
            ['href' => route('my.sources.index'), 'text' => 'Sources'],
        ], fn ($e) => $e['text']);
        $navItems[] = ['action' => route('logout'), 'text' => 'Log Out'];
        $this->navItems = $navItems;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.navigation');
    }
}
