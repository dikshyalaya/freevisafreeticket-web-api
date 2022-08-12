{{--<link rel="stylesheet" href="{{ asset('css/tabs.css') }}">--}}
<?php
use Illuminate\Support\Facades\Route;



$setting_route = 'candidate.';
$RouteName = Route::currentRouteName();
$_editProfile = $RouteName == $setting_route . 'account_setting.index';
$_changePassword = $RouteName == $setting_route . 'account_setting.get_change_password';
$_deleteAccount = $RouteName == $setting_route.'account_setting.get_account_setting';
$_support = $RouteName == $setting_route.'support.index';

$_jobsetting = $RouteName == $setting_route.'job_setting.get_job_alert';

$route = 'candidate.';
$RouteName = Route::currentRouteName();
$_deleteAccount = $RouteName == $route.'account_setting.get_account_setting';
?>
<div class="card mt-3 mb-0">
    <div class="card-body">
        <h3 class="card-title">{{ __( $title ?? 'Settings') }}</h3>
        <div class="settings-tab">
            <ul class="tabs-menu nav">
                <li>
                    <a href="{{ route('candidate.account_setting.get_change_password') }}" class="{{ $_editProfile || $_changePassword ? 'active' : '' }}">
                        <i class="icon icon-user mr-2"></i>{{ __('Account Setting') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('candidate.job_setting.get_job_alert') }}" class="{{ $_jobsetting ? 'active' : '' }}">
                        <i class="icon icon-bubble mr-2"></i>{{ __('Job Alert Setting') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('candidate.account_setting.get_account_setting') }}" class="{{ !$_deleteAccount ?: 'active' }}">
                        <i class="icon icon-ban mr-2"></i>{{ __('Deactivate Account') }}
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>

