@extends('themes.fvft.candidates.layouts.dashmaster')
@section('title') Experience @stop
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
                    @include('partial/candidates/tabs', ['title' => 'Edit My Profile - Experience'])

                    <form action="{{ route('candidate.profile.post_experience') }}" method="POST" id="candidateForm">
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
                                                <input type="hidden" name="is_experience" value="Yes" class="form-control">
                                                <input type="hidden" class="form-control" name="user_id"
                                                       value="{{ setParameter($employ, 'user_id') }}">
                                                @if (!blank($employ->experience))
                                                @php
                                                $experienceCount = 0;
                                                @endphp
                                                    @foreach ($employ->experience as $key => $employ_experience)
                                                    <div id="eRow_{{ $experienceCount }}">
                                                        <div class="form-group">
                                                            <label for=""
                                                                   class="form-label">{{ __('Experience') }}
                                                                   <span class="float-right cur_sor p-1 btn-danger" onclick="removeRow('eRow_{{ $experienceCount }}')">{{ __('Remove') }}</span>
                                                                </label>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <label for="">{{ __('Country') }}</label>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <select name="country_id[]"
                                                                            class="form-control select2-show-search"
                                                                            data-placeholder="Select Country">
                                                                        <option value="">{{ __('Select Country') }}</option>
                                                                        @foreach ($countries as $country)
                                                                            <option value="{{ $country->id }}"
                                                                                {{ $country->id == ($employ_experience->country_id ?? $defaultCountryId) ? 'selected' : '' }}>
                                                                                {{ $country->name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <label for="">{{ __('Job Category') }}</label>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <select name="job_category_id[]"
                                                                            class="form-control select2-show-search"
                                                                            data-placeholder="Select Job Category" id="">
                                                                        <option value="">{{ __('Select Job Category') }}
                                                                        </option>
                                                                        @foreach ($job_categories as $job_category)
                                                                            <option value="{{ $job_category->id }}"
                                                                                {{ $job_category->id == $employ_experience->job_category_id ? 'selected' : '' }}>
                                                                                {{ $job_category->functional_area }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <label for="">{{ __('Industry') }}</label>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <select name="industry_id[]"
                                                                            class="form-control select2-show-search" id=""
                                                                            data-placeholder="Select Industry">
                                                                        <option value="">{{ __('Select Industry') }}
                                                                        </option>
                                                                        @foreach ($industries as $industry)
                                                                            <option value="{{ $industry->id }}"
                                                                                {{ $industry->id == $employ_experience->industry_id ? 'selected' : '' }}>
                                                                                {{ $industry->title }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <label for="">{{ __('Working Duration') }}</label>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <select name="working_year[]" class="form-control select2"
                                                                            id="">
                                                                        <option value="">{{ __('Year') }}</option>
                                                                        @for ($i = 0; $i <= 10; $i++)
                                                                            <option value="{{ $i }}" {{ $i == $employ_experience->working_year ? 'selected' : '' }}>
                                                                                {{ $i }}</option>
                                                                        @endfor
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <select name="working_month[]" class="form-control select2"
                                                                            id="">
                                                                        <option value="">{{ __('Month') }}</option>
                                                                        @for ($i = 0; $i <= 12; $i++)
                                                                            <option value="{{ $i }}" {{ $i == $employ_experience->working_month ? 'selected': '' }}>
                                                                                {{ $i }}</option>
                                                                        @endfor
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @php
                                                    $experienceCount++;
                                                    @endphp
                                                    @endforeach
                                                    <input type="hidden" value="{{ $experienceCount }}" id="experienceCount">
                                                @else
                                                    <div>
                                                        @include('admin.pages.candidates.partial.experience_new')
                                                    </div>
                                                @endif

                                                <div id="appendExperience">

                                                </div>
                                                <div class="form-group">
                                                <span class="cur_sor"
                                                      id="addExperience">{{ __('Add Experience') }} <i
                                                        class="fa fa-plus"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body mx-auto">
                                        <div class="mx-auto">
                                            <span>{{ __('Qualification') }}</span> &nbsp;&nbsp;&nbsp;<a
                                                href="{{ route('candidate.profile.get_qualification') }}"
                                                class="btn btn-success rounded-0"><i
                                                    class="fa fa-arrow-left"></i>{{ __('Back') }} </a>
                                            <button type="button" onclick="submitForm(event);"
                                                    class="btn btn-success ml-3 rounded-0">{{ __('Next') }} <i
                                                    class="fa fa-arrow-right"></i></button>&nbsp;&nbsp;&nbsp;<span>{{ __('Preferred Jobs') }}
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
    @include('admin.partial.modals.newTrainingModal')
    @include('admin.partial.modals.newSkillModal')
@endsection
@section('script')
    <script>
        function initializeSelect2()
        {
            $(".select2-show-search").select2();
        }
        // Experience Section
        @if(blank($employ->experience))
        var ecount = 0;
        @else
        var ecount = $("#experienceCount").val();
        @endif
        $(function() {
            $("#addExperience").on('click', () => {
                let html = `<div id="eRow_` + ecount +
                    `">
                    <div class="form-group">
    <label for="" class="form-label">{{ __('Experience') }} <span class="float-right cur_sor p-1 btn-danger" onclick="removeRow('eRow_` +
                    ecount + `')">{{ __('Remove') }}</span></label>

</div>
<div class="form-group">
    <div class="row">
        <div class="col-md-4">
            <label for="">{{ __('Country') }}</label>
        </div>
        <div class="col-md-8">
            <select name="country_id[]" class="form-control select2-show-search" data-placeholder="Select Country" id="">
                <option value="">{{ __('Select Country') }}</option>
                @foreach ($countries as $country)
                        <option value="{{ $country->id }}" {{ $country->id == $defaultCountryId ? 'selected' : '' }}>{{ $country->name }}</option>
                @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-4">
                        <label for="">{{ __('Job Category') }}</label>
        </div>
        <div class="col-md-8">
            <select name="job_category_id[]" class="form-control select2-show-search"
                data-placeholder="Select Job Category" id="">
                <option value="">{{ __('Select Job Category') }}</option>
                @foreach ($job_categories as $job_category)
                        <option value="{{ $job_category->id }}">
                        {{ $job_category->functional_area }}</option>
                @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-4">
                        <label for="">{{ __('Industry') }}</label>
        </div>
        <div class="col-md-8">
            <select name="industry_id[]" class="form-control select2-show-search" data-placeholder="Select Industry"
                id="">
                <option value="">{{ __('Select Industry') }}</option>
                @foreach ($industries as $industry)
                        <option value="{{ $industry->id }}">{{ $industry->title }}</option>
                @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-4">
                        <label for="">{{ __('Working Duration') }}</label>
        </div>
        <div class="col-md-4">
            <select name="working_year[]" class="form-control select2" id="">
                <option value="">{{ __('Year') }}</option>
                @for ($i = 0; $i <= 10; $i++)
                        <option value="{{ $i }}">
                        {{ $i }}</option>
                @endfor
                        </select>
                    </div>
                    <div class="col-md-4">
                        <select name="working_month[]" class="form-control select2" id="">
                            <option value="">{{ __('Month') }}</option>
                @for ($i = 0; $i <= 12; $i++)
                        <option value="{{ $i }}">
                        {{ $i }}</option>
                @endfor
                        </select>
                    </div>
                </div>
            </div>

                                </div>`;
                $("#appendExperience").append(html);
                ecount++;
                initializeSelect2();
            });
        });

        // End Experience Section

        function removeRow(idname) {
            $("#" + idname).remove();
        }

        function submitForm(e, redirect='proceed') {
            e.preventDefault();
            $('.require').css('display', 'none');
            let url = $("#candidateForm").attr('action');
            var data = new FormData($("#candidateForm")[0]);
            $.ajax({
                url: url,
                type: 'post',
                // _method: 'put',
                // data: data,
                data: new FormData($("#candidateForm")[0]),
                processData: false,
                contentType: false,
                cache: false,
                success: function(response) {
                    if (response.db_error) {
                        $(".alert-secondary").css('display', 'block');
                        $(".db_error").html(response.db_error);
                        toastr.warning(response.db_error);
                    } else if (response.errors) {
                        var error_html = "";
                        $.each(response.errors, function(key, value) {
                            toastr.error(value);
                            error_html = '<div>' + value + '</div>';
                            $('.' + key).css('display', 'block').html(error_html);
                        });
                    } else if (!response.errors && !response.db_error) {
                        if (redirect && redirect === 'reload') {
                            window.location.reload()
                        }else{
                            location.href = response.redirectRoute;
                        }
                    }
                }
            });
        }
    </script>
@endsection
