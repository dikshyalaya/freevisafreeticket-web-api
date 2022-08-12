@extends('themes.fvft.candidates.layouts.dashmaster')
@section('title', 'News')
@section('style')
<style>
    a.newsitem{
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
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="card mb-0">
                                    <div class="card-body">
                                        <h3 class="card-title">{{ $news->title }}</h3>
                                        <p>{{ date('F j, Y', strtotime($news->created_at)) }}</p>
                                        <div class="image">
                                            <div class="item7-card-img">
                                                <img src="{{ asset('/') }}{{ $news->feature_img ?? 'images/defaultimage.jpg' }}"
                                                    alt="img" class="cover-image">
                                            </div>
                                            <p class="mt-3 text-center">{{ $news->title }}</p>
                                        </div>
                                        <hr>
                                        <div class="desc">
                                            {!! html_entity_decode($news->html_content) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row ml-1">
                                <div class="card mb-0">
                                    <div class="card-body">
                                        <h3 class="card-title">{{ __('Other News') }}</h3>
                                        @foreach ($other_news as $onitem)
                                            <div class="news-section">
                                                <div class="d-flex justify-content-between">
                                                    <div class="news-image w-25">
                                                        <a href="{{ route('candidate.news.detail', $onitem->slug) }}">
                                                            <img src="{{ asset('/') }}{{ $onitem->feature_img ?? 'images/defaultimage.jpg' }}"
                                                                alt="img">
                                                        </a>
                                                    </div>
                                                    <div class="news-title w-70">
                                                        <a class="newsitem" href="{{ route('candidate.news.detail', $onitem->slug) }}">
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
