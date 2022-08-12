<div class="form-group">
    <div class="form-label">{{ __('Experience') }}</div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="">{{ __('Country') }}</label>
                <select name="country_id[]" class="form-control select2-show-search" data-placeholder="Select Country">
                    <option value="">{{ __('Select Country') }}</option>
                    @foreach ($countries as $country)
                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="">{{ __('Job Category') }}</label>
                <select name="job_category_id[]" class="form-control select2-show-search"
                    data-placeholder="Select Job Category">
                    <option value="">{{ __('Select Job Category') }}</option>
                    @foreach ($job_categories as $job_category)
                        <option value="{{ $job_category->id }}">
                            {{ $job_category->functional_area }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="">{{ __('Industry') }}</label>
                <select name="industry_id[]" class="form-control select2-show-search"
                    data-placeholder="Select Industry">
                    <option value="">{{ __('Select Industry') }}</option>
                    @foreach ($industries as $industry)
                        <option value="{{ $industry->id }}">{{ $industry->title }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="">{{ __('Working Duration') }}</label>
                <div class="row">
                    <div class="col-md-6">
                        <select name="working_year[]" class="form-control select2-show-search"
                            data-placeholder="Select Year">
                            <option value="">{{ __('Year') }}</option>
                            @for ($i = 0; $i <= 10; $i++)
                                <option value="{{ $i }}">{{ $i }}
                                </option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-6">
                        <select name="working_month[]" class="form-control select2-show-search" data-placeholder="Select Month">
                            <option value="">{{ __('Month') }}</option>
                            @for ($i = 0; $i <= 12; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
