@extends('themes.fvft.candidates.layouts.dashmaster')
@section('title') Useful Information @stop
@section('content')
    <section>
        <div class="bannerimg cover-image bg-background3" data-image-src="../assets/images/banners/banner2.jpg"
            style="background: url(&quot;../assets/images/banners/banner2.jpg&quot;) center center;">
            <div class="header-text mb-0">
                <div class="text-center text-white">
                    <h1 class="">{{ __('Useful Informations') }}</h1>
                    <ol class="breadcrumb text-center">
                        <li class="breadcrumb-item"><a href="#">{{ __('Home') }}</a></li>
                        <li class="breadcrumb-item"><a href="#">{{ __('Dashboard') }} </a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">{{ __('Informations') }}</li>
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
                                <h3 class="card-title">{{ __('Useful Information') }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        @foreach ($informations as $information)
                            <div class="col-md-6">
                                <a href="{{ route('candidate.usefulinfo.detail', $information->slug) }}">
                                    <div class="row {{ $loop->iteration % 2 == 0 ? 'ml-auto' : '' }}">
        
                                        <div class="card card-aside">
                                            <div class="card-body" style="padding: 1rem 1rem;">
                                                <div class="card-item d-flex">
                                                    <img src="{{ asset('/') }}{{ $information->logo ?? 'images/defaultimage.jpg' }}"
                                                        alt="img" class="w-8 h-8">
                                                    <div class="ml-5 my-auto">
                                                        <h6 class="font-weight-bold">
                                                            {{ $information->title }}</h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
