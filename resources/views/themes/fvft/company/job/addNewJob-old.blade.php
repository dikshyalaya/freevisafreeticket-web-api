@extends('themes.fvft.company.layouts.dashmaster')
@section('css')
<link rel="stylesheet" href="{{ asset('css/datepicker.min.css') }}">
@endsection
@section('content')
    <div class="card-header">
        <h3 class="card-title">Add New Job</h3>
    </div>
    <div class="alert alert-secondary d-none" role="alert"><button type="button" class="close" data-dismiss="alert"
        aria-hidden="true">×</button><span id="db_error" class="db_error"></span></div>
    <form action="{{ route('company.saveNewJob') }}" method="POST" enctype="multipart/form-data" id="jobForm">
        @csrf
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 col-lg-6">
                    <div class="form-group">
                        <label class="form-label">Title</label>
                        <input type="text" class="form-control" name="job_title" placeholder="Job Title">
                        <div class="require job_title text-danger"></div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Company</label>
                        <div class="form-group">
                            <input type="hidden" name="company_id" class="form-control" value="{{ $company->id }}"
                                readonly>
                            <input type="text" name="company_name" class="form-control"
                                value="{{ $company->company_name }}" readonly>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Description <span class="form-label-small">56/100</span></label>
                        <textarea class="form-control" name="description" rows="7" placeholder="Description."></textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Benefits <span class="form-label-small">56/100</span></label>
                        <textarea class="form-control" name="benefits" rows="5" placeholder="Benefits."></textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Number of Positions</label>
                        <input type="number" class="form-control" name="no_of_position" placeholder="Number of Positions">
                    </div>
                    <div class="form-group">
                        <label for="deadline">Deadline</label>
                        <input type="text" name="deadline" class="form-control datetime" readonly>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Salary From</label>
                        <input type="number" class="form-control" name="salary_from" placeholder="Salary From">
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
                        <input type="file" class="dropify" name="featured_image" data-height="180" data-allowed-file-extensions="jpg png jpeg" data-max-file-size="4M">
                        <div class="require text-danger featured_image"></div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Country</label>

                        <select name="country_id" id="select-country" class="form-control select2-show-search" 
                        {{-- value="{{ isset($job->country_id) ? $job->country_id : '' }}" --}}
                            onchange="patchStates(this)">
                            @foreach ($countries as $item)
                                <option value="{{ $item->id }}"
                                    {{ $item->id == old('country_id') ? 'selected' : '' }}>
                                    {{ $item->name }}</option>
                            @endforeach

                        </select>
                        <div class="require text-danger country_id"></div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">States</label>

                        <select name="state_id" id="select-state" class="form-control select2-show-search" 
                        {{-- value="{{ isset($job->state_id) ? $job->state_id : '' }}" --}}
                            onchange="patchCities(this)">
                        </select>
                        <div class="require text-danger state_id"></div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Cities</label>

                        <select name="city_id" id="select-city" class="form-control select2-show-search">
                        </select>
                        <div class="require text-danger city_id"></div>
                    </div>
                    <div class="form-group">
                        <label class="custom-switch-checkbox">
                            <input type="checkbox" name="is_featured" class="custom-switch-input">
                            <span class="custom-switch-indicator"></span>
                            <span class="custom-switch-description">Featured</span>
                        </label>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Job Category</label>
                        <div class="form-group">
                            <select class="form-control select2-show-search" name="job_category"
                                data-placeholder="Select Category">
                                <option value="">Select Job Category</option>
                                @foreach ($job_categories as $category)
                                    <option value="{{ $category->id }}">
                                        {{ $category->functional_area }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Job Sift</label>
                        <div class="form-group">
                            <select class="form-control select2-show-search" name="job_shift"
                                data-placeholder="Select Job Shift">
                                <option value="">Select Job Shift</option>
                                @foreach ($job_shifts as $shift)
                                    <option value="{{ $shift->id }}">{{ $shift->job_shift }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Education Level</label>
                        <div class="form-group">
                            <select class="form-control select2-show-search" name="education_level"
                                data-placeholder="Select Education Level">
                                <option value="">Select Education Level</option>
                                @foreach ($education_levels as $educationlevel)
                                    <option value="{{ $educationlevel->id }}">
                                        {{ $educationlevel->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Experience</label>
                        <div class="form-group">
                            <select class="form-control select2-show-search" name="experience_level"
                                data-placeholder="Select Experience">
                                <option value="">Select Experience</option>
                                @foreach ($experience_levels as $experience)
                                    <option value="{{ $experience->id }}">{{ $experience->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer text-right">
            <div class="d-flex">
                <a href="javascript:void(0)" class="btn btn-link">Cancel</a>
                <button type="button" onclick="submitForm(event);" class="btn btn-success ml-auto">Save </button>
            </div>
        </div>
    </form>
@endsection
@section('script')
    <script src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>
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
