<link rel="stylesheet" href="{{ asset('css/tabs.css') }}">
<?php 
use Illuminate\Support\Facades\Route;
$route = 'candidate.news.';
$RouteName = Route::currentRouteName();
$_index = ($RouteName == $route.'index' || $RouteName == $route.'detail');
?>
<ul class="nav nav-tabs nav-justified navtab-wizard tabItems bg-muted"
    style="border-bottom: 0px solid #e8ebf3 !important; ">
    <li class="nav-item {{ $_index ? 'active' : '' }}"><a href="{{ route('candidate.news.index') }}" class="nav-link font-bold">{{ __('News') }}</a>
    </li>
    <li class="nav-item"><a href="#tab4" class="nav-link font-bold"></a></li>
</ul>
