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

    </style>
    <section>
        <div class="bannerimg cover-image bg-background3" data-image-src="../assets/images/banners/banner2.jpg"
            style="background: url(&quot;../assets/images/banners/banner2.jpg&quot;) center center;">
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
                    <div class="row">
                        <div class="card mb-2">
                            <div class="card-header">
                                <h3 class="card-title">{{ __('Job Search') }}</h3>
                            </div>
                        </div>
                    </div>
                    @include('partial.candidates.job_search.tabs')
                    @if (auth()->check() and auth()->user()->user_type == 'candidate')
                        <x-job-detail :job="$job" :employ="$employ" />
                    @else
                        <x-job-detail :job="$job" />
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
