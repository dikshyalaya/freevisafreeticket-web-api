@extends('themes.fvft.candidates.layouts.dashmaster')
@section('title') Support @stop
@section('content')
    <section>
        <div class="bannerimg cover-image bg-background3" data-image-src="../assets/images/banners/banner2.jpg"
            style="background: url(&quot;../assets/images/banners/banner2.jpg&quot;) center center;">
            <div class="header-text mb-0">
                <div class="text-center text-white">
                    <h1 class="">{{ __('Support') }}</h1>
                    <ol class="breadcrumb text-center">
                        <li class="breadcrumb-item"><a href="#">{{ __('Home') }}</a></li>
                        <li class="breadcrumb-item"><a href="#">{{ __('Dashboard') }} </a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">{{ __('Support') }}</li>
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
                                <h3 class="card-title">{{ __('Support') }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="card mb-2">
                            <div class="card-body">
                                <div class="breadcrumb mb-3">
                                    <p class="text-primary">FVFT JobSeeker&nbsp;&nbsp;&nbsp;<span class="text-dark ">></span>&nbsp;&nbsp;&nbsp;<span>{{ $support_category->title }}</span></p>
                                </div>
                                <h3>{{ $support_category->title }}</h3>
                                <div class="mt-5 question_lists">
                                    @foreach($supports as $support)
                                        <div class="col-md-12 mt-1">
                                            <a href="{{ route('candidate.support.get_support_answer', $support->slug) }}" class="text-primary">{{ $support->question }}</a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
