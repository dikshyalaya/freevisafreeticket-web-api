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
        <input type="hidden" value="{{ setParameter($job, 'id') }}" name="job_id" class="form-control">
        <div class="col-xl-12">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12">
                    <!--Jobs Description-->
                    <div class="card overflow-hidden">
                        <div class="card-body h-100">
                            <div class="row">
                                <div class="col">
                                    <div class="profile-pic mb-0">
                                        <div class="d-md-flex">
                                            <img src="{{ asset('/') }}{{ $job->feature_image_url != null ? $job->feature_image_url : 'images/defaultimage.jpg' }}"
                                                class="w-20 h-20" alt="user">
                                            <div class="ml-4">
                                                <span class="text-dark">
                                                    <h4 class="mt-3 mb-1 fs-20 font-weight-bold">{{ $job->title }}</h4>
                                                </span>
                                                <div class="">
                                                    <ul class="mb-0 d-flex">
                                                        <li class="mr-3"><a href="#" class="icons"><i
                                                                    class="fa fa-building-o text-muted mr-1"></i>
                                                                {{ isset($company) ? $company->company_name : '' }}</a>
                                                        </li>
                                                    </ul>
                                                    <ul class="mb-0 mt-2 d-flex">
                                                        <li class="mr-3">
                                                            <a href="#" class="icons">
                                                                <img src="{{ asset(!empty($job->country) ? 'https://flagcdn.com/16x12/' . strtolower($job->country->iso2) . '.png' : '') }}"
                                                                    class="mb-1" alt="">
                                                                {{ !empty($job->country) ? $job->country->name : '' }}
                                                            </a>
                                                        </li>
                                                        <li class="mr-3">
                                                            <a href="#" class="icons">
                                                                Basic Salary: <span class="blue">
                                                                    {{ !empty($job->country) ? $job->country->currency : '' }}&nbsp;{{ $job->country_salary }}&nbsp;&nbsp;
                                                                    @if (!empty($job->country) && $job->country->currency != 'NPR')
                                                                        NPR: {{ $job->nepali_salary }}
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
                                                {{-- icons code here saved job, apply now --}}
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
                                        <h4 class="mb-4 card-title bg-primary text-white p-2">{{ __('Job Details') }}</h4>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label for="" class="form-label">{{ __('Job Title') }}&nbsp;:</label>
                                                </div>
                                                <div class="col-md-8">
                                                    {{ $job->title }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label for="" class="form-label">{{ __('Required Numbers') }}&nbsp;:</label>
                                                </div>
                                                <div class="col-md-8">
                                                    {{ $job->num_of_positions }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label for="" class="form-label">{{ __('Job Category') }}&nbsp;:</label>
                                                </div>
                                                <div class="col-md-8">
                                                    {{ !empty($job->job_category) || $job->job_category != null ? $job->job_category->functional_area : '' }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label for="" class="form-label">{{ __('Working Hours Per Day') }}&nbsp;:</label>
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
                                                    <label for="" class="form-label">{{ __('Working Days Per Week') }}&nbsp;:</label>
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
                                                    <label for="" class="form-label">{{ __('Job Posted On') }}&nbsp;:</label>
                                                </div>
                                                <div class="col-md-8">
                                                    {{ $job->publish_date != null ? date('j M Y', strtotime($job->publish_date)) : '' }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label for="" class="form-label">{{ __('Apply Before') }}&nbsp;:</label>
                                                </div>
                                                <div class="col-md-8">
                                                    {{ $job->expiry_date != null ? date('j M Y', strtotime($job->expiry_date)) : '' }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label for="" class="form-label">{{ __('Contract Period') }}&nbsp;:</label>
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
                                            <label for="" class="form-label">{{ __('Job Description') }}&nbsp;:</label>
                                            {!! html_entity_decode($job->description_intro) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="card-body border-top">
                                        <h4 class="mb-4 card-title bg-primary text-white p-2">{{ __('Qualification') }}</h4>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label for="" class="form-label">{{ __('Minimum Qualification') }}&nbsp;:</label>
                                                </div>
                                                <div class="col-md-8">
                                                    {{ $job->education_level_id != null && (!empty($job->education_level) || $job->education_level != null)? $job->education_level->title: '' }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label for="" class="form-label">{{ __('Minimum Experience') }}&nbsp;:</label>
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
                                                    <label for="" class="form-label">{{ __('Age Requirement') }}&nbsp;:</label>
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

                                               $skills = $skills != null ? wrapInTag($skills, 'span', 'class="badge badge-success"', ' ') : '';

                                            @endphp
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label for="" class="form-label">{{ __('Skills') }}&nbsp;:</label>
                                                </div>
                                                <div class="col-md-8">
                                                    {!! $skills !!}

                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="" class="form-label">{{ __('Other Requirements') }}&nbsp;:</label>
                                            {!! html_entity_decode($job->requirement_intro) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="card-body">
                                        <h4 class="mb-4 card-title bg-primary text-white p-2">{{ __('Salary and Facility') }}</h4>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label for="" class="form-label">{{ __('Basic Salary') }}&nbsp;:</label>
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
                                                    {{ $job->country_id != null && $country != null && $job->country_salary != null? 'Per Month ' . $country->currency . ' ' . $job->country_salary: '' }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label for="" class="form-label">{{ __('Average Earning') }}&nbsp;:</label>
                                                </div>
                                                <div class="col-md-8">
                                                    @php
                                                        $country = App\Models\Country::where('id', $job->country_id)->first() ?? null;

                                                    @endphp
                                                    {{ $job->country_id != null && $country != null && $job->earning_country_salary != null? 'Per Month ' . $country->currency . ' ' . $job->earning_country_salary: '' }}
                                                    {{ $job->country_id != null && $country != null && $job->earning_nepali_salary != null? '- '.$country->currency . ' ' . $job->earning_nepali_salary: '' }}

                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label for="" class="form-label">{{ __('Accommodation') }}&nbsp;:</label>
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
                                                    <label for="" class="form-label">{{ __('Food') }}&nbsp;:</label>
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
                                                    <label for="" class="form-label">{{ __('Annual Vacation') }}&nbsp;:</label>
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
                                                    <label for="" class="form-label">{{ __('Over Time') }}&nbsp;:</label>
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
                                            <label for="" class="form-label">{{ __('Other Benefits') }}&nbsp;:</label>
                                            {!! html_entity_decode($job->benefit_intro) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mx-auto">
                    <span>{{ __('Salary and Facility') }}</span>&nbsp;&nbsp;&nbsp;<a
                        href="{{ route('company.newjob.get_salary_and_facility_form', ['job_id' => request()->job_id]) }}"
                        class="btn btn-primary rounded-0"><i class="fa fa-arrow-left"></i> {{ __('Back') }}</a>
                    <a href="{{ route('company.newjob.get_approval_form', ['job_id' => request()->job_id]) }}" class="btn btn-primary rounded-0 ml-5">{{ __('Next') }} <i
                            class="fa fa-arrow-right"></i></a>&nbsp;&nbsp;&nbsp;<span>{{ __('Send To Approval') }}</span>
                </div>
            </div>
        </div>
    </form>
@endsection
@section('script')
    <script>
        const _token = $('meta[name="csrf-token"]')[0].content;
        const appurl = "{{ env('APP_URL') }}";

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
    </script>
@endsection
