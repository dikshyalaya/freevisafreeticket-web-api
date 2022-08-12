<?php
use Illuminate\Support\Facades\Route;
$RouteName = Route::currentRouteName();
$_1st = $RouteName == 'company.newjob.get_job_detail';
$_edit = $RouteName == 'company.editjob';
$_2nd = $RouteName == 'company.newjob.get_applicant_form';
$_3rd = $RouteName == 'company.newjob.get_salary_and_facility_form';
$_4th = $RouteName == 'company.newjob.get_job_preview';
$_5th = $RouteName == 'company.newjob.get_approval_form';
// dd($RouteName);
// dd($_5th);
$hasJobId = request()->has('job_id');
?>
<div class="card">
    <div class="card-body">
        {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pixeden-stroke-7-icon@1.2.3/pe-icon-7-stroke/dist/pe-icon-7-stroke.min.css"> --}}
        <div class="steps d-flex flex-wrap flex-sm-nowrap justify-content-between padding-top-2x padding-bottom-1x">
            <div
                class="step {{ $_1st || $_edit ? 'active' : '' }} {{ $_2nd || $_3rd || $_4th || $_5th ? 'completed' : '' }}">
                <div class="step-icon-wrap">
                    <div class="step-icon">{{ __('1') }}</div>
                </div>
                <h4 class="step-title">
                    <a
                        href="{{ $hasJobId? route('company.newjob.get_job_detail', ['job_id' => request()->job_id]): route('company.newjob.get_job_detail') }}">
                        {{ strtoupper(__('Job Details')) }}
                    </a>
                </h4>
            </div>
            <div class="step {{ $_2nd ? 'active' : '' }} {{ $_3rd || $_4th || $_5th ? 'completed' : '' }}">
                <div class="step-icon-wrap">
                    <div class="step-icon">{{ __('2') }}</div>
                </div>
                <h4 class="step-title">
                    <a title="{{ $hasJobId ? '' : 'Please complete step 1 first before continue' }}"
                        href="{{ $hasJobId? route('company.newjob.get_applicant_form', ['job_id' => request()->job_id]): 'javascript:void(0)' }}">
                        {{ strtoupper(__('Applicant Qualification')) }}
                    </a>
                </h4>
            </div>
            <div class="step {{ $_3rd ? 'active' : '' }} {{ $_4th || $_5th ? 'completed' : '' }}">
                <div class="step-icon-wrap">
                    <div class="step-icon">{{ __('3') }}</div>
                </div>
                <h4 class="step-title">
                    <a title="{{ $hasJobId ? '' : 'Please complete other steps before continue' }}"
                        href="{{ $hasJobId? route('company.newjob.get_salary_and_facility_form', ['job_id' => request()->job_id]): 'javascript:void(0)' }}">
                        {{ strtoupper(__('Salary and Facility')) }}
                    </a>
                </h4>
            </div>
            <div class="step {{ $_4th ? 'active' : '' }} {{ $_5th ? 'completed' : '' }}">
                <div class="step-icon-wrap">
                    <div class="step-icon">{{ __('4') }}</div>
                </div>
                <h4 class="step-title">
                    <a title="{{ $hasJobId ? '' : 'Please complete other steps before continue' }}"
                        href="{{ $hasJobId ? route('company.newjob.get_job_preview', ['job_id' => request()->job_id]) : 'javascript:void(0)' }}">
                        {{ strtoupper(__('Preview')) }}
                    </a>
                </h4>
            </div>
            <div class="step {{ $_5th ? 'active' : '' }}">
                <div class="step-icon-wrap">
                    <div class="step-icon">{{ __('5') }}</div>
                </div>
                <h4 class="step-title">{{ strtoupper(__('Final')) }}</h4>
            </div>
        </div>
    </div>
</div>
