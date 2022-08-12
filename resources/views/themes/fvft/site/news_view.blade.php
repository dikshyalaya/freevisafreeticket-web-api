@extends('themes.fvft.layouts.master')
@section('title')
    {{ $news->title ?? '' }}
@endsection
@section('style')
<!-- jquery ui RangeSlider -->
<link href="{{asset('themes/fvft/')}}/assets/plugins/jquery-uislider/jquery-ui.css" rel="stylesheet">
@endsection
@section('main')
        @include('themes.fvft.site.components.header')
        	<!--Breadcrumb-->
		<section>
			<div class="bannerimg cover-image bg-background3 news-header" data-image-src="../assets/images/banners/banner2.jpg">
				<div class="header-text mb-0">
					<div class="container">
						<div class="text-center text-white">
							<h1 class="">{{ $news->title}}</h1>
							<ol class="breadcrumb text-center">
								<li class="breadcrumb-item"><a href="/">Home</a></li>
								<li class="breadcrumb-item"><a href="/news">News</a></li>
								<li class="breadcrumb-item active text-white" aria-current="page">{{ $news->title }}</li>
							</ol>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!--/Breadcrumb-->

	<!--Job listing-->
    <section class="sptb news-body">
        <div class="container">
            <div class="row">
                <div class="col-xl-8 col-lg-8 col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="item7-card-img">
                                @if (!blank($news->feature_img))
                                    <img src="{{ asset($news->feature_img) }}" alt="img" class="cover-image">
                                @else
                                    <img src="{{ asset('/images/defaultimage.jpg') }}" alt="img"
                                         class="cover-image">
                                @endif
                                <div class="item7-card-text">
                                    <span class="badge badge-pink">News</span>
                                </div>
                            </div>
                            <div class="item7-card-desc d-flex mb-2 mt-3">
                                <a href="#"><i class="fa fa-calendar-o text-muted mr-2"></i>{{ \Carbon\Carbon::parse($news->created_at)->diffForHumans() }}</a>
                                <a href="#"><i class="fa fa-user text-muted mr-2"></i>FreeVisaFreeTicket</a>

                            </div>
                            <a href="#" class="text-dark"><h2 class="font-weight-semibold">{{ $news->title}}</h2></a>
                           {!! html_entity_decode($news->html_content) !!}
                        </div>
                    </div>

                </div>

                @include('themes.fvft.site.components.news.sidebar')
            </div>
        </div>
    </section>
    <!--/Job listing-->

		@include('themes.fvft.site.components.footer')
@endsection
