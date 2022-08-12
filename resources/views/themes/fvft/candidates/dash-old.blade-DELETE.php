@extends('themes.fvft.candidates.layouts.dashmaster')
@section('style')
    <link rel="stylesheet" href="{{ asset('css/progress.css') }}">
@endsection
@section('content')
    <section>
        <div class="bannerimg cover-image bg-background3" data-image-src="../assets/images/banners/banner2.jpg"
            style="background: url(&quot;../assets/images/banners/banner2.jpg&quot;) center center;">
            <div class="header-text mb-0">
                <div class="text-center text-white">
                    <h1 class="">My Dashboard</h1>
                    <ol class="breadcrumb text-center">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">My Dashboard </a></li>
                        {{-- <li class="breadcrumb-item active text-white" aria-current="page">My Jobs</li> --}}
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
                    <div class="card mb-0">
                        <div class="card-header">
                            <h3 class="card-title">Dashboard</h3>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-8">
                            <div class="row">
                                @foreach ($totals as $item)
                                    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
                                        <div class="card overflow-hidden">
                                            <div class="card-header">
                                                <h3 class="card-title">{{ $item['title'] }}</h3>
                                                <div class="card-options"> <a class="btn btn-sm btn-primary"
                                                        href="{{ $item['links'] }}">View</a> </div>
                                            </div>
                                            <div class="card-body ">
                                                <h5 class="">Total {{ $item['title'] }}</h5>
                                                <h2 class="text-dark  mt-0 ">{{ $item['total'] }}</h2>
                                                <div class="progress progress-sm mt-0 mb-2">
                                                    <div class="progress-bar bg-primary w-{{ $item['total'] }}"
                                                        role="progressbar"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="row">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="profile-completeness">
                                            <h5 class="text-center mb-3 font-weight-bold">Profile Completion</h5>
                                            <div class="progress blue">
                                                <span class="progress-left">
                                                    <span class="progress-bar"></span>
                                                </span>
                                                <span class="progress-right">
                                                    <span class="progress-bar"></span>
                                                </span>
                                                <div class="progress-value">{{ $employe->calculateProfileCompletion() }}%
                                                </div>
                                            </div>
                                        </div>
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
