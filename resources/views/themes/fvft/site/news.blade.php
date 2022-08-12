@extends('themes.fvft.layouts.master')
@section('title')
    News & Notices
@endsection
@section('style')
<!-- jquery ui RangeSlider -->
<link href="{{asset('themes/fvft/')}}/assets/plugins/jquery-uislider/jquery-ui.css" rel="stylesheet">
@endsection
@section('main')
        @include('themes.fvft.site.components.header')
        	<!--Breadcrumb-->
		<section>
			<div class="bannerimg cover-image bg-background3" data-image-src="{{ asset('/uploads/site/banner.png') }}">
				<div class="header-text mb-0">
					<div class="container">
						<div class="text-center text-white">
							<h1 class="">{{ __('News') }}</h1>
							<ol class="breadcrumb text-center">
								<li class="breadcrumb-item"><a href="#">{{ __('Home') }}</a></li>
								<li class="breadcrumb-item active text-white" aria-current="page">{{ __('News') }}</li>
							</ol>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!--/Breadcrumb-->

		<!--Job listing-->
		<section class="sptb">
			<div class="container">
				<div class="row">
					<div class="col-xl-8 col-lg-8 col-md-12">
						<!--Job lists-->
						<div class="row">
							@foreach ($news as $item)
							<div class="col-xl-12 col-lg-12 col-md-12">
								<div class="card overflow-hidden">
									{{-- <div class="ribbon ribbon-top-left text-warning"><span class="bg-warning">featured</span></div> --}}
									<div class="row no-gutters blog-list">
										<div class="col-xl-4 col-lg-12 col-md-12">
											<div class="item7-card-img">
												<a href="/news/{{$item->slug}}"></a>
												<img src="{{asset('/')}}{{(!blank($item->feature_img) AND file_exists($item->feature_img)) ? $item->feature_img : 'images/defaultimage.jpg'}}" alt="img" class="cover-image">
												<div class="item7-card-text">
													{{-- <span class="badge badge-warning">Jobs</span> --}}
												</div>
											</div>
										</div>
										<div class="col-xl-8 col-lg-12 col-md-12">
											<div class="card-body">
												<div class="item7-card-desc d-flex mb-1">
													<a href="#"><i class="fa fa-calendar-o text-muted mr-2"></i>{{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</a>
													<a href="#"><i class="fa fa-user text-muted mr-2"></i>FreeVisaFreeTicket</a>

												</div>
												<a href="/news/{{$item->slug}}" class="text-dark"><h4 class="font-weight-semibold mb-3">{{ $item->title}}</h4></a>
												<p class="mb-1">{{  Str::limit($item->short_description,50) }}
												</p>
												<a href="/news/{{$item->slug}}" class="btn btn-primary btn-sm mt-4">{{ __('Read More') }}</a>
											</div>
										</div>
									</div>
								</div>
							</div>
							@endforeach

						</div>
						<div class="center-block text-center">
							{{$news->links('vendor.pagination.bootstrap-4') }}
						</div>
						<!--/Job lists-->
					</div>

					@include('themes.fvft.site.components.news.sidebar')
				</div>
			</div>
		</section>
		<!--All Listing-->

		@include('themes.fvft.site.components.footer')
@endsection
