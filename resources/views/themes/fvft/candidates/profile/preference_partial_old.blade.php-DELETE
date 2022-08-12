<?php
$c_count = 0;
$jc_count = 0;
$jt_count = 0;
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
    @foreach ($employe->job_preferences->whereNotNull('job_category_id') as $key => $job_preference)
        @if ($loop->first)
            <div class="row mt-2" id="catRow_{{ $jc_count }}">
                <div class="col-md-2">
                    <span class="cur_sor my-auto" onclick="addCategoryRow()"><i
                            class="fa fa-plus"></i>{{ __('Add') }}</span>
                </div>
                <div class="col-md-8">
                    <select name="categories[]" data-placeholder="Select Job Category"
                        class="form-control select2-show-search">
                        <option value="">{{ __('Select Job Category') }}</option>
                        @foreach ($job_categories as $job_category)
                            <option value="{{ $job_category->id }}"
                                {{ !($job_category->id == $job_preference->job_category_id) ?: 'selected' }}>
                                {{ $job_category->functional_area }}</option>
                        @endforeach
                    </select>

                </div>
            </div>
        @else
            <div class="row mt-2" id="catRow_{{ $jc_count }}">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <select name="categories[]" data-placeholder="Select Job Category"
                        class="form-control select2-show-search">
                        <option value="">{{ __('Select Job Category') }}</option>
                        @foreach ($job_categories as $job_category)
                            <option value="{{ $job_category->id }}"
                                {{ !($job_category->id == $job_preference->job_category_id) ?: 'selected' }}>
                                {{ $job_category->functional_area }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 my-auto">
                    <button type="button" class="btn btn-sm btn-danger"
                        onclick="removeRow('catRow_{{ $jc_count }}')">{{ __('Remove') }}</button>
                </div>
            </div>
        @endif
        <?php
        $jc_count++;
        ?>
    @endforeach
    <input type="hidden" value="{{ $jc_count }}" id="jcCount">

    <div id="categoryAppend">

    </div>
    <hr>
    <h3 class="card-title">{{ strtoupper(__('Job Title')) }}</h3>
    <div class="form-group">
        <input type="text" value="All Job Title" placeholder="All Job Title" name="all_job_title" class="form-control"
            readonly>
        <div class="font-weight-normal mt-2 ml-3">{{ __('Or Add your preferred job title') }}
        </div>
    </div>
    @foreach ($employe->job_preferences->whereNotNull('job_title') as $k => $job_preference)
        @if ($loop->first)
            <div class="row" id="jobRow_{{ $jt_count }}">
                <div class="col-md-2">
                    <span onclick="addJobRow();" class="cur_sor my-auto"><i
                            class="fa fa-plus"></i>{{ __('Add') }}</span>
                </div>
                <div class="col-md-8">
                    <input type="text" class="form-control" value="{{ $job_preference->job_title }}"
                        name="job_title[]" placeholder="Enter Job Title">

                </div>
            </div>
        @else
            <div class="row mt-2" id="jobRow_{{ $jt_count }}">
                <div class="col-md-2">

                </div>
                <div class="col-md-8">
                    <input type="text" class="form-control" name="job_title[]" value="{{ $job_preference->job_title }}" placeholder="Enter Job Title">

                </div>
                <div class="col-md-2 my-auto">
                    <button type="button" class="btn btn-sm btn-danger"
                        onclick="removeRow('jobRow_{{ $jt_count }}')">{{ __('Remove') }}</button>
                </div>
            </div>
        @endif
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
    @foreach ($employe->job_preferences->whereNotNull('country_id') as $a => $job_preference)
        @if ($loop->first)
            <div class="row" id="countryRow_{{ $c_count }}">
                <div class="col-md-2">
                    <span class="cur_sor my-auto" onclick="addCountryRow();"><i
                            class="fa fa-plus"></i>{{ __('Add') }}</span>
                </div>
                <div class="col-md-8">
                    <select name="countries[]" data-placeholder="Select Country"
                        class="form-control select2-show-search">
                        <option value="">{{ __('Select Country') }}</option>
                        @foreach ($countries as $country)
                            <option value="{{ $country->id }}"
                                {{ !($country->id == $job_preference->country_id) ?: 'selected' }}>
                                {{ $country->name }}
                            </option>
                        @endforeach
                    </select>

                </div>
            </div>
        @else
            <div class="row mt-2" id="countryRow_{{ $c_count }}">
                <div class="col-md-2">

                </div>
                <div class="col-md-8">
                    <select name="countries[]" data-placeholder="Select Country"
                        class="form-control select2-show-search">
                        <option value="">{{ __('Select Country') }}</option>
                        @foreach ($countries as $country)
                            <option value="{{ $country->id }}"
                                {{ !($country->id == $job_preference->country_id) ?: 'selected' }}>
                                {{ $country->name }}
                            </option>
                        @endforeach
                    </select>

                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-sm btn-danger"
                        onclick="removeRow('countryRow_{{ $c_count }}')">{{ __('Remove') }}</button>
                </div>
            </div>
        @endif
        <?php
        $c_count++;
        ?>
    @endforeach
    <input type="hidden" value="{{ $c_count }}" id="cCount">
    <div id="countryAppend">

    </div>
</div>
