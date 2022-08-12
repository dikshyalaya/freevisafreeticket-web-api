@extends('themes.fvft.candidates.layouts.dashmaster')
@section('title') My Jobs @stop
@section('content')
    <section>
        <div class="bannerimg cover-image bg-background3" data-image-src="../assets/images/banners/banner2.jpg"
            style="background: url(&quot;../assets/images/banners/banner2.jpg&quot;) center center;">
            <div class="header-text mb-0">
                <div class="text-center text-white">
                    <h1 class="">My Jobs</h1>
                    <ol class="breadcrumb text-center">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Dashboard </a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">Setting</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="sptb">
        <div class="container">
            <div class="row">
                <div class="col-xl-3 col-lg-12 col-md-12">
                    @include('themes.fvft.candidates.components.sidebar')
                </div>
                <div class="col-xl-9 col-lg-12 col-md-12">
                    <div class="row">
                        <div class="card mb-2">
                            <div class="card-body">
                                <h3 class="font-weight-bold">{{ strtoupper('Settings') }}</h3>
                                <div id="basicwizard" class="border pt-0">
                                    @include('partial/candidates/setting_tabs')
                                </div>
                            </div>
                        </div>
                        @include('partial/candidates/jobsetting/pilltab')
                    </div>
                    <div class="row">
                        <div class="card mb-0">
                            <div class="card-header">
                                <h3 class="card-title">{{ strtoupper('Job Category') }}</h3>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('candidate.account_setting.post_account_setting') }}" method="POST"
                                    id="activateForm">
                                    @csrf
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="category">Category 1</label>
                                            <select name="categories[]" class="form-control select2-show-search"
                                                data-placeholder="Select Category">
                                                <option value="">Select Category</option>
                                                @foreach ($job_categories as $category)
                                                    <option value="{{ $category->id }}">
                                                        {{ $category->functional_area }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="category">Category 2</label>
                                            <select name="categories[]" class="form-control select2-show-search"
                                                data-placeholder="Select Category">
                                                <option value="">Select Category</option>
                                                @foreach ($job_categories as $category)
                                                    <option value="{{ $category->id }}">
                                                        {{ $category->functional_area }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="category">Category 3</label>
                                            <select name="categories[]" class="form-control select2-show-search"
                                                data-placeholder="Select Category">
                                                <option value="">Select Category</option>
                                                @foreach ($job_categories as $category)
                                                    <option value="{{ $category->id }}">
                                                        {{ $category->functional_area }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <h3 class="card-title">{{ strtoupper('Choose Country') }}</h3>
                                    <hr class="mt-4 mb-4">
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="category">Country 1</label>
                                            <select name="countries[]" class="form-control select2-show-search"
                                                data-placeholder="Select Country">
                                                <option value="">Select Country</option>
                                                @foreach ($countries as $country)
                                                    <option value="{{ $country->id }}">
                                                        {{ $country->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="category">Country 2</label>
                                            <select name="countries[]" class="form-control select2-show-search"
                                                data-placeholder="Select Country">
                                                <option value="">Select Country</option>
                                                @foreach ($countries as $country)
                                                    <option value="{{ $country->id }}">
                                                        {{ $country->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="category">Country 3</label>
                                            <select name="countries[]" class="form-control select2-show-search"
                                                data-placeholder="Select Country">
                                                <option value="">Select Country</option>
                                                @foreach ($countries as $country)
                                                    <option value="{{ $country->id }}">
                                                        {{ $country->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <hr class="mt-4 mb-4">
                                    <div class="form-group">
                                       <button class="btn btn-primary float-right w-25" type="button">Update Job Preference</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('script')

@endsection
