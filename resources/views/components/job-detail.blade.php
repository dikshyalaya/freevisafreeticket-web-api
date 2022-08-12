<div class="row">
        <!--Jobs Description-->
        <div class="card overflow-hidden">
            <div class="card-body h-100">
                <div class="row">
                    <div class="col">
                        <div class="profile-pic mb-0">
                            <div class="d-md-flex">
                                <img src="{{ asset('/') }}{{ (!blank($job, 'company') and !blank(data_get($job, 'company.company_logo'))) ? data_get($job, 'company.company_logo') : ($job->feature_image_url != null ? $job->feature_image_url : 'images/defaultimage.jpg') }}"
                                    class="w-20 h-20" alt="user">
                                <div class="ml-4">
                                    <a href="{{ route('viewJob', $job->id) }}" class="text-dark">
                                        <h4 class="mt-3 mb-1 fs-20 font-weight-bold">
                                            {{ $job->title ?? 'Not-Available' }}</h4>
                                    </a>
                                    <div class="">
                                        @if (!blank(data_get($job, 'company')))
                                            <ul class="mb-0 d-flex">
                                                <li class="mr-3">
                                                    <a href="{{ route('site.companydetail', data_get($job, 'company.id')) }}"
                                                        target="_blank" class="icons">
                                                        <i class="fa fa-building-o text-muted mr-1"></i>
                                                        {{ !blank(data_get($job, 'company.company_name')) ? data_get($job, 'company.company_name') : 'Not-Available' }}
                                                    </a>
                                                </li>
                                            </ul>
                                        @endif
                                        <ul class="mb-0 mt-2 d-flex">
                                            <li class="mr-3">
                                                <a href="#" class="icons">
                                                    @if (!blank(data_get($job, 'country')))
                                                        <img src="{{ asset('https://flagcdn.com/16x12/' . strtolower(data_get($job, 'country.iso2')) . '.png') }}"
                                                            class="mb-1" alt="">
                                                        {{ data_get($job, 'country.name') ?? 'Not Available' }}
                                                    @endif
                                                </a>
                                            </li>
                                            <li class="mr-3">
                                                <a href="#" class="icons">
                                                    Basic Salary: <span class="blue">
                                                        @if (!blank(data_get($job, 'country')))
                                                            {{ data_get($job, 'country.currency') ?? '' }}&nbsp;{{ $job->country_salary ?? '' }}&nbsp;&nbsp;
                                                        @endif
                                                        @if (!blank(data_get($job, 'country')) and data_get($job, 'country.currency') != 'NPR')
                                                            NPR:
                                                            {{ $job->nepali_salary ?? '' }}
                                                        @endif
                                                    </span>
                                                </a>
                                            </li>
                                            <li class="mr-3">
                                                <a href="#" class="icons">
                                                    Post On:
                                                    {{ $job->publish_date != null ? date('j M Y', strtotime($job->publish_date)) : '' }}
                                                </a>
                                            </li>
                                            <li class="mr-3">
                                                <a href="#" class="icons">
                                                    Apply Before:
                                                    {{ $job->expiry_date != null ? date('j M Y', strtotime($job->expiry_date)) : '' }}
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="hr">
                                        <hr>
                                    </div>
                                    <div class="icons">
                                        <div class="row">
                                            @auth
                                                @if (auth()->user()->user_type == 'candidate')
                                                    @php
                                                        $application = \DB::table('job_applications')
                                                            ->where('job_id', $job->id)
                                                            ->where('employ_id', $employ->id)
                                                            ->first();
                                                        $savedJob = App\Models\SavedJob::where('employ_id', $employ->id)->where('job_id', $job->id);
                                                    @endphp

                                                    <div class="col-md-3">
                                                        @if ($application)
                                                            <a href="javascript:void(0);"
                                                                class="btn btn-primary mr-5 btn-block">Applied</a>
                                                        @else
                                                            <a href="{{ route('applyForJob', $job->id) }}"
                                                                class="btn btn-primary mr-5 btn-block"> Apply
                                                                Now</a>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-3">
                                                        @if ($savedJob->exists())
                                                            <a href="javascript:void(0);" onclick="savejob({{ $job->id }})"
                                                                class="saveJobButton ico-grid-font btn btn-warning btn-block">
                                                                <i class="fa fa-heart"></i> Saved
                                                            </a>
                                                        @else
                                                            <a href="javascript:void(0);"
                                                                onclick="savejob({{ $job->id }})"
                                                                class="saveJobButton ico-grid-font btn btn-warning btn-block">
                                                                <i class="fa fa-heart-o"></i> Save Job
                                                            </a>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="sharethis-inline-share-buttons"
                                                            data-url="{{ route('viewJob', $job->id) }}">
                                                        </div>
                                                    </div>
                                                @elseif(auth()->user()->user_type == 'company')
                                                    <div class="col-md-3">
                                                        <div class="sharethis-inline-share-buttons"
                                                            data-url="{{ route('viewJob', $job->id) }}">
                                                        </div>
                                                    </div>
                                                @endif
                                            @else
                                                <div class="col-md-3">
                                                    <a href="{{ route('applyForJob', $job->id) }}"
                                                        class="btn btn-block btn-primary mr-3"> Apply Now</a>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="sharethis-inline-share-buttons"
                                                        data-url="{{ route('viewJob', $job->id) }}">
                                                    </div>
                                                </div>
                                            @endauth
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="row">
                        <div class="card-body border-top">
                            <h4 class="mb-4 card-title bg-primary text-white p-2">Job Details</h4>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="" class="form-label">Job Title&nbsp;:</label>
                                    </div>
                                    <div class="col-md-8">
                                        {{ $job->title }}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="" class="form-label">Required Numbers&nbsp;:</label>
                                    </div>
                                    <div class="col-md-8">
                                        {{ $job->num_of_positions }}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="" class="form-label">Job Category&nbsp;:</label>
                                    </div>
                                    <div class="col-md-8">
                                        {{ !empty($job->job_category) || $job->job_category != null ? $job->job_category->functional_area : '' }}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="" class="form-label">Wokring Hours Per
                                            Day&nbsp;:</label>
                                    </div>
                                    <div class="col-md-8">
                                        {{ $job->working_hours }}
                                        {{ $job->working_hours != null ? ($job->working_hours > 1 ? 'Hours' : 'Hour') : '' }}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="" class="form-label">Wokring Days Per
                                            Week&nbsp;:</label>
                                    </div>
                                    <div class="col-md-8">
                                        {{ $job->working_days }}
                                        {{ $job->working_days != null ? ($job->working_days > 1 ? 'Days' : 'Day') : '' }}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="" class="form-label">Job Posted On&nbsp;:</label>
                                    </div>
                                    <div class="col-md-8">
                                        {{ $job->publish_date != null ? date('j M Y', strtotime($job->publish_date)) : '' }}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="" class="form-label">Apply Before&nbsp;:</label>
                                    </div>
                                    <div class="col-md-8">
                                        {{ $job->expiry_date != null ? date('j M Y', strtotime($job->expiry_date)) : '' }}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="" class="form-label">Contract Period&nbsp;:</label>
                                    </div>
                                    <div class="col-md-8">
                                        {{ $job->contract_year }}
                                        {{ $job->contract_year != null ? ($job->contract_year > 1 ? 'Years' : 'Year') : '' }}
                                        {{ $job->contract_month }}
                                        {{ $job->contract_month != null ? ($job->contract_month > 1 ? 'Months' : 'Month') : '' }}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="form-label">Job Description&nbsp;:</label>
                                {!! html_entity_decode($job->description_intro) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="card-body border-top">
                            <h4 class="mb-4 card-title bg-primary text-white p-2">Qualification</h4>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="" class="form-label">Minimum
                                            Qualification&nbsp;:</label>
                                    </div>
                                    <div class="col-md-8">
                                        {{ $job->education_level_id != null && (!empty($job->education_level) || $job->education_level != null) ? $job->education_level->title : '' }}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="" class="form-label">Minimum Experience&nbsp;:</label>
                                    </div>
                                    <div class="col-md-8">
                                        {{ $job->min_experience }}
                                        {{ $job->min_experience != null ? ($job->min_experience > 1 ? 'Years' : 'Year') : '' }}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="" class="form-label">Age Requirement&nbsp;:</label>
                                    </div>
                                    <div class="col-md-8">
                                        {{ $job->min_age }}
                                        {{ $job->min_age != null && $job->max_age != null ? '- ' . $job->max_age : '' }}
                                        {{ $job->min_age != null && $job->max_age != null ? 'Years' : '' }}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                @php
                                    $json_skills = json_decode($job->skills, true);
                                    $skills =
                                        !empty($json_skills) || $json_skills != null
                                            ? App\Models\Skill::whereIn('id', $json_skills)
                                                ->pluck('title')
                                                ->toArray()
                                            : '';

                                    // $skills = '<span class="badge badge-success">' . implode('</span> <span class="badge badge-success">', $skills) . '</span>'; //working code(converted to function)
                                    $skills = $skills != null ? wrapInTag($skills, 'span', 'class="badge badge-success"', ' ') : '';

                                @endphp
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="" class="form-label">Skills&nbsp;:</label>
                                    </div>
                                    <div class="col-md-8">
                                        {!! $skills !!}

                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="form-label">Other Requirements&nbsp;:</label>
                                {!! html_entity_decode($job->requirement_intro) !!}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="card-body">
                            <h4 class="mb-4 card-title bg-primary text-white p-2">Salary and Facility</h4>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="" class="form-label">Basic
                                            Salary&nbsp;:</label>
                                    </div>
                                    <div class="col-md-8">
                                        @php
                                            $country = App\Models\Country::where('id', $job->country_id);
                                            if ($country->exists()) {
                                                $country = $country->first();
                                            } else {
                                                $country = null;
                                            }
                                        @endphp
                                        {{ $job->country_id != null && $country != null && $job->country_salary != null ? 'Per Month ' . $country->currency . ' ' . $job->country_salary : '' }}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="" class="form-label">Average
                                            Earning&nbsp;:</label>
                                    </div>
                                    <div class="col-md-8">
                                        @php
                                            $country = App\Models\Country::where('id', $job->country_id)->first() ?? null;

                                        @endphp
                                        {{ $job->country_id != null && $country != null && $job->earning_country_salary != null ? 'Per Month ' . $country->currency . ' ' . $job->earning_country_salary : '' }}
                                        {{ $job->country_id != null && $country != null && $job->earning_nepali_salary != null ? '- ' . $country->currency . ' ' . $job->earning_nepali_salary : '' }}

                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="" class="form-label">Accommodation&nbsp;:</label>
                                    </div>
                                    <div class="col-md-8">
                                        @php
                                            $accomodation = $job->accomodation == 1 ? 'Yes' : 'No';

                                        @endphp
                                        {{ $accomodation == 'Yes' ? $accomodation . ' (As Per Company Rule)' : $accomodation }}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="" class="form-label">Food&nbsp;:</label>
                                    </div>
                                    <div class="col-md-8">
                                        @php
                                            $food = $job->food == 1 ? 'Yes' : 'No';

                                        @endphp
                                        {{ $food == 'Yes' ? $food . ' (As Per Company Rule)' : $food }}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="" class="form-label">Annual Vacation&nbsp;:</label>
                                    </div>
                                    <div class="col-md-8">
                                        @php
                                            $vacation = $job->annual_vacation == 1 ? 'Yes' : 'No';
                                        @endphp
                                        {{ $vacation == 'Yes' ? $vacation . ' (As Per Company Rule)' : $vacation }}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="" class="form-label">Over Time&nbsp;:</label>
                                    </div>
                                    <div class="col-md-8">
                                        @php
                                            $overtime = $job->overtime == 1 ? 'Yes' : 'No';
                                        @endphp
                                        {{ $overtime == 'Yes' ? $overtime . ' (As Per Company Rule)' : $overtime }}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="form-label">Other Benefits&nbsp;:</label>
                                {!! html_entity_decode($job->benefit_intro) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <!--Jobs Description-->

    </div>
</div>
