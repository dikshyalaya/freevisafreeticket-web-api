<div class="form-group">
    <label for="" class="form-label">{{ __('Experience') }}</label>
</div>
<div class="form-group">
    <div class="row">
        <div class="col-md-4">
            <label for="">{{ __('Country') }}</label>
        </div>
        <div class="col-md-8">
            <select name="country_id[]" class="form-control select2-show-search" data-placeholder="Select Country" id="">
                <option value="">Select Country</option>
                @foreach ($countries as $country)
                    <option value="{{ $country->id }}" {{ $country->id == $defaultCountryId ? 'selected' : '' }}>{{ $country->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
<div class="form-group">
    <div class="row">
        <div class="col-md-4">
            <label for="">{{ __('Job Category') }}</label>
        </div>
        <div class="col-md-8">
            <select name="job_category_id[]" class="form-control select2-show-search"
                data-placeholder="Select Job Category" id="">
                <option value="">Select Job Category</option>
                @foreach ($job_categories as $job_category)
                    <option value="{{ $job_category->id }}">
                        {{ $job_category->functional_area }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
<div class="form-group">
    <div class="row">
        <div class="col-md-4">
            <label for="">{{ __('Industry') }}</label>
        </div>
        <div class="col-md-8">
            <select name="industry_id[]" class="form-control select2-show-search" data-placeholder="Select Industry"
                id="">
                <option value="">Select Industry</option>
                @foreach ($industries as $industry)
                    <option value="{{ $industry->id }}">{{ $industry->title }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
<div class="form-group">
    <div class="row">
        <div class="col-md-4">
            <label for="">Working Duration</label>
        </div>
        <div class="col-md-4">
            <select name="working_year[]" class="form-control select2" id="">
                <option value="">Year</option>
                @for ($i = 0; $i <= 10; $i++)
                    <option value="{{ $i }}">
                        {{ $i }}</option>
                @endfor
            </select>
        </div>
        <div class="col-md-4">
            <select name="working_month[]" class="form-control select2" id="">
                <option value="">Month</option>
                @for ($i = 0; $i <= 12; $i++)
                    <option value="{{ $i }}">
                        {{ $i }}</option>
                @endfor
            </select>
        </div>
    </div>
</div>
