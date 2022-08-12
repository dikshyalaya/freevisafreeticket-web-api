@extends('themes.fvft.layouts.master')
@section('title')
    {{ $company->company_name ?? '' }}
@endsection
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
                                    <div class="col-lg-12 col-md-12">
                                        <div class="wideget-user-desc d-sm-flex">
                                            <div class="wideget-user-img mr-5 noborder">
                                                <img class="w-125 noborder"
                                                    src="{{ asset('/') }}{{ $company->company_logo ?? 'images/defaultimage.jpg' }}">
                                            </div>
                                            <div class="user-wrap wideget-user-info"
                                                style="margin-top: auto; margin-bottom:auto; text-align: left;">
                                                <a href="#" class="text-dark">
                                                    <h2 class="font-weight-semibold mb-2">{{ $company->company_name }}
                                                    </h2>
                                                </a>
                                                <h6 class="text-muted mb-1"><span class="text-dark">Followers : </span>
                                                    <span
                                                        id="count_{{ $company->id }}">({{ $company->followers->count() }})</span>
                                                </h6>
                                                <h6 class="text-muted mb-1"><span class="text-dark">Member Since :
                                                    </span>{{ \Carbon\Carbon::parse($company->created_at)->diffForHumans() }}
                                                </h6>
                                                {{-- <div class="wideget-user-rating"> <a href="#"><i class="fa fa-star text-warning"></i></a> <a href="#"><i class="fa fa-star text-warning"></i></a> <a href="#"><i class="fa fa-star text-warning"></i></a> <a href="#"><i class="fa fa-star text-warning"></i></a> <a href="#"><i class="fa fa-star-o text-warning mr-1"></i></a> <span>5 (3876 Reviews)</span> </div> --}}
                                            </div>
                                        </div>
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
                                            <li class="">
                                                <a href="#tab-5" class="@if (Request::get('page') == null) active @endif"
                                                    data-toggle="tab">Profile</a>
                                            </li>
                                            <li>
                                                <a href="#tab-6" data-toggle="tab"
                                                    class="@if (Request::get('page') !== null) active @endif">Company Jobs</a>
                                            </li>
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
                                        <div class="row">
                                            <div class="col-md-2">
                                                @if (Auth::check() && Auth::user()->user_type == 'candidate')
                                                    @if (count($employe->followings->where('company_id', $company->id)->all()) > 0)
                                                        <button type="button"
                                                            class="btn btn-primary btn-block">{{ __('Following') }}</button>
                                                    @else
                                                        <button type="button"
                                                            onclick="follow_company({{ $company->id }}, {{ $employe->id }}, $(this))"
                                                            class="btn btn-primary">{{ __('Follow') }}</button>
                                                    @endif
                                                @else
                                                    <a type="button" href="{{ route('candidate.login') }}"
                                                        class="btn btn-primary btn-block">{{ __('Follow') }}</a>
                                                @endif
                                            </div>
                                            <div class="col-md-2">
                                                <div class="sharethis-inline-share-buttons"
                                                    data-url="{{ route('site.companydetail', $company->id) }}">
                                                </div>
                                            </div>
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
                                                                                    <a
                                                                                        href="{{ route('viewJob', $item->id) }}"></a>
                                                                                    @if(!blank($item, 'company') AND !blank(data_get($item, 'company.company_logo')))
                                                                                    <img src="{{ asset(data_get($item, 'company.company_logo')) }}"
                                                                                            alt="img"
                                                                                            class="h-100">
                                                                                    @elseif ($item->feature_image_url)
                                                                                        <img src="{{ asset($item->feature_image_url) }}"
                                                                                            alt="img"
                                                                                            class="h-100">
                                                                                    @else
                                                                                        <img src="{{ asset('images/defaultimage.jpg') }}"
                                                                                            alt="img"
                                                                                            class="h-100">
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                            <div
                                                                                class="card overflow-hidden  border-0 box-shadow-0 border-left br-0 mb-0">
                                                                                <div class="card-body pt-0 pt-md-5">
                                                                                    <div class="item-card9">
                                                                                        <a href="{{ route('viewJob', $item->id) }}"
                                                                                            class="text-dark">
                                                                                            <h4
                                                                                                class="font-weight-semibold mt-1">
                                                                                                {{ $item->title }}({{ $item->num_of_positions }})
                                                                                            </h4>
                                                                                        </a>
                                                                                        <div class="mt-2 mb-2">
                                                                                            @if (!blank(data_get($item, 'company.company_name')))
                                                                                                <a href="{{ route('site.companydetail', data_get($item, 'company.id')) }}"
                                                                                                    class="mr-4"><span><i
                                                                                                            class="fa fa-building-o text-muted mr-1"></i>
                                                                                                        {{ data_get($item, 'company.company_name') }}</span></a>
                                                                                            @endif
                                                                                        </div>
                                                                                        <div class="mt-2 mb-2">
                                                                                            <a class="mr-4">
                                                                                                <span>
                                                                                                    @if (!blank(data_get($item, 'country')))
                                                                                                        <img class="mb-1"
                                                                                                            src="{{ asset('https://flagcdn.com/16x12/' . strtolower(data_get($item, 'country.iso2')) . '.png') }}"
                                                                                                            alt="">
                                                                                                        {{ data_get($item, 'country.name') }}
                                                                                                    @endif
                                                                                                </span>
                                                                                            </a>
                                                                                            <a class="mr-4">
                                                                                                <span>
                                                                                                    Basic Salary:
                                                                                                    <span
                                                                                                        style="color: blue">
                                                                                                        @if (!blank(data_get($item, 'country')))
                                                                                                            {{ data_get($item, 'country.currency') ?? '' }}&nbsp;{{ $item->country_salary ?? '' }}&nbsp;&nbsp;
                                                                                                        @endif
                                                                                                        @if (!blank(data_get($item, 'country')) and data_get($item, 'country.currency') != 'NPR')
                                                                                                            NPR:
                                                                                                            {{ $item->nepali_salary ?? '' }}
                                                                                                        @endif

                                                                                                    </span>
                                                                                                </span>
                                                                                            </a>
                                                                                            <a class="mr-4">
                                                                                                <span>
                                                                                                    Post On:
                                                                                                    {{ $item->publish_date != null ? date('j M Y', strtotime($item->publish_date)) : '' }}
                                                                                                </span>
                                                                                            </a>
                                                                                            <a class="mr-4">
                                                                                                <span>
                                                                                                    Apply Before:
                                                                                                    {{ $item->expiry_date != null ? date('j M Y', strtotime($item->expiry_date)) : '' }}
                                                                                                </span>
                                                                                            </a>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="card-footer pt-3 pb-3">
                                                                                    <div class="item-card9-footer">
                                                                                        <div class="row">
                                                                                            @if (auth()->check() and auth()->user()->user_type == 'candidate')
                                                                                                <x-job-button
                                                                                                    :job="$item"
                                                                                                    :employ="$employe" />
                                                                                            @else
                                                                                                <x-job-button
                                                                                                    :job="$item" />
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
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('themes.fvft.site.components.footer')
@endsection

@section('script')
    <script>
        @if (auth()->check() and auth()->user()->user_type == 'candidate')
            function savejob(job_id, this_button) {
                var url = "{{ route('candidate.savedjob.saveJob') }}";
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        'job_id': job_id,
                        'employ_id': '{{ $employe->id }}',
                    },
                    beforeSend: function() {
                        $(".saveJobButton").attr('disabled', true);
                    },
                    success: function(response) {
                        if (response.db_error) {
                            toastr.warning(response.db_error);
                        } else if (response.error) {
                            toastr.warning(response.error);
                        } else if (response.redirectRoute) {
                            location.href = response.redirectRoute
                        } else {
                            $(this_button).removeAttr('onclick').html('<i class="fa fa-heart"></i> Saved');
                            toastr.success(response.msg);
                        }
                    },
                    complete: function() {
                        $(".saveJobButton").attr('disabled', false);
                    },
                });
            }
        @endif

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
