<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar doc-sidebar ps ps--active-y">
    <div class="app-sidebar__user clearfix">
        <div class="dropdown user-pro-body">
            <div>
                @if (!blank($user['profile']))
                    <img src="{{ asset('/') }}{{ $user['profile'] }}" alt="user-img"
                        class="avatar avatar-lg brround">
                @else
                    <img src="{{ asset('/defaults/profile.png') }}" alt="profile-img" class="avatar avatar-md brround">
                @endif
                <a href="{{ route('admin.user.profile') }}" class="profile-img">
                    <span class="fa fa-pencil" aria-hidden="true"></span>
                </a>
            </div>
            <div class="user-info">
                <h2>{{ $user['name'] }}</h2>
                <span>Admin</span>
            </div>
        </div>
    </div>
    <ul class="side-menu">
        <li class="slide is-expanded">
            <a class="side-menu__item active" data-toggle="slide" onclick="window.location.href = '{{ route('admin.dashboard') }}'" href="#"><i
                    class="side-menu__icon fa fa-tachometer"></i><span class="side-menu__label">Dashboard</span></a>
        </li>
        <li class="slide">
            <span class="side-menu__item">
                <span class="side-menu__label">MODULES</span>
            </span>
        </li>
        <li class="slide">
            <a class="side-menu__item" data-toggle="slide" href="#">
                <i class="side-menu__icon fa fa-cogs"></i><span class="side-menu__label">Jobs</span><i
                    class="angle fa fa-angle-right"></i></a>
            <ul class="slide-menu">
                <li><a class="slide-item" href="/admin/jobs-list">All Jobs</a></li>
                <li><a class="slide-item" href="{{ route('admin.addNewJob') }}">Add Job</a></li>
            </ul>
        </li>
        <li class="slide">
            <a class="side-menu__item" data-toggle="slide" href="#">
                <i class="side-menu__icon fa fa-cogs"></i><span class="side-menu__label">Companies</span><i
                    class="angle fa fa-angle-right"></i></a>
            <ul class="slide-menu">
                <li><a class="slide-item" href="/admin/companies/">List Companies</a></li>
                <li><a class="slide-item" href="{{ route('admin.companies.create') }}">Add Company</a></li>
            </ul>
        </li>
        <li class="slide">
            <a class="side-menu__item" data-toggle="slide" href="#">
                <i class="side-menu__icon fa fa-cogs"></i><span class="side-menu__label">Candidates</span><i
                    class="angle fa fa-angle-right"></i></a>
            <ul class="slide-menu">
                <li><a class="slide-item" href="/admin/candidates/">List Candidates</a></li>
                <li><a class="slide-item" href="{{ route('admin.candidates.create') }}">Add Candidate</a></li>
            </ul>
        </li>
        <li class="slide">
            <a class="side-menu__item" data-toggle="slide" href="#">
                <i class="side-menu__icon fa fa-cogs"></i><span class="side-menu__label">Applicants</span><i
                    class="angle fa fa-angle-right"></i></a>
            <ul class="slide-menu">
                {{-- <li><a class="slide-item" href="/admin/applicants/">List Applicants</a></li> --}}
                <li><a class="slide-item" href="{{ route('admin.applicant.indexpage') }}">Application Management</a></li>
                {{-- <li><a class="slide-item" href="/admin/applicants/new">Add Applicants</a></li> --}}
            </ul>
        </li>
        <li class="slide">
            <a class="side-menu__item" data-toggle="slide" href="#">
                <i class="side-menu__icon fa fa-cogs"></i><span class="side-menu__label">Pages</span><i
                    class="angle fa fa-angle-right"></i></a>
            <ul class="slide-menu">
                <li><a class="slide-item" href="/admin/pages/">List Pages</a></li>
                <li><a class="slide-item" href="/admin/pages/new">Add Page</a></li>
            </ul>
        </li>
        <li class="slide">
            <a class="side-menu__item" data-toggle="slide" href="#">
                <i class="side-menu__icon fa fa-cogs"></i><span class="side-menu__label">News</span><i
                    class="angle fa fa-angle-right"></i></a>
            <ul class="slide-menu">
                <li><a class="slide-item" href="/admin/news/">List News</a></li>
                <li><a class="slide-item" href="/admin/news/new">Add New</a></li>
            </ul>
        </li>
        <li class="slide">
            <a class="side-menu__item" data-toggle="slide" href="#">
                <i class="side-menu__icon fa fa-cogs"></i><span class="side-menu__label">Useful Informations</span><i
                    class="angle fa fa-angle-right"></i></a>
            <ul class="slide-menu">
                <li><a class="slide-item" href="{{ route('admin.usefulinfo.index') }}">List Information</a></li>
                <li><a class="slide-item" href="{{ route('admin.usefulinfo.create') }}">Add New</a></li>
            </ul>
        </li>
        <li class="slide">
            <a class="side-menu__item" data-toggle="slide" href="#">
                <i class="side-menu__icon fa fa-cogs"></i><span class="side-menu__label">Job Categories</span><i
                    class="angle fa fa-angle-right"></i></a>
            <ul class="slide-menu">
                <li><a class="slide-item" href="{{ route('admin.job_category.index') }}">List Job Categories</a></li>
                <li><a class="slide-item" href="{{ route('admin.job_category.create') }}">Add New</a></li>
            </ul>
        </li>
        <li class="slide">
            <a class="side-menu__item" data-toggle="slide" href="#">
                <i class="side-menu__icon fa fa-cogs"></i><span class="side-menu__label">Industry</span><i
                    class="angle fa fa-angle-right"></i></a>
            <ul class="slide-menu">
                <li><a class="slide-item" href="{{ route('admin.industry.index') }}">List Industries</a></li>
                <li><a class="slide-item" href="{{ route('admin.industry.create') }}">Add New</a></li>
            </ul>
        </li>
        <li class="slide">
            <a class="side-menu__item" data-toggle="slide" href="#">
                <i class="side-menu__icon fa fa-cogs"></i><span class="side-menu__label">Training</span><i
                    class="angle fa fa-angle-right"></i></a>
            <ul class="slide-menu">
                <li><a class="slide-item" href="{{ route('admin.training.index') }}">List Trainings</a></li>
                <li><a class="slide-item" href="{{ route('admin.training.create') }}">Add New</a></li>
            </ul>
        </li>
        <li class="slide">
            <a class="side-menu__item" data-toggle="slide" href="#">
                <i class="side-menu__icon fa fa-cogs"></i><span class="side-menu__label">Address</span><i
                    class="angle fa fa-angle-right"></i></a>
            <ul class="slide-menu">
                <li><a class="slide-item" href="{{ route('admin.country.index') }}">All Countries</a></li>
                <li><a class="slide-item" href="{{ route('admin.state.index') }}">All States</a></li>
                <li><a class="slide-item" href="{{ route('admin.city.index') }}">All Cities</a></li>
                <li><a class="slide-item" href="{{ route('admin.district.index') }}">All Districts</a></li>
            </ul>
        </li>
        <li class="slide">
            <a class="side-menu__item" data-toggle="slide" href="#">
                <i class="side-menu__icon fa fa-cogs"></i><span class="side-menu__label">Support</span><i
                    class="angle fa fa-angle-right"></i></a>
            <ul class="slide-menu">
                <li><a class="slide-item" href="{{ route('admin.support_category.index') }}">Support Category</a></li>
                <li><a class="slide-item" href="{{ route('admin.support.index') }}">List Supports</a></li>
            </ul>
        </li>
        <li class="slide">
            <a class="side-menu__item" data-toggle="slide" href="#">
                <i class="side-menu__icon fa fa-cogs"></i><span class="side-menu__label">About</span><i
                    class="angle fa fa-angle-right"></i></a>
            <ul class="slide-menu">
                <li><a class="slide-item" href="{{ route('admin.about.index') }}">About Free Visa Free Ticket</a>
                </li>
                <li><a class="slide-item" href="{{ route('admin.santi.index') }}">About Santi Overseas</a></li>

            </ul>
        </li>
        <li class="slide">
            <span class="side-menu__item">
                <span class="side-menu__label">MANAGE</span>
            </span>
        </li>
        <li>
            <a class="side-menu__item" href="{{ route('admin.user.lists') }}"><i class="side-menu__icon fa fa-users"></i><span class="side-menu__label"> Admin Users</span></a>
        </li>
        <li class="slide">
            <a class="side-menu__item" data-toggle="slide" href="#">
                <i class="side-menu__icon fa fa-cogs"></i><span class="side-menu__label">Settings</span><i
                    class="angle fa fa-angle-right"></i></a>
            <ul class="slide-menu">
                <li><a class="slide-item" href="{{ route('admin.general_setting.index') }}">Site Settings</a></li>
                <li><a class="slide-item" href="{{ route('admin.setting.index') }}">Social Settings</a></li>
                <li><a class="slide-item" href="{{ route('admin.setting.getContactSetting') }}">Contact Settings</a></li>
            </ul>
        </li>
        {{-- <li>
            <a class="side-menu__item"  href="{{ route('admin.general_setting.index') }}">
                <i class="side-menu__icon fa fa-cogs"></i><span class="side-menu__label">Site Settings</span></a>
        </li> --}}

    </ul>
</aside>