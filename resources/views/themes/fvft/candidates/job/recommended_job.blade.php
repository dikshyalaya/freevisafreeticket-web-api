@extends('themes.fvft.candidates.layouts.dashmaster')
@section('title', 'Recommended Jobs')
@section('style')
@endsection

@section('content')
    <section>
        <div class="bannerimg cover-image bg-background3" data-image-src="../assets/images/banners/banner2.jpg"
            style="background: url(&quot;../assets/images/banners/banner2.jpg&quot;) center center;">
            <div class="header-text mb-0">
                <div class="text-center text-white">
                    <h1 class="">{{ __('Recommended Jobs') }}</h1>
                    <ol class="breadcrumb text-center">
                        <li class="breadcrumb-item"><a href="#">{{ __('Home') }}</a></li>
                        <li class="breadcrumb-item"><a href="#">{{ __('Dashboard') }} </a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">{{ __('Recommended Jobs') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="sptb">
        <div class="container">
            <div class="row ">
                <div class="col-xl-3 col-lg-12 col-md-12">
                    @include('themes.fvft.candidates.components.sidebar')
                </div>
                <div class="col-xl-9 col-lg-12 col-md-12">

                    <!--Job lists-->
                    <div class=" mb-lg-0">
                        <div class="">
                            <div class="item2-gl">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab-11">
                                        @if ($recommended_jobs != null)
                                            @foreach ($recommended_jobs as $recommended_job)
                                                @php
                                                    $company = DB::table('companies')->find($recommended_job->company_id);
                                                @endphp
                                                <div class="card overflow-hidden">
                                                    <div class="d-md-flex">
                                                        <div class="p-0 m-0 item-card9-img">
                                                            <div class="item-card9-imgs">
                                                                <a href="{{ route('viewJob', $recommended_job->id) }}">
                                                                    <img src="{{ asset('/' . $recommended_job->feature_image_url) }}"
                                                                        alt="img" class="h-100">
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="card overflow-hidden  border-0 box-shadow-0 border-left br-0 mb-0">
                                                            <div class="card-body pt-0 pt-md-5">
                                                                <div class="item-card9">
                                                                    <a href="{{ route('viewJob', $recommended_job->id) }}"
                                                                        class="text-dark">
                                                                        <h4 class="font-weight-semibold mt-1">
                                                                            {{ $recommended_job->title }}</h4>
                                                                    </a>
                                                                    <div class="mt-2 mb-2">
                                                                        @isset($company)
                                                                            <a href="/company-view/{{ $company->id }}"
                                                                                class="mr-4"><span><i
                                                                                        class="fa fa-building-o text-muted mr-1"></i>
                                                                                    {{ $company->company_name }}</span></a>
                                                                        @endisset
                                                                        <a class="mr-4"><span><i
                                                                                    class="fa fa-map-marker text-muted mr-1"></i>{{ @DB::table('cities')->find($recommended_job->city_id)->name . ',' }}
                                                                                {{ @DB::table('countries')->find($recommended_job->country_id)->name }}
                                                                            </span></a>

                                                                        <a class="mr-4"><span><i
                                                                                    class="fa fa-clock-o text-muted mr-1"></i>
                                                                                {{ @DB::table('job_shifts')->find($recommended_job->job_shift_id)->job_shift }}</span></a>
                                                                        <a class="mr-4"><span><i
                                                                                    class="fa fa-briefcase text-muted mr-1"></i>
                                                                                {{ \Carbon\Carbon::parse($recommended_job->expiry_date)->diffForHumans() }}
                                                                                Exp</span></a>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                            <div class="card-footer pt-3 pb-3">
                                                                <div class="item-card9-footer d-flex">
                                                                    <div
                                                                        class="d-flex align-items-center mb-3 mb-md-0 mt-auto posted">
                                                                        <div>
                                                                            @if (isset($company))
                                                                                <a href="/company-view/{{ $company->id }}"
                                                                                    class="text-muted fs-12 mb-1">Posted by
                                                                                </a><span class="ml-0 fs-13">
                                                                                    {{ $company->company_name }}</span>
                                                                            @endif
                                                                            <small
                                                                                class="d-block text-default">{{ \Carbon\Carbon::parse($recommended_job->created_at)->diffForHumans() }}</small>
                                                                        </div>
                                                                    </div>
                                                                    @php
                                                                        $employ = App\Models\Employe::where('user_id', auth()->user()->id)->first();
                                                                        $application = App\Models\JobApplication::where('job_id', $recommended_job->id)->where('employ_id', $employ->id);
                                                                        
                                                                    @endphp
                                                                    <div class="ml-auto">
                                                                        @if ($application->exists())
                                                                            <a href="javascript:void(0)"
                                                                                class="btn btn-primary">Applied</a>
                                                                        @else
                                                                            <a href="/apply-job/{{ $recommended_job->id }}"
                                                                                class="btn btn-primary"> Apply
                                                                                Now</a>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <p>No Matching Jobs</p>
                                        @endif

                                    </div>
                                </div>
                            </div>
                            @if ($recommended_jobs != null)
                                <div class="center-block text-center">
                                    {{ $recommended_jobs->links('vendor.pagination.bootstrap-4') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <!--/Job lists-->
                </div>
            </div>
        </div>
    </section>
@endsection
@section('script')
@endsection
