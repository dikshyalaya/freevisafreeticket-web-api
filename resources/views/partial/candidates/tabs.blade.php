<link rel="stylesheet" href="{{ asset('css/tabs.css') }}">
<?php
use Illuminate\Support\Facades\Route;
$route = 'candidate.profile.';
$RouteName = Route::currentRouteName();
$_index = $RouteName == $route.'index';
$_edit = ($RouteName ==  $route.'get_personal_information' || $RouteName == $route.'get_contact_information' || $RouteName == $route.'get_qualification'
    || $RouteName == $route.'get_experience' || $RouteName == $route.'get_preview' || $RouteName == $route.'get_save');
$_cv = $RouteName == $route.'get_cv';
?>


@include('themes.fvft.candidates.components.profile.profile-completion',['employee' => $employe])

<div class="card mt-3 mb-0">
    <div class="card-body">
        <h3 class="card-title">{{ __($title ?? 'No Title') }}</h3>
        <div class="settings-tab">
            <ul class="tabs-menu nav">
                <li class="">
                    <a href="{{ route('candidate.profile.index') }}" class="{{ $_index ? 'active' : '' }}"><i class="icon icon-user mr-2"></i>{{ __('My Profile') }}</a>
                </li>
                <li>
                    <a href="{{ route('candidate.profile.get_personal_information') }}" class="{{ $_edit ? 'active' : '' }}"><i class="icon icon-pencil mr-2"></i>{{ __('Edit Profile') }}</a>
                </li>
                <li>
                    <a href="{{ route('candidate.profile.get_cv') }}" class="{{ $_cv ? 'active' : '' }}"><i class="icon icon-event mr-2"></i>{{ __('CV') }}</a>
                </li>
            </ul>
        </div>
    </div>
</div>


