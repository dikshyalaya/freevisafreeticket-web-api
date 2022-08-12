@extends('admin.layouts.master')
@section('main')
    {{-- @dd($company?$company); --}}
    <div class="page-header">
        <h4 class="page-title">{{ $action }} Company</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Modules</a></li>
            <li class="breadcrumb-item" aria-current="page"><a href="/admin/companies/">Company</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add</li>
        </ol>
    </div>

    <div class="row">
        <div class="col-12">
            <form action="/admin/companies/save" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">New Company</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 col-lg-6">
                                <input type="text" name="company_id" style="display:none;"
                                    value="{{ isset($company->id) ? $company->id : '' }}">
                                <input type="text" name="company_user_id" style="display:none;"
                                    value="{{ isset($company->user_id) ? $company->user_id : '' }}">
                                <div class="form-group">
                                    <label class="form-label">Company Name</label>
                                    <input type="text" class="form-control" name="company_name" placeholder="Company Name"
                                        value="{{ isset($company->company_name) ? $company->company_name : '' }}"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Company Phone</label>
                                    <input type="text" class="form-control" name="company_phone"
                                        placeholder="Company Phone"
                                        value="{{ isset($company->company_phone) ? $company->company_phone : '' }}"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Company Email</label>
                                    <input type="text" class="form-control" name="company_email"
                                        placeholder="Company Email"
                                        value="{{ isset($company->company_email) ? $company->company_email : '' }}"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Password</label>
                                    <input type="password" class="form-control" name="company_password"
                                        placeholder="Password" value=""
                                        {{ request()->route()->getName() == 'admin.companies.edit'? '': 'required' }}>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Industry</label>
                                    <div class="form-group">
                                        <select class="form-control select2-show-search" data-placeholder="Select Industry"
                                            name="industry_id">
                                            @foreach ($industries as $industry)
                                                <option value="{{ $industry->id }}"
                                                    {{ isset($company->industry_id) ? ($industry->id == $company->industry_id ? 'selected' : '') : '' }}>
                                                    {{ $industry->title }}</option>
                                            @endforeach
                                        </select>
                                        {{-- <select class="form-control select2-show-search" data-placeholder="Select Industry"
                                            name="industry_id"
                                            value="{{ isset($company->industry_id) ? $company->industry_id : '' }}">
                                            @foreach ($industries as $industry)
                                                <option value="{{ $industry->id }}">{{ $industry->title }}</option>
                                            @endforeach
                                        </select> --}}
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label class="form-label">Company Ditails <span
                                            class="form-label-small">56/100</span></label>
                                    <textarea class="form-control" name="company_details" rows="7"
                                        placeholder="Company Ditails"
                                        required>{{ isset($company->company_details) ? $company->company_details : '' }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Country</label>
                                    <select name="country_id" id="select-country" class="form-control select2"
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
                                    <select name="state_id" id="select-state" class="form-control select2"
                                        value="{{ isset($company->state_id) ? $company->state_id : '' }}"
                                        onchange="patchCities(this)">
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Cities</label>
                                    <select name="city_id" id="select-city" class="form-control select2"
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
                                    <label class="custom-switch-checkbox">
                                        <input type="checkbox" name="is_featured" class="custom-switch-input"
                                            {{ isset($company->is_featured) ? ($company->is_featured ? 'checked' : '') : '' }}>
                                        <span class="custom-switch-indicator"></span>
                                        <span class="custom-switch-description">Featured</span>
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
                                        <input type="text" class="form-control" name="contact_person_name"
                                            placeholder="Name"
                                            value="{{ isset($contact_person->name) ? $contact_person->name : '' }}"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Email</label>
                                        <input type="text" class="form-control" name="contact_person_email"
                                            placeholder="Email"
                                            value="{{ isset($contact_person->email) ? $contact_person->email : '' }}"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Phone</label>
                                        <input type="text" class="form-control" name="contact_person_phone"
                                            placeholder="Phone"
                                            value="{{ isset($contact_person->phone) ? $contact_person->phone : '' }}"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Position</label>
                                        <input type="text" class="form-control" name="contact_person_position"
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
                                    <input type="text" class="form-control" name="company_address"
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
@section('script')
    <script src="{{ env('APP_URL') }}js/location.js"></script>
    <script>
        const _token = $('meta[name="csrf-token"]')[0].content;
        const state_id = {{ isset($company->state_id) ? $company->state_id : 'null' }};
        const city_id = {{ isset($company->city_id) ? $company->city_id : 'null' }};
        const appurl = "{{ env('APP_URL') }}";
    </script>
@endsection
