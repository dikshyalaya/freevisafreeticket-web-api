<link rel="stylesheet" href="{{ asset('css/tabs.css') }}">
<?php
use Illuminate\Support\Facades\Route;
$route = 'company.';
$RouteName = Route::currentRouteName();
$_index = $RouteName == $route . 'jobs';
$_edit = $RouteName == $route . 'newjob.get_job_detail';
?>

<div class="settings-tab">
    <ul class="tabs-menu nav">
        <li class="">
            <a href="{{ route('company.jobs') }}" class="{{ $_index ? 'active' : '' }}"><i class="icon icon-speedometer"></i> {{ __('Job Status') }}</a>
        </li>
        <li>
            <a href="{{ route('company.newjob.get_job_detail') }}" class="{{ $_edit ? 'active' : '' }}"><i class="icon icon-bubble"></i>  {{ __('Post New Job') }}</a>
        </li>
        {{--<li><a href="#tab3" data-toggle="tab" class=""><i class="icon icon-settings"></i>  Advanced</a></li>--}}
    </ul>
</div>
