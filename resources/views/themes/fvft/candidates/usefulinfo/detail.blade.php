@extends('themes.fvft.candidates.layouts.dashmaster')
@section('title', 'Useful Information')
@section('style')
    <style>
        a.informationitem {
            color: #343a40;
        }

    </style>
@endsection
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
                        <li class="breadcrumb-item active text-white" aria-current="page">{{ __('Information') }}</li>
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
                        <div class="card mb-2">
                            <div class="card-header">
                                <div class="row">
                                    <div class="d-flex">
                                        <img src="{{ asset('/') }}{{ $information->logo ?? 'images/defaultimage.jpg' }}"
                                            alt="img" class="w-25">
                                        <h3 class="card-title my-auto ml-5">{{ $information->title }}</h3>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="card mb-0">
                                    <div class="card-body">
                                        <div class="desc">
                                            {!! html_entity_decode($information->desc_content) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row ml-1">
                                <div class="card mb-0">
                                    <div class="card-body">
                                        <h3 class="card-title">{{ __('Other Useful Informations') }}</h3>
                                        @foreach ($other_information as $onitem)
                                            <div class="information-section">
                                                <div class="d-flex justify-content-between">
                                                    <div class="information-image w-25">
                                                        <a
                                                            href="{{ route('candidate.usefulinfo.detail', $onitem->slug) }}">
                                                            <img src="{{ asset('/') }}{{ $onitem->logo ?? 'images/defaultimage.jpg' }}"
                                                                alt="img">
                                                        </a>
                                                    </div>
                                                    <div class="information-title my-auto w-70">
                                                        <a class="informationitem"
                                                            href="{{ route('candidate.usefulinfo.detail', $onitem->slug) }}">
                                                            <p>{{ $onitem->title }}</p>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            @if ($loop->first)
                                                <hr style="margin-bottom: 0.5rem !important; margin-top: 1rem !important">
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
