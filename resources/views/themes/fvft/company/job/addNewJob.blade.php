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
            <h3 class="card-title">Add New Job </h3>
        </div>
    </div>
    <div class="alert alert-secondary d-none" role="alert"><button type="button" class="close" data-dismiss="alert"
            aria-hidden="true">×</button><span id="db_error" class="db_error"></span></div>
    <form action="{{ route('company.saveNewJob') }}" method="POST" enctype="multipart/form-data" id="jobForm">
        @csrf
        <div class="row">
            <div class="col-xl-6">
                <div class="row">
                    <div class="card m-b-20">
                        <div class="card-header">
                            <h3 class="card-title tempcolor">{{ strtoupper('Job Details') }}</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="title" class="form-label">Job Title&nbsp;<span
                                                class="req">*</span></label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" name="title" class="form-control"
                                            placeholder="Enter Job Title">
                                        <div class="require text-danger title"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="company" class="form-label"> 123 Company Name&nbsp;<span
                                                class="req">*</span></label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="hidden" name="company_id" class="form-control"
                                            value="{{ $company->id }}" readonly>
                                        <input type="text" name="company_name" class="form-control"
                                            value="{{ $company->company_name }}" readonly>
                                        <div class="require text-danger company_id"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="no_of_employee" class="form-label">No of Employee&nbsp;<span
                                                class="req">*</span></label>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="male_employee" class="form-label">Male</label>
                                                <input type="number" min="1" oninput="preventNegativeNo($(this));"
                                                    class="form-control" name="male_employee" placeholder="Enter number">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="female_employee" class="form-label">Female</label>
                                                <input type="number" min="1" oninput="preventNegativeNo($(this));"
                                                    class="form-control" name="female_employee"
                                                    placeholder="Enter number">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="any_employee" class="form-label">Any</label>
                                                <input type="number" min="1" oninput="preventNegativeNo($(this));"
                                                    class="form-control" name="any_employee" placeholder="Enter number">
                                            </div>
                                        </div>
                                        <div class="require text-danger male_employee"></div>
                                        <div class="require text-danger female_employee"></div>
                                        <div class="require text-danger any_employee"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="job_category" class="form-label">Job Category&nbsp;<span
                                                class="req"></span></label>
                                    </div>
                                    <div class="col-md-8">
                                        <select name="category_id" class="form-control select2-show-search">
                                            <option value="">Select Job Category</option>
                                            @foreach ($job_categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->functional_area }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="require text-danger category_id"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="working_hours" class="form-label">Working Hours Per Day&nbsp;<span
                                                class="req">*</span></label>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="input-group">
                                            <input type="number" class="form-control" name="working_hours"
                                                placeholder="eg, 8">
                                            <div class="input-group-append">
                                                <button type="button" class="btn btn-primary">In Hour(/hr)</button>
                                            </div>
                                        </div>
                                        <div class="require text-danger working_hour"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="working_days" class="form-label">Working Days Per Week&nbsp;<span
                                                class="req">*</span></label>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="input-group">
                                            <input type="number" class="form-control" name="working_days"
                                                placeholder="eg, 5">
                                            <div class="input-group-append">
                                                <button type="button" class="btn btn-primary">Days</button>
                                            </div>
                                        </div>
                                        <div class="require text-danger working_days"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="deadline" class="form-label">Apply Before</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" name="deadline" class="form-control datetime" readonly>
                                        <div class="require text-danger deadline"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class="form-label">Country&nbsp;<span
                                                class="req">*</span></label>
                                    </div>
                                    <div class="col-md-8">
                                        <select name="country" id="select-country" class="form-control select2-show-search"
                                            value="{{ isset($job->country_id) ? $job->country_id : '' }}"
                                            onchange="patchStates(this)">
                                            @foreach ($countries as $item)
                                                <option value="{{ $item->id }}" data-name="{{ $item->currency_name }}"
                                                    {{ isset($job->country_id) ? ($item->id == $job->country_id ? 'selected' : '') : null }}>
                                                    {{ $item->name }}</option>
                                            @endforeach

                                        </select>
                                        <div class="require text-danger country"></div>
                                    </div>
                                </div>

                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class="form-label">States&nbsp;<span
                                                class="req">*</span></label>
                                    </div>
                                    <div class="col-md-8">
                                        <select name="state" id="select-state" class="form-control select2-show-search"
                                            value="{{ isset($job->state_id) ? $job->state_id : '' }}"
                                            onchange="patchCities(this)">
                                        </select>
                                        <div class="require text-danger state"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class="form-label">Cities&nbsp;<span
                                                class="req">*</span></label>
                                    </div>
                                    <div class="col-md-8">
                                        <select name="city_id" id="select-city" class="form-control select2-show-search"
                                            value="{{ isset($job->city_id) ? $job->city_id : '' }}">
                                        </select>
                                        <div class="require text-danger city_id"></div>
                                    </div>
                                </div>

                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="contract" class="form-label">Contract Period&nbsp;<span
                                                class="req">*</span></label>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <select name="contract_year" class="form-control select2">
                                                    <option value="">Select Year</option>
                                                    @for ($i = 1; $i <= 10; $i++)
                                                        <option value="{{ $i }}">{{ $i }}</option>
                                                    @endfor
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <select name="contract_month" class="form-control select2">
                                                    <option value="">Select Month</option>
                                                    @for ($i = 1; $i <= 12; $i++)
                                                        <option value="{{ $i }}">{{ $i }}</option>
                                                    @endfor
                                                </select>
                                            </div>
                                        </div>
                                        {{-- <textarea name="contract_description" class="form-control mt-3" cols="10"
                                            rows="5"></textarea> --}}
                                        <div class="require text-danger contract_year"></div>
                                        <div class="require text-danger contract_month"></div>
                                        {{-- <div class="require text-danger contract_description"></div> --}}
                                    </div>

                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="job_description" class="form-label">Job Description</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="hidden" class="form-control" name="job_description"
                                            id="jobdescriptionID">
                                        <input type="hidden" class="form-control" name="job_description_intro"
                                            id="job_description_intro">
                                        <div id="JobDescription" style="min-height: 15rem;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="card m-b-20">
                        <div class="card-header">
                            <h3 class="card-title tempcolor">{{ strtoupper('Salary Facility') }}</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="salary" class="form-label">Salary&nbsp;<span
                                                class="req">*</span></label>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <input type="text" name="country_salary" class="form-control">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="" class="form-label countrylabel">USD</label>
                                                    </div>
                                                </div>
                                                <div class="row mt-3">
                                                    <div class="col-md-8">
                                                        <input type="text" name="nepali_salary" class="form-control">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="" class="form-label">NPR</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="require text-danger country_salary"></div>
                                            <div class="require text-danger nepali_salary"></div>
                                        </div>
                                        <div class="form-group mt-2">
                                            <label class="custom-switch-checkbox">
                                                <input type="checkbox" name="hide_salary" class="custom-switch-input">
                                                <span class="custom-switch-indicator"></span>
                                                <span class="custom-switch-description">Hide Salary</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="accomodation" class="form-label">Accommodation&nbsp;<span
                                                class="req">*</span></label>
                                    </div>
                                    <div class="col-md-8">
                                        <select name="accomodation" class="form-control select2">
                                            <option value="">Select</option>
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                        <div class="require text-danger accomodation"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="food" class="form-label">Food&nbsp;<span
                                                class="req">*</span></label>
                                    </div>
                                    <div class="col-md-8">
                                        <select name="food" class="form-control select2">
                                            <option value="">Select</option>
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                        <div class="require text-danger food"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="annual_vacation" class="form-label">Annual Vacation&nbsp;<span
                                                class="req">*</span></label>
                                    </div>
                                    <div class="col-md-8">
                                        <select name="annual_vacation" class="form-control select2">
                                            <option value="">Select</option>
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                        <div class="require text-danger annual_vacation"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="over_time" class="form-label">Over Time&nbsp;<span
                                                class="req">*</span></label>
                                    </div>
                                    <div class="col-md-8">
                                        <select name="over_time" class="form-control select2">
                                            <option value="">Select</option>
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                        <div class="require text-danger over_time"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="requirements" class="form-label">Other Benefits</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="hidden" class="form-control" name="other_benefits" id="benefitID">
                                        <input type="hidden" class="form-control" name="benefit_intro"
                                            id="benefit_intro">
                                        <div id="benefitEditor" style="min-height: 15rem;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="row ml-2">
                    <div class="card m-b-20">
                        <div class="card-header">
                            <h3 class="card-title tempcolor">{{ strtoupper('Applicant Qualification') }}</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="education_level" class="form-label">Minimum
                                            Qualification&nbsp;<span class="req">*</span></label>
                                    </div>
                                    <div class="col-md-8">
                                        <select name="education_level" class="form-contorl select2-show-search">
                                            <option value="">Select Qualification</option>
                                            @foreach ($educationlevels as $educationlevel)
                                                <option value="{{ $educationlevel->id }}">{{ $educationlevel->title }}
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
                                        <label for="year_of_experience" class="form-label">Year of Experience</label>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <select name="min_experience" class="form-control select2">
                                                    <option value="">Min</option>
                                                    @for ($i = 0; $i <= 10; $i++)
                                                        <option value="{{ $i }}">{{ $i }}</option>
                                                    @endfor
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <select name="max_experience" class="form-control select2">
                                                    <option value="">Max</option>
                                                    @for ($i = 1; $i <= 15; $i++)
                                                        <option value="{{ $i }}">{{ $i }}</option>
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
                                        <label for="age_requirement" class="form-label">Age Requirement</label>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <select name="min_age" class="form-control select2">
                                                    <option value="">Min</option>
                                                    @for ($i = 18; $i <= 25; $i++)
                                                        <option value="{{ $i }}">{{ $i }}</option>
                                                    @endfor
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <select name="max_age" class="form-control select2">
                                                    <option value="">Max</option>
                                                    @for ($i = 18; $i <= 50; $i++)
                                                        <option value="{{ $i }}">{{ $i }}</option>
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
                                        <label for="skils" class="form-label">Skills</label>
                                    </div>
                                    <div class="col-md-8">
                                        <select name="skills[]" class="form-control select2" multiple="multiple">
                                            @foreach ($skills as $skill)
                                                <option value="{{ $skill->id }}">{{ $skill->title }}</option>
                                            @endforeach
                                        </select>
                                        <div class="require text-danger skills"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="requirements" class="form-label">Other Requirements</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="hidden" class="form-control" name="other_requirements"
                                            id="requirementID">
                                        <input type="hidden" class="form-control" name="requirement_intro"
                                            id="requirement_intro">
                                        <div id="editor" style="min-height: 15rem;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row ml-2">
                    <div class="card m-b-20">
                        <div class="card-header">
                            <h3 class="card-title tempcolor">{{ strtoupper('Picture') }}</h3>
                        </div>
                        <div class="card-body">
                            {{-- <div class="form-group">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="" class="form-label">Upload Picture(Max Number is 5)</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="file" class="form-control dropify" name="picture[]"
                                        data-allowed-file-extensions="png jpg jpeg" id="Picture" multiple>
                                    <div class="require text-danger picture"></div>
                                </div>
                            </div>
                        </div> --}}
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="" class="form-label">Upload Featured Image</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="file" class="form-control dropify" name="feature_image"
                                            data-allowed-file-extensions="png jpg jpeg">
                                        <div class="require text-danger feature_image"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mr-auto ml-2">
                    <button type="button" name="saveType" value="save_as_draft"
                        onclick="submitForm(event, 'save_as_draft');" class="btn btn-primary rounded-0">Save as Draft</button>
                    <button type="button" name="saveType" value="save_and_preview"
                        onclick="submitForm(event, 'save_and_preview');" class="btn btn-warning rounded-0 ml-2">Preview</button>
                    <button type="button" name="saveType" value="proceed_to_approval"
                        onclick="submitForm(event, 'proceed_to_approval');" class="btn btn-success rounded-0 ml-3">Proceed To
                        Approval</button>
                </div>
            </div>
        </div>
        {{-- <div class="row mb-5">
            <div class="mx-auto">
                <button type="button" onclick="submitForm(event);" class="btn btn-success">Submit</button>
            </div>
        </div> --}}
    </form>
