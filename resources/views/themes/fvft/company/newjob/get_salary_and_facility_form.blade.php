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
    <form action="{{ route('company.newjob.post_salary_and_facility') }}" method="POST" enctype="multipart/form-data"
        id="jobForm">
        @csrf
        <div class="col-xl-12">
            <div class="row">
                <div class="card m-b-20">
                    <div class="card-header">
                        <h3 class="card-title tempcolor">{{ strtoupper(__('Salary Facility')) }}</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <input type="hidden" name="job_id" class="form-control"
                                value="{{ setParameter($job, 'id') }}">
                            <input type="hidden" class="form-control" id="countryId"
                                value="{{ setParameter($job, 'country_id') }}">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="salary" class="form-label">{{ __('Basic Salary') }}&nbsp;<span
                                            class="req">*</span></label>
                                </div>
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <input type="text" name="country_salary" value="{{ setParameter($job, 'country_salary') }}" class="form-control">
                                                    <div class="require text-danger country_salary"></div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="" class="form-label countrylabel">{{ isset($currency) ? $currency : 'NPR' }}</label>
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-md-8">
                                                    <input type="text" name="nepali_salary" value="{{ setParameter($job, 'nepali_salary') }}" class="form-control">
                                                    <div class="require text-danger nepali_salary"></div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="" class="form-label">NPR</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mt-2">
                                        <label class="custom-switch-checkbox">
                                            <input type="checkbox" name="hide_salary" class="custom-switch-input" {{ setParameter($job, 'hide_salary') == 1 ? 'checked' : '' }}>
                                            <span class="custom-switch-indicator"></span>
                                            <span class="custom-switch-description">{{ __('Hide Salary') }}</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="salary" class="form-label">{{ __('Average Earning') }}</label>
                                </div>
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <input type="text" name="earning_country_salary" value="{{ setParameter($job, 'earning_country_salary') }}" class="form-control">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="" class="form-label countrylabel">{{ isset($currency) ? $currency : '' }}</label>
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-md-8">
                                                    <input type="text" name="earning_nepali_salary" value="{{ setParameter($job, 'earning_nepali_salary') }}" class="form-control">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="" class="form-label countrylabel">{{ isset($currency) ? $currency : '' }}</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="require text-danger earning_country_salary"></div>
                                        <div class="require text-danger earning_nepali_salary"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="accomodation" class="form-label">{{ __('Accommodation') }}&nbsp;<span
                                            class="req">*</span></label>
                                </div>
                                <div class="col-md-8">
                                    <select name="accomodation" class="form-control select2">
                                        <option value="">{{ __('Select') }}</option>
                                        <option value="1" {{ setParameter($job, 'accomodation') == 1 ? 'selected' : '' }}>{{ __('Yes') }}</option>
                                        <option value="0" {{ setParameter($job, 'accomodation') == 0 ? 'selected' : '' }}>{{ __('No') }}</option>
                                    </select>
                                    <div class="require text-danger accomodation"></div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="food" class="form-label">{{ __('Food') }}&nbsp;<span
                                            class="req">*</span></label>
                                </div>
                                <div class="col-md-8">
                                    <select name="food" class="form-control select2">
                                        <option value="">{{ __('Select') }}</option>
                                        <option value="1" {{ setParameter($job, 'food') == 1 ? 'selected' : '' }}>{{ __('Yes') }}</option>
                                        <option value="0" {{ setParameter($job, 'food') == 0 ? 'selected' : '' }}>{{ __('No') }}</option>
                                    </select>
                                    <div class="require text-danger food"></div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="annual_vacation" class="form-label">{{ __('Annual Vacation') }}&nbsp;<span
                                            class="req">*</span></label>
                                </div>
                                <div class="col-md-8">
                                    <select name="annual_vacation" class="form-control select2">
                                        <option value="">{{ __('Select') }}</option>
                                        <option value="1" {{ setParameter($job, 'annual_vacation') == 1 ? 'selected' : '' }}>{{ __('Yes') }}</option>
                                        <option value="0" {{ setParameter($job, 'annual_vacation') == 0 ? 'selected' : '' }}>{{ __('No') }}</option>
                                    </select>
                                    <div class="require text-danger annual_vacation"></div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="over_time" class="form-label">{{ __('Over Time') }}&nbsp;<span
                                            class="req">*</span></label>
                                </div>
                                <div class="col-md-8">
                                    <select name="over_time" class="form-control select2">
                                        <option value="">{{ __('Select') }}</option>
                                        <option value="1" {{ setParameter($job, 'over_time') == 1 ? 'selected' : '' }}>{{ __('Yes') }}</option>
                                        <option value="0" {{ setParameter($job, 'over_time') == 0 ? 'selected' : '' }}>{{ __('No') }}</option>
                                    </select>
                                    <div class="require text-danger over_time"></div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="requirements" class="form-label">{{ __('Other Benefits') }}</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="hidden" class="form-control" value="{{ setParameter($job, 'benefits') }}" name="other_benefits" id="benefitID">
                                    <input type="hidden" class="form-control" name="benefit_intro" value="{{ setParameter($job, 'benefit_intro') }}" id="benefit_intro">
                                    <div id="benefitEditor" style="min-height: 15rem;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mx-auto">
                    <span>{{__('Applicant Qualification')}}</span>&nbsp;&nbsp;&nbsp;<a
                        href="{{ route('company.newjob.get_applicant_form', ['job_id' => request()->job_id]) }}"
                        class="btn btn-primary rounded-0"><i class="fa fa-arrow-left"></i> {{ __('Back') }}</a>
                    <button type="button" onclick="submitForm(event);" class="btn btn-primary rounded-0 ml-5">{{ __('Next') }} <i
                            class="fa fa-arrow-right"></i></button>&nbsp;&nbsp;&nbsp;<span>{{ __('Preview') }}</span>
                </div>
            </div>
        </div>
    </form>
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


            $("#Picture").on("change", function() {
                if ($("#Picture")[0].files.length > 5) {
                    alert("You can select only 5 images");
                    $("#Picture").val(null);
                }
            });

            $('.dropify').dropify({
                error: {

                    'imageFormat': 'The image format is not allowed (png, jpg, jpeg only).'
                }
            });

            var currency_name = $("#select-country option:selected").data('name');
            $(".countrylabel").html(currency_name);


            $("#select-country").on('change', function() {
                var currency_name = $(this).find('option:selected').data('name');
                $(".countrylabel").html(currency_name);
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


        let benefits = "";

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
        var ben_quill = new Quill('#benefitEditor', {
            theme: 'snow',
            modules: {
                toolbar: toolbarOptions
            }
        });

        // for benefits
        ben_quill.on('text-change', function() {
            benefits = JSON.stringify(ben_quill.getContents());
            $("#benefitID")[0].value = benefits;
            $("#benefit_intro")[0].value = escapeHtml($('.ql-editor').html());
        });
        if ($("#benefitID")[0].value != '') {
            ben_quill.setContents(JSON.parse($("#benefitID")[0].value))
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
    </script>
@endsection
