@php
$footer_cats= DB::table("job_categories")->limit(5)->get();
$job_shifts= DB::table("job_shifts")->get();
$pages= DB::table("pages")->limit(5)->get();
@endphp
<!--Footer Section-->
		<section class="main-footer">
			<footer class="bg-dark text-white cover-image" data-image-src="{{asset('themes/fvft/')}}/assets/images/banners/banner3.jpg">
				<div class="footer-main">
					<div class="container">
						<div class="row">
							<div class="col-lg-3 col-md-12">
								<h6>{{ __('Job') }} {{ __('Categories') }}</h6>
								<hr class="deep-purple  accent-2 mb-4 mt-0 d-inline-block mx-auto">
								<ul class="list-unstyled mb-0">
									@foreach ($footer_cats as $item)
									<li><a href="{{ route('site.jobs',['job_category' => $item->id]) }}"> {{$item->functional_area}} </a></li>
									@endforeach
								</ul>
							</div>
							<div class="col-lg-3 col-md-12">
								<h6>{{ __('Job Shifts') }}</h6>
								<hr class="deep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto">
								<ul class="list-unstyled mb-0">
									@foreach ($job_shifts as $item)
									<li><a href="/jobs&job_shift={{$item->id}}">{{$item->job_shift}}</a></li>
									@endforeach
								</ul>
							</div>
							<div class="col-lg-3 col-md-12">
								<h6>{{ __('Pages') }}</h6>
								<hr class="deep-purple  accent-2 mb-4 mt-0 d-inline-block mx-auto">
								<ul class="list-unstyled mb-0">
									@foreach ($pages as $item)
									<li><a href="/page/{{$item->slug}}"><i class="fa fa-caret-right text-white-50"></i> {{$item->title}}</a></li>
									@endforeach
								</ul>
							</div>
							<div class="col-lg-3 col-md-12">
								<h6 class="mb-2">{{ __('Subscribe') }}</h6>
								<hr class="deep-purple  accent-2 mb-4 mt-0 d-inline-block mx-auto">
								<div class="input-group w-100">
									<input type="text" class="form-control " placeholder="{{ __('Email') }}">
									<div class="input-group-append ">
										<button type="button" class="btn btn-primary "> {{ __('Subscribe') }} </button>
									</div>
								</div>
							
							</div>
						</div>
					</div>
				</div>
				<div class="text-white-50 border-top p-0">
					<div class="container">
						<div class="row d-flex">
							<div class="col-lg-8 col-sm-12  mt-2 mb-2 text-left ">
								Copyright © 2022&nbsp;&nbsp;<a href="/" class="fs-14 text-white">FreeVisaFreeTicket</a>.All rights reserved.
							</div>
							<div class="col-lg-4 col-sm-12 ml-auto mb-2 mt-2 d-none d-lg-block">
								<ul class="social mb-0">
									<li>
										<a class="social-icon" href=""><i class="fa fa-facebook"></i></a>
									</li>
									<li>
										<a class="social-icon" href=""><i class="fa fa-twitter"></i></a>
									</li>
									<li>
										<a class="social-icon" href=""><i class="fa fa-rss"></i></a>
									</li>
									<li>
										<a class="social-icon" href=""><i class="fa fa-youtube"></i></a>
									</li>
									<li>
										<a class="social-icon" href=""><i class="fa fa-linkedin"></i></a>
									</li>
									<li>
										<a class="social-icon" href=""><i class="fa fa-google-plus"></i></a>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
				<div class="text-white p-0 border-top">
					<div class="container">
						<div class="p-2 text-center footer-links">
							@foreach ($pages as $item)
									<a href="/page/{{$item->slug}}" class="btn btn-link">{{$item->title}}</a>
							@endforeach
						</div>
					</div>
				</div>
			</footer>
		</section>
		<!--Footer Section-->