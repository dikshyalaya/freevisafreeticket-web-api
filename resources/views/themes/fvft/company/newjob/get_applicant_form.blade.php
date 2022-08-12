@extends('themes.fvft.company.layouts.dashmaster')
@section('title', 'Add New Job')
@section('jobs', 'active')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/datepicker.min.css') }}">
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <style>
        .req {
            color: red;
        }

        .tempcolor {
            color: #1650e2;
            font-weight: bold;
        }

        .ql-container {
            height: 0 !important;
        }

    </style>
@endsection
@section('data')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ __('Add New Job') }}</h3>
        </div>
    </div>
    @include('partial.job.step')
    <div class="alert alert-secondary d-none" role="alert"><button type="button" class="close" data-dismiss="alert"
            aria-hidden="true">×</button><span id="db_error" class="db_error"></span></div>
    <form action="{{ route('company.newjob.post_applicant_form') }}" method="POST" enctype="multipart/form-data"
        id="jobForm">
        @csrf
        <div class="col-xl-12">
            <div class="row">
                <div class="card m-b-20">
                    <div class="card-header">
                        <h3 class="card-title tempcolor">{{ strtoupper(__('Applicant Qualification')) }}</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <input type="hidden" value="{{ setParameter($job, 'id') }}" class="form-control"
                                name="job_id">
                            <input type="hidden" class="form-control" name="editRoute"
                                value="{{ $editRoute }}">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="education_level" class="form-label">{{ __('Minimum Qualification') }}&nbsp;<span class="req">*</span></label>
                                </div>
                                <div class="col-md-8">
                                    <select name="education_level" class="form-contorl select2-show-search"
                                        data-placeholder="Select Qualification">
                                        <option value="">{{ __('Select Qualification') }}</option>
                                        @foreach ($educationlevels as $educationlevel)
                                            <option value="{{ $educationlevel->id }}"
                                                {{ setParameter($job, 'education_level_id') == $educationlevel->id ? 'selected' : '' }}>
                                                {{ $educationlevel->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="require text-danger education_level"></div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="year_of_experience" class="form-label">{{ __('Year of Experience') }}</label>
                                </div>
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <select name="min_experience" class="form-control select2">
                                                <option value="">{{ __('Min') }}</option>
                                                @for ($i = 0; $i <= 10; $i++)
                                                    <option value="{{ $i }}"
                                                        {{ setParameter($job, 'min_experience') != null && setParameter($job, 'min_experience') == $i ? 'selected' : '' }}>
                                                        {{ $i }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <select name="max_experience" class="form-control select2">
                                                <option value="">{{ __('Max') }}</option>
                                                @for ($i = 1; $i <= 15; $i++)
                                                    <option value="{{ $i }}"
                                                        {{ setParameter($job, 'max_experience') == $i ? 'selected' : '' }}>
                                                        {{ $i }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                    <div class="require text-danger min_experience"></div>
                                    <div class="require text-danger max_experience"></div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="age_requirement" class="form-label">{{ __('Age Requirement') }}</label>
                                </div>
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <select name="min_age" class="form-control select2">
                                                <option value="">{{ __('Min') }}</option>
                                                @for ($i = 18; $i <= 25; $i++)
                                                    <option value="{{ $i }}"
                                                        {{ setParameter($job, 'min_age') == $i ? 'selected' : '' }}>
                                                        {{ $i }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <select name="max_age" class="form-control select2">
                                                <option value="">{{ __('Max') }}</option>
                                                @for ($i = 18; $i <= 50; $i++)
                                                    <option value="{{ $i }}"
                                                        {{ setParameter($job, 'max_age') == $i ? 'selected' : '' }}>
                                                        {{ $i }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                    <div class="require text-danger min_age"></div>
                                    <div class="require text-danger max_age"></div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="skils" class="form-label">{{ __('Skills') }}</label>
                                </div>
                                <div class="col-md-6">
                                    <select name="skills[]" id="skill" class="form-control select2" multiple="multiple">
                                        @foreach ($skills as $skill)
                                            <option value="{{ $skill->id }}"
                                                {{ json_decode(setParameter($job, 'skills'), true) != null &&in_array($skill->id, json_decode(setParameter($job, 'skills'), true))? 'selected': '' }}>
                                                {{ $skill->title }}</option>
                                        @endforeach
                                    </select>
                                    <div class="require text-danger skills"></div>
                                </div>
                                <div class="col-md-2 mt-1">
                                    <span class="cur_sor btn btn-sm btn-primary rounded-0" data-toggle="modal"
                                        data-target="#newSkillModal">{{ __('Add New Skill') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="requirements" class="form-label">{{ __('Other Requirements') }}</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="hidden" class="form-control"
                                        value="{{ setParameter($job, 'requirements') }}" name="other_requirements"
                                        id="requirementID">
                                    <input type="hidden" class="form-control"
                                        value="{{ setParameter($job, 'requirement_intro') }}" name="requirement_intro"
                                        id="requirement_intro">
                                    <div id="editor" style="min-height: 15rem;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mx-auto">
                    @if (request()->editRoute == 'company.editjob')
                        <span>{{ __('Job Details') }}</span>&nbsp;&nbsp;&nbsp;<a
                            href="{{ route('company.editjob', request()->job_id) }}" class="btn btn-primary rounded-0"><i
                                class="fa fa-arrow-left"></i> {{ __('Back') }}</a>
                    @else
                        <span>{{ __('Job Details') }}</span>&nbsp;&nbsp;&nbsp;<a
                            href="{{ route('company.newjob.get_job_detail', ['job_id' => request()->job_id]) }}"
                            class="btn btn-primary rounded-0"><i class="fa fa-arrow-left"></i> {{ __('Back') }}</a>
                    @endif

                    <button type="button" onclick="submitForm(event);" class="btn btn-primary rounded-0 ml-5">{{ __('Next') }} <i
                            class="fa fa-arrow-right"></i></button>&nbsp;&nbsp;&nbsp;<span>{{ __('Salary and Facility') }}</span>
                </div>
            </div>
        </div>
    </form>

    @include('admin.partial.modals.newSkillModal')
@endsection
@section('script')
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <script src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>
    <script>
        const _token = $('meta[name="csrf-token"]')[0].content;
        const appurl = "{{ env('APP_URL') }}";

        $(function() {
            $('.datetime').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                todayHighlight: true,
            });


            $('.dropify').dropify({
                error: {

                    'imageFormat': 'The image format is not allowed (png, jpg, jpeg only).'
                }
            });
        });

        function submitForm(e) {
            e.preventDefault();
            $('.require').css('display', 'none');
            let url = $("#jobForm").attr("action");
            var formData = new FormData($("#jobForm")[0]);
            $.ajax({
                url: url,
                type: 'post',
                data: formData,
                // data: new FormData($("#jobForm")[0]),
                processData: false,
                contentType: false,
                cache: false,
                success: function(data) {
                    // return true;
                    if (data.db_error) {
                        $(".alert-warning").css('display', 'block');
                        $(".db_error").html(data.db_error);
                        toastr.warning(data.db_error);
                    } else if (data.errors) {
                        var error_html = "";
                        $.each(data.errors, function(key, value) {
                            error_html = '<div>' + value + '</div>';
                            $('.' + key).css('display', 'block').html(error_html);
                        });
                    } else if (!data.errors && !data.db_error) {
                        location.href = data.redirectRoute;
                        // toastr.success(data.msg);
                    }
                }
            });
        }


        let requirement = "";

        var toolbarOptions = [
            [{
                'header': [1, 2, 3, 4, 5, 6, false]
            }],
            [{
                'color': []
            }, {
                'background': []
            }], // dropdown with defaults from theme
            // [{ 'font': [] }],
            // [{ 'list': 'ordered'}, { 'list': 'bullet' }],
            [{
                'align': []
            }],
            ['bold', 'italic', 'underline'],
            ['link', 'image']
        ];
        var req_quill = new Quill('#editor', {
            theme: 'snow',
            modules: {
                toolbar: toolbarOptions
            }
        });

        req_quill.on('text-change', function() {
            requirement = JSON.stringify(req_quill.getContents());
            $("#requirementID")[0].value = requirement;
            $("#requirement_intro")[0].value = escapeHtml($('.ql-editor').html());
        });
        if ($("#requirementID")[0].value != '') {
            req_quill.setContents(JSON.parse($("#requirementID")[0].value))
        }



        function escapeHtml(text) {
            const map = {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            };

            return text.replace(/[&<>"']/g, function(m) {
                return map[m];
            });
        }


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

        $(document).ready(function() {
            $("#newSkillModal").on('hidden.bs.modal', function() {
                $(this).find('form')[0].reset();
                $('.require').css('display', 'none');
            });
        });
    </script>
@endsection