@endsection
@section('script')
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <script src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>
    <script>
        const _token = $('meta[name="csrf-token"]')[0].content;
        const state_id = {{ isset($job->state_id) ? $job->state_id : 'null' }};
        const city_id = {{ isset($job->city_id) ? $job->city_id : 'null' }};
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

        function submitForm(e, saveType) {
            e.preventDefault();
            $('.require').css('display', 'none');
            let url = $("#jobForm").attr("action");
            var formData = new FormData($("#jobForm")[0]);
            formData.append('saveType', saveType);
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
                        toastr.success(data.msg);
                    }
                }
            });
        }


        let requirement = "";
        let benefits = "";
        let job_description = "";

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

        var ben_quill = new Quill('#benefitEditor', {
            theme: 'snow',
            modules: {
                toolbar: toolbarOptions
            }
        });

        var jd_quill = new Quill('#JobDescription', {
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

        // for benefits
        ben_quill.on('text-change', function() {
            benefits = JSON.stringify(ben_quill.getContents());
            $("#benefitID")[0].value = benefits;
            $("#benefit_intro")[0].value = escapeHtml($('.ql-editor').html());
        });
        if ($("#benefitID")[0].value != '') {
            ben_quill.setContents(JSON.parse($("#benefitID")[0].value))
        }

        // for job_description
        jd_quill.on('text-change', function() {
            job_description = JSON.stringify(jd_quill.getContents());
            $("#jobdescriptionID")[0].value = job_description;
            $("#job_description_intro")[0].value = escapeHtml($('.ql-editor').html());
        });
        if ($("#jobdescriptionID")[0].value != '') {
            jd_quill.setContents(JSON.parse($("#jobdescriptionID")[0].value))
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
