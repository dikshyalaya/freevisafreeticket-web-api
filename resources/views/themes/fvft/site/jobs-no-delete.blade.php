@extends('themes.fvft.layouts.master')
@section('title')
    Search Jobs
@endsection
@section('style')
    <!-- jquery ui RangeSlider -->
    <link href="{{ asset('themes/fvft/') }}/assets/plugins/jquery-uislider/jquery-ui.css" rel="stylesheet">
@endsection
@section('main')
    @include('themes.fvft.site.components.header')

    @php
    if (checkUserType('candidate')) {
        $employ_id = App\Models\Employe::where('user_id', \Auth::user()->id)->first()->id;
        // dd($employ_id);
    } else {
        $employ_id = '';
    }
    @endphp
    <!--Job listing-->
    <section class="sptb">
        <div class="container">
            <div class="row">
                @include('themes.fvft.site.components.jobs.sidebar')
                <div class="col-xl-9 col-lg-8 col-md-12">
                    <!--Job lists-->
                    <div class=" mb-lg-0">
                        <div class="">
                            <div class="item2-gl">
                                <div class=" mb-0">
                                    <div class="">
                                        <div class="p-5 bg-white item2-gl-nav d-flex">
                                            <h6 class="mb-0 mt-3">{{ __('Showing') }} @if ($jobs->count() > 1)
                                                    <b>{{ __('1') }} {{ __('to') }} {{ __($jobs->count()) }}
                                                    @else
                                                        {{ __($jobs->count()) }}
                                                @endif
                                                </b> {{ __('of') }} {{ __($jobs->total()) }} {{ __('Entries') }}
                                            </h6>
                                            <ul class="nav item2-gl-menu mt-1 ml-auto">
                                                <li class=""><a href="#tab-11" class="active show"
                                                        data-toggle="tab" title="List style"><i
                                                            class="fa fa-list"></i></a></li>
                                                <li><a href="#tab-12" data-toggle="tab" class=""
                                                        title="Grid"><i class="fa fa-th"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab-11">
                                        @foreach ($jobs as $item)
                                            <div class="card overflow-hidden shadow-none">
                                                <div class="d-md-flex">
                                                    <div class="p-0 m-0 item-card9-img">
                                                        <div class="item-card9-imgs">
                                                            <a href="{{ route('viewJob', $item->id) }}"></a>
                                                            @if ($item->feature_image_url)
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
                                                                            class="mr-4">
                                                                            <span><i
                                                                                    class="fa fa-building-o text-muted mr-1"></i>{{ data_get($item, 'company.company_name') }}</span>
                                                                        </a>
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
                                                                                    NPR: {{ $item->nepali_salary ?? '' }}
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
                                                                                        class="saveJobButton btn btn-warning btn-block">
                                                                                        <i class="fa fa-heart"></i>
                                                                                        {{ __('Saved') }}
                                                                                    </a>
                                                                                @else
                                                                                    <a href="javascript:void(0);"
                                                                                        onclick="savejob({{ $item->id }})"
                                                                                        class="saveJobButton btn btn-block btn-warning">
                                                                                        <i class="fa fa-heart-o"></i>
                                                                                        {{ __('Save Job') }}
                                                                                    </a>
                                                                                @endif
                                                                            </div>
                                                                        @endif
                                                                    @else
                                                                        <div class="col-md-3">
                                                                            <a href="{{ route('applyForJob', $item->id) }}"
                                                                                class="btn btn-primary mr-3 btn-block">
                                                                                {{ __('Apply Now') }}</a>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <a href="{{ route('candidate.login', ['name' => 'login']) }}"
                                                                                class="saveJobButton btn btn-warning btn-block">
                                                                                <i class="fa fa-heart-o"></i>
                                                                                {{ __('Save Job') }}
                                                                            </a>
                                                                        </div>
                                                                    @endauth
                                                                    <div class="col-md-3">
                                                                        <a href="{{ route('viewJob', $item->id) }}"
                                                                            class="btn btn-warning btn-block">
                                                                            <i
                                                                                class="fa fa-eye"></i>&nbsp;{{ __('View Details') }}
                                                                        </a>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="sharethis-inline-share-buttons"
                                                                            data-url="{{ route('viewJob', $item->id) }}">
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach

                                    </div>
                                    <div class="tab-pane " id="tab-12">
                                        <div class="row">
                                            @foreach ($jobs as $item)
                                                <div class="col-lg-6 col-md-6 col-sm-12 col-xl-6">
                                                    <div class="card overflow-hidden">
                                                        <div class="item-card9-img border-bottom">
                                                            <div class="item-card9-imgs">
                                                                <a href="{{ route('viewJob', $item->id) }}"></a>
                                                                @if ($item->feature_image_url)
                                                                    <img src="{{ asset($item->feature_image_url) }}"
                                                                        alt="img" class="h-100">
                                                                @else
                                                                    <img src="{{ asset('images/defaultimage.jpg') }}"
                                                                        alt="img" class="h-100">
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="item-card9">
                                                                <a href="{{ route('viewJob', $item->id) }}"
                                                                    class="text-dark mt-2">
                                                                    <h4 class="font-weight-semibold mt-1 mb-2">
                                                                        {{ $item->title }}({{ $item->num_of_positions }})
                                                                    </h4>
                                                                </a>
                                                                <div class="mt-2 mb-2">
                                                                    @if (!blank(data_get($item, 'company')))
                                                                        <a href="{{ route('site.companydetail', data_get($item, 'company.id')) }}"
                                                                            class="mr-4">
                                                                            <span><i
                                                                                    class="fa fa-building-o text-muted mr-1"></i>{{ data_get($item, 'company.company_name') ?? '' }}</span>
                                                                        </a>
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
                                                                </div>
                                                                <div class="mt-2 mb-2">
                                                                    <a class="mr-4">
                                                                        <span>
                                                                            Basic Salary:
                                                                            <span style="color: blue">
                                                                                @if (!blank(data_get($item, 'country')))
                                                                                    {{ data_get($item, 'country.currency') ?? '' }}&nbsp;{{ $item->country_salary ?? '' }}&nbsp;&nbsp;
                                                                                @endif
                                                                                @if (!blank(data_get($item, 'country')) and data_get($item, 'country.currency') != 'NPR')
                                                                                    NPR: {{ $item->nepali_salary ?? '' }}
                                                                                @endif

                                                                            </span>
                                                                        </span>
                                                                    </a>
                                                                </div>
                                                                <div class="mt-2 mb-2">
                                                                    <a class="mr-4">
                                                                        <span>
                                                                            Post On:
                                                                            {{ $item->publish_date != null ? date('j M Y', strtotime($item->publish_date)) : '' }}
                                                                        </span>
                                                                    </a>
                                                                </div>
                                                                <div class="mt-2 mb-2">

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
                                                                            <div class="col-md-6">
                                                                                @if ($savedJob->exists())
                                                                                    <a href="javascript:void(0);"
                                                                                        class="saveJobButton ico-grid-font btn btn-warning btn-block">
                                                                                        <i class="fa fa-heart"></i>
                                                                                        {{ __('Saved') }}
                                                                                    </a>
                                                                                @else
                                                                                    <a href="javascript:void(0);"
                                                                                        onclick="savejob({{ $item->id }})"
                                                                                        class="saveJobButton ico-grid-font btn btn-warning btn-block">
                                                                                        <i class="fa fa-heart-o"></i>
                                                                                        {{ __('Save Job') }}
                                                                                    </a>
                                                                                @endif
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                @if ($application)
                                                                                    <a href="javascript:void(0);"
                                                                                        class="btn btn-primary mr-5 btn-block">{{ __('Applied') }}</a>
                                                                                @else
                                                                                    <a href="{{ route('applyForJob', $item->id) }}"
                                                                                        class="btn btn-primary mr-5 btn-block">
                                                                                        {{ __('Apply Now') }}</a>
                                                                                @endif
                                                                            </div>
                                                                            <div class="col-md-6 mt-3">
                                                                                <a href="{{ route('viewJob', $item->id) }}"
                                                                                    class="ico-grid-font btn btn-warning btn-block">
                                                                                    <i
                                                                                        class="fa fa-eye"></i>&nbsp;{{ __('View Details') }}
                                                                                </a>
                                                                            </div>
                                                                            <div class="col-md-6 mt-3">
                                                                                <div class="sharethis-inline-share-buttons"
                                                                                    data-url="{{ route('viewJob', $item->id) }}">
                                                                                </div>
                                                                            </div>
                                                                        @elseif(auth()->user()->user_type == 'company')
                                                                            <div class="col-md-6 mt-3">
                                                                                <a href="{{ route('viewJob', $item->id) }}"
                                                                                    class="ico-grid-font btn btn-warning btn-block">
                                                                                    <i
                                                                                        class="fa fa-eye"></i>&nbsp;{{ __('View Details') }}
                                                                                </a>
                                                                            </div>
                                                                            <div class="col-md-6 mt-3">
                                                                                <div class="sharethis-inline-share-buttons"
                                                                                    data-url="{{ route('viewJob', $item->id) }}">
                                                                                </div>
                                                                            </div>
                                                                        @endif
                                                                    @else
                                                                        <div class="col-md-6">
                                                                            <a href="{{ route('applyForJob', $item->id) }}"
                                                                                class="btn btn-primary mr-3 btn-block">
                                                                                {{ __('Apply Now') }}</a>
                                                                        </div>
                                                                        <div class="col-md-6 mt-3">
                                                                            <a href="{{ route('viewJob', $item->id) }}"
                                                                                class="ico-grid-font btn btn-warning btn-block">
                                                                                <i
                                                                                    class="fa fa-eye"></i>&nbsp;{{ __('View Details') }}
                                                                            </a>
                                                                        </div>
                                                                        <div class="col-md-6 mt-3">
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
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="center-block text-center">
                                {{ $jobs->links('vendor.pagination.bootstrap-4') }}
                            </div>
                        </div>
                    </div>
                    <!--/Job lists-->
                </div>
            </div>
        </div>
    </section>
    <!--/Job Listings-->
    @include('themes.fvft.site.components.footer')
@endsection
@section('script')
    <script src="{{ env('APP_URL') }}js/location.js"></script>
    <script>
        const _token = $('meta[name="csrf-token"]')[0].content;
        const state_id = {{ isset($candidate->state_id) ? $candidate->state_id : '3871' }};
        const city_id = {{ isset($candidate->city_id) ? $candidate->city_id : 'null' }};
        const appurl = "{{ env('APP_URL') }}";
    </script>

    <script>
        function savejob(job_id) {
            var url = "{{ route('candidate.savedjob.saveJob') }}";
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    'job_id': job_id,
                    'employ_id': '{{ $employ_id }}',
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
                        toastr.success(response.msg);
                    }
                    window.location.reload()
                },
                complete: function() {
                    $(".saveJobButton").attr('disabled', false);
                },
            });
        }
    </script>
@endsection
