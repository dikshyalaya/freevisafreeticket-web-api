@extends('themes.fvft.candidates.layouts.dashmaster')
@section('title', 'My Dashboard')
@section('style')
    <link rel="stylesheet" href="{{ asset('css/progress.css') }}">
    <style>
        .progress-lg {
            height: 1.75rem;
        }

        .progress-lg .progress-bar {
            height: 1.75rem;
        }

        .progress {
            font-size: 1rem;
        }

        /* .profileRow .feature .icons {
                            font-size: 2em;
                            position: relative;
                            display: inline-block;
                            width: 3em;
                            height: 2em;
                            line-height: 3em;
                            vertical-align: middle;
                            border-radius: 50%;
                            border: 1px solid rgba(255, 255, 255, 0.1);
                        } */
        .gray-round {
            background-color: rgb(166 181 217);
        }

        .notification-badge {
            top: -10px;
            position: relative;
        }

    </style>
@endsection
@section('content')
    <section>
        <div class="bannerimg cover-image bg-background3" data-image-src="/uploads/site/banner.png"
            style="background: url(/uploads/site/banner.png) center center;">
            <div class="header-text mb-0">
                <div class="text-center text-white">
                    <h1 class="">{{ __('My Dashboard') }}</h1>
                    <ol class="breadcrumb text-center">
                        <li class="breadcrumb-item"><a href="#">{{ __('Home') }}</a></li>
                        <li class="breadcrumb-item"><a href="#">{{ __('My Dashboard') }} </a></li>
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

                    @include('themes.fvft.candidates.components.profile.profile-completion',['employee' => $employe])

                    <div class="mt-5">
                        <div class="item-all-cat">
                            <div class="row category-type">
                                @foreach ($profile_datas as $profile_data)
                                    <div class="col-lg-3 col-md-6 col-sm-6">
                                        <div class="item-all-card text-dark text-center card">
                                            <a href="{{ $profile_data['link'] }}"></a>
                                            <div class="iteam-all-icon1">
                                                <img src="{{ asset($profile_data['icon']) }}" class="imag-service"
                                                    alt="">
                                                <i class="{{ $profile_data['icon'] }}"></i>
                                            </div>
                                            <div class="item-all-text mt-3">
                                                <h5 class="mb-0 text-body">{{ __($profile_data['title']) }}
                                                    <span
                                                        class="notification-badge badge badge-warning">{{ $profile_data['totalcount'] ?? 0 }}</span>
                                                </h5>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="row row-cards">
                            @foreach ($application_datas as $a_data)
                                <div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
                                    <a href="{{ $a_data['link'] }}">
                                        <div class="card">
                                            <div class="card-body p-4 text-center feature">
                                                <p class="h2 text-center text-primary">{{ $a_data['totalcount'] ?? 0 }}
                                                </p>
                                                <p class="card-text mt-3 mb-3">{{ __($a_data['title']) }}</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    @if (!blank($saved_jobs))
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card mb-0">
                                    <div class="card-header">
                                        <div class="col-md-6">
                                            <div class="row">
                                                <h3 class="card-title" style="width: 100%;">{{ __('Saved Jobs') }}
                                                </h3>
                                            </div>
                                        </div>
                                        <div class="col-md-6 my-auto">
                                            <div class="row float-right">
                                                <a
                                                    href="{{ route('candidate.job_search.index', ['type' => 'saved_jobs']) }}">{{ __('View all') }}</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="">
                                            <div class="item2-gl">
                                                <div class="tab-content">
                                                    <div class="tab-pane active" id="tab-11">
                                                        @foreach ($saved_jobs as $item)
                                                            @if (!blank(data_get($item, 'job')))
                                                                <div class="card overflow-hidden  shadow-none">
                                                                    <div class="d-md-flex">
                                                                        <div class="p-0 m-0 item-card9-img">
                                                                            <div class="item-card9-imgs">
                                                                                <a
                                                                                    href="{{ route('viewJob', $item->job->id) }}"></a>
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
                                                                                    <a href="{{ route('viewJob', $item->job->id) }}"
                                                                                        class="text-dark">
                                                                                        <h4
                                                                                            class="font-weight-semibold mt-1">
                                                                                            {{ $item->job->title ?? '' }}({{ $item->job->num_of_positions ?? '' }})
                                                                                        </h4>
                                                                                    </a>
                                                                                    <div class="mt-2 mb-2">
                                                                                        @if ($item->job != null && $item->job->company != null)
                                                                                            <a href="{{ route('site.companydetail', $item->job->company->id) }}"
                                                                                                class="mr-4"><span>
                                                                                                    <i
                                                                                                        class="fa fa-building-o text-muted mr-1"></i>
                                                                                                    {{ $item->job->company->company_name ?? '' }}</span>
                                                                                            </a>
                                                                                            <span>
                                                                                                @if ($item->job != null && $item->job->country != null)
                                                                                                    <img class="mb-1"
                                                                                                        src="{{ asset('https://flagcdn.com/16x12/' . strtolower($item->job->country->iso2) . '.png') }}"
                                                                                                        alt="">
                                                                                                    {{ $item->job->country->name ?? '' }}
                                                                                                @endif
                                                                                            </span>
                                                                                        @endif
                                                                                    </div>
                                                                                    <div class="mt-2 mb-2">
                                                                                        <a class="mr-4">
                                                                                            <span>
                                                                                                Basic Salary:
                                                                                                <span style="color:blue">
                                                                                                    {{ $item->job != null && $item->job->country != null ? $item->job->country->currency : '' }}&nbsp;{{ $item->job != null ? $item->job->country_salary : '' }}&nbsp;&nbsp;
                                                                                                    @if ($item->job->country && $item->job->country->currency != 'NPR')
                                                                                                        NPR:
                                                                                                        {{ $item->job->nepali_salary ?? '' }}
                                                                                                    @endif
                                                                                                </span>
                                                                                            </span>
                                                                                        </a>
                                                                                        <a class="mr-4">
                                                                                            <span>Post On:
                                                                                                @if ($item->job != null)
                                                                                                    {{ $item->job->publish_date != null ? date('j M Y', strtotime($item->job->publish_date)) : '' }}
                                                                                                @endif
                                                                                            </span>
                                                                                        </a>
                                                                                        <a class="mr-4">
                                                                                            <span>Apply Before:
                                                                                                @if ($item->job != null)
                                                                                                    {{ $item->job->expiry_date != null ? date('j M Y', strtotime($item->job->expiry_date)) : '' }}
                                                                                                @endif
                                                                                            </span>
                                                                                        </a>
                                                                                        {{-- <div class="row">
                                                                                            <div class="col-md-12">
                                                                                                <h6>Basic Salary
                                                                                                    <span
                                                                                                        style="color: blue">
                                                                                                        {{ $item->job != null && $item->job->country != null ? $item->job->country->currency : '' }}&nbsp;{{ $item->job != null ? $item->job->country_salary : '' }}&nbsp;&nbsp;
                                                                                                        @if ($item->job->country && $item->job->country->currency != 'NPR')
                                                                                                            NPR:
                                                                                                            {{ $item->job->nepali_salary ?? '' }}
                                                                                                        @endif

                                                                                                    </span>
                                                                                                </h6>
                                                                                            </div>
                                                                                            <div class="col-md-12">
                                                                                                <h6>
                                                                                                    Post on
                                                                                                    @if ($item->job != null)
                                                                                                        {{ $item->job->publish_date != null ? date('j M Y', strtotime($item->job->publish_date)) : '' }}
                                                                                                    @endif
                                                                                                    - Apply before
                                                                                                    @if ($item->job != null)
                                                                                                        {{ $item->job->expiry_date != null ? date('j M Y', strtotime($item->job->expiry_date)) : '' }}
                                                                                                    @endif
                                                                                                </h6>
                                                                                            </div>
                                                                                            <div class="col-md-6">

                                                                                            </div>
                                                                                        </div> --}}
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
                                                                                                        ->where('job_id', $item->job->id)
                                                                                                        ->where('employ_id', $employe->id)
                                                                                                        ->first();

                                                                                                @endphp

                                                                                                <div class="col-md-3">
                                                                                                    @if ($application)
                                                                                                        <a href="javascript:void(0);"
                                                                                                            class="btn btn-primary btn-block">{{ __('Applied') }}</a>
                                                                                                    @else
                                                                                                        <a href="{{ route('applyForJob', $item->job->id) }}"
                                                                                                            class="btn btn-primary btn-block">
                                                                                                            {{ __('Apply Now') }}</a>
                                                                                                    @endif
                                                                                                </div>
                                                                                                <div class="col-md-3">
                                                                                                    <a href="javascript:void(0);"
                                                                                                        class="saveJobButton btn btn-warning btn-block">
                                                                                                        <i
                                                                                                            class="fa fa-heart"></i>
                                                                                                        {{ __('Saved') }}
                                                                                                    </a>
                                                                                                </div>
                                                                                                <div class="col-md-3">
                                                                                                    <a href="{{ route('viewJob', $item->job->id) }}"
                                                                                                        class="btn btn-warning btn-block">
                                                                                                        <i
                                                                                                            class="fa fa-eye"></i>&nbsp;{{ __('View Details') }}
                                                                                                    </a>
                                                                                                </div>
                                                                                                <div class="col-md-3">
                                                                                                    <div class="sharethis-inline-share-buttons"
                                                                                                        data-url="{{ route('viewJob', $item->job->id) }}">
                                                                                                    </div>
                                                                                                </div>
                                                                                            @elseif(auth()->user()->user_type == 'company')
                                                                                                <div class="col-md-3">
                                                                                                    <a href="{{ route('viewJob', $item->job->id) }}"
                                                                                                        class="btn btn-warning btn-block">
                                                                                                        <i
                                                                                                            class="fa fa-eye"></i>&nbsp;{{ __('View Details') }}
                                                                                                    </a>
                                                                                                </div>
                                                                                                <div class="col-md-3">
                                                                                                    <div class="sharethis-inline-share-buttons"
                                                                                                        data-url="{{ route('viewJob', $item->job->id) }}">
                                                                                                    </div>
                                                                                                </div>
                                                                                            @endif
                                                                                        @else
                                                                                            <div class="col-md-3">
                                                                                                <a href="{{ route('applyForJob', $item->job->id) }}"
                                                                                                    class="btn btn-primary btn-block">
                                                                                                    {{ __('Apply Now') }}</a>
                                                                                            </div>
                                                                                            <div class="col-md-3">
                                                                                                <a href="{{ route('viewJob', $item->job->id) }}"
                                                                                                    class="btn btn-warning btn-block">
                                                                                                    <i
                                                                                                        class="fa fa-eye"></i>&nbsp;{{ __('View Details') }}
                                                                                                </a>
                                                                                            </div>
                                                                                            <div class="col-md-3">
                                                                                                <div class="sharethis-inline-share-buttons"
                                                                                                    data-url="{{ route('viewJob', $item->job->id) }}">
                                                                                                </div>
                                                                                            </div>
                                                                                        @endauth
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="row mt-5">
                        <div class="col-md-6">
                            <div class="card mb-0">
                                <div class="card-header">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <h3 class="card-title">{{ __('Countries') }}</h3>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row float-right">
                                            <a href="#" class="float-right">{{ __('View All') }}</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="container">
                                        @foreach ($Countries as $country)
                                            <a href="javascript:void()" class="d-flex mb-2">
                                                <img src="{{ 'https://ipdata.co/flags/' . strtolower($country->iso2) . '.png' }}"
                                                    alt="img" class="w-4 h-4">
                                                <div class="ml-5 my-auto">
                                                    <h6 class="font-weight-bold">
                                                        {{ $country->name }}&nbsp;({{ $country->jobs_count }})
                                                    </h6>
                                                </div>
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card mb-0">
                                <div class="card-header">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <h3 class="card-title">{{ __('Latest News Update') }}</h3>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row float-right">
                                            <a href="{{ route('candidate.news.index') }}"
                                                class="float-right">{{ __('View All') }}</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    @foreach ($news as $nitem)
                                        <div class="container">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <div class="news-title">
                                                            <a href="{{ route('news.details', $nitem->slug) }}">
                                                                <h5>{{ \Illuminate\Support\Str::limit($nitem->title, 20) }}
                                                                </h5>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="row float-right">
                                                        <p class="">{{ parseDate($nitem->created_at) }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @if ($loop->first)
                                            <hr style="margin-top: 0rem !important; margin-bottom: 1rem !important;">
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
@endsection
