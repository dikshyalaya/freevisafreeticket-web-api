<style>
    .tab-menu-heading {
    border: none;
}
</style>
<?php
use Illuminate\Support\Facades\Route;
$route = 'candidate.';
$RouteName = Route::currentRouteName();
$_preferJob = $RouteName == $route . 'job_setting.index';
$_jobalert = $RouteName == $route . 'job_setting.get_job_alert';
?>
<div class="tab-menu-heading">
    <div class="tabs-menu ">
        <!-- Tabs -->
        <ul class="nav panel-tabs">
            {{-- <li class=""><a href="{{ route('candidate.job_setting.index') }}" class="{{ !$_preferJob ?: 'active' }}">{{ strtoupper(__('Preferred Job')) }}</a></li> --}}
            <li><a href="{{ route('candidate.job_setting.get_job_alert') }}" class="{{ !$_jobalert ?: 'active' }}">{{ strtoupper(__('Job Alert')) }}</a></li>
        </ul>
    </div>
</div>