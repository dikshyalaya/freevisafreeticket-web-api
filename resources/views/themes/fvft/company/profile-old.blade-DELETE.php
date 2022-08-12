@extends('themes.fvft.company.layouts.dashmaster')
@section('css')
    <link href="{{ asset('/') }}themes/fvft/assets/plugins/fileuploads/css/dropify.css" rel="stylesheet" type="text/css">
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <form action="/company/profile" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Update Profile</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label class="form-label">Company Name</label>
                                    <input type="text" class="form-control text-dark" name="company_name"
                                        placeholder="Company Name"
                                        value="{{ isset($company->company_name) ? $company->company_name : '' }}" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Company Phone</label>
                                    <input type="text" class="form-control text-dark" name="company_phone"
                                        placeholder="Company Phone"
                                        value="{{ isset($company->company_phone) ? $company->company_phone : '' }}" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Company Email</label>
                                    <input type="text" class="form-control text-dark" name="company_email"
                                        placeholder="Company Email"
                                        value="{{ isset($company->company_email) ? $company->company_email : '' }}" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Password</label>
                                    <input type="password" class="form-control text-dark" name="company_password"
                                        placeholder="Password" value="">
                                </div>




                                <div class="form-group">
                                    <label class="form-label">Company Ditails <span
                                            class="form-label-small">56/100</span></label>
                                    <textarea class="form-control text-dark" name="company_details" rows="7"
                                        placeholder="Company Ditails"
                                        >{{ isset($company->company_details) ? $company->company_details : '' }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Country</label>
                                    <select name="country_id" id="select-country" class="form-control select2  text-dark"
                                        value="{{ isset($company->country_id) ? $company->country_id : '' }}"
                                        onchange="patchStates(this)">
                                        @foreach ($countries as $item)
                                            <option value="{{ $item->id }}"
                                                {{ isset($company->country_id) ? ($item->id == $company->country_id ? 'selected' : '') : null }}>
                                                {{ $item->name }}</option>
                                        @endforeach

                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">States</label>
                                    <select name="state_id" id="select-state" class="form-control select2 text-dark"
                                        value="{{ isset($company->state_id) ? $company->state_id : '' }}"
                                        onchange="patchCities(this)">
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Cities</label>
                                    <select name="city_id" id="select-city" class="form-control select2 text-dark"
                                        value="{{ isset($company->city_id) ? $company->city_id : '' }}">
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="custom-switch-checkbox">
                                        <input type="checkbox" name="is_active" class="custom-switch-input"
                                            {{ isset($company->is_active) ? ($company->is_active ? 'checked' : '') : '' }}>
                                        <span class="custom-switch-indicator"></span>
                                        <span class="custom-switch-description">Active</span>
                                    </label>

                                </div>

                            </div>
                            <div class="col-md-6 col-lg-6">
                                <label class="form-label">Contact Person</label>
                                <input type="text" name="contact_person_id" style="display:none;"
                                    value="{{ isset($contact_person->id) ? $contact_person->id : '' }}">
                                <div class="form-group p-4">
                                    <div class="form-group">
                                        <label class="form-label">Name</label>
                                        <input type="text" class="form-control text-dark" name="contact_person_name"
                                            placeholder="Name"
                                            value="{{ isset($contact_person->name) ? $contact_person->name : '' }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Email</label>
                                        <input type="text" class="form-control text-dark" name="contact_person_email"
                                            placeholder="Email"
                                            value="{{ isset($contact_person->email) ? $contact_person->email : '' }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Phone</label>
                                        <input type="text" class="form-control text-dark" name="contact_person_phone"
                                            placeholder="Phone"
                                            value="{{ isset($contact_person->phone) ? $contact_person->phone : '' }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Position</label>
                                        <input type="text" class="form-control text-dark" name="contact_person_position"
                                            placeholder="Position"
                                            value="{{ isset($contact_person->position) ? $contact_person->position : '' }}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Company Logo</label>
                                    <input type="file" class="dropify" name="company_logo" data-height="180"
                                        data-default-file="{{ isset($company->company_logo) ? env('APP_URL') . $company->company_logo : '' }}">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Company Banner</label>
                                    <input type="file" class="dropify" name="company_cover" data-height="180"
                                        data-default-file="{{ isset($company->company_cover) ? env('APP_URL') . $company->company_cover : '' }}">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Street Address</label>
                                    <input type="text" class="form-control text-dark" name="company_address"
                                        placeholder="Street Address"
                                        value="{{ isset($company->company_address) ? $company->company_address : '' }}">
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
