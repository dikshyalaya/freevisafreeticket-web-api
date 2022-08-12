<?php
$c_count = 0;
$jc_count = 0;
$jt_count = 0; //industry_count
?>
<h3 class="card-title">{{ strtoupper(__('Country')) }}</h3>
<div class="form-group">
    <input type="text" value="All Country" placeholder="All Country" name="all_country" class="form-control"
           readonly>
    <div class="font-weight-normal mt-2 ml-3">{{ __('Or Select your preferred country') }}
    </div>
</div>
@foreach ($employe->countryPreference as $a => $country_preference)
    @if ($loop->first)
        <div class="row" id="countryRow_{{ $c_count }}">
            <div class="col-md-8">
                <select name="countries[]" data-placeholder="Select Country"
                        class="form-control country select2-show-search">
                    <option value="">{{ __('Select Country') }}</option>
                    @foreach ($countries as $country)
                        <option value="{{ $country->id }}"
                            {{ !($country->id == $country_preference->id) ?: 'selected' }}>
                            {{ $country->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                    <span class="cur_sor my-auto" onclick="addCountryRow();"><i
                            class="fa fa-plus"></i>{{ __('Add') }}</span>
            </div>
        </div>
    @else
        <div class="row mt-2" id="countryRow_{{ $c_count }}">
            <div class="col-md-8">
                <select name="countries[]" data-placeholder="Select Country"
                        class="form-control select2-show-search">
                    <option value="">{{ __('Select Country') }}</option>
                    @foreach ($countries as $country)
                        <option value="{{ $country->id }}"
                            {{ !($country->id == $country_preference->id) ?: 'selected' }}>
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
