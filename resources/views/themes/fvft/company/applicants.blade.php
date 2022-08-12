@extends('themes.fvft.company.layouts.dashmaster')
@section('css')
    <link href="{{asset("/")}}themes/fvft/assets/plugins/fileuploads/css/dropify.css" rel="stylesheet" type="text/css">
@endsection
@section('applicants') active @endsection
@section('title') Applicants @endsection
@section('content')
    <section>
        <div class="bannerimg cover-image bg-background3" data-image-src="../assets/images/banners/banner2.jpg" style="background: url(&quot;../assets/images/banners/banner2.jpg&quot;) center center;">
            <div class="header-text mb-0">
                <div class="text-center text-white">
                    <h1 class="">Applicants</h1>
                    <ol class="breadcrumb text-center">
                        <li class="breadcrumb-item"><a href="{{ route('company.dash') }}">Company</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">Applicants</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="sptb">
        <div class="container">
            <div class="row">
                <div class="col-xl-3 col-lg-12 col-md-12">
                    @include('themes.fvft.company.components.sidebar')
                </div>
                <div class="col-xl-9 col-lg-12 col-md-12">
                    <div class="card mb-0">
                        <div class="card-header">
                            <h3 class="card-title">All Applicants</h3>
                        </div>
                        <div class="card-body">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('js')

@endsection
