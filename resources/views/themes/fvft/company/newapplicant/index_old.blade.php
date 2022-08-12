        @extends('themes.fvft.company.layouts.dashmaster')
@section('title', 'Applicants')
@section('applicants', 'active')
@section('data')
    <style>
        .table-responsive>.table-bordered {
            border: 1px solid #e8ebf3;
            ;
        }

        a.advancedSearch:hover{
            color: white !important;
        }

    </style>
    <?php
    use App\Enum\JobApplicationStatus;
    ?>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ __('Application Management') }}</h3>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="row row-cards">
                @foreach ($application_datas as $a_data)
                    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-2">
                        <a href="{{ $a_data['link'] }}">
                            <div class="card {{ $a_data['bg-color'] }} text-white">
                                <div class="card-body p-4 text-center feature">
                                    <p class="card-text mt-3 mb-3">{{ __($a_data['title']) }}</p>
                                    <p class="h2 text-center">{{ $a_data['totalcount'] ?? 0 }}</p>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
            <div class="text-white">
                <div class="card-header bg-primary">
                    <div class="row w-100">
                        <div class="col-md-6">
                            <h6 class="card-title">Shortlisted Applicants</h6>
                        </div>
                        <div class="col-md-6">
                            <a href="javascript:void(0);" class="float-right text-white">View All</a>
                        </div>
                    </div>
                </div>
            </div>
            <form action="{{ route('company.applicant.indexpage') }}" method="GET">
                <div class="search-section mx-auto mt-5 text-center">
                    <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-md-6">
                            <div class="input-group input-icons mb-3">
                                <i class="fa fa-search-icon"></i>
                                <input type="text" name="q" value="{{ request()->q }}" class="form-control"
                                    placeholder="{{ __('Search Applicants') }}" aria-label="Search Applicants"
                                    aria-describedby="button-addon2">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-primary rounded-0">{{ __('Search') }}</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <a href="#" class="btn btn-outline-primary rounded-0 advancedSearch text-dark">Advanced Search</a>
                        </div>
                    </div>

                    {{-- <div class="d-inline-flex">
                        <div class="form-group">
                            <input type="text" name="q" value="{{ request()->q }}" class="form-control"
                                placeholder="{{ __('Search Applicants') }}">
                        </div>
                        <div class="ml-3">
                            <button type="submit" class="btn btn-primary rounded-0">{{ __('Search') }}</button>
                        </div>
                    </div> --}}
                </div>
                {{-- <div class="applicant-per-page-section mt-5">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-7 my-auto">
                                        <label for="">Applicant Per Page</label>
                                    </div>
                                    <div class="col-md-5">
                                        <select name="limit" class="form-control rounded-0 bg-gray text-white"
                                            onchange="this.form.submit();">
                                            <option value="All" {{ !(request('limit') == 'All') ?: 'selected' }}>All
                                            </option>
                                            <option value="10"
                                                {{ !(request('limit') == '10' || request('limit') == '') ?: 'selected' }}>
                                                10</option>
                                            <option value="50" {{ !(request('limit') == '50') ?: 'selected' }}>50
                                            </option>
                                            <option value="100" {{ !(request('limit') == '100') ?: 'selected' }}>100
                                            </option>
                                            <option value="250" {{ !(request('limit') == '250') ?: 'selected' }}>250
                                            </option>
                                            <option value="500" {{ !(request('limit') == '500') ?: 'selected' }}>500
                                            </option>
                                            <option value="1000" {{ !(request('limit') == '1000') ?: 'selected' }}>1000
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mt-1">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="checkAll"> Select All Applicants On This
                                Page
                            </div>
                        </div>
                        <div class="col-md-4 mt-1">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input"> Select All Applicants On This Job
                            </div>
                        </div>
                    </div>
                </div> --}}
            </form>
            <div class="status-section mt-5">
                <div class="row">
                    <div class="col-md-3">
                        <a href="javascript:void(0);"
                            class="btn btn-primary rounded-0 w-90">{{ __('Set Application Status') }}</a>
                    </div>
                    <div class="col-md-9">
                        <a href="javascript:void(0)"
                            onclick="updateBulkApplicantStatus('{{ ApplicantStatus::PENDING }}');"
                            class="btn btn-outline-secondary rounded-0 text-dark bg-white">Unscreened</a>
                        <a href="javascript:void(0)"
                            onclick="updateBulkApplicantStatus('{{ ApplicantStatus::SHORTLISTED }}');"
                            class="btn btn-outline-secondary rounded-0 text-dark bg-white ml-2">Shortlisted</a>
                        <a href="javascript:void(0)"
                            onclick="updateBulkApplicantStatus('{{ ApplicantStatus::INTERVIEWED }}');"
                            class="btn btn-outline-secondary rounded-0 text-dark bg-white ml-2">Interviewed</a>
                        <a href="javascript:void(0)"
                            onclick="updateBulkApplicantStatus('{{ ApplicantStatus::SELECTEDFORINTERVIEW }}');"
                            class="btn btn-outline-secondary rounded-0 text-dark bg-white ml-2">Selected</a>
                        <a href="javascript:void(0)"
                            onclick="updateBulkApplicantStatus('{{ ApplicantStatus::REJECTED }}');"
                            class="btn btn-outline-secondary rounded-0 text-dark bg-white ml-2">Rejected</a>
                    </div>
                </div>
            </div>
            <div class="action-section mt-2">
                <div class="row">
                    <div class="col-md-3">
                        <a href="javascript:void(0);" class="btn btn-primary rounded-0 w-90">{{ __('Action') }}</a>
                    </div>
                    <div class="col-md-9">
                        <a href="javascript:void(0)" class="btn btn-outline-secondary rounded-0 text-dark bg-white">Schedule
                            Interview</a>
                        <a href="javascript:void(0)"
                            class="btn btn-outline-secondary rounded-0 text-dark bg-white ml-2">Send Email</a>
                        <a href="javascript:void(0)"
                            class="btn btn-outline-secondary rounded-0 text-dark bg-white ml-2">Send Message</a>
                        <a href="javascript:void(0)" onclick="bulkApplicationDelete();"
                            class="btn btn-outline-secondary rounded-0 text-dark bg-white ml-2">Delete</a>
                        <a href="javascript:void(0)" onclick="bulkCvDownload();"
                            class="btn btn-outline-secondary rounded-0 text-dark bg-white ml-2">Download
                            CV</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="applicant-section">
        <div class="row">
            <div class="col-md-3">
                <div class="form-inline">
                    <label for="">Applicant Per Page</label>
                    <select name="limit" class="form-control rounded-0 bg-gray text-white" onchange="this.form.submit();">
                        <option value="All" {{ !(request('limit') == 'All') ?: 'selected' }}>All
                        </option>
                        <option value="10" {{ !(request('limit') == '10' || request('limit') == '') ?: 'selected' }}>
                            10</option>
                        <option value="50" {{ !(request('limit') == '50') ?: 'selected' }}>50
                        </option>
                        <option value="100" {{ !(request('limit') == '100') ?: 'selected' }}>100
                        </option>
                        <option value="250" {{ !(request('limit') == '250') ?: 'selected' }}>250
                        </option>
                        <option value="500" {{ !(request('limit') == '500') ?: 'selected' }}>500
                        </option>
                        <option value="1000" {{ !(request('limit') == '1000') ?: 'selected' }}>1000
                        </option>
                    </select>
                </div>
            </div>
            <div class="col-md-4 my-auto">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="checkAll">
                    <label for="" class="my-auto">Select All Applicants On This Page</label>
                </div>
            </div>
            <div class="col-md-4 my-auto">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input">
                    <label for="" class="my-auto">Select All {{ $totalApplicant }} Applicants On This Job</label>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th></th>
                            <th>S.N</th>
                            <th>Name</th>
                            <th>Job Title</th>
                            <th>Category</th>
                            <th>Applied Date</th>
                            <th>Country</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Profile Score</th>
                            <th>Experience</th>
                            <th>Education</th>
                            <th>Training</th>
                            <th>Language</th>
                            <th>Skill</th>
                            <th>Preferred Country</th>
                            <th>Preferred Job</th>
                            <th>Status</th>
                            {{-- <th>Applied Jobs</th> --}}
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($applicants as $applicant)
                            <tr data-id="{{ $applicant->id }}">
                                <td>
                                    <input type="checkbox" class="form-check rowCheck" name="applicationID[]"
                                        value="{{ $applicant->id }}" data-id="{{ $applicant->id }}">
                                </td>
                                <td>{{ $sn++ }}</td>
                                <td>{{ !blank(data_get($applicant, 'employe')) ? data_get($applicant, 'employe.full_name') : '' }}
                                </td>
                                <td>{{ !blank(data_get($applicant, 'job')) ? data_get($applicant, 'job.title') : '' }}
                                </td>
                                <td>{{ !blank(data_get($applicant, 'job.job_category')) ? data_get($applicant, 'job.job_category.functional_area') : '' }}
                                </td>
                                <td>{{ getFormattedDate($applicant->created_at, 'M j, Y') }}</td>
                                <td>{{ (!blank(data_get($applicant, 'employe')) and !blank(data_get($applicant, 'employe.country'))) ? data_get($applicant, 'employe.country.name') : '' }}
                                </td>
                                <td>{{ (!blank(data_get($applicant, 'employe')) and !blank(data_get($applicant, 'employe.user'))) ? data_get($applicant, 'employe.user.email') : '' }}
                                </td>
                                <td>{{ !blank(data_get($applicant, 'employe.mobile_phone')) ? data_get($applicant, 'employe.mobile_phone') : (!blank(data_get($applicant, 'employe.mobile_phone2')) ? data_get($applicant, 'employe.mobile_phone2') : '') }}
                                </td>
                                <td>{{ !blank(data_get($applicant, 'employe')) ? $applicant->employe->calculateProfileCompletion() . '%' : '' }}
                                </td>
                                <td>
                                    @if (!blank(data_get($applicant, 'employe')) and !blank(data_get($applicant, 'employe.experience')))
                                        @foreach (data_get($applicant, 'employe.experience') as $eexperience)
                                            @if ($loop->first)
                                                {{ !blank(data_get($eexperience, 'job_category')) ? data_get($eexperience, 'job_category.functional_area') . ',' : '' }}&nbsp;{{ $eexperience->working_year != null ? $eexperience->working_year . ' ' . getYearForm($eexperience->working_year) : '' }}&nbsp;{{ $eexperience->working_month != null ? $eexperience->working_month . ' ' . getMonthForm($eexperience->working_month) : '' }}
                                            @endif
                                        @break
                                    @endforeach
                                @endif
                            </td>
                            <td>{{ !blank(data_get($applicant, 'employe.education_level')) ? data_get($applicant, 'employe.education_level.title') : '' }}
                            </td>
                            <td>
                                @if (!blank(data_get($applicant, 'employe')) and !blank(data_get($applicant, 'employe.employeeTrainings')))
                                    @foreach (data_get($applicant, 'employe.employeeTrainings') as $eetraining)
                                        @if ($loop->first)
                                            {{ !blank(data_get($eetraining, 'training')) ? data_get($eetraining, 'training.title') : '' }}
                                        @endif
                                    @break
                                @endforeach
                            @endif
                        </td>
                        <td>
                            @if (!blank(data_get($applicant, 'employe')) and !blank(data_get($applicant, 'employe.employeeLanguage')))
                                @foreach (data_get($applicant, 'employe.employeeLanguage') as $elanguage)
                                    @if ($loop->first)
                                        {{ !blank(data_get($elanguage, 'language')) ? data_get($elanguage, 'language.lang') : '' }}
                                        {{ $elanguage->language_level != null ? '(' . $elanguage->language_level . ')' : '' }}
                                    @endif
                                @break
                            @endforeach
                        @endif
                    </td>
                    <td>
                        @if (!blank(data_get($applicant, 'employe')) and !blank(data_get($applicant, 'employe.employeeSkills')))
                            @foreach (data_get($applicant, 'employe.employeeSkills') as $eskill)
                                @if ($loop->first)
                                    {{ !blank(data_get($eskill, 'skill')) ? data_get($eskill, 'skill.title') : '' }}
                                @endif
                            @break
                        @endforeach
                    @endif
                </td>
                <td>
                    @if (!blank(data_get($applicant, 'employe')) and !blank(data_get($applicant, 'employe.countryPreference')))
                        @foreach (data_get($applicant, 'employe.countryPreference') as $countryPreference)
                            @if ($loop->first)
                                {{ !blank(data_get($countryPreference, 'name')) ? data_get($countryPreference, 'name') : '' }}
                            @endif
                        @break
                    @endforeach
                @endif
            </td>
            <td>
                @if (!blank(data_get($applicant, 'employe')) and !blank(data_get($applicant, 'employe.jobCategoryPreference')))
                    @foreach (data_get($applicant, 'employe.jobCategoryPreference') as $jobCategoryPreference)
                        @if ($loop->first)
                            {{ !blank(data_get($jobCategoryPreference, 'functional_area')) ? data_get($jobCategoryPreference, 'functional_area') : '' }}
                        @endif
                    @break
                @endforeach
            @endif
        </td>
        <td class="applicantStatus">{{ ucfirst($applicant->status) }}</td>
        {{-- <td>{{ !blank(data_get($applicant, 'employe')) ? $applicant->employe->job_applications->count() : '' }}</td> --}}
        <td>
            <a href="{{ route('company.applicant.editApplication', $applicant->id) }}"
                class="text-primary my-auto"><i class="fa fa-edit"></i></a>
            <a href="{{ route('company.applicant.detail', $applicant->employ_id) }}"
                class="text-primary my-auto"><i class="fa fa-eye"></i></a>
        </td>
    </tr>
