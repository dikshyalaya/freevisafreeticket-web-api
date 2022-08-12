@extends('themes.fvft.candidates.layouts.dashmaster')
@section('title') Job Search @stop
@section('content')
    <style>
        .tabs-menu1 .nav {
            flex-wrap: nowrap;
            padding-left: 15px;
        }

        .tabs-menu1 li a:not(:active) {
            background-color: #868e96;
            border-color: #868e96;
            color: #171a1d;
        }

        .tabs-menu1 li a:focus {
            background-color: #868e96;
            border-color: #868e96;
            color: #171a1d;
        }

        .tabs-menu1 li a.active {
            background-color: #2861b1;
            border-color: #2861b1;
            color: #fff;
        }

        .input-icons i {
            position: absolute;
        }

        .input-icons input {
            text-indent: 20px;
        }

        .icon {
            padding: 10px;
            min-width: 40px;
            z-index: 9
        }
        .tab-content{
            padding-top: 0 !important;
        }

    </style>
    <section>
        <div class="bannerimg cover-image bg-background3" data-image-src="/uploads/site/banner.png">
            <div class="header-text mb-0">
                <div class="text-center text-white">
                    <h1 class="">{{ __('Job Search') }}</h1>
                    <ol class="breadcrumb text-center">
                        <li class="breadcrumb-item"><a href="#">{{ __('Home') }}</a></li>
                        <li class="breadcrumb-item"><a href="#">{{ __('Dashboard') }} </a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">{{ __('Job Search') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="sptb">
        <div class="container">
            <div class="row">
                <div class="col-xl-3 col-lg-12 col-md-12">
                    @include('themes.fvft.candidates.components.sidebar')
                </div>
                <div class="col-xl-9 col-lg-12 col-md-12">
                    @include('partial.candidates.job_search.tabs')
                    @if (!request()->has('is_active') && !request()->is_active == 'about')
                        <div class="row">
                            <div class="mb-lg-0">
                                <div class="">
                                    <div class="item2-gl">
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="tab-11">
                                                @foreach ($jobs as $item)
                                                    <div class="card overflow-hidden  shadow-none">
                                                        <div class="d-md-flex">
                                                            <div class="p-0 m-0 item-card9-img">
                                                                <div class="item-card9-imgs">
                                                                    <a href="{{ route('viewJob', $item->id) }}"></a>
                                                                    @if(!blank($item, 'company') AND !blank(data_get($item, 'company.company_logo')))
                                                                    <img src="{{ asset(data_get($item, 'company.company_logo')) }}"
                                                                            alt="img" class="h-100">
                                                                    @elseif ($item->feature_image_url)
                                                                        <img src="{{ asset($item->feature_image_url) }}"
                                                                            alt="img" class="h-100">
                                                                    @else
                                                                        <img src="{{ asset('images/defaultimage.jpg') }}"
                                                                            alt="img" class="h-100">
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div
                                                                class="card overflow-hidden  border-0 box-shadow-0 border-left br-0 mb-0">
                                                                <div class="card-body pt-0 pt-md-5">
                                                                    <div class="item-card9">
                                                                        <a href="{{ route('viewJob', $item->id) }}"
                                                                            class="text-dark">
                                                                            <h4 class="font-weight-semibold mt-1">
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
                                                                                    <span style="color: blue">
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
                                                                            @auth
                                                                                @if (auth()->user()->user_type == 'candidate')
                                                                                    @php
                                                                                        $application = \DB::table('job_applications')
                                                                                            ->where('job_id', $item->id)
                                                                                            ->where('employ_id', $employ->id)
                                                                                            ->first();
                                                                                        $savedJob = App\Models\SavedJob::where('employ_id', $employ->id)->where('job_id', $item->id);
                                                                                    @endphp

                                                                                    <div class="col-md-3">
                                                                                        @if ($application)
                                                                                            <a href="javascript:void(0);"
                                                                                                class="btn btn-primary mr-5 btn-block">{{ __('Applied') }}</a>
                                                                                        @else
                                                                                            <a href="{{ route('applyForJob', $item->id) }}"
                                                                                                class="btn btn-primary mr-5 btn-block">
                                                                                                {{ __('Apply Now') }}</a>
                                                                                        @endif
                                                                                    </div>
                                                                                    <div class="col-md-3">
                                                                                        @if ($savedJob->exists())
                                                                                            <a href="javascript:void(0);"
                                                                                                onclick="savejob({{ $item->id }}, $(this))"
                                                                                                class="saveJobButton btn btn-warning btn-block">
                                                                                                <i class="fa fa-heart"></i>
                                                                                                {{ __('Saved') }}
                                                                                            </a>
                                                                                        @else
                                                                                            <a href="javascript:void(0);"
                                                                                                onclick="savejob({{ $item->id }}, $(this))"
                                                                                                class="saveJobButton btn btn-warning btn-block">
                                                                                                <i class="fa fa-heart-o"></i>
                                                                                                {{ __('Save Job') }}
                                                                                            </a>
                                                                                        @endif
                                                                                    </div>
                                                                                    <div class="col-md-3">
                                                                                        {{-- <a href="{{ route('viewJob', $item->id) }}" --}}
                                                                                        <a href="{{ route('candidate.job_search.viewJobDetails', $item->id) }}"
                                                                                            class="btn btn-success btn-block">
                                                                                            <i
                                                                                                class="fa fa-eye"></i>&nbsp;{{ __('View Details') }}
                                                                                        </a>
                                                                                    </div>
                                                                                    <div class="col-md-3">
                                                                                        <div class="sharethis-inline-share-buttons"
                                                                                            data-url="{{ route('viewJob', $item->id) }}">
                                                                                        </div>
                                                                                    </div>
                                                                                @elseif(auth()->user()->user_type == 'company')
                                                                                    <div class="col-md-3">
                                                                                        <a href="{{ route('viewJob', $item->id) }}"
                                                                                            class="btn btn-success btn-block">
                                                                                            <i
                                                                                                class="fa fa-eye"></i>&nbsp;{{ __('View Details') }}
                                                                                        </a>
                                                                                    </div>
                                                                                    <div class="col-md-3">
                                                                                        <div class="sharethis-inline-share-buttons"
                                                                                            data-url="{{ route('viewJob', $item->id) }}">
                                                                                        </div>
                                                                                    </div>
                                                                                @endif
                                                                            @else
                                                                                <div class="col-md-3">
                                                                                    <a href="{{ route('applyForJob', $item->id) }}"
                                                                                        class="btn btn-primary mr-3 btn-block">
                                                                                        {{ __('Apply Now') }}</a>
                                                                                </div>
                                                                                <div class="col-md-3">
                                                                                    <a href="{{ route('viewJob', $item->id) }}"
                                                                                        class="btn btn-success btn-block">
                                                                                        <i
                                                                                            class="fa fa-eye"></i>&nbsp;{{ __('View Details') }}
                                                                                    </a>
                                                                                </div>
                                                                                <div class="col-md-3">
                                                                                    <div class="sharethis-inline-share-buttons"
                                                                                        data-url="{{ route('viewJob', $item->id) }}">
                                                                                    </div>
                                                                                </div>

                                                                            @endauth
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
                                        {{ $jobs->links('vendor.pagination.bootstrap-4') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script src="{{ env('APP_URL') }}js/location.js"></script>
    <script>
        function savejob(job_id, this_button) {
            var url = "{{ route('candidate.savedjob.saveJob') }}";
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    'job_id': job_id,
                    'employ_id': '{{ $employ->id }}',
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
                        if (response.status == 'delete') {
                            $(this_button).html('<i class="fa fa-heart-o"></i> Save Job');
                        } else if (response.status == 'saved') {
                            $(this_button).html('<i class="fa fa-heart"></i> Saved');
                            // $(this_button).removeAttr('onclick').html('<i class="fa fa-heart"></i> Saved');
                        }

                        toastr.success(response.msg);
                    }
                },
                complete: function() {
                    $(".saveJobButton").attr('disabled', false);
                },
            });
        }

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
                        $(follow_button).text('Following');
                    }
                },
            });
        }
    </script>
@endsection
