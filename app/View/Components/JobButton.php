<?php

namespace App\View\Components;

use Illuminate\View\Component;

class JobButton extends Component
{
    public $job;

    public $employ;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($job, $employ = null)
    {
        $this->job = $job;
        $this->employ = $employ;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.job-button');
    }
}
