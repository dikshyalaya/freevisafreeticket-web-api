<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ApplicationManagement extends Component
{
    public $applicants;
    public $totalApplicant;
    public $application_datas;
    public $sn;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($applicants, $totalApplicant, $application_datas, $sn)
    {
        $this->applicants = $applicants;
        $this->totalApplicant = $totalApplicant;
        $this->application_datas = $application_datas;
        $this->sn = $sn;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.application-management');
    }
}
