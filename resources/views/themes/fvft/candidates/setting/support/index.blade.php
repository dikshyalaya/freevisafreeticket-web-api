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
                        <li class="breadcrumb-item active text-white" aria-current="page">{{ __('Setting') }}</li>
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
                                <h3 class="font-weight-bold">{{ strtoupper(__('Settings')) }}</h3>
                                <div id="basicwizard" class="border pt-0">
                                    @include('partial/candidates/setting_tabs')
                                </div>
                            </div>
                        </div>
                        <div class="tab-menu-heading">
                            <div class="tabs-menu ">
                                <!-- Tabs -->
                                <ul class="nav panel-tabs">
                                    @foreach ($pages as $page)
                                        <li class=""><a href="#tab{{ $loop->iteration }}"
                                                class="{{ $loop->first ? 'active' : '' }}"
                                                data-toggle="tab">{{ strtoupper(__($page->title)) }}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="card mb-0">
                            <div class="card-body">
                                <div class="tab-content">
                                    @foreach ($pages as $page)
                                        <div class="tab-pane {{ $loop->first ? 'active' : '' }} "
                                            id="tab{{ $loop->iteration }}">
                                            {!! html_entity_decode($page->html_content) !!}
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

@section('script')

@endsection
