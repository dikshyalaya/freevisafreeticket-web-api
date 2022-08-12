@extends('themes.fvft.company.layouts.dashmaster')
@section('title', 'Applicants')
@section('applicants', 'active')
@section('data')
    <link rel="stylesheet" href="{{ asset('css/datepicker.min.css') }}">
    <style>
        .table-responsive>.table-bordered {
            border: 1px solid #e8ebf3;
            ;
        }

        a.advancedSearch:hover {
            color: white !important;
        }

        #rangeValue {
            position: absolute;
            margin-left: -0.9em;
            top: -24px;
        }

        .ui-slider-range.ui-corner-all.ui-widget-header {
            background-color: blue !important;
        }

        .ui-state-default,
        .ui-widget-content .ui-state-default,
        .ui-widget-header .ui-state-default,
        .ui-button,
        html .ui-button.ui-state-disabled:hover,
        html .ui-button.ui-state-disabled:active {
            background: #007bff;
        }

        .ui-slider-horizontal {
            background: #0006108f !important;
        }

    </style>
    <?php
    use App\Enum\ApplicantStatus;
    ?>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ __('Application Management') }}</h3>
        </div>
    </div>
    <form action="#" method="#" id="FilterForm">
        {{-- @csrf --}}
        <div class="card">
            <div class="card-body">
                <div class="search-section mx-auto">
                    <h4 class="text-center">Advanced Application Search</h4>
                    <div class="row text-center">
                        <div class="col-md-2"></div>
                        <div class="col-md-6">
                            <div class="form-inline">
                                <label for="" class="font-weight-bold">Select Predefined Filter</label>
                                <select name="predefined_filter" class="form-control ml-3 w-60"
                                    onchange="getApplicantFilter($(this).val());">
                                    <option value="">Select Filter</option>
                                    @foreach ($applicantFilters as $applicantFilter)
                                        <option value="{{ $applicantFilter->id }}">{{ $applicantFilter->filter_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                        </div>
                    </div>
                    <div class="row mt-5">
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4 my-auto">
                                        <label for="" class="form-label">{{ __('Job Title') }}</label>
                                    </div>
                                    <div class="col-md-8">
                                        <select name="job_title" class="form-control select2-show-search"
                                            data-placeholder="All Job Title" id="jobTitle">
                                            <option value="">All Job Title</option>
                                            @foreach ($job_categories as $job_category)
                                                <option value="{{ $job_category->id }}">
                                                    {{ $job_category->functional_area }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4 my-auto">
                                        <label for="" class="form-label">{{ __('Gender') }}</label>
                                    </div>
                                    <div class="col-md-8">
                                        <select name="gender" class="form-control select2-show-search"
                                            data-placeholder="Select Gender" id="gender">
                                            <option value="">Select Gender</option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4 my-auto">
                                        <label for="" class="form-label">{{ __('Applied On') }}</label>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="d-inline-flex">
                                            <input type="text" name="from_date" class="form-control from_date w-70"
                                                placeholder="25-01-2022" id="from_date">
                                            &nbsp;<label for="" class="w-30 my-auto">From Date</label>
                                        </div>
                                        <div class="d-inline-flex mt-2">
                                            <input type="text" name="to_date" class="form-control to_date w-70"
                                                placeholder="25-02-2022" id="to_date">
                                            <label for="" class="w-30">To Date</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4 my-auto">
                                        <label for="" class="form-label">{{ __('Experience') }}</label>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="d-flex">
                                            <select name="experience" class="form-control select2-show-search w-60"
                                                data-placeholder="Select Experience" id="Experience">
                                                <option value="">Select Experience</option>
                                                @for ($i = 0; $i <= 10; $i++)
                                                    <option value="{{ $i }}">
                                                        {{ $i }}</option>
                                                @endfor
                                            </select>
                                            <label for="" class="w-40 my-auto">Years Min</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4 my-auto">
                                        <label for="" class="form-label">{{ __('Education') }}</label>
                                    </div>
                                    <div class="col-md-8">
                                        <select name="education_level" class="form-control select2-show-search"
                                            data-placeholder="Select Education Level" id="EducationLevel">
                                            <option value="">Select Education Level</option>
                                            @foreach ($education_levels as $education_level)
                                                <option value="{{ $education_level->id }}">
                                                    {{ $education_level->title }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4 my-auto">
                                        <label for="" class="form-label">{{ __('Skills') }}</label>
                                    </div>
                                    <div class="col-md-8">
                                        <select name="skills[]" class="form-control select2-show-search" id="Skills"
                                            multiple>
                                            <option value="">Select Skills</option>
                                            @foreach ($skills as $skill)
                                                <option value="{{ $skill->id }}">{{ $skill->title }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4 my-auto">
                                        <label for="" class="form-label">Application Status</label>
                                    </div>
                                    <div class="col-md-8">
                                        <select name="application_status" class="form-control select2-show-search"
                                            data-placeholder="Select Application Status" id="ApplicationStatus">
                                            <option value="">Select Application Status</option>
                                            <option value="{{ ApplicantStatus::PENDING }}">
                                                {{ ucfirst(ApplicantStatus::PENDING) }}</option>
                                            <option value="{{ ApplicantStatus::SHORTLISTED }}">
                                                {{ ucfirst(ApplicantStatus::SHORTLISTED) }}</option>
                                            <option value="{{ ApplicantStatus::SELECTEDFORINTERVIEW }}">
                                                {{ ucfirst(ApplicantStatus::SELECTEDFORINTERVIEW) }}</option>
                                            <option value="{{ ApplicantStatus::INTERVIEWED }}">
                                                {{ ucfirst(ApplicantStatus::INTERVIEWED) }}</option>
                                            <option value="{{ ApplicantStatus::ACCEPTED }}">
                                                {{ ucfirst(ApplicantStatus::ACCEPTED) }}</option>
                                            <option value="{{ ApplicantStatus::REJECTED }}">
                                                {{ ucfirst(ApplicantStatus::REJECTED) }}</option>
                                            <option value="{{ ApplicantStatus::REDLISTED }}">
                                                {{ ucfirst(ApplicantStatus::REDLISTED) }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4 my-auto">
                                        <label for="" class="form-label">Profile Score</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="hidden" name="profile_score" id="profileScore">
                                        <div id="profileScoreSlider">
                                            <span id="rangeValue" tabindex="0" style="left:0%">0%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4 my-auto">
                                        <label for="" class="form-label">Age Range</label>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="d-flex">
                                                    <select name="min_age" class="form-control select2-show-search"
                                                        data-placeholder="Min" id="MinAge">
                                                        <option value="">Min</option>
                                                        @for ($i = 18; $i <= 25; $i++)
                                                            <option value="{{ $i }}">{{ $i }}
                                                            </option>
                                                        @endfor
                                                    </select>
                                                    <label for="" class="my-auto ml-1">years to</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="d-flex">
                                                    <select name="max_age" class="form-control select2-show-search"
                                                        data-placeholder="Max" id="MaxAge">
                                                        <option value="">Max</option>
                                                        @for ($i = 18; $i <= 50; $i++)
                                                            <option value="{{ $i }}">{{ $i }}
                                                            </option>
                                                        @endfor
                                                    </select>
                                                    <label for="" class="my-auto ml-1">years</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4 my-auto">
                                        <label for="" class="form-label">Training</label>
                                    </div>
                                    <div class="col-md-8">
                                        <select name="trainings[]" class="form-control select2-show-search" multiple
                                            id="Trainings">
                                            <option value="">Select Trainings</option>
                                            @foreach ($trainings as $training)
                                                <option value="{{ $training->id }}">{{ $training->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4 my-auto">
                                        <label for="" class="form-label">Language</label>
                                    </div>
                                    <div class="col-md-8">
                                        <select name="languages[]" class="form-control select2-show-search" multiple
                                            id="Languages">
                                            <option value="">Select Languages</option>
                                            @foreach ($languages as $language)
                                                <option value="{{ $language->id }}">{{ $language->lang }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4 my-auto">
                                        <label for="" class="form-label">Preferred Job</label>
                                    </div>
                                    <div class="col-md-8">
                                        <select name="preferred_jobs[]" class="form-control select2-show-search" multiple
                                            id="PreferredJobs">
                                            <option value="">Select Preferred Job</option>
                                            @foreach ($preferredCategories as $preferredCategory)
                                                <option value="{{ $preferredCategory->id }}">
                                                    {{ $preferredCategory->functional_area }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4 my-auto">
                                        <label for="" class="form-label">Preferred Country</label>
                                    </div>
                                    <div class="col-md-8">
                                        <select name="preferred_countries[]" class="form-control select2-show-search"
                                            multiple id="PreferredCountries">
                                            <option value="">Select Preferred Country</option>
                                            @foreach ($preferredCountries as $preferredCountry)
                                                <option value="{{ $preferredCountry->id }}">
                                                    {{ $preferredCountry->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body" style="background-color: #b6b8bb4a">
                <div class="filter-section">
                    <h6 class="font-weight-bold text-center" style="color: #1650e2">Save this setting for future use.</h6>
                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-7">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="" class="form-label">Filter Name</label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" name="filter_name" class="form-control" id="filterName">
                                    <span class="require text-danger filter_name"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <button type="button" class="btn btn-warning" id="SaveFilter" onclick="saveFilter();">Save
                                Filter</button>
                            <a href="javascript:void(0);" class="ml-3" id="ResetFilter">Reset Filter</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center mx-auto">
            <button type="button" class="btn btn-primary rounded-0 text-right mx-auto font-weight-bold" id="SearchNow"
                onclick="searchNow();">Search Now</button>

        </div>
    </form>
@endsection

@section('js')
    <script src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>
    <script>
        function removeSpan() {
            $("#profileScoreSlider").find("span:nth-child(3)").remove();
        }
        $(document).ready(function() {
            $("#profileScoreSlider").find("span:nth-child(3)").remove();

            $("#ResetFilter").on("click", function() {
                resetForm();
            });

            $('#from_date').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                todayHighlight: true,
                endDate: '0d',
            }).on("changeDate", function(selected) {
                var minDate = new Date(selected.date.valueOf());
                $("#to_date").datepicker('setStartDate', minDate);
            });

            $('#to_date').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                todayHighlight: true,
                // endDate: '0d',
            }).on('changeDate', function(selected) {
                var minDate = new Date(selected.date.valueOf());
                $("#from_date").datepicker('setEndDate', minDate);
            });
        });

        function resetForm() {
            $("#FilterForm")[0].reset();
            $(".select2-show-search").val(null).trigger('change');
            $(".select2").val(null).trigger('change');
            $("#profileScore").val("0%");
            $("#rangeValue").text("0%").css({
                left: "0%"
            });
            $(".ui-slider-range.ui-corner-all.ui-widget-header").css({
                width: "0%"
            });
            $(".ui-slider-handle.ui-corner-all.ui-state-default").css({
                left: "0%"
            });
            $(".require").css('display', 'none');
        }

        function saveFilter() {
            var url = "{{ route('saveFilter') }}",
                method = "POST";
            $("#FilterForm").attr('action', url);
            $("#FilterForm").attr('method', 'POST');
            var formData = new FormData($("#FilterForm")[0]);
            formData.append('_token', "{{ csrf_token() }}");
            $.ajax({
                url: url,
                type: "POST",
                data: formData,
                // data: new FormData($("#FilterForm")[0]),
                processData: false,
                contentType: false,
                cache: false,
                beforeSend: function() {
                    busySign();
                },
                success: function(data) {
                    if (data.success == false) {
                        if (data.errors) {
                            toastr.error(data.errors.filter_name[0]);
                            $(".filter_name").html(data.errors.filter_name[0]);
                        } else if (data.db_error) {
                            toastr.error(data.db_error);
                        }
                    } else if (data.success == true) {
                        toastr.success(data.msg);
                        resetForm();
                    }
                },
                complete: function() {
                    hideBusySign();
                }
            });
        }


        function searchNow() {
            var url = "{{ route('getAdvancedSearchData') }}",
                method = 'GET';
            $("#FilterForm").attr('action', url);
            $("#FilterForm").attr('method', method);
            $("#FilterForm").submit();
        }

        $("#profileScoreSlider").slider({
            range: true,
            min: 0,
            max: 100,
            values: [0],
            slide: function(event, ui) {
                $("#profileScore").val(ui.values[1] + "%");
                $("#rangeValue").text(ui.values[1] + "%").css({
                    left: ui.values[1] + "%"
                });
                // $("#profileScore").val(ui.values[0] + "%" + "-" + ui.values[1]+"%");
            }
        });

        $("#profileScore").val($("#profileScoreSlider").slider("values", 1) + "%");
        // $("#profileScore").val($("#profileScoreSlider").slider("values", 0) + "%"  + $("#profileScoreSlider").slider("values", 1) + "%");

        function getApplicantFilter(filterId) {
            if (filterId == '') {
                resetForm();
            } else {
                $.ajax({
                    url: "{{ route('getApplicantFilter') }}",
                    type: "GET",
                    data: {
                        "applicantFilterId": filterId
                    },
                    beforeSend: function() {
                        busySign();
                    },
                    success: function(data) {
                        if (data.success == false) {
                            toastr.error(data.error);
                        } else if (data.success == true) {
                            var jsonData = JSON.parse(data.applicantFilter.filter_value)[0];
                            $("#jobTitle").select2('val', jsonData.job_title);
                            $("#gender").val(jsonData.gender).trigger('change');
                            $("#from_date").val(jsonData.from_date);
                            $("#to_date").val(jsonData.to_date);
                            $("#Experience").select2('val', jsonData.experience);
                            $("#EducationLevel").select2('val', jsonData.education_level);
                            $("#Skills").val(JSON.parse(jsonData.skills)).trigger('change');
                            $("#ApplicationStatus").val(jsonData.application_status).trigger('change');
                            $("#profileScore").val(jsonData.profile_score);
                            $("#rangeValue").text(jsonData.profile_score).css({
                                left: jsonData.profile_score
                            });
                            $(".ui-slider-range.ui-corner-all.ui-widget-header").css({
                                width: jsonData.profile_score
                            });
                            $(".ui-slider-handle.ui-corner-all.ui-state-default").css({
                                left: jsonData.profile_score
                            });
                            $("#MinAge").val(jsonData.min_age).trigger('change');
                            $("#MaxAge").val(jsonData.max_age).trigger('change');
                            $("#Trainings").val(JSON.parse(jsonData.trainings)).trigger('change');
                            $("#Languages").val(JSON.parse(jsonData.languages)).trigger('change');
                            $("#PreferredJobs").val(JSON.parse(jsonData.preferred_jobs)).trigger('change');
                            $("#PreferredCountries").val(JSON.parse(jsonData.preferred_countries)).trigger(
                                'change');
                            $("#filterName").val(data.applicantFilter.filter_name);
                        }
                    },
                    complete: function() {
                        hideBusySign();
                    }
                });
            }
        }
    </script>
@endsection
