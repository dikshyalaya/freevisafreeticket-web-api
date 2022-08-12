<style>
    .tab-menu-heading {
    border: none;
}
</style>
<?php
use Illuminate\Support\Facades\Route;
$route = 'candidate.';
$RouteName = Route::currentRouteName();
$_editProfile = $RouteName == $route . 'account_setting.index';
$_changePassword = $RouteName == $route . 'account_setting.get_change_password';
$_deleteAccount = $RouteName == $route.'account_setting.get_account_setting';
?>
<div class="tab-menu-heading">
    <div class="tabs-menu ">
        <!-- Tabs -->
        <ul class="nav panel-tabs">
            {{-- <li class=""><a href="{{ route('candidate.account_setting.index') }}" class="{{ !$_editProfile ?: 'active' }}">{{ strtoupper(__('Edit Profile')) }}</a></li> --}}
            <li><a href="{{ route('candidate.account_setting.get_change_password') }}" class="{{ !$_changePassword ?: 'active' }}">{{ strtoupper(__('Change Password')) }}</a></li>
            <li><a href="{{ route('candidate.account_setting.get_account_setting') }}" class="{{ !$_deleteAccount ?: 'active' }}">{{ strtoupper(__('Deactivate My Account')) }}</a></li>
        </ul>
    </div>
</div>