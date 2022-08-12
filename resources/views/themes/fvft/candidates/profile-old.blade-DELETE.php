@extends('themes.fvft.candidates.layouts.dashmaster')
@section('style')
<!-- file Uploads -->
<link href="/themes/fvft/assets/plugins/fileuploads/css/dropify.css" rel="stylesheet" type="text/css" />
@endsection
@section('content')
<section>
    <div class="bannerimg cover-image bg-background3" data-image-src="../assets/images/banners/banner2.jpg" style="background: url(&quot;../assets/images/banners/banner2.jpg&quot;) center center;">
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
    <form action="/candidate/profile" method="post">
        @csrf
    <div class="container">
        <div class="row ">
            <div class="col-xl-3 col-lg-12 col-md-12">
                @include('themes.fvft.candidates.components.sidebar')
            </div>
            <div class="col-lg-8 col-md-12 col-md-12">
                @include('themes.fvft.candidates.components.profile.personal-info')
                {{-- @include('themes.fvft.candidates.components.profile.education')
                @include('themes.fvft.candidates.components.profile.work-experience')
                @include('themes.fvft.candidates.components.profile.skills')
                @include('themes.fvft.candidates.components.profile.personal-skills')
                @include('themes.fvft.candidates.components.profile.upload-resume') --}}
                <div class="float-right mb-4 mb-lg-0">
                    <button class="btn btn-success w-150" type="submit">Save</button>
                </div>
            </div>
           
        </div>
    </div>
    </form>
</section>
@endsection
@section('script')
<!-- file Uploads -->
<!-- file uploads js -->
<script src="/themes/fvft/assets/plugins/fileuploads/js/dropify.js"></script>
<script src="/themes/fvft/assets/plugins/fileuploads/js/dropfy-custom.js"></script>

<!--Upload Js-->
<script src="/themes/fvft/assets/js/upload.js"></script>

<script src="{{env('APP_URL')}}js/location.js"></script>
<script>
    const _token=$('meta[name="csrf-token"]')[0].content;
    const state_id={{isset($employe->state_id)?$employe->state_id:"3871" }};
    const city_id={{isset($employe->city_id)?$employe->city_id:"null" }};
    const appurl="{{env('APP_URL')}}";
</script>
@endsection