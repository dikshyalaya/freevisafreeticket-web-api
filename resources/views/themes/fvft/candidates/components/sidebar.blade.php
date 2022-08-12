<style>
    .profile-pic-img span {
        position: absolute;
        width: 4rem;
        height: 1rem;
        right: -30px;
        top: -2.5rem;
        border: 2px solid #fff;
        font-size: 50px;
    }

</style>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ __('My Dashboard') }}</h3>
    </div>
    <div class="card-body text-center item-user border-bottom">
        <div class="profile-pic">
            <div class="profile-pic-img">
                <span><i class="fa fa-pencil" style="color: blue; cursor:pointer;" onclick="changeCandidateProfile()"></i></span>
                <input type="file" id="CandidateProfileImage" style="display: none">
                {{-- <span class="bg-success dots" data-toggle="tooltip" data-placement="top" title="" data-original-title="online"></span> --}}
                <img onclick="changeCandidateProfile()" src="{{ asset($employe->avatar ?? 'uploads/defaultimage.jpg') }}" class="brround"
                    alt="user" style="width: 100%;height: 100%; cursor:pointer;" id="candidateImageSrc">
            </div>
            <a href="{{ route('candidate.profile.index') }}" class="text-dark">
                <h4 class="mt-3 mb-0 font-weight-semibold">{{ $employe->first_name }} {{ $employe->middle_name }}
                    {{ $employe->last_name }}</h4>
            </a>
        </div>
    </div>
    <div class="item1-links  mb-0">
        <a href="{{ route('candidate.dashboard') }}"
            class="@if (Route::currentRouteName() == 'candidate.dashboard') active @endif   d-flex  border-bottom">
            <span class="icon1 mr-2"><i class="typcn typcn-briefcase fs-20"></i></span> {{ __('Dashboard') }}
        </a>
        <a href="{{ route('candidate.profile.index') }}"
            class="@if (Route::currentRouteName() == 'candidate.profile.index') active @endif d-flex border-bottom">
            <span class="icon1 mr-2"><i class="typcn typcn-edit fs-20"></i></span> {{ __('Profile') }}
        </a>
        <a href="{{ route('candidate.job_search.index', ['type' => 'all']) }}"
            class="@if (Route::currentRouteName() == 'candidate.job_search.index') active @endif   d-flex  border-bottom">
            <span class="icon1 mr-2"><i class="typcn typcn-briefcase fs-20"></i></span> {{ __('Jobs Search') }}
        </a>
        <a href="{{ route('candidate.job_application.index') }}"
            class="@if (Route::currentRouteName() == 'candidate.job_application.index') active @endif   d-flex  border-bottom">
            <span class="icon1 mr-2"><i class="typcn typcn-briefcase fs-20"></i></span>
            {{ __('My Job Applications') }}
        </a>
        <a href="{{ route('candidate.company_lists') }}"
            class="@if (Route::currentRouteName() == 'candidate.company_lists') active @endif   d-flex  border-bottom">
            <span class="icon1 mr-2"><i class="typcn typcn-briefcase fs-20"></i></span> {{ __('Companies') }}
        </a>
        <a href="{{ route('candidate.news.index') }}"
            class="@if (Route::currentRouteName() == 'candidate.news.index' || Route::currentRouteName() == 'candidate.news.detail') active @endif   d-flex  border-bottom">
            <span class="icon1 mr-2"><i class="typcn typcn-briefcase fs-20"></i></span> {{ __('News') }}
        </a>
        <a href="{{ route('candidate.usefulinfo.index') }}"
            class="@if (Route::currentRouteName() == 'candidate.usefulinfo.index' || Route::currentRouteName() == 'candidate.usefulinfo.detail') active @endif   d-flex  border-bottom">
            <span class="icon1 mr-2"><i class="typcn typcn-briefcase fs-20"></i></span> {{ __('Informations') }}
        </a>
        <a href="{{ route('candidate.savedjob.saveJobLists') }}"
            class="@if (Route::currentRouteName() == 'candidate.savedjob.saveJobLists') active @endif   d-flex  border-bottom">
            <span class="icon1 mr-2"><i class="typcn typcn-briefcase fs-20"></i></span> {{ __('Saved Jobs') }}
        </a>
        {{-- <a href="{{ route('candidate.recommended_job') }}" class="@if (Route::currentRouteName() == 'candidate.recommended_job') active @endif   d-flex  border-bottom">
            <span class="icon1 mr-2"><i class="typcn typcn-briefcase fs-20"></i></span> {{ __('Recommended Jobs') }}
        </a> --}}
        {{-- <a href="/pages/tips" class="d-flex border-bottom">
            <span class="icon1 mr-2"><i class="typcn typcn-flag-outline fs-20"></i></span> Safety Tips
        </a> --}}
        {{-- <a href="/candidate/job-preferences" class="@if (Route::currentRouteName() == 'candidate.job-preferences') active @endif  d-flex border-bottom">
            <span class="icon1 mr-2"><i class="typcn typcn-cog-outline fs-20"></i></span> Job Preferences
        </a> --}}
        <a href="{{ route('candidate.account_setting.get_change_password') }}"
            class="@if (Route::currentRouteName() == 'candidate.account_setting.get_change_password') active @endif  d-flex border-bottom">
            <span class="icon1 mr-2"><i class="typcn typcn-cog-outline fs-20"></i></span> {{ __('Settings') }}
        </a>
        {{-- <a href="{{ route('candidate.support.support') }}" class="@if (Route::currentRouteName() == 'candidate.support.support') active @endif  d-flex border-bottom"> --}}
        {{-- <span class="icon1 mr-2"><i class="typcn typcn-cog-outline fs-20"></i></span> {{ __('Support') }} --}}
        {{-- </a> --}}
        <form action="{{ route('logout') }}" method="post">
            @csrf
            <button type="submit" class="btn btn-secondary btn-block">
                <span class="icon1 mr-2" style="background: #ffffff00;color: #f3f6ff;"><i
                        class="typcn typcn-power-outline fs-20"></i></span> {{ __('Logout') }}
            </button>
        </form>
    </div>
</div>
