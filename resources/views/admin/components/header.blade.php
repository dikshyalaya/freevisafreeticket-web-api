<div class="app-header1 header py-1 d-flex">
    <div class="container-fluid">
        <div class="d-flex">
            <a class="header-brand" href="/admin/">
                <img src="{{asset('/uploads/site/logo.png')}}" class="header-brand-img" alt="Jobslist logo">
            </a>
            <a aria-label="Hide Sidebar" class="app-sidebar__toggle" data-toggle="sidebar" href="#"></a>
            <div class="header-navicon">
                <a href="#" data-toggle="search" class="nav-link d-lg-none navsearch-icon">
                    <i class="fa fa-search"></i>
                </a>
            </div>
            <div class="d-flex order-lg-2 ml-auto">

                <div class="dropdown d-none d-md-flex mr-2">
                    <a class="nav-link icon" data-toggle="dropdown">
                        <i class="fa fa-bell-o"></i>
                        <span class=" nav-unread badge badge-danger  badge-pill">{{ Auth::user()->unReadNotifications->count() }}</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow" style="width: 307px;">
                        <a href="#" class="dropdown-item text-center">You have <strong>{{ Auth::user()->unReadNotifications->count() }}</strong> notification</a>
                        <div class="dropdown-divider"></div>
                        @if(Auth::user()->unReadNotifications->count() > 0)
                            @foreach(Auth::user()->unReadNotifications()->get() as $value)
                                <a href="{{ route('markread', $value->id) }}" class="dropdown-item d-flex pb-3">
                                    <div class="notifyimg">
                                        <i class="fa fa-bell-o"></i>
                                    </div>
                                    <div>
                                        <small><strong>{!! $value->data['msg'] ?? '' !!}</strong></small>
                                        <div class="small text-muted">{{ $value->created_at ?? '' }}</div>
                                    </div>
                                </a>
                            @endforeach
                        @endif
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item text-center btn btn-link btn-sm">See all Notification</a>
                    </div>
                </div>
                <div class="dropdown">
                    <a href="{{ route('admin.user.profile') }}" class="nav-link p-0 leading-none user-img" data-toggle="dropdown">
                        @if(!blank($user["profile"]))
                            <img src="{{ asset('/')}}{{ $user["profile"] }}" alt="profile-img" class="avatar avatar-md brround">
                        @else
                            <img src="{{ asset('/defaults/profile.png') }}" alt="profile-img" class="avatar avatar-md brround">
                        @endif
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow ">
                        <a class="dropdown-item" href="{{ route('admin.user.profile') }}">
                            <i class="dropdown-icon icon icon-user"></i> My Profile
                        </a>
                        {{-- <a class="dropdown-item" href="{{ route('admin.user.profile') }}">
                            <i class="dropdown-icon  icon icon-settings"></i> Account Settings
                        </a> --}}
                        <form action="/admin/logout" method="post">
                            @csrf
                            <button type="submit" class="dropdown-item">
                                <i class="dropdown-icon icon icon-power"></i> Log out
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
