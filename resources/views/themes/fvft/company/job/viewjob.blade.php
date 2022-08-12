@extends('themes.fvft.company.layouts.dashmaster')
@section('css')
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
<div class="card m-b-20">
    <div class="card-header">
        <div class="col-md-6">
            <h3 class="card-title">View Job</h3>
        </div>
        <div class="col-md-6">
                <a href="{{ route('company.editjob', $job->id) }}" class="btn btn-success mr-auto">Edit Job</a>
        </div>
    </div>
</div>
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
                                <label for="title" class="form-label">Job Title</label>
                            </div>
                            <div class="col-md-8">
                                {{ $job->title }}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="company" class="form-label">Company Name</label>
                            </div>
                            <div class="col-md-8">
                                {{ $job->company != null && isset($job->company) ? $job->company->company_name : '' }}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="no_of_employee" class="form-label">No of Employee</label>
                            </div>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="male_employee" class="form-label">Male</label>
                                        <input type="text" class="form-control" value="{{ $job->no_of_male }}"
                                            readonly>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="female_employee" class="form-label">Female</label>
                                        <input type="text" class="form-control" value="{{ $job->no_of_female }}"
                                            readonly>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="any_employee" class="form-label">Any</label>
                                        <input type="text" class="form-control" value="{{ $job->any_gender }}"
                                            readonly>
                                    </div>
                                </div>
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
                                @php
                                    $category = DB::table('job_categories')->where('id', $job->job_categories_id);
                                    //    dd($category->exists());
                                    $category_name = $category != null && $category->exists() ? $category->first()->functional_area : '';
                                @endphp
                                {{ $category_name }}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="working_hours" class="form-label">Working Hours Per Day</label>
                            </div>
                            <div class="col-md-8">
                                <div class="input-group">
                                    {{ $job->working_hours }}
                                    {{ $job->working_hours != null ? 'hrs/day' : 'Not Available' }}
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="working_days" class="form-label">Working Days Per Week</label>
                            </div>
                            <div class="col-md-8">
                                {{ $job->working_days }}
                                {{ $job->working_days != null ? 'days/week' : 'Not Available' }}
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="deadline" class="form-label">Apply Before</label>
                            </div>
                            <div class="col-md-8">
                                {{ date('Y-m-d', strtotime($job->expiry_date)) }}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <label class="form-label" for="status">Status</label>
                            </div>
                            <div class="col-md-8">
                                {{ $job->status }}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <label class="form-label">Country</label>
                            </div>
                            <div class="col-md-8">
                                @php
                                    $country = DB::table('countries')->where('id', $job->country_id);
                                    $country_name = $country != null && $country->exists() ? $country->first()->name : '';
                                    $country_code = $country != null && $country->exists() ? $country->first()->currency_name : 'NPR';
                                @endphp
                                {{ $country_name }}
                            </div>
                        </div>

                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <label class="form-label">States</label>
                            </div>
                            <div class="col-md-8">
                                @php
                                    $state = DB::table('states')->where('id', $job->state_id);
                                    $stateName = $state != null && $state->exists() ? $state->first()->name : '';
                                @endphp
                                {{ $stateName }}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <label class="form-label">Cities</label>
                            </div>
                            <div class="col-md-8">
                                @php
                                    $city = DB::table('cities')->where('id', $job->city_id);
                                    $cityName = $city != null && $city->exists() ? $city->first()->name : '';
                                @endphp
                                {{ $cityName }}
                            </div>
                        </div>

                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="contract" class="form-label">Contract Period</label>
                            </div>
                            <div class="col-md-8">
                                @php
                                    $contract_year = $job->contract_year != null && $job->contact_year > 1 ? 'years' : ($job->contract_year == null ? '' : 'year');
                                    $contract_month = $job->contract_month != null && $job->contract_month > 1 ? 'months' : ($job->contract_month == null ? '' : 'month');
                                @endphp
                                {{ $job->contract_year }} {{ $contract_year }} &nbsp;
                                {{ $job->contract_month }} {{ $contract_month }}
                            </div>

                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="job_description" class="form-label">Job Description</label>
                            </div>
                            <div class="col-md-8">
                                <textarea style="width: 100%;">{!! html_entity_decode($job->description_intro) !!}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="custom-switch-checkbox">
                            <input type="checkbox" name="is_active" class="custom-switch-input"
                                {{ $job->is_active == 1 ? 'checked' : '' }}>
                            <span class="custom-switch-indicator"></span>
                            <span class="custom-switch-description">Active</span>
                        </label>
                        <label class="custom-switch-checkbox">
                            <input type="checkbox" name="is_featured" class="custom-switch-input"
                                {{ $job->is_featured == 1 ? 'checked' : '' }}>
                            <span class="custom-switch-indicator"></span>
                            <span class="custom-switch-description">Featured</span>
                        </label>
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
                                <label for="salary" class="form-label">Salary</label>
                            </div>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <input type="text" value="{{ $job->country_salary }}"
                                                    class="form-control">
                                            </div>
                                            <div class="col-md-4">

                                                <label for="" class="form-label countrylabel">{{ $country_code }}</label>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md-8">
                                                <input type="text" value="{{ $job->nepali_salary }}"
                                                    class="form-control">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="" class="form-label">NPR</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mt-2">
                                    <label class="custom-switch-checkbox">
                                        <input type="checkbox" name="hide_salary" class="custom-switch-input"
                                            {{ $job->hide_salary == 1 ? 'checked' : '' }}>
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
                                <label for="accomodation" class="form-label">Accommodation</label>
                            </div>
                            <div class="col-md-8">
                                {{ $job->accomodation == 1 ? 'Yes' : 'No' }}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="food" class="form-label">Food</label>
                            </div>
                            <div class="col-md-8">
                                {{ $job->food == 1 ? 'Yes' : 'No' }}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="annual_vacation" class="form-label">Annual Vacation</label>
                            </div>
                            <div class="col-md-8">
                                {{ $job->annual_vacation == 1 ? 'Yes' : 'No' }}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="over_time" class="form-label">Over Time</label>
                            </div>
                            <div class="col-md-8">
                                {{ $job->over_time == 1 ? 'Yes' : 'No' }}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="requirements" class="form-label">Other Benefits</label>
                            </div>
                            <div class="col-md-8">
                                <textarea style="width: 100%">{!! $job->benefit_intro !!}</textarea>
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
                                <label for="education_level" class="form-label">Minimum Qualification</label>
                            </div>
                            <div class="col-md-8">
                                @php
                                    $educationlevel = DB::table('educationlevels')->where('id', $job->education_level_id);
                                    $levelName = $educationlevel != null && $educationlevel->exists() ? $educationlevel->first()->title : '';
                                @endphp
                                {{ $levelName }}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="year_of_experience" class="form-label">Year of Experience</label>
                            </div>
                            <div class="col-md-8">
                                @php
                                    $min_experience = $job->min_experience != null && $job->min_experience > 1 ? 'years' : ($job->min_experience == null ? '' : 'year');
                                    $max_experience = $job->max_experience != null && $job->max_experience > 1 ? 'years' : ($job->max_experience == null ? '' : 'years');
                                @endphp
                                {{ $job->min_experience }} {{ $min_experience }}
                                {{ $job->min_experience != null && $job->max_experience != null ? '-' : '' }}
                                {{ $job->max_experience }} {{ $max_experience }}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="age_requirement" class="form-label">Age Requirement</label>
                            </div>
                            <div class="col-md-8">
                                @php
                                    $min_age = $job->min_age != null && $job->min_age > 1 ? 'years' : ($job->min_age == null ? '' : 'year');
                                    $max_age = $job->max_age != null && $job->max_age > 1 ? 'years' : ($job->max_age == null ? '' : 'years');
                                @endphp
                                {{ $job->min_age }} {{ $min_age }}
                                {{ $job->min_age != null && $job->max_age != null ? '-' : '' }}
                                {{ $job->max_age }}
                                {{ $max_age }}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="skils" class="form-label">Skills</label>
                            </div>
                            <div class="col-md-8">
                                @php
                                    $skills = DB::table('skills')
                                        ->whereIn('id', (array) json_decode($job->skills, true))
                                        ->pluck('title');
                                    foreach ($skills as $key => $skill) {
                                        echo '<span class="badge badge-success">' . $skill . '</span>&nbsp;';
                                    }
                                @endphp

                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="requirements" class="form-label">Other Requirements</label>
                            </div>
                            <div class="col-md-8">
                                <textarea style="width: 100%">{!! html_entity_decode($job->requirement_intro) !!}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if ($job->feature_image_url != null && file_exists($job->feature_image_url))
            <div class="row ml-2">
                <div class="card m-b-20">
                    <div class="card-header">
                        <h3 class="card-title tempcolor">{{ strtoupper('Picture') }}</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="" class="form-label">Feature Image</label>
                                </div>
                                <div class="col-md-8">
                                    <img src="{{ asset($job->feature_image_url) }}" style="width: 100px;" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
@section('script')

@endsection
