<div class="row">
    <div class="col-md-6">
        <select name="language[]" class="form-control select2-show-search" data-placeholder="Select Language">
            <option value="">Select Language</option>
            @foreach ($languages as $language)
                <option value="{{ $language->id }}">{{ $language->lang }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6">
        <select name="language_level[]" class="form-control select2-show-search" data-placeholder="Select Level">
            <option value="">Select Level</option>
            <option value="Very Good">Very Good</option>
            <option value="Good">Good</option>
            <option value="Fair">Fair</option>
        </select>
    </div>
</div>
