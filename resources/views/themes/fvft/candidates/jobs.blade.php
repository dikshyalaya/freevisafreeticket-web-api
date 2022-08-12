@extends('themes.fvft.candidates.layouts.dashmaster')
@section('title') My Jobs @stop
@section('content')
<section>
    <div class="bannerimg cover-image bg-background3" data-image-src="../assets/images/banners/banner2.jpg" style="background: url(&quot;../assets/images/banners/banner2.jpg&quot;) center center;">
        <div class="header-text mb-0">
            <div class="text-center text-white">
                <h1 class="">My Jobs</h1>
                <ol class="breadcrumb text-center">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Dashboard </a></li>
                    <li class="breadcrumb-item active text-white" aria-current="page">My Jobs</li>
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
                        <h3 class="card-title">My Jobs</h3>
                    </div>
                    <div class="card-body">
                        <div class="ads-tabs">
                            <div class="tabs-menus">
                                <!-- Tabs -->
                                <ul class="nav panel-tabs">
                                    <li class=""><a href="#tab1" class="active" data-toggle="tab">All Jobs</a></li>
                                    <li><a href="#tab2" data-toggle="tab" class="">Pending</a></li>
                                    <li><a href="#tab3" data-toggle="tab" class="">Accepted</a></li>
                                    <li><a href="#tab4" data-toggle="tab" class="">Rejected</a></li>
                                </ul>
                            </div>
                            <div class="tab-content">
                                <div class="tab-pane table-responsive border-top userprof-tab active" id="tab1">
                                    @include('themes.fvft.candidates.components.jobs.joblist',['items'=>$all_jobs,'action'=>'All Jobs'])
                                </div>
                                <div class="tab-pane table-responsive border-top userprof-tab" id="tab2">
                                    @include('themes.fvft.candidates.components.jobs.joblist',['items'=>$pending_jobs,'action'=>'Pending Jobs '])
                                </div>
                                <div class="tab-pane table-responsive border-top userprof-tab" id="tab3">
                                    @include('themes.fvft.candidates.components.jobs.joblist',['items'=>$accepted_jobs,'action'=>'Accepted Jobs'])
                                </div>
                                <div class="tab-pane table-responsive border-top userprof-tab " id="tab4">
                                    @include('themes.fvft.candidates.components.jobs.joblist',['items'=>$rejected_jobs,'action'=>'Rejected Jobs'])
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
