<?php
$c_count = 0;
$jc_count = 0;
$jt_count = 0; //industry_count
?>
<h3 class="card-title">{{ strtoupper(__('Industry')) }}</h3>
<div class="form-group">
    <input type="text" value="All Industry" placeholder="All Industry" name="all_industry" class="form-control"
           readonly>
    <div class="font-weight-normal mt-2 ml-3">{{ __('Or Add your preferred job industry') }}
    </div>
</div>
@foreach ($employe->industryPreference as $k => $industry_preference)
    @if ($loop->first)
        <div class="row" id="jobRow_{{ $jt_count }}">
            <div class="col-md-8">
                <select name="industry[]" class="form-control select2-show-search">
                    <option value="">Select Industry</option>
                    @foreach ($job_industries as $job_industry)
                        <option value="{{ $job_industry->id }}"
                            {{ $job_industry->id == $industry_preference->id ? 'selected' : '' }}>
                            {{ $job_industry->title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                    <span onclick="addJobRow();" class="cur_sor my-auto"><i
                            class="fa fa-plus"></i>{{ __('Add') }}</span>
            </div>
        </div>
    @else
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
    @endif
    <?php
    $jt_count++;
    ?>
@endforeach
<input type="hidden" value="{{ $jt_count }}" id="jt_count">
<div id="jobTitleAppend">

</div>
