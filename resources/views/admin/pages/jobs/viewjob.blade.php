@extends('admin.layouts.master')
@section('main')
    <style>
        .buttondiv {
            margin-top: -43px;
            z-index: 999;
            position: absolute;
            left: 35%;
        }

        .buttondiv button {
            padding: 0.375rem 3rem;
        }

        .app-content .side-app {
            padding: 38px 30px 30px 30px;
        }

    </style>
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12">
            <div class="card overflow-hidden">
                <div class="card-body h-100">
                    <div class="row">
                        <div class="col">
                            <div class="profile-pic mb-0">
                                <div class="d-md-flex">
                                    <img src="{{ asset('/') }}{{ (!blank($job, 'company') AND !blank(data_get($job, 'company.company_logo'))) ? data_get($job, 'company.company_logo') :  ($job->feature_image_url != null ? $job->feature_image_url : 'images/defaultimage.jpg') }}"
                                        class="w-20 h-20" alt="user">
                                    <div class="ml-4">
                                        <a href="/job/{{ $job->id }}" class="text-dark">
                                            <h4 class="mt-3 mb-1 fs-20 font-weight-bold">
                                                {{ $job->title ?? 'Not-Available' }}</h4>
                                        </a>
                                        <div class="">
                                            <ul class="mb-0 d-flex">
                                                <li class="mr-3">
                                                    @if (!blank(data_get($job, 'company')))
                                                        <a href="#" class="icons">
                                                            <i class="fa fa-building-o text-muted mr-1"></i>
                                                            {{ data_get($job, 'company.company_name') ?? 'Not-Available' }}
                                                        </a>
                                                    @endif
                                                </li>
                                            </ul>
                                            <ul class="mb-0 mt-2 d-flex">
                                                <li class="mr-3">
                                                    <a href="#" class="icons">
                                                        @if (!blank(data_get($job, 'country')))
                                                            <img src="{{ asset('https://flagcdn.com/16x12/' . strtolower(data_get($job, 'country.iso2')) . '.png') }}"
                                                                class="mb-1" alt="">
                                                            {{ data_get($job, 'country.name') ?? 'Not-Available' }}
                                                        @endif
                                                    </a>
                                                </li>
                                                <li class="mr-3">
                                                    <a href="#" class="icons">
                                                        Basic Salary:
                                                        <span class="blue">
                                                            @if (!blank(data_get($job, 'country')))
                                                                {{ data_get($job, 'country.currency') ?? 'Not-Available' }}&nbsp;{{ $job->country_salary ?? 'Not-Available' }}&nbsp;&nbsp;
                                                            @endif
                                                            @if (!blank(data_get($job, 'country')) and data_get($job, 'country.currency') != 'NPR')
                                                                NPR: {{ $job->nepali_salary ?? 'Not-Available' }}
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

            </div>
            @if ($job->status == 'Pending')
                <div class="text-center buttondiv">
                    <button class="btn btn-primary rounded-0" data-toggle="modal" data-target="#approveRejectJobModal" data-id="{{ $job->id }}" data-status="Approved" data-modaltitle="approve">Approve</button>
                    <button class="btn btn-secondary rounded-0 ml-5" data-toggle="modal" data-target="#approveRejectJobModal" data-id="{{ $job->id }}" data-status="Rejected" data-modaltitle="reject">Reject</button>
                    {{-- <button class="btn btn-primary rounded-0" onclick="updateJobStatus({{ $job->id }}, 'Approved')">Approve</button>
                    <button class="btn btn-secondary rounded-0 ml-5" onclick="updateJobStatus({{ $job->id }}, 'Rejected')">Reject</button> --}}
                </div>
            @endif
        </div>
    </div>
    @include('modals.approveRejectJob')
@endsection
@section('script')
    <script>
        $(document).ready(function(){
            $("#approveRejectJobModal").on('show.bs.modal', function(e){
                var $_button = $(e.relatedTarget),
                    $_this_data_id = $($_button).data('id'),
                    $_this_data_status = $($_button).data('status'),
                    $_this_data_modal_title = $($_button).data('modaltitle');
                $("#JobButton").attr('onclick', 'updateJobStatus('+ $_this_data_id +', '+ "'" + $_this_data_status + "'" +')');
                $("#modalTitle").html(capitalizeFirstLetter($_this_data_modal_title));
                $("#JobButton").html(capitalizeFirstLetter($_this_data_modal_title));
                $("#ApproveRejectTitle").html($_this_data_modal_title);
            });

            $("#approveRejectJobModal").on('hide.bs.modal', function(){
                $("#JobButton").removeAttr('onclick');
            });
        });
        function updateJobStatus(job_id, job_status) {
            if (job_id != null && job_status != null) {
                $.ajax({
                    url: "{{ route('admin.job.updateJobStatus') }}",
                    type: 'POST',
                    data: {'job_id': job_id, 'job_status': job_status},
                    beforeSend: function(){
                        $(".buttondiv").find('button').attr('disabled', true);
                    },
                    success: function(response){
                        if(response.db_error){
                            toastr.warning(response.db_error);
                            hideApproveRejectJobModal();
                        } else if(!response.db_error){
                            toastr.success(response.msg);
                            $(".buttondiv").hide();
                            hideApproveRejectJobModal();
                        }
                    },
                    complete: function(){
                        $(".buttondiv").find('button').attr('disabled', false);
                        hideApproveRejectJobModal();
                    }
                });
            } else {
                toastr.error('Something went wrong');
            }

        }

        function hideApproveRejectJobModal()
        {
            $("#approveRejectJobModal").modal('hide');
        }
    </script>
@endsection