@endforeach
</tbody>
</table>
<div class="d-flex justify-content-center mt-3">
{{ $applicants->links('vendor.pagination.bootstrap-4') }}
</div>
</div>
</div>
</div>
@endsection

@section('js')
<script>
    $("#checkAll").click(function() {
        $(".rowCheck").prop('checked', $(this).prop('checked'));
    });

    $(".rowCheck").click(function() {
        $("#checkAll").prop('checked', false);
    });

    function updateBulkApplicantStatus(applicantStatus) {
        var allIds = [];
        $(".rowCheck:checked").each(function() {
            allIds.push($(this).val());
        });
        if (allIds.length <= 0) {
            Swal.fire({
                title: 'Oops..',
                text: 'Please Select Row',
                icon: 'error'
            });
        } else {
            Swal.fire({
                text: 'Are you sure you want to perform bulk operation?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: "Yes",
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
            }).then((result) => {
                if (result.isConfirmed) {
                    var joinCheckedValues = allIds.join(",");
                    $.ajax({
                        url: "{{ route('company.applicant.bulkUpdateApplicationStatus') }}",
                        type: "POST",
                        data: {
                            "ids": joinCheckedValues,
                            "applicantStatus": applicantStatus,
                            _method: "PUT",
                        },
                        beforeSend: function() {
                            busySign();
                        },
                        success: function(response) {
                            if (response.success == false) {
                                if (response.db_error) {
                                    toastr.error(response.db_error);
                                } else if (response.error) {
                                    toastr.error(response.error);
                                }
                            }
                            if (response.success == true) {
                                var statuses = JSON.parse(response.statuses);
                                $.each(statuses, function(k, v) {
                                    $.each(v, function(key, value) {
                                        var tableRow = $('tr[data-id="' + key +
                                            '"]');
                                        $(tableRow).find(".applicantStatus").text(
                                            value);
                                    });
                                });
                                toastr.success(response.msg);
                                $('input:checkbox').prop('checked', false);
                            }
                        },
                        complete: function() {
                            hideBusySign();
                        }
                    });
                }
            });
            // var check = confirm("Are you sure you want to perform bulk operation?");
            // if (check == true) {

            // }
        }
    }


    function bulkCvDownload() {
        var allIds = [];
        $(".rowCheck:checked").each(function() {
            allIds.push($(this).val());
        });
        if (allIds.length <= 0) {
            Swal.fire({
                title: 'Oops..',
                text: 'Please Select Row',
                icon: 'error'
            });
        } else {
            Swal.fire({
                text: 'Are you sure you want to perform bulk download?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: "Yes Download!",
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
            }).then((result) => {
                if (result.isConfirmed) {
                    var joinCheckedValues = allIds.join(",");
                    $.ajax({
                        url: "{{ route('company.applicant.bulkCvDownload') }}",
                        type: "GET",
                        data: {
                            "ids": joinCheckedValues
                        },
                        xhrFields: {
                            responseType: 'blob',
                        },
                        beforeSend: function() {
                            busySign();
                        },
                        success: function(data) {
                            if (data.success == false) {
                                if (data.error) {
                                    toastr.error(data.error);
                                }
                            }
                            var blob = new Blob([data], {
                                type: 'application/pdf'
                            });
                            var link = document.createElement('a');
                            link.href = window.URL.createObjectURL(blob);
                            link.download = "Applicants.pdf";
                            link.click();
                            toastr.success('Applicants CV Downloaded');
                            $('input:checkbox').prop('checked', false);
                        },
                        complete: function() {
                            hideBusySign();
                        }
                    });
                }
            });
            // var check = confirm("Are you sure you want to perform bulk download?");
            // if (check == true) {

            // }
        }
    }

    function bulkApplicationDelete() {
        var allIds = [];
        $(".rowCheck:checked").each(function() {
            allIds.push($(this).val());
        });
        if (allIds.length <= 0) {
            Swal.fire({
                title: 'Oops..',
                text: 'Please Select Row',
                icon: 'error'
            });
        } else {
            Swal.fire({
                text: 'Are you sure you want to perform bulk delete?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: "Yes Delete!",
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
            }).then((result) => {
                if (result.isConfirmed) {
                    var joinCheckedValues = allIds.join(",");
                    $.ajax({
                        url: "{{ route('company.applicant.bulkApplicationDelete') }}",
                        type: "POST",
                        data: {
                            "ids": joinCheckedValues,
                            _method: 'DELETE'
                        },
                        beforeSend: function() {
                            busySign();
                        },
                        success: function(data) {
                            if (data.success == false) {
                                if (data.error) {
                                    toastr.error(data.error);
                                }
                            }
                            $(".rowCheck:checked").each(function() {
                                $(this).parents("tr").remove();
                            });
                            toastr.success(data.msg);
                            $('input:checkbox').prop('checked', false);
                        },
                        complete: function() {
                            hideBusySign();
                        }
                    });
                }
            });
            // var check = confirm("Are you sure you want to perform bulk delete?");
            // if (check == true) {

            // }
        }
    }
</script>
@endsection
