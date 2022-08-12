<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ __('My Dashboard') }} </h3>
    </div>

    <div class="card-body text-center item-user border-bottom">
        <div class="profile-pic">
            <div class="profile-pic-img">
                {{--<span class="bg-success dots" data-toggle="tooltip" data-placement="top" title="" data-original-title="online"></span>--}}
                @if($company AND !blank($company->company_logo))
                    <img src="{{ asset($company->company_logo) }}" class="brround" alt="user">
                    @else
                    <img src="{{ asset('/uploads/site/logo-min.png') }}" class="logo" alt="user" >
                @endif
            </div>
            <a href="#" class="text-dark"><h4 class="mt-3 mb-0 font-weight-bold">{{ $company->company_name ?? ''}}</h4></a>
        </div>
    </div>
    <div class="item1-links  mb-0">
        <a href="{{ route('company.dash') }}" class="@yield('dashboard') d-flex border-bottom">
            <span class="icon1 mr-2"><i class="typcn typcn-home fs-20"></i></span> {{ __('Dashboard') }}
        </a>
        <a href="{{ route('company.view_profile') }}" class="@yield('edit_profile') d-flex border-bottom">
            <span class="icon1 mr-2"><i class="typcn typcn-edit fs-20"></i></span> {{ __('Profile') }}
        </a>
        <a href="{{ route('company.jobs') }}" class="@yield('jobs') d-flex border-bottom">
            <span class="icon1 mr-2"><i class="typcn typcn-briefcase fs-20"></i></span> {{ __('My Jobs') }}
        </a>

        <a href="{{ route('company.applicant.indexpage') }}" class="@yield('applicants') d-flex border-bottom">
            <span class="icon1 mr-2"><i class="typcn typcn-heart-outline fs-20"></i></span> {{ __('Applicants') }}
        </a>

        <a href="{{ route('company.settings') }}" class="@yield('setting') d-flex border-bottom">
            <span class="icon1 mr-2"><i class="typcn typcn-cog-outline fs-20"></i></span> {{ __('Settings') }}
        </a>
        <form action="/logout" method="post">
            @csrf
            <button type="submit" class="btn btn-secondary btn-block ">
                <span class="icon1 mr-2" style="background: #ffffff00;color: #f3f6ff;"><i class="typcn typcn-power-outline fs-20"></i></span> {{ __('Logout') }}
            </button>
        </form>
    </div>
</div>
