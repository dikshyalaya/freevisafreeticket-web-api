@extends('themes.fvft.layouts.master')
@section('title')
    {{ $page->title ?? '' }}
@endsection
@section('style')
<!-- jquery ui RangeSlider -->
<link href="{{asset('themes/fvft/')}}/assets/plugins/jquery-uislider/jquery-ui.css" rel="stylesheet">
@endsection
@section('main')
        @include('themes.fvft.site.components.header')
        	<!--Breadcrumb-->
		<section>
			<div class="bannerimg cover-image bg-background3" data-image-src="../assets/images/banners/banner2.jpg">
				<div class="header-text mb-0">
					<div class="container">
						<div class="text-center text-white">
							<h1 class="">{{ $page->title}}</h1>
							<ol class="breadcrumb text-center">
								<li class="breadcrumb-item"><a href="#">Home</a></li>
								<li class="breadcrumb-item"><a href="#">Page</a></li>
								<li class="breadcrumb-item active text-white" aria-current="page">{{ $page->title}}</li>
							</ol>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!--/Breadcrumb-->

    <!--Faq section-->
    <section class="sptb">
        <div class="container">
            <div class="card">
                <div class="card-body">
                    {!! html_entity_decode($page->html_content) !!}
                </div>
            </div>
        </div>
    </section>
    <!--/Faq section-->

		@include('themes.fvft.site.components.footer')
@endsection
