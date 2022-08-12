<?php
$c_count = 0;
$jc_count = 0;
$jt_count = 0; //industry_count
?>
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

@foreach ($employ->jobCategoryPreference as $key => $category_preference)
    @if ($loop->first)
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
            <div class="col-md-2">
                    <span class="cur_sor my-auto" onclick="addCategoryRow()"><i
                            class="fa fa-plus"></i>{{ __('Add') }}</span>
            </div>
        </div>
    @else
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
    @endif
    <?php
    $jc_count++;
    ?>
@endforeach
<input type="hidden" value="{{ $jc_count }}" id="jcCount">

<div id="categoryAppend"></div>
