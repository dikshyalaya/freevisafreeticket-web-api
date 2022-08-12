@extends('themes.fvft.layouts.master')
@section('main')
    @include('themes.fvft.site.components.header')
    <!--User Profile-->
    <section class="sptb">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="wideget-user">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <div class="wideget-user-desc d-sm-flex">
                                            <div class="wideget-user-img mr-5 noborder"><img class="w-125 noborder"
                                                    src="{{ asset('/') }}{{ $company->company_logo ?? 'images/defaultimage.jpg' }}">
                                            </div>
                                            <div class="user-wrap wideget-user-info"> <a href="#" class="text-dark">
                                                    <h4 class="font-weight-semibold mb-2">{{ $company->company_name }}
                                                    </h4>
                                                </a>
                                                <h6 class="text-muted mb-1"><span class="text-dark">Followers : </span>
                                                    <span
                                                        id="count_{{ $company->id }}">({{ $company->followers->count() }})</span>
                                                </h6>
                                                <h6 class="text-muted mb-1"><span class="text-dark">Member Since :
                                                    </span>{{ \Carbon\Carbon::parse($company->created_at)->diffForHumans() }}
                                                </h6>
                                                {{-- <div class="wideget-user-rating"> <a href="#"><i class="fa fa-star text-warning"></i></a> <a href="#"><i class="fa fa-star text-warning"></i></a> <a href="#"><i class="fa fa-star text-warning"></i></a> <a href="#"><i class="fa fa-star text-warning"></i></a> <a href="#"><i class="fa fa-star-o text-warning mr-1"></i></a> <span>5 (3876 Reviews)</span> </div> --}}
                                                <div class="wideget-user-icons mt-2"> <a href="#"
                                                        class="facebook-bg mt-0"><i class="fa fa-facebook"></i></a> <a
                                                        href="#" class="twitter-bg"><i class="fa fa-twitter"></i></a>
                                                    <a href="#" class="google-bg"><i class="fa fa-google"></i></a> <a
                                                        href="#" class="dribbble-bg"><i class="fa fa-dribbble"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        @if (Auth::check() && Auth::user()->user_type == 'candidate')
                                            @if (count($employe->followings->where('company_id', $company->id)->all()) > 0)
                                                <button type="button"
                                                    class="btn btn-primary float-right">{{ __('Following') }}</button>
                                            @else
                                                <button type="button"
                                                    onclick="follow_company({{ $company->id }}, {{ $employe->id }}, $(this))"
                                                    class="btn btn-primary float-right">{{ __('Follow') }}</button>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="tab-content">
                        <div>
                            <div class="wideget-user-tab">
                                <div class="tab-menu-heading">
                                    <div class="tabs-menu1">
                                        <ul class="nav">
                                            <li class=""><a href="#tab-5"
                                                    class="@if (Request::get('page') == null) active @endif"
                                                    data-toggle="tab">Profile</a></li>
                                            <li><a href="#tab-6" data-toggle="tab"
                                                    class="@if (Request::get('page') !== null) active @endif">Company Jobs</a>
                                            </li>
                                            {{-- <li><a href="#tab-7" data-toggle="tab" class="">Reviews</a></li> --}}
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane @if (Request::get('page') == null) active @endif" id="tab-5">
                            <div class="card mb-0 border-0">
                                <div class="card-body">
                                    <div class="profile-log-switch">
                                        <div class="media-heading">
                                            <h3 class="card-title mb-4 font-weight-bold">Employer Details</h3>
                                        </div>
                                        <ul class="usertab-list mb-0">
                                            <p><a href="#" class="text-dark"><span
                                                        class="font-weight-semibold w100">Location :&nbsp;</span>
                                                    {{ @DB::table('cities')->find($company->city_id)->name ? @DB::table('cities')->find($company->city_id)->name . ' ,' : '' }}
                                                    {{ @DB::table('countries')->find($company->country_id)->name }}</a>
                                            </p>
                                            {{-- <li><a href="#" class="text-dark"><span class="font-weight-semibold w100">Website :</span> {{ $company->website}}</a></li> --}}
                                            <p><a href="#" class="text-dark"><span
                                                        class="font-weight-semibold w100">Email
                                                        :&nbsp;</span>{{ $company->company_email }}</a></p>
                                            <p><a href="#" class="text-dark"><span
                                                        class="font-weight-semibold w100">Phone
                                                        :&nbsp;</span>{{ $company->company_phone }} </a></p>
                                        </ul>
                                        <div class="row profie-img">
                                            <div class="col-md-12">
                                                <div class="media-heading">
                                                    <h3 class="card-title mb-3 mt-5 font-weight-bold">Company Info</h3>
                                                </div>
                                                <p>{!! html_entity_decode($company->html_content_intro) !!}</p>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer bg-light-50">
                                    <div class="icons">
                                        <div class="sharethis-inline-share-buttons"
                                            data-url="{{ route('site.companydetail', $company->id) }}">
                                        </div>
                                        {{-- <a href="#" class="btn btn-danger icons mb-1 mt-1" data-toggle="modal"
                                            data-target="#report"><i class="icon icon-exclamation mr-1"></i> Report
                                            Abuse</a> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane @if (Request::get('page') !== null) active @endif" id="tab-6">
                            <!--Job listing-->
                            <div class="card mb-0 border-0">
                                <div class="card-body">
                                    <div class="row">
                                        <!--Job lists-->
                                        <div class="col-12">
                                            <div class=" mb-lg-0">
                                                <div class="">
                                                    <div class="item2-gl">
                                                        <div class="tab-content pt-0">
                                                            <div class="tab-pane active" id="tab-11">
                                                                @foreach ($company_jobs as $item)
                                                                    <div class="card overflow-hidden  shadow-none">
                                                                        <div class="d-md-flex">
                                                                            <div class="p-0 m-0 item-card9-img">
                                                                                <div class="item-card9-imgs">
                                                                                    <a href="job/{{ $item->slug }}"></a>
                                                                                    <img src="{{ asset('/') }}{{ $item->feature_image_url }}"
                                                                                        alt="img" class="h-100">
                                                                                </div>
                                                                            </div>
                                                                            <div
                                                                                class="card overflow-hidden  border-0 box-shadow-0 border-left br-0 mb-0">
                                                                                <div class="card-body pt-0 pt-md-5">
                                                                                    <div class="item-card9">
                                                                                        <a href="/job/{{ $item->id }}"
                                                                                            class="text-dark">
                                                                                            <h4
                                                                                                class="font-weight-semibold mt-1">
                                                                                                {{ $item->title }}</h4>
                                                                                        </a>
                                                                                        <div class="mt-2 mb-2">
                                                                                            <a href="/company-view/{{ $company->id }}"
                                                                                                class="mr-4"><span><i
                                                                                                        class="fa fa-building-o text-muted mr-1"></i>
                                                                                                    {{ $company->company_name }}</span></a>
                                                                                            <a class="mr-4"><span><i
                                                                                                        class="fa fa-map-marker text-muted mr-1"></i>{{ @DB::table('cities')->find($item->city_id)->name . ',' }}
                                                                                                    {{ @DB::table('countries')->find($item->country_id)->name }}
                                                                                                </span></a>
                                                                                            {{-- <a class="mr-4"><span><i class="fa fa fa-usd text-muted mr-1"></i> {{ $item->salary_from}} - {{ $item->salary_to}}</span></a> --}}
                                                                                            {{-- <a  class="mr-4"><span><i class="fa fa-clock-o text-muted mr-1"></i> {{@DB::table('job_shifts')->find($item->job_shift_id)->job_shift}}</span></a> --}}
                                                                                            <a class="mr-4"><span><i
                                                                                                        class="fa fa-briefcase text-muted mr-1"></i>
                                                                                                    {{ \Carbon\Carbon::parse($item->expiry_date)->diffForHumans() }}
                                                                                                    Exp</span></a>
                                                                                        </div>
                                                                                        <p class="mb-0 leading-tight">
                                                                                            {!! html_entity_decode(Str::limit($item->description_intro, 50)) !!} </p>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="card-footer pt-3 pb-3">
                                                                                    <div
                                                                                        class="item-card9-footer d-sm-flex">
                                                                                        <div
                                                                                            class="d-flex align-items-center mb-3 mb-md-0 mt-auto posted">
                                                                                            <div>
                                                                                                <a href="/"
                                                                                                    class="text-muted fs-12 mb-1">Posted
                                                                                                    by </a><span
                                                                                                    class="ml-0 fs-13">
                                                                                                    {{ $company->company_name }}</span>
                                                                                                <small
                                                                                                    class="d-block text-default">{{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</small>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="ml-auto">
                                                                                            {{-- <a  class="mr-3"><i class="ion-checkmark-circled text-success mr-1"></i>Phone Verified</a> --}}
                                                                                            <a class="btn btn-primary mt-3 mt-md-0"
                                                                                                href="/apply-job/{{ $item->id }}">Apply
                                                                                                Now</a>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="center-block text-center">
                                                        {{ $company_jobs->links('vendor.pagination.bootstrap-4') }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--/Job lists-->
                                    </div>
                                </div>
                            </div>
                            <!--Job Listing-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane @if (Request::get('page') !== null) active @endif" id="tab-6">
            <!--Job listing-->
            <div class="card mb-0 border-0">
                <div class="card-body">
                    <div class="row">
                        <!--Job lists-->
                        <div class="col-12">
                            <div class=" mb-lg-0">
                                <div class="">
                                    <div class="item2-gl">
                                        <div class="tab-content pt-0">
                                            <div class="tab-pane active" id="tab-11">
                                                @foreach ($company_jobs as $item)
                                                    <div class="card overflow-hidden  shadow-none">
                                                        <div class="d-md-flex">
                                                            <div class="p-0 m-0 item-card9-img">
                                                                <div class="item-card9-imgs">
                                                                    <a href="job/{{ $item->slug }}"></a>
                                                                    @if (!blank($item->feature_image_url))
                                                                        <img src="{{ asset($item->feature_image_url) }}"
                                                                            alt="img" class="h-100">
                                                                    @else
                                                                        <img src="/uploads/defaultimage.jpg" alt="img"
                                                                            class="h-100">
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div
                                                                class="card overflow-hidden  border-0 box-shadow-0 border-left br-0 mb-0">
                                                                <div class="card-body pt-0 pt-md-5">
                                                                    <div class="item-card9">
                                                                        <a href="/job/{{ $item->id }}"
                                                                            class="text-dark">
                                                                            <h4 class="font-weight-semibold mt-1">
                                                                                {{ $item->title }}</h4>
                                                                        </a>
                                                                        <div class="mt-2 mb-2">
                                                                            <a href="/company-view/{{ $company->id }}"
                                                                                class="mr-4"><span><i
                                                                                        class="fa fa-building-o text-muted mr-1"></i>
                                                                                    {{ $company->company_name }}</span></a>
                                                                            <a class="mr-4"><span><i
                                                                                        class="fa fa-map-marker text-muted mr-1"></i>{{ @DB::table('cities')->find($item->city_id)->name . ',' }}
                                                                                    {{ @DB::table('countries')->find($item->country_id)->name }}
                                                                                </span></a>
                                                                            <a class="mr-4"><span><i
                                                                                        class="fa fa fa-usd text-muted mr-1"></i>
                                                                                    {{ $item->salary_from }} -
                                                                                    {{ $item->salary_to }}</span></a>
                                                                            <a class="mr-4"><span><i
                                                                                        class="fa fa-clock-o text-muted mr-1"></i>
                                                                                    {{ @DB::table('job_shifts')->find($item->job_shift_id)->job_shift }}</span></a>
                                                                            <a class="mr-4"><span><i
                                                                                        class="fa fa-briefcase text-muted mr-1"></i>
                                                                                    {{ \Carbon\Carbon::parse($item->expiry_date)->diffForHumans() }}
                                                                                    Exp</span></a>
                                                                        </div>
                                                                        <p class="mb-0 leading-tight">
                                                                            {{ Str::limit($item->description, 50) }} </p>
                                                                    </div>
                                                                </div>
                                                                <div class="card-footer pt-3 pb-3">
                                                                    <div class="item-card9-footer d-sm-flex">
                                                                        <div
                                                                            class="d-flex align-items-center mb-3 mb-md-0 mt-auto posted">
                                                                            <div>
                                                                                Posted by <a
                                                                                    href="/company-view/{{ $company->id }}"
                                                                                    class="text-muted fs-12 mb-1"><span
                                                                                        class="ml-0 fs-13">
                                                                                        {{ $company->company_name }}</span></a>
                                                                                <small
                                                                                    class="text-default">({{ $item->updated_at->diffForHumans() }})</small>
                                                                            </div>
                                                                        </div>
                                                                        <div class="ml-auto">
                                                                            {{-- <a  class="mr-3"><i class="ion-checkmark-circled text-success mr-1"></i>Phone Verified</a> --}}
                                                                            @if (Auth::check() && auth()->user()->user_type == 'candidate')
                                                                                <a class="btn btn-primary mt-3 mt-md-0"
                                                                                    href="/apply-job/{{ $item->id }}">Apply
                                                                                    Now</a>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <div class="center-block text-center">
                                        {{ $company_jobs->links('vendor.pagination.bootstrap-4') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--/Job lists-->
                    </div>
                </div>
            </div>
            <!--Job Listing-->
        </div>
        {{-- <div class="tab-pane" id="tab-7">
                            <div class="card border-0">
                                <div class="card-body">
                                    <h3 class="card-title">Rating And Reviews</h3>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="badge badge-default mb-2">5 <i class="fa fa-star"></i></div>
                                            <div class="progress progress-md mb-4">
                                                <div class="progress-bar bg-success w-100">6,532</div>
                                            </div>
                                            <div class="badge badge-default mb-2">4 <i class="fa fa-star"></i></div>
                                            <div class="progress progress-md mb-4">
                                                <div class="progress-bar bg-primary w-80">7,532</div>
                                            </div>
                                            <div class="badge badge-default mb-2">3 <i class="fa fa-star"></i></div>
                                            <div class="progress progress-md mb-4">
                                                <div class="progress-bar bg-info w-60">3,526</div>
                                            </div>
                                            <div class="badge badge-default mb-2">2 <i class="fa fa-star"></i></div>
                                            <div class="progress progress-md mb-4">
                                                <div class="progress-bar bg-warning w-60">485</div>
                                            </div>
                                            <div class="badge badge-default mb-2">1 <i class="fa fa-star"></i></div>
                                            <div class="progress progress-md mb-0">
                                                <div class="progress-bar bg-danger w-20">126</div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 text-center align-items-center">

                                        </div>
                                    </div>
                                </div>
                                <div class="card-body p-0">
                                    <div class="media mt-0 p-5">
                                        <div class="d-flex mr-3">
                                            <a href="#"><img class="media-object brround" alt="64x64" src="../assets/images/users/male/1.jpg"> </a>
                                        </div>
                                        <div class="media-body">
                                            <h5 class="mt-0 mb-1 font-weight-semibold">Joanne Scott
                                                <span class="fs-14 ml-0" data-toggle="tooltip" data-placement="top" title="" data-original-title="verified"><i class="fa fa-check-circle-o text-success"></i></span>
                                                <span class="fs-14 ml-2"> 4.5 <i class="fa fa-star text-yellow"></i></span>
                                            </h5>
                                            <small class="text-muted"><i class="fa fa-calendar"></i> Dec 21st  <i class=" ml-3 fa fa-clock-o"></i> 13.00  <i class=" ml-3 fa fa-map-marker"></i> Brezil</small>
                                            <p class="font-13  mb-2 mt-2">
                                              On the other hand, we denounce with righteous indignation and dislike men who are so beguiled and demoralized by the charms of pleasure of the moment, so blinded by desire, that they cannot foresee the pain and trouble that are bound to ensue
                                            </p>
                                            <a href="#" class="mr-2"><span class="badge badge-primary">Helpful</span></a>
                                            <a href="" class="mr-2" data-toggle="modal" data-target="#Comment"><span class="">Comment</span></a>
                                            <a href="" class="mr-2" data-toggle="modal" data-target="#report"><span class="">Report</span></a>
                                            <div class="media mt-5">
                                                <div class="d-flex mr-3">
                                                    <a href="#"> <img class="media-object brround" alt="64x64" src="../assets/images/users/female/2.jpg"> </a>
                                                </div>
                                                <div class="media-body">
                                                    <h5 class="mt-0 mb-1 font-weight-semibold">Rose Slater <span class="fs-14 ml-0" data-toggle="tooltip" data-placement="top" title="" data-original-title="verified"><i class="fa fa-check-circle-o text-success"></i></span></h5>
                                                    <small class="text-muted"><i class="fa fa-calendar"></i> Dec 22st  <i class=" ml-3 fa fa-clock-o"></i> 6.00  <i class=" ml-3 fa fa-map-marker"></i> Brezil</small>
                                                    <p class="font-13  mb-2 mt-2">
                                                       Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris   commodo Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur consequat.
                                                    </p>
                                                    <a href="" data-toggle="modal" data-target="#Comment"><span class="badge badge-default">Comment</span></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="media p-5 border-top mt-0">
                                        <div class="d-flex mr-3">
                                            <a href="#"> <img class="media-object brround" alt="64x64" src="../assets/images/users/male/3.jpg"> </a>
                                        </div>
                                        <div class="media-body">
                                            <h5 class="mt-0 mb-1 font-weight-semibold">Edward
                                            <span class="fs-14 ml-0" data-toggle="tooltip" data-placement="top" title="" data-original-title="verified"><i class="fa fa-check-circle-o text-success"></i></span>
                                            <span class="fs-14 ml-2"> 4 <i class="fa fa-star text-yellow"></i></span>
                                            </h5>
                                            <small class="text-muted"><i class="fa fa-calendar"></i> Dec 21st  <i class=" ml-3 fa fa-clock-o"></i> 16.35  <i class=" ml-3 fa fa-map-marker"></i> UK</small>
                                            <p class="font-13  mb-2 mt-2">
                                              On the other hand, we denounce with righteous indignation and dislike men who are so beguiled and demoralized by the charms of pleasure of the moment, so blinded by desire, that they cannot foresee the pain and trouble that are bound to ensue
                                            </p>
                                            <a href="#" class="mr-2"><span class="badge badge-primary">Helpful</span></a>
                                            <a href="" class="mr-2" data-toggle="modal" data-target="#Comment"><span class="">Comment</span></a>
                                            <a href="" class="mr-2" data-toggle="modal" data-target="#report"><span class="">Report</span></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card mb-0">
                                <div class="card-header">
                                    <h3 class="card-title">Leave a reply</h3>
                                </div>
                                <div class="card-body">
                                    <div>
                                        <div class="form-group">
                                            <input type="text" class="form-control"  placeholder="Your Name">
                                        </div>
                                        <div class="form-group">
                                            <input type="email" class="form-control" placeholder="Email Address">
                                        </div>
                                        <div class="form-group">
                                            <textarea class="form-control" name="example-textarea-input" rows="6" placeholder="Comment"></textarea>
                                        </div>
                                        <a href="#" class="btn btn-primary">Send Reply</a>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
        </div>
        </div>
        </div>
        </div>
    </section>

    @include('themes.fvft.site.components.footer')
@endsection

@section('script')
    <script>
        function follow_company(company_id, employ_id, follow_button) {
            $.ajax({
                type: "POST",
                url: "{{ route('candidate.follow_company') }}",
                data: {
                    'company_id': company_id,
                    'employ_id': employ_id
                },
                beforeSend: function() {
                    $(follow_button).text('Wait Submitting...')
                },
                success: function(data) {
                    if (data.db_error) {
                        toastr.warning(data.db_error)
                    } else if (data.alreadyFollowed == true) {
                        toastr.info(data.msg);
                        $(follow_button).text('Following');
                    } else if (data.alreadyFollowed == false) {
                        toastr.success(data.msg);
                        $("#count_" + company_id).text('(' + data.followers + ')');
                        $(follow_button).text('Following');
                    }
                },
            });
        }
    </script>
@endsection
