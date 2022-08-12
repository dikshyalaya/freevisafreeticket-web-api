<style>
    .horizontalMenu {
        color: #fff;
        font-size: 14px;
        padding: 20px 0px 20px 48px;
        padding-bottom: 0;
        display: block;
        float: none;
    }

    .horizontalMenu-list.rightList {
        width: auto !important;

    }


    @media only screen and (max-width: 991px) {
        .horizontalMenu>.horizontalMenu-list {
            height: auto;
            min-height: auto !important;
            width: 240px;
            background: #fff;
            padding-bottom: 0;
            margin-left: -240px;
            display: block;
            text-align: center;
        }
    }

</style>
<nav class="horizontalMenu clearfix d-md-flex">
    <ul class="horizontalMenu-list">
        @foreach ($primary_menu as $item)
            <li><a href="{{ $item->link }}">{{ __($item->title) }}</a></li>
            @if($item->title == 'Companies' AND auth()->check() AND auth()->user()->user_type == 'candidate')
                <li>
                    <a href="{{ route('candidate.usefulinfo.index') }}">{{ __('Information') }}</a>
                </li>
            @endif
            @continue
        @endforeach
        {{-- @auth
            @if (auth()->user()->user_type == 'candidate')
                <li><a href="#">{{ __('Useful Information') }}</a></li>
            @endif
        @endauth --}}
    </ul>
    <ul class="horizontalMenu-list ml-auto rightList d-lg-flex">
        <li class="mt-0 pt-0 pb-5 mt-lg-0 ml-lg-3">
            <span><a class="btn btn-success rounded-0 mt-1"
                    href="{{ !blank($google_play_link) ? $google_play_link : '#' }}"
                    target="{{ !blank($google_play_link) ? '_blank' : '' }}">
                    {{ __('Download App') }}</a></span>
        </li>
        @auth
            <li class="mt-0 pt-0 ml-lg-3 pb-5 mt-lg-0"><span><a href="#"
                        class="btn btn-primary rounded-0 mt-1">{{ __('My Dashboard') }} <span
                            class="fa fa-caret-down m-0"></span></a> </span>
                <ul class="sub-menu">
                    @if (auth()->user()->user_type == 'candidate')
                        <li>
                            <a href="/candidate/">{{ __('My Dashboard') }}</a>
                        </li>
                        <li>
                            <a href="{{ route('candidate.profile.index') }}">{{ __('Profile') }}</a>
                        </li>
                        <li>
                            <a href="{{ route('candidate.job_application.index') }}">{{ __('My Jobs') }}</a>
                        </li>
                        <li>
                            <a
                                href="{{ route('candidate.account_setting.get_change_password') }}">{{ __('Settings') }}</a>
                        </li>
                    @elseif(auth()->user()->user_type == 'company')
                        <li>
                            <a href="/company/">{{ __('My Dashboard') }}</a>
                        </li>
                        <li>
                            <a href="/company/profile">{{ __('Edit Profile') }}</a>
                        </li>
                        <li>
                            <a href="/company/jobs">{{ __('My Jobs') }}</a>
                        </li>
                        <li>
                            <a href="{{ route('company.applicant.indexpage') }}">{{ __('Applicants') }}</a>
                        </li>

                        <li>
                            <a href="/company/settings">{{ __('Settings') }}</a>
                        </li>
                    @elseif(auth()->user()->user_type == 'admin')
                        <li>
                            <a href="/admin/">{{ __('My Dashboard') }}</a>
                        </li>
                    @endif
                    <li>
                        <form action="/logout" method="post">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm text-white btn-block">
                                <span class="icon1 " style="background: #ffffff00;color: #f3f6ff;"><i
                                        class="typcn typcn-power-outline fs-20"></i></span> {{ __('Logout') }}
                            </button>
                        </form>
                    </li>
                </ul>
            </li>
        @else
            {{-- <li class="mt-0 pt-0 pb-5 mt-lg-0 ml-lg-3">
                <span><a class="btn btn-outline-primary rounded-0 mt-1"
                        href="{{ route('candidate.login', ['name' => 'login']) }}">{{ __('Login') }}</a></span>
            </li>
            <li class="mt-0 pt-0 pb-5 mt-lg-0 ml-lg-3">
                <span><a class="btn btn-outline-primary rounded-0 mt-1"
                        href="{{ route('candidate.login', ['name' => 'register']) }}">{{ __('Sign Up') }}</a></span>
            </li> --}}
            <li class="mt-0 pt-0 pb-5 mt-lg-0 ml-lg-3">
                <span><a class="btn btn-info rounded-0  mt-1" href="{{ route('candidate.login') }}"><i
                            class="fa fa-users"></i>
                        {{ __('For Candidate') }}</a></span>
            </li>
            <li class="mt-0 pt-0 pb-5 mt-lg-0 ml-lg-3">
                <span><a class="btn btn-info rounded-0  mt-1" href="{{ route('company.login') }}"><i
                            class="fa fa-users"></i>
                        {{ __('For Employer') }}</a></span>
            </li>
        @endauth
        <li class="mt-0 pt-0 pb-5 mt-lg-0 ml-lg-3">
            <span>
                <a class="btn btn-danger rounded-0  mt-1"
                    href="{{ url('lang/' . ($current_locale == 'en' ? 'np' : 'en')) }}">
                    {{ $current_locale == 'en' ? 'नेपाली' : 'English' }}
                </a>
            </span>
        </li>
        {{-- <li class="mt-0 pt-0 ml-lg-3 pb-5 mt-lg-0"><span><a href="#"
                    class="btn btn-primary rounded-0 mt-1">{{ in_array($current_locale, array_keys($available_locales)) ? __($available_locales[$current_locale]) : __('English') }}
                    <span class="fa fa-caret-down m-0"></span></a> </span>
            <ul class="sub-menu">
                @if (in_array($current_locale, array_keys($available_locales)))
                    <li>
                        <a href="{{ url('lang/' . $current_locale) }}">
                            {{ $available_locales[$current_locale] }}
                        </a>
                    </li>
                    @foreach ($available_locales as $key => $value)
                        @if ($current_locale != $key)
                            <li>
                                <a href="{{ url('lang/' . $key) }}">
                                    {{ $value }}
                                </a>
                            </li>
                        @endif
                    @endforeach
                @else
                    @foreach ($available_locales as $key => $value)
                    <li>
                        <a href="{{ url('lang/' . $key) }}">
                            {{ $value }}
                        </a>
                    </li>
                    @endforeach
                @endif
            </ul>
        </li> --}}
    </ul>
    {{-- <ul class="horizontalMenu-list d-lg-flex">


    </ul> --}}
</nav>
