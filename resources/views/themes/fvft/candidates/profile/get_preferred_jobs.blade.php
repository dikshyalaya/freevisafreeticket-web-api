@extends('themes.fvft.candidates.layouts.dashmaster')
@section('title') Qualification @stop
@section('style')
    <!-- file Uploads -->
    <link href="/themes/fvft/assets/plugins/fileuploads/css/dropify.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ asset('css/datepicker.min.css') }}">
@endsection
@section('content')
    <section>
        <div class="bannerimg cover-image bg-background3" data-image-src="/uploads/site/banner.png"
             style="background: url(/uploads/site/banner.png) center center;">
            <div class="header-text mb-0">
                <div class="text-center text-white">
                    <h1 class="">{{ __('My Profile') }}</h1>
                    <ol class="breadcrumb text-center">
                        <li class="breadcrumb-item"><a href="#">{{ __('Home') }}</a></li>
                        <li class="breadcrumb-item"><a href="#">{{ __('Dashboard') }} </a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">{{ __('My Profile') }}</li>
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
                    @include('partial/candidates/tabs', ['title' => 'Edit My Profile - Preferred Jobs'])
                    <form action="{{ route('candidate.profile.post_preferred_jobs') }}" method="POST" id="preferenceForm">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card mb-2">
                                    <div class="card-header">
                                        @include('partial/candidates/step')
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <input type="hidden" class="form-control" name="user_id" value="{{ setParameter($employ, 'user_id') }}">
                                                @if (blank($employ->jobCategoryPreference))
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <h3 class="card-title">{{ __('Job Category') }}</h3>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label class="custom-switch">
                                                                            <input type="checkbox" name="job_notify" class="custom-switch-input" {{ setParameter($employe, 'job_notify') ? 'checked' : '' }}>
                                                                            <span class="custom-switch-indicator"></span>
                                                                            <span class="custom-switch-description">{{ __('Notify me for job') }}</span>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-8">
                                                                    <input type="text" value="All Job Category"
                                                                           placeholder="All Job Category" name="all_category"
                                                                           class="form-control" readonly>
                                                                    <div class="text-sm m-4">
                                                                        <small>{{ __('Or Select your preferred job category') }}</small>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-8">
                                                                    <select name="categories[]"
                                                                            data-placeholder="Select Job Category"
                                                                            class="form-control select2-show-search">
                                                                        <option value="">{{ __('Select Job Category') }}
                                                                        </option>
                                                                        @foreach ($all_job_categories as $job_category)
                                                                            <option value="{{ $job_category->id }}">
                                                                                {{ $job_category->functional_area }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <button type="button" class="btn btn-block cur_sor my-auto" onclick="addCategoryRow()">
                                                                        <i class="fa fa-plus mr-1"></i>{{ __('Add') }}
                                                                    </button>
                                                                </div>

                                                            </div>
                                                            <div id="categoryAppend"></div>
                                                        </div>
                                                    </div>
                                                @else
                                                    @include('themes.fvft.candidates.profile.preference-category')
                                                @endif
                                                <hr>
                                                @if (blank($employ->industryPreference))
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <h3 class="card-title">{{ __('Industry') }}</h3>
                                                            <div class="row">
                                                                <div class="col-md-8">
                                                                    <input type="text" value="All Industry" placeholder="All Industry"
                                                                           name="all_industry" class="form-control" readonly>
                                                                    <div class="text-sm m-4">
                                                                        <small>{{ __('Or Add your preferred job industry') }}</small>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-8">
                                                                    <select name="industry[]" class="form-control select2-show-search" data-placeholder="Select Industry">
                                                                        <option value="">{{ __('Select Industry') }}</option>
                                                                        @foreach($job_industries as $job_industry)
                                                                            <option value="{{ $job_industry->id }}">{{ $job_industry->title }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <button type="button" onclick="addJobRow();" class="btn btn-block cur_sor my-auto">
                                                                        <i class="fa fa-plus mr-1"></i>{{ __('Add') }}
                                                                    </button>
                                                                </div>
                                                            </div>
                                                            <div id="jobTitleAppend"></div>
                                                        </div>
                                                    </div>
                                                @else
                                                    @include('themes.fvft.candidates.profile.preference-industry')
                                                @endif
                                                <hr>
                                                @if (blank($employ->countryPreference))
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <h3 class="card-title">{{ __('Country') }}</h3>
                                                            <div class="row">
                                                                <div class="col-md-8">
                                                                    <input type="text" value="All Country" placeholder="All Country"
                                                                           name="all_country" class="form-control" readonly>
                                                                    <div class="text-sm m-4">
                                                                        <small>{{ __('Or Select your preferred country') }}</small>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-8">
                                                                    <select name="countries[]" data-placeholder="Select Country"
                                                                            class="form-control country select2-show-search">
                                                                        <option value="">{{ __('Select Country') }}</option>
                                                                        @foreach ($countries as $country)
                                                                            <option value="{{ $country->id }}">
                                                                                {{ $country->name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <button type="button" class="btn btn-block cur_sor my-auto" onclick="addCountryRow();">
                                                                        <i class="fa fa-plus mr-1"></i>{{ __('Add') }}
                                                                    </button>
                                                                </div>
                                                            </div>
                                                            <div id="countryAppend"></div>
                                                        </div>
                                                    </div>
                                                @else
                                                    @include('themes.fvft.candidates.profile.preference-country')
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-body mx-auto">
                                        <div class="mx-auto">
                                            <span>{{ __('Experience') }}</span> &nbsp;&nbsp;&nbsp;<a
                                                href="{{ route('candidate.profile.get_experience') }}"
                                                class="btn btn-success rounded-0 "><i
                                                    class="fa fa-arrow-left mr-1"></i>{{ __('Back') }} </a>
                                            <button type="button" onclick="submitForm(event);"
                                                    class="btn btn-success ml-3 rounded-0" id="updateButton">{{ __('Next') }} <i
                                                    class="fa fa-arrow-right"></i></button>&nbsp;&nbsp;&nbsp;<span>{{ __('Next') }}
                                        </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('script')
    <script>
        function select2() {
            $(".select2-show-search").select2();
        }
            @if ($employe->job_preferences->isEmpty())
        var c_count = 0;
        var jc_count = 0;
        var jt_count = 0; //industry_count;
            @else
        var c_count = $("#cCount").val();
        var jc_count = $("#jcCount").val();
        var jt_count = $("#jt_count").val(); // industry_count;
        @endif


        function submitForm(e, redirect='proceed') {
            e.preventDefault();
            $('.require').css('display', 'none');
            let url = $("#preferenceForm").attr('action');
            var data = new FormData($("#preferenceForm")[0]);
            $.ajax({
                url: url,
                type: 'post',
                // _method: 'put',
                // data: data,
                data: new FormData($("#preferenceForm")[0]),
                processData: false,
                contentType: false,
                cache: false,
                beforeSend: function() {
                    $("#updateButton").attr('disabled', true);
                },
                success: function(response) {
                    // return true;
                    if (response.db_error) {
                        $(".alert-secondary").css('display', 'block');
                        $(".db_error").html(response.db_error);
                        toastr.warning(response.db_error);
                    } else if(response.limit_error){
                        toastr.error(response.limit_error);
                    } else if (response.errors) {
                        var error_html = "";
                        $.each(response.errors, function(key, value) {
                            error_html = '<div>' + value + '</div>';
                            $('.' + key).css('display', 'block').html(error_html);
                        });
                    } else if (!response.errors && !response.db_error) {
                        toastr.success(response.msg);
                        if (redirect && redirect === 'reload') {
                            window.location.reload()
                        }else{
                            location.href = response.redirectRoute;
                        }
                    }
                },
                complete: function() {
                    $("#updateButton").attr('disabled', false);
                }
            });
        }

        function addCountryRow() {
            var html = `
            <div class="row mt-2" id="countryRow_` + c_count + `">
                <div class="col-md-8">
                    <select name="countries[]" data-placeholder="Select Country"
                        class="form-control country select2-show-search">
                        <option value="">{{ __('Select Country') }}</option>
                        @foreach ($countries as $country)
                <option value="{{ $country->id }}">{{ $country->name }}</option>
                        @endforeach
                </select>
            </div>
            <div class="col-md-2 my-auto">
                <button type="button" class="btn btn-sm btn-danger" onclick="removeRow('countryRow_` + c_count + `')">
                         Remove
                    </button>
                </div>
            </div>`;
            $("#countryAppend").append(html);
            select2();
            c_count++;
        }

        function addJobRow() {
            var html = `<div class="row mt-2" id="jobRow_` + jt_count + `">
                        <div class="col-md-8">
                            <select name="industry[]" class="form-control select2-show-search" data-placeholder="Select Industry">
                                <option value="">{{ __('Select Industry') }}</option>
                                @foreach($job_industries as $job_industry)
                                <option value="{{ $job_industry->id }}">{{ $job_industry->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-block" onclick="removeRow('jobRow_` + jt_count + `')">
                                <i class="fa fa-close mr-1 text-danger"></i> Remove
                            </button>
                        </div>
                    </div>`;
            $("#jobTitleAppend").append(html);
            select2();
            jt_count++;
        }

        function addCategoryRow(e) {
            var html = `<div class="row mt-2" id="catRow_` + jc_count + `">
                        <div class="col-md-8">
                            <select name="categories[]" data-placeholder="Select Job Category"
                                class="form-control select2-show-search">
                                <option value="">{{ __('Select Job Category') }}</option>
                                @foreach ($all_job_categories as $job_category)
                <option value="{{ $job_category->id }}">
                                        {{ $job_category->functional_area }}</option>
                                @endforeach
                </select>
            </div>
            <div class="col-md-2 my-auto">
                <button type="button" class="btn btn-sm btn-danger" onclick="removeRow('catRow_` + jc_count + `')">
                     Remove
                    </button>
                        </div>
                    </div>`;
            $("#categoryAppend").append(html);
            select2();
            jc_count++;
        }

        function removeRow(rowId) {
            $("#" + rowId).remove();
        }
    </script>
@endsection
