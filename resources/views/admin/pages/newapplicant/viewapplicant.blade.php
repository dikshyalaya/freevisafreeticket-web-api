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
    use App\Enum\JobApplicationStatus;
    ?>
    <div class="page-header">
        <h4 class="page-title">Application Details</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Modules</a></li>
            <li class="breadcrumb-item" aria-current="page"><a href="/admin/applicants/">Applicants</a></li>
        </ol>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="applicantDetailSection">
                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="applicantName">Full Name:</label>
                            </div>
                            <div class="col-md-8">
                                {{ (!blank($applicant, 'employ') and !blank($applicant, 'employe.full_name')) ? data_get($applicant, 'employe.full_name') : '' }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <label for="applicantName">Email:</label>
                            </div>
                            <div class="col-md-8">
                                {{ (!blank($applicant, 'employ') and !blank($applicant, 'employe.user') and !blank($applicant, 'employe.user.email')) ? data_get($applicant, 'employe.user.email') : '' }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <label for="applicantName">Phone:</label>
                            </div>
                            <div class="col-md-8">
                                {{ (!blank($applicant, 'employ') and !blank($applicant, 'employe.mobile_phone')) ? data_get($applicant, 'employe.mobile_phone') : data_get($applicant, 'employe.mobile_phone2') }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <label for="applicantName">Gender:</label>
                            </div>
                            <div class="col-md-8">
                                {{ (!blank($applicant, 'employ') and !blank($applicant, 'employe.gender')) ? data_get($applicant, 'employe.gender') : '' }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <label for="applicantName">Marital Status:</label>
                            </div>
                            <div class="col-md-8">
                                {{ (!blank($applicant, 'employ') and !blank($applicant, 'employe.marital_status')) ? data_get($applicant, 'employe.marital_status') : '' }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <label for="applicantName">Date Of Birth:</label>
                            </div>
                            <div class="col-md-8">
                                {{ (!blank($applicant, 'employ') and !blank($applicant, 'employe.dob')) ? getFormattedDate(data_get($applicant, 'employe.dob'), 'Y-m-d') : '' }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <label for="applicantName">Education:</label>
                            </div>
                            <div class="col-md-8">
                                {{ (!blank($applicant, 'employ') and !blank($applicant, 'employe.education_level') and !blank($applicant, 'employe.education_level.title')) ? data_get($applicant, 'employe.education_level.title') : '' }}
                            </div>
                        </div>
                        @if ((!blank($applicant, 'employe') and !blank($applicant, 'employe.experience')))
                            <div class="experience_div mt-5">
                                <h4>{{ strtoupper('Experience') }}</h4>

                                <div class="mt-5 experience_detail">
                                    @foreach (data_get($applicant, 'employe.experience') as $employ_experience)
                                        <p>{{ $loop->iteration }}.&nbsp;<span>{{ $employ_experience->industry != null ? $employ_experience->industry->title : '' }},
                                                {{ $employ_experience->working_year != null ? $employ_experience->working_year . ' ' . getYearForm($employ_experience->working_year) : '' }}
                                                {{ $employ_experience->working_month != null ? $employ_experience->working_month . ' ' . getMonthForm($employ_experience->working_month) : '' }}
                                                {{ $employ_experience->job_category != null ? $employ_experience->job_category->functional_area : '' }},
                                                {{ $employ_experience->country != null ? $employ_experience->country->name : '' }}</span>
                                        </p>
                                    @endforeach
                                </div>

                            </div>
                        @endif
                        @if ((!blank($applicant, 'employe') AND !blank($applicant, 'employe.employeeTrainings')))
                            <div class="training_div mt-5">
                                <h4>{{ strtoupper('Training') }}</h4>
                                <div class="mt-3 training_detail">
                                    @foreach (data_get($applicant, 'employe.employeeTrainings') as $etraining)
                                        <p>{{ $loop->iteration }}.&nbsp;<span>{{ $etraining->training != null ? $etraining->training->title : '' }}</span>
                                        </p>
                                    @endforeach

                                </div>
                            </div>
                        @endif
                        @if ((!blank($applicant, 'employe') AND !blank($applicant, 'employe.employeeSkills')))
                            <div class="skill_div mt-5">
                                <h4>{{ strtoupper('Skills') }}</h4>
                                <div class="mt-3 skill_detail">
                                    @foreach (data_get($applicant, 'employe.employeeSkills') as $eskill)
                                        <p>{{ $loop->iteration }}.&nbsp;<span>{{ $eskill->skill != null ? $eskill->skill->title : '' }}</span>
                                        </p>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        @if ((!blank($applicant, 'employe') AND !blank($applicant, 'employe.employeeLanguage')))
                            <div class="language_div mt-5">
                                <h4>{{ strtoupper('Language') }}</h4>
                                <div class="mt-3 language_detail">
                                    @foreach (data_get($applicant, 'employe.employeeLanguage') as $elanguage)
                                        <p>{{ $loop->iteration }}.&nbsp;{{ $elanguage->language != null ? $elanguage->language->lang : '' }}:&nbsp;<span>{{ $elanguage->language_level }}</span>
                                        </p>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
@endsection
