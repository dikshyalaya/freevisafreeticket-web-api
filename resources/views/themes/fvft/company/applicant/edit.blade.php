@extends('themes.fvft.company.layouts.dashmaster')
@section('title', 'Edit Applicant')
@section('applicants', 'active')
@section('content')
    <form action="{{ route('company.applicant.updateApplication', $application->id) }}" method="POST" id="applicantForm">
        @csrf
        @method('put')

        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="">Full Name:</label>
                            </div>
                            <div class="col-md-8">
                                {{ $application->employe->full_name }}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="">Address:</label>
                            </div>
                            <div class="col-md-8">
                                {{ $application->employe->address }}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="">Email:</label>
                            </div>
                            <div class="col-md-8">
                                {{ $application->employe->user->email }}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="">Phone:</label>
                            </div>
                            <div class="col-md-8">
                                {{ $application->employe->mobile_phone }}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="">Status:</label>
                            </div>
                            <div class="col-md-8">
                                <select id="inputState" class="form-control select2 custom-select select2-hidden-accessible"
                                    data-select2-id="select2-data-inputState" tabindex="-1" aria-hidden="true"
                                    name="status">
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
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="interview_status">Interview Status</label>
                            </div>
                            <div class="col-md-8">
                                @php
                                    $statuses = ['started' => 'Started', 'notstarted' => 'Not Started', 'fail' => 'Fail', 'pass' => 'Pass'];
                                @endphp
                                <select name="interview_status" class="form-control select2-show-search">
                                    <option value="">Select Interview Status</option>
                                    @foreach ($statuses as $key => $value)
                                        <option value="{{ $key }}"
                                            {{ $key == $application->interview_status ? 'selected' : '' }}>
                                            {{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <label class="form-label">Interview Date</label>
                            </div>
                            <div class="col-md-8">
                                <input type="date" class="form-control" name="interview_date"
                                    value="{{ isset($application->interview_date) ? $application->interview_date : '' }}">
                            </div>
                        </div>


                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <label class="form-label">Interview Time</label>
                            </div>
                            <div class="col-md-8">
                                <input type="time" class="form-control" name="interview_time"
                                    value="{{ isset($application->interview_time) ? $application->interview_time : '' }}">
                            </div>
                        </div>


                    </div>
                    <div class="form-group">
                        <button type="button" onclick="submitForm(event);" class="btn btn-primary">Submit</button>
                    </div>

                </div>
            </div>
        </div>
    </form>
@endsection

@section('js')
    <script>
        function submitForm(e) {
            e.preventDefault();
            $('.require').css('display', 'none');
            let url = $("#applicantForm").attr('action');
            $.ajax({
                url: url,
                type: 'post',
                // _method: 'put',
                // data: data,
                data: new FormData($("#applicantForm")[0]),
                processData: false,
                contentType: false,
                cache: false,
                success: function(response) {
                    // return true;
                    if (response.db_error) {
                        $(".alert-secondary").css('display', 'block');
                        $(".db_error").html(response.db_error);
                    } else if (!response.db_error) {
                        location.href = response.redirectRoute;
                        toastr.success(response.msg);
                    }
                }
            });
        }
    </script>
@endsection
