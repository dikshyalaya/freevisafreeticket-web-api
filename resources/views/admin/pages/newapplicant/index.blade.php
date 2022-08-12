@extends('admin.layouts.master')
@section('main')
    <style>
        .table-responsive>.table-bordered {
            border: 1px solid #e8ebf3;
            ;
        }

        a.advancedSearch:hover {
            color: white !important;
        }

    </style>
    <?php
    use App\Enum\ApplicantStatus;
    ?>
    <div class="page-header">
        <h4 class="page-title">Application Management</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Modules</a></li>
            <li class="breadcrumb-item" aria-current="page"><a href="/admin/applicants/">Applicants</a></li>
        </ol>
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
                            <h6 class="card-title">All Applicants</h6>
                        </div>
                        <div class="col-md-6">
                            <a href="" class="float-right text-white">View All</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="search-section mx-auto mt-5 text-center">
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-6">
                        <form action="{{ route('admin.applicant.indexpage') }}" method="GET">
                            <div class="input-group input-icons mb-3">
                                <i class="fa fa-search-icon"></i>
                                <input type="text" name="q" value="{{ request()->q }}" class="form-control"
                                    placeholder="{{ __('Search Applicants') }}" aria-label="Search Applicants"
                                    aria-describedby="button-addon2">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-primary rounded-0">{{ __('Search') }}</button>
                                </div>
                            </div>
                            <input type="hidden" name="limit" value="{{ request()->limit }}" class="form-control">
                        </form>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ route('admin.applicant.advancedSearch') }}"
                            class="btn btn-outline-primary rounded-0 advancedSearch text-dark">Advanced
                            Search</a>
                    </div>
                </div>
            </div>
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
                            onclick="updateBulkApplicantStatus('{{ ApplicantStatus::ACCEPTED }}');"
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
                        <a href="javascript:void(0)" data-toggle="modal" data-target="#interviewModal"
                            class="btn btn-outline-secondary rounded-0 text-dark bg-white" id="scheduleInterview">Schedule
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
        <form action="{{ route('admin.applicant.indexpage') }}" id="searchForm">
            <input type="hidden" class="form-control" id="SearchInput">
            @if(request()->limit)
            <input type="hidden" class="form-control" name="limit" value="{{ request('limit') }}">
            @endif
        </form>
        <div class="row">
            <div class="col-md-4">
                <select name="jobTitle" class="form-control select2-show-search" id="JobTitle">
                    <option value="All Job Titles">All Job Titles</option>
                    @foreach ($job_categories as $job_category)
                        <option value="{{ $job_category->id }}"
                            {{ request()->jobTitle == $job_category->id ? 'selected' : '' }}>
                            {{ $job_category->functional_area }}
                        </option>
                    @endforeach
                </select>

            </div>
            <div class="col-md-4">
                <select name="countries" class="form-control select2-show-search" id="Countries">
                    <option value="All Countries">All Countries</option>
                    @foreach ($countries as $country)
                        <option value="{{ $country->id }}"
                            {{ request()->countries == $country->id ? 'selected' : '' }}>
                            {{ $country->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <select name="companies" class="form-control select2-show-search" id="Companies">
                    <option value="All Companies">All Companies</option>
                    @foreach ($companies as $company)
                        <option value="{{ $company->id }}"
                            {{ request()->companies == $company->id ? 'selected' : '' }}>
                            {{ $company->company_name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-4">
                <form action="{{ route('admin.applicant.indexpage') }}" method="GET">
                    <input type="hidden" name="q" value="{{ request()->q }}" class="form-control">
                    @if (!blank(request()->jobTitle))
                        <input type="hidden" name="jobTitle" class="form-control" value="{{ request()->jobTitle }}">
                    @endif
                    @if (!blank(request()->countries))
                        <input type="hidden" name="countries" class="form-control" value="{{ request()->countries }}">
                    @endif
                    @if (!blank(request()->companies))
                        <input type="hidden" name="companies" class="form-control" value="{{ request()->companies }}">
                    @endif
                    <div class="form-inline">
                        <label for="">Applicant Per Page</label>
                        <select name="limit" class="form-control rounded-0 bg-gray text-white w-50"
                            onchange="this.form.submit();">
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
                </form>
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
        <td>
            <a href="{{ route('admin.applicants.edit', $applicant->id) }}"
                class="text-primary my-auto"><i class="fa fa-edit"></i></a>
            <a href="{{ route('admin.applicant.viewApplicant', $applicant->id) }}"
                class="text-primary my-auto"><i class="fa fa-eye"></i></a>
            <a href="{{ route('company.applicant.detail', $applicant->employ_id) }}" data-id="{{ $applicant->id }}" data-action="{{ route('admin.applicants.delete', $applicant->id) }}" data-method="{{ getRouteMethodName('admin.applicants.delete') }}" data-modaltitle="Delete Applicant" data-toggle="modal" data-target="#dataDeleteModal"
                class="text-danger my-auto"><i class="fa fa-trash-o"></i></a>
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
{{-- Modal Section --}}
{{-- Interview Modal --}}
@include('themes/fvft/company/newapplicant/interviewModal')
{{-- End Interview Modal --}}
{{-- End Modal Section --}}
@endsection
@section('script')
@include('themes/fvft/company/newapplicant/script')
<script>
    $("#JobTitle").on('change', function() {
        $("#SearchInput").attr('name', 'jobTitle').val($("#JobTitle").val());
        $("#searchForm").submit();
    });
    $("#Countries").on('change', function() {
        $("#SearchInput").attr('name', 'countries').val($("#Countries").val());
        $("#searchForm").submit();
    });
    $("#Companies").on('change', function() {
        $("#SearchInput").attr('name', 'companies').val($("#Companies").val());
        $("#searchForm").submit();
    });
</script>
@endsection
