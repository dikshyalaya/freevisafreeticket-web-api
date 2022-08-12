@extends('themes.fvft.candidates.layouts.dashmaster')
@section('title', 'Company Lists')
@section('style')
    <!-- file Uploads -->
    <link href="/themes/fvft/assets/plugins/fileuploads/css/dropify.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ asset('css/datepicker.min.css') }}">
@endsection

@section('content')
    <style>
        .form-control {
            color: #272626 !important;
        }

    </style>
    <section>
        <div class="bannerimg cover-image bg-background3" data-image-src="../assets/images/banners/banner2.jpg"
            style="background: url(&quot;../assets/images/banners/banner2.jpg&quot;) center center;">
            <div class="header-text mb-0">
                <div class="text-center text-white">
                    <h1 class="">{{ __('Company Lists') }}</h1>
                    <ol class="breadcrumb text-center">
                        <li class="breadcrumb-item"><a href="#">{{ __('Home') }}</a></li>
                        <li class="breadcrumb-item"><a href="#">{{ __('Dashboard') }} </a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">{{ __('Company Lists') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="sptb">
        {{-- <form action="/candidate/profile" method="post">
        @csrf --}}
        <div class="container">
            <div class="row ">
                <div class="col-xl-3 col-lg-12 col-md-12">
                    @include('themes.fvft.candidates.components.sidebar')
                </div>
                <div class="col-lg-8 col-md-12 col-md-12">
                    <!--Job lists-->
                    <div class=" mb-lg-0">
                        <div class="">
                            <div class="item2-gl">
                                <div class=" mb-0">
                                    <div class="">
                                        <div class="p-5 bg-white item2-gl-nav d-flex">
                                            <ul class="nav item2-gl-menu mt-1 ml-auto">
                                                <li class=""><a href="#tab-11" class="active show"
                                                        data-toggle="tab" title="List style"><i
                                                            class="fa fa-list"></i></a></li>
                                                <li><a href="#tab-12" data-toggle="tab" class=""
                                                        title="Grid"><i class="fa fa-th"></i></a></li>
                                            </ul>
                                            <div class="d-flex">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-content company-list">
                                    <div class="tab-pane active" id="tab-11">
                                        <div class="row">
                                            @if($companies != null)
                                            @foreach ($companies as $company)
                                                @php
                                                    $company_logo = $company->company_logo != null ? $company->company_logo : 'uploads/company/default_company.jpg';
                                                @endphp
                                                <div class="col-lg-6">
                                                    <div class="card overflow-hidden br-0 overflow-hidden">
                                                        <div class="d-sm-flex card-body p-3">
                                                            <div class="p-0 m-0 mr-3">
                                                                <div class="">
                                                                    <a
                                                                        href="{{ route('site.companydetail', $company->id) }}" target="_blank"></a>
                                                                    <img src="{{ asset($company_logo) }}" alt="img"
                                                                        class="w-100 h-9">
                                                                </div>
                                                            </div>
                                                            <div class="item-card9 mt-3 mt-md-5">
                                                                <a href="{{ route('site.companydetail', $company->id) }}"
                                                                    class="text-dark" target="_blank">
                                                                    <h4 class="font-weight-semibold mt-1">
                                                                        {{ $company->company_name }}</h4>
                                                                </a>
                                                                <h6>{{ $company->company_address }}</h6>
                                                            </div>
                                                            <div class="ml-auto">
                                                                <a class="btn btn-light mt-3 mt-md-6 mr-4 font-weight-semibold text-dark"
                                                                    href="{{ route('site.companydetail', $company->id) }}" target="_blank"><i
                                                                        class="fa fa-eye"></i>{{ __('View Detail') }}</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                            @else
                                            <p>{{ __('No company to show') }}</p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tab-12">
                                        <div class="row">

                                            @if ($companies != null)
                                                @foreach ($companies as $company)
                                                    @php
                                                        $company_logo = $company->company_logo != null ? $company->company_logo : 'uploads/company/default_company.jpg';
                                                    @endphp
                                                    <div class="col-lg-6 col-md-12 col-xl-4">
                                                        <div class="card overflow-hidden br-0 overflow-hidden">
                                                            <div class="d-sm-flex card-body p-3">
                                                                <div class="p-0 m-0 mr-3">
                                                                    <div class="">
                                                                        <a
                                                                            href="{{ route('site.companydetail', $company->id) }}" target="_blank"></a>
                                                                        <img src="{{ asset($company_logo) }}" alt="img"
                                                                            class="w-8 h-8">
                                                                    </div>
                                                                </div>
                                                                <div class="item-card9 mt-2">
                                                                    <a href="{{ route('site.companydetail', $company->id) }}"
                                                                        class="text-dark" target="_blank">
                                                                        <h4 class="font-weight-semibold mt-1">
                                                                            {{ $company->company_name }}</h4>
                                                                    </a>
                                                                    <h6>{{ $company->company_address }}</h6>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                @endforeach
                                                @else
                                                <p>{{ __('No company to show') }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if($companies != null)
                            <div class="center-block text-center">
                                {{ $companies->links('vendor.pagination.bootstrap-4') }}
                            </div>
                            @endif
                        </div>
                    </div>
                    <!--/Job lists-->

                </div>

            </div>
        </div>
        {{-- </form> --}}
    </section>
@endsection
@section('script')
@endsection
{{-- <h6 class="mb-0 mt-3">Showing @if ($companies->count() > 1)<b>1 to {{ $companies->count() }}
    @else {{$companies->count()}} @endif</b> of {{$companies->total()}} Entries</h6> --}}
