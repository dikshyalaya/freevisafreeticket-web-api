@if(isset($latest_jobs) AND !blank($latest_jobs))
    <section class="sptb bg-white">
        <div class="container closed" id="container1" style="height: 315px; overflow: hidden;">
            <div class="section-title center-block text-center">
                <h1>{{ __('Recent Jobs') }}</h1>
                <p>Mauris ut cursus nunc. Morbi eleifend, ligula at consectetur vehicula</p>
            </div>
            <div class="row">
                @foreach ($latest_jobs as $job)
                    <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12">
                        <div class="card overflow-hidden">
                            <div class="power-ribbon power-ribbon-top-left text-warning">
                                <span class="bg-warning"><i class="fa fa-bolt"></i></span>
                            </div>
                            <div class="card-body">
                                <div class="item-det row">
                                    <div class="col-md-9">
                                        <a href="{{ route('viewJob', $job->id) }}" class="text-dark">
                                            <h4 class="mb-2 fs-16 font-weight-semibold">
                                                {{ $job->title }}
                                                <span class="badge badge-warning fs-12">Expires in {{ \Carbon\Carbon::parse($job->expiry_date)->diffForHumans() }}</span>
                                            </h4>
                                        </a>
                                        <div class="">
                                            <ul class="mb-0 d-flex">
                                                @if(!blank(data_get($job, 'company.company_name')))
                                                    <li class="mr-5">
                                                        <a href="#" class="icons">
                                                            <i class="si si-briefcase text-muted mr-1"></i> {{ data_get($job, 'company.company_name') }}
                                                        </a>
                                                    </li>
                                                @endif
                                                @if(!blank(data_get($job, 'country.name')))
                                                    <li class="">
                                                        <a href="#" class="icons"><i class="si si-location-pin text-muted mr-1"></i>
                                                            {{ data_get($job, 'country.name') }}
                                                        </a>
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-auto">
                                        <div class="icons mt-3 mt-sm-0 pb-0">
                                            <a href="/apply-job/{{ $job->id }}" class="btn  btn-primary mt-2 float-md-right"> {{ __('Apply Now') }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif


<!--Latest Jobs-->
{{--<section class="sptb bg-white">--}}
{{--<div class="container">--}}
{{--<div class="section-title center-block text-center">--}}
{{--<h1>New Jobs</h1>--}}
{{-- <p>Mauris ut cursus nunc. Morbi eleifend, ligula at consectetur vehicula</p> --}}
{{--</div>--}}
{{--<div class="owl-carousel owl-carousel-icons2">--}}
{{--@foreach ($latest_jobs as $job)--}}
{{--<div class="item">--}}
{{--<div class="card mb-0">--}}
{{--<div class="card-body">--}}
{{--<div class="power-ribbon power-ribbon-top-left text-warning">--}}
{{--<span class="bg-warning"><i class="fa fa-bolt"></i></span>--}}
{{--</div>--}}
{{--@if(!blank($job->feature_image_url))--}}
{{--<img src="{{ asset($job->feature_image_url) }}" alt="{{ $job->title }}" class=" avatar avatar-xxl brround mx-auto">--}}
{{--@else--}}
{{--<img src="{{ asset("/uploads/site/logo-min.png") }}" alt="{{ $job->title }}" class=" avatar avatar-xxl brround mx-auto">--}}
{{--@endif--}}
{{--<div class="item-card2">--}}
{{--<div class="item-card2-desc">--}}
{{--<div class="text-center">--}}
{{--<div class="item-card2-text mt-3">--}}
{{--<a href="/job/{{$job->id}}" class="text-dark">--}}
{{--<h4 class="font-weight-bold">{{ $job->title }}</h4>--}}
{{--</a>--}}
{{--</div>--}}
{{--<p class="">{{ data_get('category.functional_area', $job) }}</p>--}}
{{--</div>--}}
{{--<div class="item-card7-text">--}}
{{--<ul class="icon-card mb-0">--}}
{{--<li class="">--}}
{{--<a href="#" class="icons"><i class="si si-location-pin text-muted mr-1"></i>--}}
{{--{{ data_get($job, 'country.name') }}--}}
{{--</a>--}}
{{--</li>--}}
{{--<li>--}}
{{--<a href="#" class="icons"><i class="si si-event text-muted mr-1"></i>--}}
{{--{{ \Carbon\Carbon::parse($job->created_at)->diffForHumans() }}--}}
{{--</a>--}}
{{--</li>--}}
{{--<li class="mb-0">--}}
{{--<a href="#" class="icons"><i class="si si-user text-muted mr-1"></i>--}}
{{--{{ data_get($job, 'company.company_name') }}--}}
{{--</a>--}}
{{--</li>--}}
{{--<li class="mb-2">--}}
{{--<a href="#" class="icons"><i class="si si-briefcase text-muted mr-1"></i>--}}
{{--{{ \Carbon\Carbon::parse($job->expiry_date)->diffForHumans() }}--}}
{{--</a>--}}
{{--</li>--}}
{{--</ul>--}}
{{--</div>--}}
{{--<div class="text-center">--}}
{{--<a href="/job/{{$job->id}}" class="btn btn-white btn-sm mt-2">--}}
{{--{{$job->num_of_positions}} Positions--}}
{{--</a>--}}
{{--</div>--}}
{{--</div>--}}
{{--</div>--}}
{{--</div>--}}
{{--<div class="card-footer  p-0">--}}
{{--<div class=" w-100">--}}
{{--<a class="float-left w-50 text-center p-2 border-right text-muted" href="#"><i class="fa fa-clock-o mr-1"></i> Part Time</a>--}}
{{--<a class=" float-left w-50 text-center p-2  text-muted" href="#"><i class="fa fa-usd mr-1"></i> 32 - 40</a>--}}
{{--</div>--}}
{{--</div>--}}
{{--</div>--}}
{{--</div>--}}
{{--@endforeach--}}
{{--</div>--}}
{{--</div>--}}
{{--</section>--}}
