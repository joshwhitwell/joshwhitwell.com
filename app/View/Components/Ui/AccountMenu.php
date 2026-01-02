<?php

namespace App\View\Components\Ui;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class AccountMenu extends Component
{
    public array $links = [];

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        if (Auth::check()) {
            $this->links = [
                'admin' => 'Admin',
                'welcome' => 'Welcome',
                'logout' => 'Log out',
            ];
        } else {
            $this->links = [
                'login' => 'Log in',
            ];
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.ui.account-menu');
    }

    /**
     * Whether the component should be rendered
     */
    public function shouldRender(): bool
    {
        return !request()->routeIs('login');
    }
}
