@php
$countries = \DB::table('countries')->get();
$states = \DB::table('states')
    ->where('country_id', $job->country_id)
    ->get();
$cities = \DB::table('cities')
    ->where('state_id', $job->state_id)
    ->get();

@endphp
<div id="EditJob{{ $job->id }}" class="modal fade JobModal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content ">
            <div class="modal-header pd-x-20">
                <h6 class="modal-title">{{ $action }} Job </h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="alert alert-secondary d-none" role="alert"><button type="button" class="close" data-dismiss="alert"
                aria-hidden="true">×</button><span id="db_error" class="db_error"></span></div>
            <form action="{{ route('admin.job.update', $job->id) }}" method="post" enctype="multipart/form-data"
                id="jobForm{{ $job->id }}">
                @csrf
                @method('put')
                <div class="modal-body pd-20">

                    <input type="number" class="form-control" name="id" value="{{ $job->id }}"
                        style="display: none;">
                    <div class="row">
                        <div class="col-md-6 col-lg-6">
                            <div class="form-group">
                                <label class="form-label">Title</label>
                                <input type="text" class="form-control" name="title" placeholder="Job Title"
                                    value="{{ $job->title }}">
                                <div class="require text-danger title"></div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Company</label>
                                <div class="form-group">
                                    <select class="form-control select2-show-search" data-placeholder="Select Company"
                                        name="company_id">
                                        @foreach ($companies as $company)
                                            <option value="{{ $company->id }}"
                                                {{ $job->company_id == $company->id ? 'selected' : '' }}>
                                                {{ $company->company_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Description <span
                                        class="form-label-small">56/100</span></label>
                                <textarea class="form-control" name="description" rows="7"
                                    placeholder="Description.">{{ $job->description }}</textarea>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Benefits <span
                                        class="form-label-small">56/100</span></label>
                                <textarea class="form-control" name="benefits" rows="5"
                                    placeholder="Benefits.">{{ $job->benefits }}</textarea>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Number of Positions</label>
                                <input type="number" class="form-control" name="number_of_position"
                                    placeholder="Number of Positions" value="{{ $job->num_of_positions }}">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Deadline</label>
                                <input type="text" class="form-control datetime" name="deadline"
                                    placeholder="Deadline"
                                    value="{{ date('Y-m-d', strtotime($job->expiry_date)) }}" readonly>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Salary From</label>
                                <div class="d-flex align-items-center">
                                    <span class="p-1">Rs.</span>
                                    <input type="number" class="form-control" name="salary_from"
                                        placeholder="Salary From" value="{{ $job->salary_from }}">
                                    <span class="p-1">/-</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Salary To</label>
                                <div class="d-flex align-items-center">
                                    <span class="p-1">Rs.</span>
                                    <input type="number" class="form-control" name="salary_to" placeholder="Salary To"
                                        value="{{ $job->salary_to }}">
                                    <span class="p-1">/-</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="custom-switch-checkbox">
                                    <input type="checkbox" name="hide_salary" class="custom-switch-input"
                                        @if (isset($job->hide_salary)) checked="" @endif>
                                    <span class="custom-switch-indicator"></span>
                                    <span class="custom-switch-description">Hide Salary</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6">
                            <div class="form-group">
                                <label class="form-label">Featured Image</label>
                                <input type="file" id="feature_image{{ $job->id }}" class="dropify"
                                    name="feature_image" data-default-file="{{ asset($job->feature_image_url) }}"
                                    data-allowed-file-extensions="jpg png jpeg" data-max-file-size="4M"
                                    value="{{ $job->feature_image_url }}" data-height="180">

                            </div>
                            <div class="form-group">
                                <label class="form-label">Country</label>
                                <select name="country" id="select-countries-{{ $job->id }}"
                                    class="form-control select2 ">
                                    @foreach ($countries as $item)
                                        <option value="{{ $item->id }}"
                                            {{ $item->id == $job->country_id ? 'selected' : '' }}>{{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">States</label>
                                <select name="state" id="select-states-{{ $job->id }}"
                                    class="form-control select2 ">
                                    @foreach ($states as $item)
                                        <option value="{{ $item->id }}"
                                            {{ $item->id == $job->state_id ? 'selected' : '' }}>{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Cities</label>
                                <select name="city_id" id="select-cities-{{ $job->id }}"
                                    class="form-control select2 ">
                                    @foreach ($cities as $item)
                                        <option value="{{ $item->id }}"
                                            {{ $item->id == $job->city_id ? 'selected' : '' }}>{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="custom-switch-checkbox">
                                    <input type="checkbox" name="is_active" class="custom-switch-input"
                                        @if (isset($job->is_active) && $job->is_active == 1) checked="" @endif>
                                    <span class="custom-switch-indicator"></span>
                                    <span class="custom-switch-description">Active</span>
                                </label>
                                <label class="custom-switch-checkbox">
                                    <input type="checkbox" name="is_featured" class="custom-switch-input"
                                        @if (isset($job->is_featured) && $job->is_featured == 1) checked="" @endif>
                                    <span class="custom-switch-indicator"></span>
                                    <span class="custom-switch-description">Featured</span>
                                </label>
                                @if(isset($job->approval_status) && $job->approval_status == 1)
                                <label class="custom-switch-checkbox">
                                    <input type="checkbox" name="publish_status" class="custom-switch-input"
                                        @if (isset($job->publish_status) && $job->publish_status == 1) checked="" @endif>
                                    <span class="custom-switch-indicator"></span>
                                    <span class="custom-switch-description">Published</span>
                                </label>
                                @endif
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="status">Status</label>
                                @php
                                    $statuses = ['Approved' => 'Approved', 'Not Approved' => 'Not Approved'];
                                @endphp
                                <select name="job_status" class="form-control select2-show-search">
                                    <option value="">Select Status</option>
                                    @foreach ($statuses as $key => $value)
                                        <option value="{{ $key }}"
                                            {{ $job->status == $key ? 'selected' : '' }}>{{ $value }}
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
                                            <option value="{{ $category->id }}"
                                                {{ $job->job_categories_id == $category->id ? 'selected' : '' }}>
                                                {{ $category->functional_area }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Job Sift</label>
                                <div class="form-group">
                                    <select class="form-control select2-show-search" name="job_shift"
                                        data-placeholder="Select Contry">
                                        @foreach ($job_shifts as $shift)
                                            <option value="{{ $shift->id }}"
                                                {{ $job->job_shift_id == $shift->id ? 'selected' : '' }}>
                                                {{ $shift->job_shift }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Education Level</label>
                                <div class="form-group">
                                    <select class="form-control select2-show-search" name="educationlevel"
                                        data-placeholder="Select Contry">
                                        @foreach ($educationlevels as $educationlevel)
                                            <option value="{{ $educationlevel->id }}"
                                                {{ $job->education_level_id == $educationlevel->id ? 'selected' : '' }}>
                                                {{ $educationlevel->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Experience</label>
                                <div class="form-group">
                                    <select class="form-control select2-show-search" name="experiencelevel"
                                        data-placeholder="Select Contry">
                                        @foreach ($experiencelevels as $experience)
                                            <option value="{{ $experience->id }}"
                                                {{ $job->job_experience_id == $experience->id ? 'selected' : '' }}>
                                                {{ $experience->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    
                </div><!-- modal-body -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success" onclick="submitForm(event, {{ $job->id }});">Save </button>
                </div>
            </form>
        </div>
    </div><!-- modal-dialog -->
</div>
