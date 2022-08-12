@extends('themes.fvft.candidates.layouts.dashmaster')
@section('style')
  
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
                    <h1 class="">Profile</h1>
                    <ol class="breadcrumb text-center">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Dashboard </a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">Profile</li>
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
                  
                   
                        @include('partial/candidates/candidateShow')
                   

                </div>

            </div>
        </div>
        {{-- </form> --}}
    </section>
@endsection
@section('script')
   

   
@endsection
