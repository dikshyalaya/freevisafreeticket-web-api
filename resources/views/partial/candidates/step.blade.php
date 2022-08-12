<?php
use Illuminate\Support\Facades\Route;
$route = 'candidate.profile.';
$RouteName = Route::currentRouteName();
$_1st = $RouteName == $route.'get_personal_information';
$_2nd = $RouteName == $route.'get_contact_information';
$_3rd = $RouteName == $route.'get_qualification';
$_4th = $RouteName == $route.'get_experience';
$_5th = $RouteName == $route.'get_preferred_jobs';
$_6th = $RouteName == $route.'get_preview';
$_7th = $RouteName == $route.'get_save';
// dd($RouteName);
// dd($_5th);
?>

{{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pixeden-stroke-7-icon@1.2.3/pe-icon-7-stroke/dist/pe-icon-7-stroke.min.css"> --}}
<div style="width: 100%;" class="steps d-flex flex-wrap flex-sm-nowrap justify-content-between padding-top-2x padding-bottom-1x mt-5">
            <div
                class="step {{ $_1st  ? 'active' : '' }} {{ $_2nd || $_3rd || $_4th || $_5th || $_6th || $_7th ? 'completed' : '' }}">
                <div class="step-icon-wrap">
                    <div class="step-icon">1</div>
                </div>
                <h4 class="step-title">
                    <a href="{{ route('candidate.profile.get_personal_information') }}">
                        {{ strtoupper(__('Personal Information')) }}
                    </a>
                </h4>
            </div>
            <div class="step {{ $_2nd ? 'active' : '' }} {{ $_3rd || $_4th || $_5th || $_6th || $_7th ? 'completed' : '' }}">
                <div class="step-icon-wrap">
                    <div class="step-icon">2</div>
                </div>
                <h4 class="step-title">
                    <a href="{{ route('candidate.profile.get_contact_information') }}">
                        {{ strtoupper(__('Contact Information')) }}
                    </a>
                </h4>
            </div>
            <div class="step {{ $_3rd ? 'active' : '' }} {{ $_4th || $_5th || $_6th || $_7th ? 'completed' : '' }}">
                <div class="step-icon-wrap">
                    <div class="step-icon">3</div>
                </div>
                <h4 class="step-title">
                    <a href="{{ route('candidate.profile.get_qualification') }}">
                        {{ strtoupper(__('Qualification')) }}
                    </a>
                </h4>
            </div>
            <div class="step {{ $_4th ? 'active' : '' }} {{ $_5th || $_6th || $_7th ? 'completed' : '' }}">
                <div class="step-icon-wrap">
                    <div class="step-icon">4</div>
                </div>
                <h4 class="step-title">
                    <a href="{{ route('candidate.profile.get_experience') }}">
                        {{ strtoupper(__('Experience')) }}
                    </a>
                </h4>
            </div>
            <div class="step {{ $_5th ? 'active' : '' }} {{ $_6th || $_7th ? 'completed' : '' }}">
                <div class="step-icon-wrap">
                    <div class="step-icon">5</div>
                </div>
                <h4 class="step-title">
                    <a href="{{ route('candidate.profile.get_preferred_jobs') }}">
                        {{ strtoupper(__('Preferred Jobs')) }}
                    </a>
                </h4>
            </div>
            <div class="step {{ $_6th ? 'active' : '' }} {{ $_7th ? 'completed' : '' }}">
                <div class="step-icon-wrap">
                    <div class="step-icon">6</div>
                </div>
                <h4 class="step-title">
                    <a href="{{ route('candidate.profile.get_preview') }}">
                        {{ strtoupper(__('Preview')) }}
                    </a>
                </h4>
            </div>
            {{-- <div class="step {{ $_7th ? 'active' : '' }}"> //don't remove
                <div class="step-icon-wrap">
                    <div class="step-icon">7</div>
                </div>
                <h4 class="step-title">{{ strtoupper(__('Save')) }}</h4>
            </div> --}}
        </div>

