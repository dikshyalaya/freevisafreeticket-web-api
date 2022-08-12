@extends('themes.fvft.company.layouts.dashmaster')
@section('title', 'Applicants')
@section('applicants', 'active')
@section('data')
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
    use App\Enum\JobApplicationStatus;
    ?>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ __('Application Management') }}</h3>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            {{-- <th></th> --}}
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
                                {{-- <td>
                                    <input type="checkbox" class="form-check rowCheck" name="applicationID[]"
                                        value="{{ $applicant->id }}" data-id="{{ $applicant->id }}">
                                </td> --}}
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
            {{-- <a href="{{ route('company.applicant.editApplication', $applicant->id) }}"
                class="text-primary my-auto"><i class="fa fa-edit"></i></a> --}}
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

@endsection
