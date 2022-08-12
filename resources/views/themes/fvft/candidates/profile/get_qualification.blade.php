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
                    @include('partial/candidates/tabs', ['title' => 'Edit My Profile - Qualification'])

                    <form action="{{ route('candidate.profile.post_qualification') }}" method="POST" id="candidateForm">
                        @csrf

                        <div class="row">
                            <div class="col-md-12">
                                <div class="card mb-2">
                                    <div class="card-header">
                                        @include('partial/candidates/step')
                                    </div>
                                    <div class="card-body">
                                        <input type="hidden" class="form-control" name="user_id"
                                               value="{{ setParameter($employ, 'user_id') }}">
                                        <div class="form-group">
                                            <label for="">{{ __('Education Level') }}&nbsp;<span
                                                    class="req">*</span></label>
                                            <select name="education_level_id" class="form-control select2-show-search" data-placeholder="Select Education Level">
                                                <option value="">{{ __('Select Education Level') }}</option>
                                                @foreach ($educationLevels as $educationLevel)
                                                    <option value="{{ $educationLevel->id }}"
                                                        {{ $educationLevel->id == setParameter($employ,'education_level_id') ? 'selected' : '' }}>
                                                        {{ $educationLevel->title }}</option>
                                                @endforeach
                                            </select>
                                            <div class="require text-danger education_level_id"></div>
                                        </div>
                                        <div class="form-group">
                                            <label for="">{{ __('Training') }}</label>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <select name="training[]" class="form-control select2 training"
                                                            multiple="multiple" id="training">
                                                        <option value="">{{ __('Select Training') }}</option>
                                                        @if ($employ->employeeTrainings != null)
                                                            @foreach ($trainings as $training)
                                                                <option value="{{ $training->id }}"
                                                                    {{ in_array($training->id, $employ->employeeTrainings->pluck('training_id')->toArray()) ? 'selected' : '' }}>
                                                                    {{ $training->title }}</option>
                                                            @endforeach
                                                        @else
                                                            @include(
                                                                'admin.pages.candidates.partial.training'
                                                            )
                                                        @endif
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                        <span class="cur_sor" data-toggle="modal"
                                                              data-target="#newTrainingModal">{{ __('Add Training') }} <span><i class="fa fa-plus"></i></span></span>
                                                </div>
                                            </div>

                                        </div>


                                        <div class="form-group">
                                            <label for="">{{ __('Skill') }}</label>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <select name="skill[]" class="form-control select2"
                                                            multiple="multiple" id="skill">
                                                        <option value="">{{ __('Select Skill') }}</option>
                                                        @if ($employ->employeeSkills != null)
                                                            @foreach ($skills as $skill)
                                                                <option value="{{ $skill->id }}"
                                                                    {{ in_array($skill->id, $employ->employeeSkills->pluck('skills_id')->toArray()) ? 'selected' : '' }}>
                                                                    {{ $skill->title }}</option>
                                                            @endforeach
                                                        @else
                                                            @include(
                                                                'admin.pages.candidates.partial.skill'
                                                            )
                                                        @endif
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                        <span class="cur_sor" data-toggle="modal"
                                                              data-target="#newSkillModal">{{ __('Add Skill') }}
                                                            <span><i class="fa fa-plus"></i></span></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-label">{{ __('Language') }}</div>
                                            @if ($employ->employeeLanguage != null)
                                                @foreach ($employ->employeeLanguage as $key => $employ_language)
                                                    <div class="row {{ !$loop->first ? 'mt-2' : '' }}">
                                                        <div class="col-md-6">
                                                            <select name="language[]" class="form-control select2-show-search" data-placeholder="Select Language">
                                                                <option value="">{{ __('Select Language') }}</option>
                                                                @foreach ($languages as $language)
                                                                    <option value="{{ $language->id }}"
                                                                        {{ $language->id == $employ_language->language_id ? 'selected' : '' }}>
                                                                        {{ $language->lang }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <select name="language_level[]"
                                                                    class="form-control select2-show-search" data-placeholder="Select Level">
                                                                <option value="">{{ __('Select Level') }}</option>
                                                                <option value="Very Good"
                                                                    {{ $employ_language->language_level == 'Very Good' ? 'selected' : '' }}>
                                                                    Very Good</option>
                                                                <option value="Good"
                                                                    {{ $employ_language->language_level == 'Good' ? 'selected' : '' }}>
                                                                    Good
                                                                </option>
                                                                <option value="Fair"
                                                                    {{ $employ_language->language_level == 'Fair' ? 'selected' : '' }}>
                                                                    Fair
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                @include(
                                                    'admin.pages.candidates.partial.language'
                                                )
                                            @endif
                                            <div id="appendLanguageDiv">

                                            </div>
                                            <div class="form-group mt-5">

                                                <a href="javascript:void()" class="btn btn-link" id="addLanguage">{{ __('Add Language') }} <i class="fa fa-plus"></i></a>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body mx-auto">
                                        <div class="mx-auto">
                                            <span>{{ __('Contact Information') }}</span> &nbsp;&nbsp;&nbsp;<a
                                                href="{{ route('candidate.profile.get_contact_information') }}"
                                                class="btn btn-success rounded-0"><i class="fa fa-arrow-left"></i>{{ __('Back') }} </a>
                                            <button type="button" onclick="submitForm(event);"
                                                    class="btn btn-success ml-3 rounded-0">{{ __('Next') }} <i
                                                    class="fa fa-arrow-right"></i></button>&nbsp;&nbsp;&nbsp;<span>{{ __('Experience') }}
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
        $(document).ready(function() {
            $("#newTrainingModal").on('hidden.bs.modal', function() {
                $(this).find('form')[0].reset();
                $('.require').css('display', 'none');
            });

            $("#newSkillModal").on('hidden.bs.modal', function() {
                $(this).find('form')[0].reset();
                $('.require').css('display', 'none');
            });
        });

        // Ajax Add Training and Skill Section
        $("#addNewTraining").on('click', function(e) {
            $('.require').css('display', 'none');
            e.preventDefault();
            var formData = ($("#newTrainingForm").serialize());
            var action = $("#newTrainingForm").attr('action');
            $.ajax({
                url: action,
                type: 'post',
                data: formData,
                dataType: 'json',
                success: function(data) {
                    if (data.errors) {
                        var error_html = "";
                        $.each(data.errors, function(key, value) {
                            error_html = '<div>' + value + '</div>';
                            $('.' + key).css('display', 'block');
                            $('.' + key).css('color', 'red');
                            $('.' + key).html(error_html);
                        });
                    } else {
                        $("#newTrainingModal").modal('hide');
                        let new_option = $('<option></option>').val(data.training_id).html(data
                            .training_title)
                            .attr('selected', 'selected');
                        $("#training").append(new_option);

                    }

                }
            });
        });

        $("#addNewSkill").on('click', function(e) {
            $('.require').css('display', 'none');
            e.preventDefault();
            var formData = ($("#newSkillForm").serialize());
            var action = $("#newSkillForm").attr('action');
            $.ajax({
                url: action,
                type: 'post',
                data: formData,
                dataType: 'json',
                success: function(data) {
                    if (data.errors) {
                        var error_html = "";
                        $.each(data.errors, function(key, value) {
                            error_html = '<div>' + value + '</div>';
                            $('.' + key).css('display', 'block');
                            $('.' + key).css('color', 'red');
                            $('.' + key).html(error_html);
                        });
                    } else {
                        $("#newSkillModal").modal('hide');
                        let new_option = $('<option></option>').val(data.skill_id).html(data
                            .skill_title)
                            .attr('selected', 'selected');
                        $("#skill").append(new_option);

                    }

                }
            });
        });

        // End Ajax Add Training and Skill Section

        // Language Section
        var count = 0;
        $("#languageSelect").on('change', function() {

            let language_id = $(this).find(':selected').data('id');
            let language_name = $(this).find(':selected').data('name');
            let html = `<div class="row" id="languageRow_` + count + `">
                            <div class="col-md-4">
                                <label for="" class="">` + language_name + `</label>
                                <input type="hidden" name="language[]" class="form-control"
                                    value="` + language_id +
                `">
                            </div>
                            <div class="col-md-4">
                                <div class="custom-controls-stacked d-inline-flex">
                                    <label class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" value="Good" name="language_level_` +
                language_id +
                `[]">
                                        <span class="custom-control-label">Good</span>
                                    </label>
                                    <label class="custom-control custom-radio ml-2">
                                        <input type="radio" class="custom-control-input" value="Fair" name="language_level_` +
                language_id + `[]">
                                        <span class="custom-control-label">Fair</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-3">
                            <span class="text-danger cur_sor" onclick="removeRow('languageRow_` + count + `')">X</span>
                        </div>
                        </div>`;
            $("#appendLanguageDiv").append(html);
            count++;
        });


        $("#addLanguage").on('click', () => {
            let language_html = `<div class="row mt-5" id="languageRow_` + count + `">
                                <div class="col-md-6">
                                    <select name="language[]" class="form-control select2-show-search" id="lang_` + count + `">
                                        <option value="">{{ __('Select Language') }}</option>
                                        @foreach ($languages as $language)
                    <option value="{{ $language->id }}">{{ $language->lang }}</option>
                                        @endforeach
                    </select>
                </div>
                <div class="col-md-5">
                    <select name="language_level[]" class="form-control select2-show-search">
                        <option value="">{{ __('Select Level') }}</option>
                                        <option value="Very Good">Very Good</option>
                                        <option value="Good">Good</option>
                                        <option value="Fair">Fair</option>
                                    </select>
                                </div>
                                <div class="col-md-1 mt-2">
                            <button class="text-danger btn btn-sm btn-default" onclick="removeRow('languageRow_` +
                count + `')"><i class="fa fa-minus"/></button>
                        </div>
                            </div>`;
            $("#appendLanguageDiv").append(language_html);
            initializeSelect2();
            count++;
        });
        // End Language Section

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
