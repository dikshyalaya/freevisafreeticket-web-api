<div class="row">
    <div class="col-xl-6">
        <div class="row">
            <div class="card m-b-20">
                <div class="card-header">
                    <h3 class="card-title tempcolor">{{ strtoupper('Job Details') }}</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="title" class="form-label">Job Title&nbsp;<span
                                        class="req">*</span></label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" name="title" value="{{ $job->title }}" class="form-control"
                                    placeholder="Enter Job Title">
                                <div class="require text-danger title"></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="company" class="form-label">Company Name&nbsp;<span
                                        class="req">*</span></label>
                            </div>
                            <div class="col-md-8">
                                <select name="company_id" class="form-control select2">
                                    <option value="">Select Company</option>
                                    @foreach ($companies as $company)
                                        <option value="{{ $company->id }}"
                                            {{ isset($job->company_id) && $job->company_id == $company->id ? 'selected' : '' }}>
                                            {{ $company->company_name }}</option>
                                    @endforeach
                                </select>
                                <div class="require text-danger company_id"></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="no_of_employee" class="form-label">No of Employee&nbsp;<span
                                        class="req">*</span></label>
                            </div>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="male_employee" class="form-label">Male</label>
                                        <input type="number" min="1" oninput="preventNegativeNo($(this));"
                                            class="form-control" value="{{ $job->no_of_male }}" name="male_employee"
                                            placeholder="Enter number">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="female_employee" class="form-label">Female</label>
                                        <input type="number" min="1" oninput="preventNegativeNo($(this));"
                                            class="form-control" value="{{ $job->no_of_female }}"
                                            name="female_employee" placeholder="Enter number">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="any_employee" class="form-label">Any</label>
                                        <input type="number" min="1" oninput="preventNegativeNo($(this));"
                                            class="form-control" name="any_employee" value="{{ $job->any_gender }}"
                                            placeholder="Enter number">
                                    </div>
                                </div>
                                <div class="require text-danger male_employee"></div>
                                <div class="require text-danger female_employee"></div>
                                <div class="require text-danger any_employee"></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="job_category" class="form-label">Job Category&nbsp;<span
                                        class="req"></span></label>
                            </div>
                            <div class="col-md-8">
                                <select name="category_id" class="form-control select2-show-search">
                                    <option value="">Select Job Category</option>
                                    @foreach ($job_categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ $job->job_categories_id == $category->id ? 'selected' : '' }}>
                                            {{ $category->functional_area }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="require text-danger category_id"></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="working_hours" class="form-label">Working Hours Per Day&nbsp;<span
                                        class="req">*</span></label>
                            </div>
                            <div class="col-md-8">
                                <div class="input-group">
                                    <input type="number" min="1" oninput="preventNegativeNo($(this));"
                                        value="{{ $job->working_hours }}" class="form-control" name="working_hours"
                                        placeholder="eg, 8">
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-primary">In Hour(/hr)</button>
                                    </div>
                                </div>
                                <div class="require text-danger working_hour"></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="working_days" class="form-label">Working Days Per Week&nbsp;<span
                                        class="req">*</span></label>
                            </div>
                            <div class="col-md-8">
                                <div class="input-group">
                                    <input type="number" min="1" oninput="preventNegativeNo($(this));"
                                        value="{{ $job->working_days }}" class="form-control" name="working_days"
                                        placeholder="eg, 5">
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-primary">Days</button>
                                    </div>
                                </div>
                                <div class="require text-danger working_days"></div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="deadline" class="form-label">Apply Before</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" name="deadline"
                                    value="{{ $job->expiry_date != null ? date('Y-m-d', strtotime($job->expiry_date)) : '' }}"
                                    class="form-control datetime" readonly>
                                <div class="require text-danger deadline"></div>
                            </div>
                        </div>
                    </div>
                    @if ($job->draft_status == 0)
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="form-label" for="status">Status</label>
                                </div>
                                <div class="col-md-8">
                                    @php
                                        $statuses = ['Draft', 'Pending', 'Active', 'Approved', 'Not Approved', 'Published', 'Unpublished', 'Expired', 'Rejected'];
                                        // $statuses = ['Approved' => 'Approved', 'Not Approved' => 'Not Approved'];
                                    @endphp
                                    <select name="job_status" class="form-control select2">
                                        <option value="">Select Status</option>
                                        @foreach ($statuses as $key => $value)
                                            <option value="{{ $value }}" {{ $job->status == $value ? 'selected' : '' }}>{{ $value }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="require text-danger job_status"></div>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <label class="form-label">Country&nbsp;<span class="req">*</span></label>
                            </div>
                            <div class="col-md-8">
                                <select name="country" id="select-country" class="form-control select2-show-search"
                                    value="{{ isset($job->country_id) ? $job->country_id : '' }}"
                                    onchange="patchStates(this)">
                                    @foreach ($countries as $item)
                                        <option value="{{ $item->id }}" data-name="{{ $item->currency_name }}"
                                            {{ isset($job->country_id) ? ($item->id == $job->country_id ? 'selected' : '') : null }}>
                                            {{ $item->name }}</option>
                                    @endforeach

                                </select>
                                <div class="require text-danger country"></div>
                            </div>
                        </div>

                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <label class="form-label">States&nbsp;<span class="req">*</span></label>
                            </div>
                            <div class="col-md-8">
                                <select name="state" id="select-state" class="form-control select2-show-search"
                                    value="{{ isset($job->state_id) ? $job->state_id : '' }}"
                                    onchange="patchCities(this)">
                                </select>
                                <div class="require text-danger state"></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <label class="form-label">Cities&nbsp;<span
                                        class="req">*</span></label>
                            </div>
                            <div class="col-md-8">
                                <select name="city_id" id="select-city" class="form-control select2-show-search"
                                    value="{{ isset($job->city_id) ? $job->city_id : '' }}">
                                </select>
                                <div class="require text-danger city_id"></div>
                            </div>
                        </div>

                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="contract" class="form-label">Contract Period&nbsp;<span
                                        class="req">*</span></label>
                            </div>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-6">
                                        <select name="contract_year" class="form-control select2">
                                            <option value="">Select Year</option>
                                            @for ($i = 1; $i <= 10; $i++)
                                                <option value="{{ $i }}"
                                                    {{ $i == $job->contract_year ? 'selected' : '' }}>
                                                    {{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <select name="contract_month" class="form-control select2">
                                            <option value="">Select Month</option>
                                            @for ($i = 0; $i <= 12; $i++)
                                                <option value="{{ $i }}"
                                                    {{ $i == $job->contract_month ? 'selected' : '' }}>
                                                    {{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                                {{-- <textarea name="contract_description" class="form-control mt-3" cols="10"
                                    rows="5">{{ $job->contract_description }}</textarea> --}}
                            </div>
                            <div class="require text-danger contract_year"></div>
                            <div class="require text-danger contract_month"></div>
                            {{-- <div class="require text-danger contract_description"></div> --}}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="job_description" class="form-label">Job Description</label>
                            </div>
                            <div class="col-md-8">
                                <input type="hidden" class="form-control" value="{{ $job->description }}"
                                    name="job_description" id="jobdescriptionID">
                                <input type="hidden" class="form-control" value="{{ $job->description_intro }}"
                                    name="job_description_intro" id="job_description_intro">
                                <div id="JobDescription" style="min-height: 15rem;">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        {{-- <label class="custom-switch-checkbox">
                            <input type="checkbox" name="is_active" class="custom-switch-input"
                                {{ $job->is_active == 1 ? 'checked' : '' }}>
                            <span class="custom-switch-indicator"></span>
                            <span class="custom-switch-description">Active</span>
                        </label> --}}
                        <label class="custom-switch-checkbox">
                            <input type="checkbox" name="is_featured" class="custom-switch-input"
                                {{ $job->is_featured == 1 ? 'checked' : '' }}>
                            <span class="custom-switch-indicator"></span>
                            <span class="custom-switch-description">Featured</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="card m-b-20">
                <div class="card-header">
                    <h3 class="card-title tempcolor">{{ strtoupper('Salary Facility') }}</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="salary" class="form-label">Basic Salary&nbsp;<span
                                        class="req">*</span></label>
                            </div>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <input type="text" name="country_salary"
                                                    value="{{ $job->country_salary }}" class="form-control">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="" class="form-label countrylabel">USD</label>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md-8">
                                                <input type="text" name="nepali_salary"
                                                    value="{{ $job->nepali_salary }}" class="form-control">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="" class="form-label">NPR</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="require text-danger country_salary"></div>
                                    <div class="require text-danger nepali_salary"></div>
                                </div>
                                <div class="form-group mt-2">
                                    <label class="custom-switch-checkbox">
                                        <input type="checkbox" name="hide_salary" class="custom-switch-input"
                                            {{ $job->hide_salary == 1 ? 'checked' : '' }}>
                                        <span class="custom-switch-indicator"></span>
                                        <span class="custom-switch-description">Hide Salary</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="salary" class="form-label">Average Earnings&nbsp;<span
                                        class="req">*</span></label>
                            </div>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <input type="text" name="earning_country_salary"
                                                    value="{{ $job->earning_country_salary }}" class="form-control">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="" class="form-label countrylabel">USD</label>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md-8">
                                                <input type="text" name="earning_nepali_salary"
                                                    value="{{ $job->earning_nepali_salary }}" class="form-control">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="" class="form-label countrylabel">NPR</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="require text-danger earning_country_salary"></div>
                                    <div class="require text-danger earning_nepali_salary"></div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="accomodation" class="form-label">Accommodation&nbsp;<span
                                        class="req">*</span></label>
                            </div>
                            <div class="col-md-8">
                                <select name="accomodation" class="form-control select2">
                                    <option value="">Select</option>
                                    <option value="1" {{ $job->accomodation == 1 ? 'selected' : '' }}>Yes</option>
                                    <option value="0" {{ $job->accomodation == 0 ? 'selected' : '' }}>No</option>
                                </select>
                                <div class="require text-danger accomodation"></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="food" class="form-label">Food&nbsp;<span
                                        class="req">*</span></label>
                            </div>
                            <div class="col-md-8">
                                <select name="food" class="form-control select2">
                                    <option value="">Select</option>
                                    <option value="1" {{ $job->food == 1 ? 'selected' : '' }}>Yes</option>
                                    <option value="0" {{ $job->food == 0 ? 'selected' : '' }}>No</option>
                                </select>
                                <div class="require text-danger food"></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="annual_vacation" class="form-label">Annual Vacation&nbsp;<span
                                        class="req">*</span></label>
                            </div>
                            <div class="col-md-8">
                                <select name="annual_vacation" class="form-control select2">
                                    <option value="">Select</option>
                                    <option value="1" {{ $job->annual_vacation == 1 ? 'selected' : '' }}>Yes</option>
                                    <option value="0" {{ $job->annual_vacation == 0 ? 'selected' : '' }}>No</option>
                                </select>
                                <div class="require text-danger annual_vacation"></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="over_time" class="form-label">Over Time&nbsp;<span
                                        class="req">*</span></label>
                            </div>
                            <div class="col-md-8">
                                <select name="over_time" class="form-control select2">
                                    <option value="">Select</option>
                                    <option value="1" {{ $job->over_time == 1 ? 'selected' : '' }}>Yes</option>
                                    <option value="0" {{ $job->over_time == 0 ? 'selected' : '' }}>No</option>
                                </select>
                                <div class="require text-danger over_time"></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="requirements" class="form-label">Other Benefits</label>
                            </div>
                            <div class="col-md-8">
                                <input type="hidden" class="form-control" name="other_benefits"
                                    value="{{ $job->benefits }}" id="benefitID">
                                <input type="hidden" class="form-control" name="benefit_intro" id="benefit_intro"
                                    value="{{ $job->benefit_intro }}">
                                <div id="benefitEditor" style="min-height: 15rem;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-6">
        <div class="row ml-2">
            <div class="card m-b-20">
                <div class="card-header">
                    <h3 class="card-title tempcolor">{{ strtoupper('Applicant Qualification') }}</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="education_level" class="form-label">Minimum Qualification&nbsp;<span
                                        class="req">*</span></label>
                            </div>
                            <div class="col-md-8">
                                <select name="education_level" class="form-contorl select2-show-search">
                                    <option value="">Select Qualification</option>
                                    @foreach ($educationlevels as $educationlevel)
                                        <option value="{{ $educationlevel->id }}"
                                            {{ $job->education_level_id == $educationlevel->id ? 'selected' : '' }}>
                                            {{ $educationlevel->title }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="require text-danger education_level"></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="year_of_experience" class="form-label">Year of Experience</label>
                            </div>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-6">
                                        <select name="min_experience" class="form-control select2">
                                            <option value="">Min</option>
                                            @for ($i = 0; $i <= 10; $i++)
                                                <option value="{{ $i }}"
                                                    {{ $i == $job->min_experience ? 'selected' : '' }}>
                                                    {{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <select name="max_experience" class="form-control select2">
                                            <option value="">Max</option>
                                            @for ($i = 1; $i <= 15; $i++)
                                                <option value="{{ $i }}"
                                                    {{ $i == $job->max_experience ? 'selected' : '' }}>
                                                    {{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                                <div class="require text-danger min_experience"></div>
                                <div class="require text-danger max_experience"></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="age_requirement" class="form-label">Age Requirement</label>
                            </div>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-6">
                                        <select name="min_age" class="form-control select2">
                                            <option value="">Min</option>
                                            @for ($i = 18; $i <= 25; $i++)
                                                <option value="{{ $i }}"
                                                    {{ $i == $job->min_age ? 'selected' : '' }}>{{ $i }}
                                                </option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <select name="max_age" class="form-control select2">
                                            <option value="">Max</option>
                                            @for ($i = 18; $i <= 50; $i++)
                                                <option value="{{ $i }}"
                                                    {{ $i == $job->max_age ? 'selected' : '' }}>{{ $i }}
                                                </option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                                <div class="require text-danger max_age"></div>
                                <div class="require text-danger min_age"></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="skils" class="form-label">Skills</label>
                            </div>
                            <div class="col-md-8">
                                <select name="skills[]" class="form-control select2" multiple="multiple">
                                    @foreach ($skills as $skill)
                                        <option value="{{ $skill->id }}"
                                            {{ json_decode($job->skills, true) != null && in_array($skill->id, json_decode($job->skills, true))? 'selected': '' }}>
                                            {{ $skill->title }}</option>
                                    @endforeach
                                </select>
                                <div class="require text-danger skills"></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="requirements" class="form-label">Other Requirements</label>
                            </div>
                            <div class="col-md-8">
                                <input type="hidden" class="form-control" name="other_requirements"
                                    id="requirementID" value="{{ $job->requirements }}">
                                <input type="hidden" class="form-control" name="requirement_intro"
                                    id="requirement_intro" value="{{ $job->requirement_intro }}">
                                <div id="editor" style="min-height: 15rem;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row ml-2">
            <div class="card m-b-20">
                <div class="card-header">
                    <h3 class="card-title tempcolor">{{ strtoupper('Picture') }}</h3>
                </div>
                <div class="card-body">
                    {{-- <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="" class="form-label">Upload Picture(Max Number is 5)</label>
                            </div>
                            <div class="col-md-8">
                                <input type="file" class="form-control dropify" name="picture[]"
                                    data-allowed-file-extensions="png jpg jpeg" id="Picture" multiple>
                                <div class="require text-danger picture"></div>
                            </div>
                        </div>
                    </div> --}}
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="" class="form-label">Upload Featured Image</label>
                            </div>
                            <div class="col-md-8">
                                <input type="file" class="form-control dropify"
                                    data-default-file="{{ asset($job->feature_image_url) }}" name="feature_image"
                                    data-allowed-file-extensions="png jpg jpeg">
                                <div class="require text-danger feature_image"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mr-auto">
            <button type="button" onclick="submitForm(event);" class="btn btn-primary ml-3">Submit</button>
        </div>
    </div>
</div>
<div class="row mb-5">
    <div class="mx-auto">

    </div>
</div>
