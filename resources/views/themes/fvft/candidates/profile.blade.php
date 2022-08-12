@extends('themes.fvft.candidates.layouts.dashmaster')
@section('title') Update Profile @stop
@section('style')
    <!-- file Uploads -->
    <link href="/themes/fvft/assets/plugins/fileuploads/css/dropify.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ asset('css/datepicker.min.css') }}">
@endsection

@section('content')
    <style>
        .req {
            color: red;
        }
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
                <div class="col-lg-9 col-md-12 col-md-12">
                    <div class="alert alert-secondary d-none" role="alert"><button type="button" class="close"
                            data-dismiss="alert" aria-hidden="true">×</button><span id="db_error"
                            class="db_error"></span></div>
                    <form action="{{ route('candidate.updateProfile', $employ->id) }}" method="POST" id="candidateForm"
                        enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        {{-- @dd($countries) --}}
                        @include('partial/candidates/candidateEdit')
                    </form>

                </div>

            </div>
        </div>
        {{-- </form> --}}
    </section>
@endsection
@section('script')
    <!-- file Uploads -->
    <!-- file uploads js -->
    <script src="/themes/fvft/assets/plugins/fileuploads/js/dropify.js"></script>
    <script src="/themes/fvft/assets/plugins/fileuploads/js/dropfy-custom.js"></script>

    <!--Upload Js-->
    <script src="/themes/fvft/assets/js/upload.js"></script>

    @include('partial/candidates/script')
@endsection
