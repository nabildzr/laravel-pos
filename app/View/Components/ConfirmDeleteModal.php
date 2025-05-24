<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ConfirmDeleteModal extends Component
{
    public $modalId;
    public $route;

    /**
     * Create a new component instance.
     */
    public function __construct($modalId, $route)
    {
        $this->modalId = $modalId;
        $this->route = $route;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.confirm-delete-modal');
    }
}
