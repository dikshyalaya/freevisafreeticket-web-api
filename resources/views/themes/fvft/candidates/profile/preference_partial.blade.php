<?php
$c_count = 0;
$jc_count = 0;
$jt_count = 0; //industry_count
?>
<div class="col-md-12">
    <div class="row">
        <div class="col-md-6">
            <h3 class="card-title">{{ strtoupper(__('Job Category')) }}</h3>
        </div>
        <div class="col-md-6 my-auto">
            <div class="form-group">
                <label class="custom-switch">
                    <input type="checkbox" name="job_notify" class="custom-switch-input"
                        {{ setParameter($employe, 'job_notify') ? 'checked' : '' }}>
                    <span class="custom-switch-indicator"></span>
                    <span class="custom-switch-description">{{ __('Notify me for job') }}</span>
                </label>
            </div>
        </div>
    </div>
    <div class="form-group">
        <input type="text" value="All Job Category" placeholder="{{ __('All Job Category') }}" name="all_category"
            class="form-control" readonly>
        <div class="font-weight-normal mt-2 ml-3">{{ __('Or Select your preferred job category') }}
        </div>
    </div>
    <span class="cur_sor my-auto" onclick="addCategoryRow()"><i
            class="fa fa-plus"></i>{{ __('Add Category') }}</span>
    @foreach ($employ->jobCategoryPreference as $key => $category_preference)
        <div class="row mt-2" id="catRow_{{ $jc_count }}">
            <div class="col-md-8">
                <select name="categories[]" data-placeholder="Select Job Category"
                    class="form-control select2-show-search">
                    <option value="">{{ __('Select Job Category') }}</option>
                    @foreach ($job_categories as $job_category)
                        <option value="{{ $job_category->id }}"
                            {{ !($job_category->id == $category_preference->id) ?: 'selected' }}>
                            {{ $job_category->functional_area }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 my-auto">
                <button type="button" class="btn btn-sm btn-danger"
                    onclick="removeRow('catRow_{{ $jc_count }}')">{{ __('Remove') }}</button>
            </div>
        </div>
        <?php
        $jc_count++;
        ?>
    @endforeach
    <input type="hidden" value="{{ $jc_count }}" id="jcCount">

    <div id="categoryAppend">

    </div>
    <hr>
    <h3 class="card-title">{{ strtoupper(__('Industry')) }}</h3>
    <div class="form-group">
        <input type="text" value="All Industry" placeholder="All Industry" name="all_industry" class="form-control"
            readonly>
        <div class="font-weight-normal mt-2 ml-3">{{ __('Or Add your preferred job industry') }}
        </div>
    </div>
    <span onclick="addJobRow();" class="cur_sor my-auto"><i
            class="fa fa-plus"></i>{{ __('Add Industry') }}</span>
    @foreach ($employe->industryPreference as $k => $industry_preference)
        <div class="row mt-2" id="jobRow_{{ $jt_count }}">
            <div class="col-md-8">
                <select name="industry[]" class="form-control select2-show-search" data-placeholder="Select Industry">
                    <option value="">Select Industry</option>
                    @foreach ($job_industries as $job_industry)
                        <option value="{{ $job_industry->id }}"
                            {{ $job_industry->id == $industry_preference->id ? 'selected' : '' }}>
                            {{ $job_industry->title }}</option>
                    @endforeach
                </select>

            </div>
            <div class="col-md-2 my-auto">
                <button type="button" class="btn btn-sm btn-danger"
                    onclick="removeRow('jobRow_{{ $jt_count }}')">{{ __('Remove') }}</button>
            </div>
        </div>
        <?php
        $jt_count++;
        ?>
    @endforeach
    <input type="hidden" value="{{ $jt_count }}" id="jt_count">
    <div id="jobTitleAppend">

    </div>
    <hr>
    <h3 class="card-title">{{ strtoupper(__('Country')) }}</h3>
    <div class="form-group">
        <input type="text" value="All Country" placeholder="All Country" name="all_country" class="form-control"
            readonly>
        <div class="font-weight-normal mt-2 ml-3">{{ __('Or Select your preferred country') }}
        </div>
    </div>
    <span class="cur_sor my-auto" onclick="addCountryRow();"><i
            class="fa fa-plus"></i>{{ __('Add Country') }}</span>
    @foreach ($employe->countryPreference as $a => $country_preference)
        <div class="row mt-2" id="countryRow_{{ $c_count }}">
            <div class="col-md-8">
                <select name="countries[]" data-placeholder="Select Country" class="form-control select2-show-search">
                    <option value="">{{ __('Select Country') }}</option>
                    @foreach ($countries as $country)
                        <option value="{{ $country->id }}"
                            {{ !($country->id == $country_preference->id) ?: 'selected' }}>
                            {{ $country->name }}
                        </option>
                    @endforeach
                </select>

            </div>
            <div class="col-md-2 my-auto">
                <button type="button" class="btn btn-sm btn-danger"
                    onclick="removeRow('countryRow_{{ $c_count }}')">{{ __('Remove') }}</button>
            </div>
        </div>
        <?php
        $c_count++;
        ?>
    @endforeach
    <input type="hidden" value="{{ $c_count }}" id="cCount">
    <div id="countryAppend">

    </div>
</div>
