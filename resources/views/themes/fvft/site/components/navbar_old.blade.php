<nav class="horizontalMenu clearfix d-md-flex">
    <ul class="horizontalMenu-list">
        @foreach ($primary_menu as $item)
            <li><a href="{{$item->link}}">{{__($item->title)}}</a></li>
        @endforeach
        @auth
            <li><a href="#">{{ __('My Dashboard') }} <span class="fa fa-caret-down m-0"></span></a>
                <ul class="sub-menu">
                    @if(auth()->user()->user_type=='candidate')
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
                            <a href="{{ route('candidate.account_setting.get_change_password') }}">{{ __('Settings') }}</a>
                        </li>
                    @elseif(auth()->user()->user_type=='company')
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
                            <a href="/company/applicants">{{ __('Applicants') }}</a>
                        </li>

                        <li>
                            <a href="/company/settings">{{ __('Settings') }}</a>
                        </li>
                    @elseif(auth()->user()->user_type=='admin')
                        <li>
                            <a href="/admin/">{{ __('My Dashboard') }}</a>
                        </li>
                    @endif
                    <li>
                        <form action="/logout" method="post">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm text-white btn-block">
                                <span class="icon1 " style="background: #ffffff00;color: #f3f6ff;"><i class="typcn typcn-power-outline fs-20"></i></span> {{ __('Logout') }}
                            </button>
                        </form>
                    </li>
                </ul>
            </li>
        @else
            <li class="mt-0 pt-0 pb-5 mt-lg-0 create-resume-btn">
                <span><a class="btn btn-info ad-post mt-1" href="{{ route('company.login') }}"><i class="fa fa-users"></i> {{ __('For Employer') }}</a></span>
            </li>
        @endauth
    </ul>
</nav>
