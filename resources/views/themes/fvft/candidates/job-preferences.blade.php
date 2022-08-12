@extends('themes.fvft.candidates.layouts.dashmaster')
@section('title', 'Job Preference')
@section('style')
<!-- file Uploads -->
<link href="/themes/fvft/assets/plugins/fileuploads/css/dropify.css" rel="stylesheet" type="text/css" />
@endsection
@section('content')
<section>
    <div class="bannerimg cover-image bg-background3" data-image-src="../assets/images/banners/banner2.jpg" style="background: url(&quot;../assets/images/banners/banner2.jpg&quot;) center center;">
        <div class="header-text mb-0">
            <div class="text-center text-white">
                <h1 class="">Job Preferences</h1>
                <ol class="breadcrumb text-center">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Dashboard </a></li>
                    <li class="breadcrumb-item active text-white" aria-current="page">Job Preferences</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<section class="sptb">
    <form action="/candidate/job-preferences" method="post">
        @csrf
    <div class="container">
        <div class="row ">
            <div class="col-xl-3 col-lg-12 col-md-12">
                @include('themes.fvft.candidates.components.sidebar')
            </div>
            <div class="col-lg-8 col-md-12 col-md-12">
                @php
                $user=Auth::user();
                @endphp
                <div class="card dropify-image-avatar">
                    <div class="card-header ">
                        <h3 class="card-title">Personal Data</h3>
                    </div>
                    <div class="card-body">

                        <div class="row">

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Job Category</label>
                                    <select name="job_category_id" id="select-job_category_id" class="form-control select2 text-dark">
                                        @foreach ($job_categories as $item)
                                            <option value="{{$item->id}}" {{isset($employ_job_preference->job_category_id)?$item->id==$employ_job_preference->job_category_id?"selected":"":null}}>{{$item->functional_area}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label">Country</label>
                                            <select name="country_id" id="select-country" class="form-control select2 text-dark" value="{{isset($employe->country_id)?$employe->country_id:''}}">
                                                @foreach ($countries as $item)
                                                    <option value="{{$item->id}}" {{isset($employ_job_preference->country_id)?$item->id==$employ_job_preference->country_id?"selected":"":null}}>{{$item->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end align-items-center ">
                                    <button class="btn btn-primary w-150" type="submit">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
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
