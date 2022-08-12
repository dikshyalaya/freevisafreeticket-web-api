@extends('themes.fvft.company.layouts.dashmaster')
@section('css')
    <link href="{{ asset('themes/fvft/assets/plugins/fileuploads/css/dropify.css') }}" rel="stylesheet" type="text/css">
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <form action="" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Edit Job</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label class="form-label">Title</label>
                                    <input type="text" class="form-control text-dark" name="title" placeholder="Job Title"
                                        value="{{ old('title') }}" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Company</label>
                                    <input type="text" class="form-control" value="{{ $job->company->company_name }}">
                                    <input type="hidden" class="form-control text-dark" name="company_id"
                                        placeholder="Company" value="{{ $job->company_id }}" required>
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
                                    <textarea class="form-control" name="Bbenefits" rows="5"
                                        placeholder="Benefits.">{{ $job->benefits }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Number of Positions</label>
                                    <input type="number" class="form-control" value="{{ $job->num_of_positions }}" name="number-of-position"
                                        placeholder="Number of Positions">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Salary From</label>
                                    <input type="number" class="form-control" name="salary-from"
                                        placeholder="Salary From" value="{{$job->salary_from}}">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Salary To</label>
                                    <input type="number" class="form-control" name="salary-to" placeholder="Salary To" value="{{$job->salary_to}}">
                                </div>
                                <div class="form-group">
                                    <label class="custom-switch-checkbox">
                                        <input type="checkbox" name="is_featured" class="custom-switch-input" {{ $job->hide_salary ? 'checked' : '' }}>
                                        <span class="custom-switch-indicator"></span>
                                        <span class="custom-switch-description">Hide Salary</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label class="form-label">Featured Image</label>
                                    <input type="file" class="dropify" name="feature_image" value="{{$job->feature_image_url}}" data-height="180">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Country</label>

                                    <select name="country_id" id="select-country" class="form-control select2"
                                        value="{{ isset($job->country_id) ? $job->country_id : '' }}"
                                        onchange="patchStates(this)">
                                        @foreach ($countries as $item)
                                            <option value="{{ $item->id }}"
                                                {{ $item->id == $job->country_id ? 'selected' : '' }}>
                                                {{ $item->name }}</option>
                                        @endforeach

                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">States</label>

                                    <select name="state_id" id="select-state" class="form-control select2"
                                        value="{{ isset($job->state_id) ? $job->state_id : '' }}"
                                        onchange="patchCities(this)">
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Cities</label>

                                    <select name="city_id" id="select-city" class="form-control select2"
                                        value="{{ isset($job->city_id) ? $job->city_id : '' }}">
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="custom-switch-checkbox">
                                        <input type="checkbox" name="is_active" class="custom-switch-input" checked="">
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
                                    <label class="form-label">Job Category</label>
                                    <div class="form-group">
                                        <select class="form-control select2-show-search" name="category"
                                            data-placeholder="Select Category">
                                            @foreach ($job_categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->functional_area }}
                                                </option>
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
                                                <option value="{{ $shift->id }}">{{ $shift->job_shift }}</option>
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
                                                <option value="{{ $educationlevel->id }}">{{ $educationlevel->title }}
                                                </option>
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
                                                <option value="{{ $experience->id }}">{{ $experience->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <div class="d-flex">
                            <a href="/admin/companies/" class="btn btn-link">Cancel</a>
                            <button type="submit" class="btn btn-success ml-auto">Save </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{ asset('/') }}themes/fvft/assets/plugins/fileuploads/js/dropify.js"></script>
    <script src="/themes/fvft/assets/plugins/fileuploads/js/dropfy-custom.js"></script>
    <script src="{{ env('APP_URL') }}js/location.js"></script>
    <script>
        const _token = $('meta[name="csrf-token"]')[0].content;
        const state_id = {{ isset($company->state_id) ? $company->state_id : 'null' }};
        const city_id = {{ isset($company->city_id) ? $company->city_id : 'null' }};
        const appurl = "{{ env('APP_URL') }}";
    </script>
@endsection
