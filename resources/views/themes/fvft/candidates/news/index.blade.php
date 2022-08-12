@extends('themes.fvft.candidates.layouts.dashmaster')
@section('title', 'News')
@section('content')
    <section>
        <div class="bannerimg cover-image bg-background3" data-image-src="../assets/images/banners/banner2.jpg"
            style="background: url(&quot;../assets/images/banners/banner2.jpg&quot;) center center;">
            <div class="header-text mb-0">
                <div class="text-center text-white">
                    <h1 class="">{{ __('News') }}</h1>
                    <ol class="breadcrumb text-center">
                        <li class="breadcrumb-item"><a href="#">{{ __('Home') }}</a></li>
                        <li class="breadcrumb-item"><a href="#">{{ __('Dashboard') }} </a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">{{ __('News') }}</li>
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
                            <div class="card-body">
                                <h3 class="font-weight-bold">{{ strtoupper(__('News')) }}</h3>
                                <div id="basicwizard" class="border pt-0">
                                    @include('partial/candidates/news/tabs')
                                </div>
                            </div>
                        </div>
                        <div class="card mb-0">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xl-12 col-lg-12 col-md-12">
                                        <div class="row">
                                            @foreach ($news as $nitem)
                                                <div class="col-xl-4 col-lg-12 col-md-12">
                                                    <div class="card">
                                                        <a href="{{ route('candidate.news.detail', $nitem->slug) }}">
                                                            <div class="item7-card-img">
                                                                <img src="{{ asset('/') }}{{ $nitem->feature_img ?? 'images/defaultimage.jpg' }}"
                                                                    alt="img" class="cover-image">
                                                            </div>
                                                        </a>
                                                        <div class="card-body">
                                                            <a href="{{ route('candidate.news.detail', $nitem->slug) }}"
                                                                class="text-dark">
                                                                <h4 class="font-weight-semibold">{{ $nitem->title }}</h4>
                                                            </a>
                                                            <p>{!! mb_strimwidth(html_entity_decode($nitem->html_content), 0, 90, '..') !!}</p>
                                                            <span><i
                                                                    class="fa fa-clock-o"></i>&nbsp;{{ parseDate($nitem->created_at) }}</span>
                                                            <a href="{{ route('candidate.news.detail', $nitem->slug) }}"
                                                                class="float-right text-primary">{{ __('More') }}&nbsp;<i
                                                                    class="mdi mdi-arrow-down-drop-circle"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="center-block text-center">
                                            {{ $news->links('vendor.pagination.bootstrap-4') }}
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
