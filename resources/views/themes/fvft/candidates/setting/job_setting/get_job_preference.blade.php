@extends('themes.fvft.candidates.layouts.dashmaster')
@section('title') Job Preference @stop
@section('content')
    <section>
        <div class="bannerimg cover-image bg-background3" data-image-src="../assets/images/banners/banner2.jpg"
            style="background: url(&quot;../assets/images/banners/banner2.jpg&quot;) center center;">
            <div class="header-text mb-0">
                <div class="text-center text-white">
                    <h1 class="">{{ __('Job Preference') }}</h1>
                    <ol class="breadcrumb text-center">
                        <li class="breadcrumb-item"><a href="#">{{ __('Home') }}</a></li>
                        <li class="breadcrumb-item"><a href="#">{{ __('Dashboard') }} </a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">{{ __('Setting') }}</li>
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
                                <h3 class="font-weight-bold">{{ strtoupper(__('Settings')) }}</h3>
                                <div id="basicwizard" class="border pt-0">
                                    @include('partial/candidates/setting_tabs')
                                </div>
                            </div>
                        </div>
                        @include('partial/candidates/jobsetting/pilltab')
                    </div>
                    <div class="row">
                        <div class="card mb-0">
                            <div class="card-body">
                                @if ($employe->job_preferences->isEmpty())
                                    <div class="col-md-6">
                                        {{-- <h3 class="card-title">{{ strtoupper('Job Category') }}</h3> --}}
                                        <form action="{{ route('candidate.job_setting.post_job_preference') }}"
                                            method="POST" id="preferenceForm">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <h3 class="card-title">{{ __('Job Category') }}</h3>
                                                </div>
                                                <div class="col-md-6 my-auto">
                                                    <div class="form-group">
                                                        <label class="custom-switch">
                                                            <input type="checkbox" name="job_notify" class="custom-switch-input">
                                                            <span class="custom-switch-indicator"></span>
                                                            <span class="custom-switch-description">{{ __('Notify me for job') }}</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <input type="text" value="All Job Category" placeholder="All Job Category"
                                                    name="all_category" class="form-control" readonly>
                                                <div class="font-weight-normal mt-2 ml-3">{{ __('Or Select your preferred job category') }}
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <span class="cur_sor my-auto" onclick="addCategoryRow()"><i
                                                            class="fa fa-plus"></i>{{ __('Add') }}</span>
                                                </div>
                                                <div class="col-md-8">
                                                    <select name="categories[]" data-placeholder="Select Job Category"
                                                        class="form-control select2-show-search">
                                                        <option value="">{{ __('Select Job Category') }}</option>
                                                        @foreach ($job_categories as $job_category)
                                                            <option value="{{ $job_category->id }}">
                                                                {{ $job_category->functional_area }}</option>
                                                        @endforeach
                                                    </select>

                                                </div>
                                            </div>
                                            <div id="categoryAppend">

                                            </div>
                                            <hr>
                                            <h3 class="card-title">{{ strtoupper(__('Job Title')) }}</h3>
                                            <div class="form-group">
                                                <input type="text" value="All Job Title" placeholder="All Job Title"
                                                    name="all_job_title" class="form-control" readonly>
                                                <div class="font-weight-normal mt-2 ml-3">{{ __('Or Add your preferred job title') }}
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <span onclick="addJobRow();" class="cur_sor my-auto"><i
                                                            class="fa fa-plus"></i>{{ __('Add') }}</span>
                                                </div>
                                                <div class="col-md-8">
                                                    <input type="text" class="form-control" name="job_title[]"
                                                        placeholder="Enter Job Title">

                                                </div>
                                            </div>
                                            <div id="jobTitleAppend">

                                            </div>
                                            <hr>
                                            <h3 class="card-title">{{ strtoupper(__('Country')) }}</h3>
                                            <div class="form-group">
                                                <input type="text" value="All Country" placeholder="All Country"
                                                    name="all_country" class="form-control" readonly>
                                                <div class="font-weight-normal mt-2 ml-3">{{ __('Or Select your preferred country') }}
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <span class="cur_sor my-auto" onclick="addCountryRow();"><i
                                                            class="fa fa-plus"></i>{{ __('Add') }}</span>
                                                </div>
                                                <div class="col-md-8">
                                                    <select name="countries[]" data-placeholder="Select Country"
                                                        class="form-control select2-show-search">
                                                        <option value="">{{ __('Select Country') }}</option>
                                                        @foreach ($countries as $country)
                                                            <option value="{{ $country->id }}">{{ $country->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>

                                                </div>
                                            </div>
                                            <div id="countryAppend">

                                            </div>

                                            <div class="form-group mt-3">
                                                <button type="button" id="updateButton" onclick="submitForm(event);"
                                                    class="btn btn-primary">{{ __('Update Job Preference') }}</button>
                                            </div>
                                        </form>
                                    </div>
                                @else
                                    @include(
                                        'themes.fvft.candidates.setting.job_setting.preference_partial'
                                    )
                                @endif
                            </div>
                        </div>
                    </div>
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
            var jt_count = 0;
        @else
            var c_count = $("#cCount").val();
            var jc_count = $("#jcCount").val();
            var jt_count = $("#jt_count").val();
        @endif


        function submitForm(e) {
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
                    } else if (response.errors) {
                        var error_html = "";
                        $.each(response.errors, function(key, value) {
                            error_html = '<div>' + value + '</div>';
                            $('.' + key).css('display', 'block').html(error_html);
                        });
                    } else if (!response.errors && !response.db_error) {
                        toastr.success(response.msg);
                        location.href = response.redirectRoute;
                    }
                },
                complete: function() {
                    $("#updateButton").attr('disabled', false);
                }
            });
        }

        function addCountryRow() {
            var html = `<div class="row mt-2" id="countryRow_` + c_count + `">
                            <div class="col-md-2"></div>
                            <div class="col-md-8">
                                <select name="countries[]" data-placeholder="Select Country"
                                    class="form-control select2-show-search">
                                    <option value="">Select Country</option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}">{{ $country->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2 my-auto">
                                <button type="button" class="btn btn-sm btn-danger" onclick="removeRow('countryRow_` +
                c_count + `')">Remove</button>
                            </div>
                        </div>`;
            $("#countryAppend").append(html);
            select2();
            c_count++;
        }

        function addJobRow() {
            var html = `<div class="row mt-2" id="jobRow_` + jt_count + `">
                            <div class="col-md-2"></div>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="job_title[]"
                                    placeholder="Enter Job Title">
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-sm btn-danger" onclick="removeRow('jobRow_` +
                jt_count + `')">Remove</button>
                            </div>
                        </div>`;
            $("#jobTitleAppend").append(html);
            select2();
            jt_count++;
        }

        function addCategoryRow() {
            var html = `<div class="row mt-2" id="catRow_` + jc_count + `">
                            <div class="col-md-2"></div>
                            <div class="col-md-8">
                                <select name="categories[]" data-placeholder="Select Job Category"
                                    class="form-control select2-show-search">
                                    <option value="">Select Job Category</option>
                                    @foreach ($job_categories as $job_category)
                                        <option value="{{ $job_category->id }}">
                                            {{ $job_category->functional_area }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2 my-auto">
                                <button type="button" class="btn btn-sm btn-danger" onclick="removeRow('catRow_` +
                jc_count + `')">Remove</button>
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
