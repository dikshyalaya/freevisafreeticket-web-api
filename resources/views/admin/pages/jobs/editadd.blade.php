@extends('admin.layouts.master')
@section('main')
    <link rel="stylesheet" href="{{ asset('css/datepicker.min.css') }}">
    <div class="page-header">
        <h4 class="page-title">Add Job</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Modules</a></li>
            <li class="breadcrumb-item" aria-current="page">Jobs</li>
            <li class="breadcrumb-item active" aria-current="page">Add</li>
        </ol>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="alert alert-secondary d-none" role="alert"><button type="button" class="close" data-dismiss="alert"
                aria-hidden="true">×</button><span id="db_error" class="db_error"></span></div>
            <form action="{{ route('admin.saveNewJob') }}" method="post" enctype="multipart/form-data" id="jobForm">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">New Job</h3>

                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label class="form-label">Title</label>
                                    <input type="text" class="form-control" name="title" placeholder="Job Title">
                                    <div class="require text-danger title"></div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Company</label>
                                    <div class="form-group">
                                        <select class="form-control select2-show-search" data-placeholder="Select Company"
                                            name="company_id">
                                            @foreach ($companies as $company)
                                                <option value="{{ $company->id }}">{{ $company->company_name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="require text-danger company_id"></div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Description <span
                                            class="form-label-small">56/100</span></label>
                                    <textarea class="form-control" name="description" rows="7"
                                        placeholder="Description."></textarea>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Benefits <span
                                            class="form-label-small">56/100</span></label>
                                    <textarea class="form-control" name="benefits" rows="5"
                                        placeholder="Benefits."></textarea>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Number of Positions</label>
                                    <input type="number" class="form-control" name="number_of_position"
                                        placeholder="Number of Positions">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Deadline</label>
                                    <input type="text" class="form-control datetime" name="deadline"
                                        placeholder="Deadline"
                                        value="" readonly>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Salary From</label>
                                    <input type="number" class="form-control" name="salary_from"
                                        placeholder="Salary From">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Salary To</label>
                                    <input type="number" class="form-control" name="salary_to" placeholder="Salary To">
                                </div>
                                <div class="form-group">
                                    <label class="custom-switch-checkbox">
                                        <input type="checkbox" name="hide_salary" class="custom-switch-input">
                                        <span class="custom-switch-indicator"></span>
                                        <span class="custom-switch-description">Hide Salary</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label class="form-label">Featured Image</label>
                                    <input type="file" class="dropify" name="feature_image" data-height="180" data-allowed-file-extensions="jpg png jpeg" data-max-file-size="4M">

                                </div>
                                <div class="form-group">
                                    <label class="form-label">Country</label>
                                   
                                    <select name="country" id="select-country" class="form-control select2-show-search"
                                        value="{{ isset($job->country_id) ? $job->country_id : '' }}"
                                        onchange="patchStates(this)">
                                        @foreach ($countries as $item)
                                            <option value="{{ $item->id }}"
                                                {{ isset($job->country_id) ? ($item->id == $job->country_id ? 'selected' : '') : null }}>
                                                {{ $item->name }}</option>
                                        @endforeach

                                    </select>
                                    <div class="require text-danger country"></div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">States</label>
                                    
                                    <select name="state" id="select-state" class="form-control select2-show-search"
                                        value="{{ isset($job->state_id) ? $job->state_id : '' }}"
                                        onchange="patchCities(this)">
                                    </select>
                                    <div class="require text-danger state"></div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Cities</label>
                                   
                                    <select name="city_id" id="select-city" class="form-control select2-show-search"
                                        value="{{ isset($job->city_id) ? $job->city_id : '' }}">
                                    </select>
                                    <div class="require text-danger city_id"></div>
                                </div>
                                <div class="form-group">
                                    <label class="custom-switch-checkbox">
                                        <input type="checkbox" name="is_active" class="custom-switch-input">
                                        <span class="custom-switch-indicator"></span>
                                        <span class="custom-switch-description">Active</span>
                                    </label>
                                    <label class="custom-switch-checkbox">
                                        <input type="checkbox" name="is_featured" class="custom-switch-input">
                                        <span class="custom-switch-indicator"></span>
                                        <span class="custom-switch-description">Featured</span>
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="status">Status</label>
                                    @php
                                        $statuses = ['Approved' => 'Approved', 'Not Approved' => 'Not Approved'];
                                    @endphp
                                    <select name="job_status" class="form-control select2-show-search">
                                        <option value="">Select Status</option>
                                        @foreach ($statuses as $key => $value)
                                            <option value="{{ $key }}">{{ $value }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Job Category</label>
                                    <div class="form-group">
                                        <select class="form-control select2-show-search" name="category"
                                            data-placeholder="Select Category">
                                            @foreach ($job_categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->functional_area }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="require text-danger category"></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Job Sift</label>
                                    <div class="form-group">
                                        <select class="form-control select2-show-search" name="job_shift"
                                            data-placeholder="Select Contry">
                                            @foreach ($job_shifts as $shift)
                                                <option value="{{ $shift->id }}">{{ $shift->job_shift }}</option>
                                            @endforeach
                                        </select>
                                        <div class="require text-danger job_shift"></div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Education Level</label>
                                    <div class="form-group">
                                        <select class="form-control select2-show-search" name="educationlevel"
                                            data-placeholder="Select Contry">
                                            @foreach ($educationlevels as $educationlevel)
                                                <option value="{{ $educationlevel->id }}">{{ $educationlevel->title }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="require text-danger educationlevel"></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Experience</label>
                                    <div class="form-group">
                                        <select class="form-control select2-show-search" name="experiencelevel"
                                            data-placeholder="Select Contry">
                                            @foreach ($experiencelevels as $experience)
                                                <option value="{{ $experience->id }}">{{ $experience->title }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="require text-danger experiencelevel"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <div class="d-flex">
                            <a href="{{ route('admin.jobs-list') }}" class="btn btn-link">Cancel</a>
                            <button type="button" onclick="submitForm(event);" class="btn btn-success ml-auto">Save
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('js/location.js') }}"></script>
    <script>
        const _token = $('meta[name="csrf-token"]')[0].content;
        const state_id = {{ isset($job->state_id) ? $job->state_id : 'null' }};
        const city_id = {{ isset($job->city_id) ? $job->city_id : 'null' }};
        const appurl = "{{ env('APP_URL') }}";


        $(function() {
            $('.datetime').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                todayHighlight: true,
            });


        });

        function submitForm(e) {
            e.preventDefault();
            $('.require').css('display', 'none');
            let url = $("#jobForm").attr("action");
            $.ajax({
                url: url,
                type: 'post',
                data: new FormData($("#jobForm")[0]),
                processData: false,
                contentType: false,
                cache: false,
                success: function(data) {
                    // return true;
                    if (data.db_error) {
                        $(".alert-warning").css('display', 'block');
                        $(".db_error").html(data.db_error);
                    } else if (data.errors) {
                        var error_html = "";
                        $.each(data.errors, function(key, value) {
                            error_html = '<div>' + value + '</div>';
                            $('.' + key).css('display', 'block').html(error_html);
                        });
                    } else if (!data.errors && !data.db_error) {
                        location.href = data.redirectRoute;
                        toastr.success(data.msg);
                    }
                }
            });
        }
    </script>
@endsection
