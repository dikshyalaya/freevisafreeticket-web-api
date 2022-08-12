@extends('admin.layouts.master')
@section('main')
    {{-- @dd($candidate?$candidate); --}}
    {{-- {{ dd($candidate) }} --}}
    <div class="page-header">
        <h4 class="page-title">{{ $action }} Applicants</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Modules</a></li>
            <li class="breadcrumb-item" aria-current="page"><a href="/admin/applicants/">Applicants</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add</li>
        </ol>
    </div>

    <div class="row">
        <div class="col-12">
            <form action="/admin/applicants/save" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="application_id" value="{{ $application->id }}">
                <input type="hidden" name="employ_id" value="{{ $application->employ_id }}">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ $action }} Applicants</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 col-lg-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div id="profile-log-switch">
                                            <div class="fade show active ">
                                                <div class="table-responsive border ">
                                                    <table class="table row table-borderless w-100 m-0 ">
                                                        <tbody class="col-lg-12 col-xl-6 p-0">
                                                            <tr>
                                                                <td><strong>Full Name :</strong>
                                                                    {{ $candidate->full_name }}
                                                                    {{ $candidate->middle_name }}
                                                                    {{ $candidate->last_name }}</td>
                                                            </tr>
                                                            @if ($candidate->country_id !== null)
                                                                <tr>
                                                                    <td><strong>Location :</strong>
                                                                        {{ \DB::table('countries')->find($candidate->country_id)->name }}
                                                                    </td>
                                                                </tr>
                                                            @endif
                                                        </tbody>
                                                        <tbody class="col-lg-12 col-xl-6 p-0">
                                                            <tr>
                                                                <td><strong>Email :</strong> {{ $candidate_user->email }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>Phone :</strong>
                                                                    {{ $candidate->mobile_phone }}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <div class="form-group p-2">
                                                        <label for="inputState"
                                                            class="col-form-label card-title">Status</label>
                                                        <select id="inputState"
                                                            class="form-control select2 custom-select select2-hidden-accessible"
                                                            data-select2-id="select2-data-inputState" tabindex="-1"
                                                            aria-hidden="true" name="status">
                                                            <option data-select2-id="select2-data-5-o1jo" value="pending"
                                                                {{ isset($application->status) ? ('pending' == $application->status ? 'selected' : '') : null }}>
                                                                Pending</option>
                                                            <option data-select2-id="select2-data-5-o1j" value="shortlisted"
                                                                {{ isset($application->status) ? ('shortlisted' == $application->status ? 'selected' : '') : null }}>
                                                                Shortlisted</option>
                                                            <option data-select2-id="select2-data-5-o1k" value="selectedForInterview"
                                                                {{ isset($application->status) ? ('selectedForInterview' == $application->status ? 'selected' : '') : null }}>
                                                                Selected For Interview</option>
                                                            <option data-select2-id="select2-data-5-o1u" value="interviewed"
                                                                {{ isset($application->status) ? ('interviewed' == $application->status ? 'selected' : '') : null }}>
                                                                Interviewed</option>
                                                            <option data-select2-id="select2-data-43-0e3k" value="accepted"
                                                                {{ isset($application->status) ? ('accepted' == $application->status ? 'selected' : '') : null }}>
                                                                Accepted</option>
                                                            <option data-select2-id="select2-data-44-q5hf" value="rejected"
                                                                {{ isset($application->status) ? ('rejected' == $application->status ? 'selected' : '') : null }}>
                                                                Rejected</option>
                                                            <option data-select2-id="select2-data-44-q5hi" value="redlisted"
                                                                {{ isset($application->status) ? ('redlisted' == $application->status ? 'selected' : '') : null }}>
                                                                Red Listed</option>
                                                        </select>
                                                    </div>
                                                    {{-- <div class="form-group p-2">
                                                        <label for="inputState" class="col-form-label card-title">Job
                                                            Preferences</label>
                                                        <div class="form-group">
                                                            <label class="form-label">Job Category</label>
                                                            <div class="form-group ">
                                                                <select class="form-control select2-show-search"
                                                                    name="category" data-placeholder="Select Category">
                                                                    @foreach ($job_categories as $category)
                                                                        <option value="{{ $category->id }}"
                                                                            {{ isset($job_preference->job_category_id)? ($category->id == $job_preference->job_category_id? 'selected': ''): null }}>
                                                                            {{ $category->functional_area }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label ">Country</label>
                                                            <select name="country_id" id="select-country"
                                                                class="form-control select2 "
                                                                value="{{ isset($candidate->country_id) ? $candidate->country_id : '' }}"
                                                                onchange="patchStates(this)">
                                                                @foreach ($countries as $item)
                                                                    <option value="{{ $item->id }}"
                                                                        {{ isset($job_preference->country_id) ? ($item->id == $job_preference->country_id ? 'selected' : '') : null }}>
                                                                        {{ $item->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div> --}}
                                                    <div class="form-group p-2">
                                                        <label for="inputState" class="col-form-label card-title">Interview
                                                            Process</label>
                                                        <div class="form-group">
                                                            <label class="form-label ">Status</label>
                                                            <div class="form-group">
                                                                <select class="form-control select2-show-search"
                                                                    name="interview_status"
                                                                    data-placeholder="Select Interview Status">
                                                                    <option value="notstarted"
                                                                        {{ isset($application->interview_status)? ($application->interview_status == 'notstarted'? 'selected': ''): null }}>
                                                                        Not Started</option>
                                                                    <option value="started"
                                                                        {{ isset($application->interview_status)? ($application->interview_status == 'started'? 'selected': ''): null }}>
                                                                        Started</option>
                                                                    <option value="fail"
                                                                        {{ isset($application->interview_status) ? ($application->interview_status == 'fail' ? 'selected' : '') : null }}>
                                                                        Fail</option>
                                                                    <option value="pass"
                                                                        {{ isset($application->interview_status) ? ($application->interview_status == 'pass' ? 'selected' : '') : null }}>
                                                                        Pass</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        @if (isset($application->interview_status))
                                                            @if ($application->interview_status == 'started')
                                                                <div class="form-group">
                                                                    <label class="form-label">Interview Date</label>
                                                                    <input type="date" class="form-control"
                                                                        name="interview_date"
                                                                        value="{{ isset($application->interview_date) ? $application->interview_date : '' }}">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="form-label">Interview Time</label>
                                                                    <input type="time" class="form-control"
                                                                        name="interview_time"
                                                                        value="{{ isset($application->interview_time) ? $application->interview_time : '' }}">
                                                                </div>
                                                            @endif
                                                        @endif
                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>
                            <div class="col-md-6 col-lg-6">
                                <div class="card-body">
                                    <div class="bg-light p-6 text-center">
                                        <img class="" alt="Product"
                                            src="{{ env('APP_URL') . $job->feature_image_url }}" width="300px">
                                    </div>

                                    <div class="border mt-4 mb-4">
                                        <h4 class="m-b-0 m-t-20">Description</h4>
                                        <p>{{ $job->description }}</p>
                                    </div>
                                    <h4 class="mb-4">Info</h4>
                                    <div class="pro_detail border p-4">
                                        <h5 class="m-l-0 m-t-10">General</h5>
                                        <ul class="list-unstyled mb-0">
                                            <li class="row">
                                                <div class="col-sm-3 text-muted mb-2">Job Catagory</div>
                                                <div class="col-sm-3 mb-2">
                                                    {{ DB::table('job_categories')->find($job->job_categories_id)->functional_area }}
                                                </div>
                                            </li>
                                            <li class=" row">
                                                <div class="col-sm-3 text-muted mb-2">Job Sifts</div>
                                                <div class="col-sm-3 mb-2">
                                                    {{ @DB::table('job_shifts')->find($job->job_shift_id)->job_shift }}
                                                </div>
                                            </li>
                                            <li class="p-b-20 row">
                                                <div class="col-sm-3 text-muted mb-2">Salary Range</div>
                                                <div class="col-sm-3 mb-2"> Rs.{{ $job->salary_from }} -
                                                    {{ $job->salary_to }}</div>
                                            </li>

                                        </ul>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <div class="d-flex">
                            <a href="/admin/applicants/" class="btn btn-link">Back</a>
                            <button type="submit" class="btn btn-primary ml-auto">Save </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ env('APP_URL') }}js/location.js"></script>
    <script>
        const _token = $('meta[name="csrf-token"]')[0].content;
        const state_id = {{ isset($candidate->state_id) ? $candidate->state_id : '3871' }};
        const city_id = {{ isset($candidate->city_id) ? $candidate->city_id : 'null' }};
        const appurl = "{{ env('APP_URL') }}";
    </script>
@endsection
