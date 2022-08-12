<div class="row">
    <div class="col-md-12">
        <div class="card m-b-20">
            <div class="card-header">
                @if (Request::is('company/profile'))
                    <div class="col-md-6 pl-0">
                        <h3 class="card-title">{{ strtoupper(__('Picture')) }}</h3>
                    </div>
                    <div class="col-md-6 pr-0">
                        <a href="{{ $viewRoute }}" class="float-right tempcolor" style="position:absolute; right: -5px;top: -8px;">&nbsp;{{ __('View Profile') }}</a>
                    </div>
                @else
                    <h3 class="card-title">{{ strtoupper(__('Picture')) }}</h3>
                @endif


            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-xl-4">
                        <div class="form-group company_logo" id="company_logo">
                            <label for="">{{ __('Display') }} {{ __('Picture') }}</label>
                            <input type="file" name="company_logo"
                                   data-delete-url="{{ route('company.remove_image') }}"
                                   data-company-id="{{ $company->id }}"
                                   data-default-file="{{ $company->company_logo ? asset($company->company_logo) : '' }}"
                                   class="custom-dropify" data-allowed-file-extensions="png jpg jpeg" data-height="180">
                            <div class="require text-danger profile_picture"></div>
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <div class="form-group company_logo">
                            <label for="">{{ __('Cover') }} {{ __('Picture') }}</label>
                            <input type="file" name="company_cover"
                                   data-delete-url="{{ route('company.remove_image') }}"
                                   data-company-id="{{ $company->id }}"
                                   data-default-file="{{ $company->company_cover ? asset($company->company_cover) : '' }}"
                                   class="custom-dropify" data-height="180" data-allowed-file-extensions="png jpg jpeg">
                            <div class="require text-danger company_cover"></div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <button type="button" class="btn btn-primary float-right text-center"
                                onclick="submitForm(event);">{{ __('Update') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xl-12">
        <div class="card m-b-20">
            <div class="card-header">
                <h3 class="card-title">{{ strtoupper(__('Basic Information')) }}</h3>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label class="form-label" for="company_name">{{ __('Company Name') }}&nbsp;<span
                                    class="req">*</span></label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" value="{{ $company->company_name }}"
                                   name="company_name" placeholder="Enter Company Name">
                            <div class="require text-danger company_name"></div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="industry_category">{{ __('Industry') }}&nbsp;<span
                                    class="req">*</span></label>
                        </div>
                        <div class="col-md-8">
                            <select name="industry_id" class="form-control select2-show-search" data-placeholder="Select Industry">
                                <option value="">{{ __('Select Industry') }}</option>
                                @foreach ($industries as $industry)
                                    <option value="{{ $industry->id }}"
                                        {{ $industry->id == $company->industry_id ? 'selected' : '' }}>
                                        {{ $industry->title }}</option>
                                @endforeach
                            </select>
                            <div class="require text-danger industry_id"></div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="ownership">{{ __('Ownership') }}&nbsp;<span
                                    class="req">*</span></label>
                        </div>
                        <div class="col-md-8">
                            <select name="ownership" class="form-control select2">
                                <option value="">{{ __('Select Ownership') }}</option>
                                <option value="Private" {{ $company->ownership == 'Private' ? 'selected' : '' }}>
                                    {{ __('Private') }}</option>
                                <option value="Public" {{ $company->ownership == 'Public' ? 'selected' : '' }}>
                                    {{ __('Public') }}</option>
                                <option value="Government"
                                    {{ $company->ownership == 'Government' ? 'selected' : '' }}>
                                    {{ __('Government') }}
                                </option>
                                <option value="Non Profit"
                                    {{ $company->ownership == 'Non Profit' ? 'selected' : '' }}>
                                    {{ __('Non Profit') }}
                                </option>
                                <option value="Recruitment Agency"
                                    {{ $company->ownership == 'Recruitment Agency' ? 'selected' : '' }}>
                                    {{ __('Recruitment Agency') }}
                                </option>
                            </select>
                            <div class="require text-danger ownership"></div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="no_of_employee">{{ __('Number of Employee') }}&nbsp;<span
                                    class="req">*</span></label>
                        </div>
                        <div class="col-md-8">
                            {{-- <input type="text" name="no_of_employee" value="{{ $company->no_of_employee }}"
                                class="form-control" placeholder="eg, 1-50, 51-200"> --}}
                            <select name="no_of_employee" class="form-control select2">
                                <option value="">No of Employee</option>
                                <option value="1-500" {{ $company->no_of_employee == '1-500' ? 'selected' : '' }}>
                                    1-500</option>
                                <option value="501-2500"
                                    {{ $company->no_of_employee == '501-2500' ? 'selected' : '' }}>501-2500</option>
                                <option value="2501-5000"
                                    {{ $company->no_of_employee == '2501-5000' ? 'selected' : '' }}>2501-5000
                                </option>
                                <option value="5001-10000"
                                    {{ $company->no_of_employee == '5001-10000' ? 'selected' : '' }}>5001-10000
                                </option>
                                <option value="Above 10001"
                                    {{ $company->no_of_employee == 'Above 10001' ? 'selected' : '' }}>Above 10001
                                </option>
                            </select>
                            <div class="require text-danger no_of_employee"></div>
                        </div>
                    </div>
                </div>


                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="" class="form-label">{{ __('Operating Since') }}&nbsp;<span
                                    class="req">*</span></label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control opsince" value="{{ $company->operating_since }}"
                                   name="operating_since" readonly id="">
                            <div class="require text-danger operating_since"></div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="company_introduction">{{ __('Company Introduction') }}</label>
                    <input type="hidden" class="form-control" name="company_introduction" id="body_id"
                           value="{{ isset($company->company_details) ? $company->company_details : null }}">
                    <input type="hidden" class="form-control" name="html_content_intro" id="html_content_intro"
                           value="{{ isset($company->html_content_intro) ? $company->html_content_intro : null }}">
                    <div id="editor"></div>

                </div>
                <div class="form-group">
                    <label for="company_services">{{ __('Company Services') }}</label>
                    <input type="hidden" class="form-control" name="company_services" id="company_service_id"
                           value="{{ isset($company->company_services) ? $company->company_services : null }}">
                    <input type="hidden" class="form-control" name="html_content_service" id="html_content_service"
                           value="{{ isset($company->html_content_service) ? $company->html_content_service : null }}">
                    <div id="companyServices">
                    </div>

                </div>
                <div class="form-group">
                    <label class="custom-switch-checkbox">
                        <input type="checkbox" name="is_active" class="custom-switch-input"
                            {{ $company->is_active ? 'checked' : '' }}>
                        <span class="custom-switch-indicator"></span>
                        <span class="custom-switch-description">{{ __('Active') }}</span>
                    </label>

                    {{--show if admin--}}
                    @if(auth()->user()->user_type === 'admin')
                        <label class="custom-switch-checkbox">
                            <input type="checkbox" name="is_featured" class="custom-switch-input"
                                {{ $company->is_featured ? 'checked' : '' }}>
                            <span class="custom-switch-indicator"></span>
                            <span class="custom-switch-description">{{ __('Featured') }}</span>
                        </label>
                    @endif
                </div>

            </div>
        </div>
    </div>
    <!-- end col -->
    <div class="col-xl-12">

        <div class="card m-b-20">
            <div class="card-header">
                <h3 class="card-title">{{ strtoupper(__('Company Contact Information')) }}</h3>

            </div>
            <div class="card-body mb-0">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="country" class="form-label">{{ __('Country') }}</label>
                        </div>
                        <div class="col-md-8">
                            <select name="country_id" id="select-country" class="form-control select2-show-search" data-placeholder="Select Country"
                                    value="{{ isset($company->country_id) ? $company->country_id : '' }}"
                                    onchange="patchStates(this);getIsoCode($(this))">
                                <option value="">{{ __('Select Country') }}</option>
                                @foreach ($countries as $country)
                                    <option value="{{ $country->id }}" data-phonecode="{{ $country->phonecode }}"
                                        {{ $company->country_id == $country->id ? 'selected' : '' }}>
                                        {{ $country->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="state" class="form-label">{{ __('State/Province') }}</label>
                        </div>
                        <div class="col-md-8">
                            <select name="state_id" id="select-state" class="form-control select2-show-search" data-placeholder="Select State/Province"
                                    value="{{ isset($company->state_id) ? $company->state_id : '' }}"
                                    onchange="patchCities(this)">
                                <option value="">Select State/Province</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="state" class="form-label">{{ __('City') }}</label>
                        </div>
                        <div class="col-md-8">
                            <select name="city_id" id="select-city" class="form-control select2-show-search" data-placeholder="Select City"
                                    value="{{ isset($company->city_id) ? $company->city_id : '' }}">
                                <option value="">{{ __('Select City') }}</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="address">{{ __('Address') }}</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="company_address" value="{{ $company->company_address }}"
                                   class="form-control" placeholder="Enter Company Address">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="phn">{{ __('Company Phone Number') }}</label>
                        </div>
                        <div class="col-md-3">
                            <select name="dial_code" class="form-control select2-show-search" data-placeholder="ISO" id="dialCode">
                                <option value="">{{ __('ISO') }}</option>
                                @foreach ($countries as $country)
                                    <option value="{{ $country->phonecode }}"
                                        {{ $company->dialcode1 == $country->phonecode ? 'selected' : '' }}>
                                        {{ $country->phonecode }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-5">
                            <input type="text" name="mobile_phone1" class="form-control"
                                   placeholder="Enter Phone Number1" value="{{ $company->mobile_phone1 }}">
                            <input type="text" name="mobile_phone2" class="form-control mt-3"
                                   placeholder="Enter Phone Number2" value="{{ $company->mobile_phone2 }}">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="company_email">{{ __('Company Email ID') }}</label>
                        </div>
                        <div class="col-md-8">
                            <input type="email" class="form-control" name="company_email"
                                   placeholder="Enter Company Email ID" value="{{ $company->company_email }}">
                            <div class="require text-danger company_email"></div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="">{{ __('Company Website') }}</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="company_website" class="form-control"
                                   placeholder="Enter Website URL" value="{{ $company->company_website }}">
                            <div class="require text-danger company_website"></div>
                            <small class="text-info">Eg. https://www.companydomain.com</small>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="">{{ __('Company Facebook Page') }}</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="company_fb_page" class="form-control"
                                   placeholder="Enter Company Facebook Page Link"
                                   value="{{ $company->company_fb_page }}">
                            <div class="require text-danger company_fb_page"></div>
                            <small class="text-info">Eg. https://www.facebook.com/username</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card m-b-20">
            <div class="card-header">
                <h3 class="card-title">{{ strtoupper(__('Contact Person Details')) }}</h3>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="">{{ __('Full Name') }}&nbsp;<span class="req">*</span></label>
                        </div>
                        @php
                            $hasContactPerson = !empty($company->company_contact_person);

                        @endphp
                        <div class="col-md-3">
                            <select name="person_designation" class="form-control select2">
                                <option value="Mr"
                                    {{ $hasContactPerson && $company->company_contact_person->person_designation == 'Mr' ? 'selected' : '' }}>
                                    Mr.</option>
                                <option value="Miss"
                                    {{ $hasContactPerson && $company->company_contact_person->person_designation == 'Miss' ? 'selected' : '' }}>
                                    Miss.</option>
                                <option value="Mrs"
                                    {{ $hasContactPerson && $company->company_contact_person->person_designation == 'Mrs' ? 'selected' : '' }}>
                                    Mrs.</option>
                            </select>
                            <div class="require text-danger person_designation"></div>
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control"
                                   value="{{ $hasContactPerson ? $company->company_contact_person->name : '' }}"
                                   name="full_name" placeholder="Enter Full Name">
                            <div class="require text-danger full_name"></div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="">{{ __('Designation') }}&nbsp;<span class="req">*</span></label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" name="contact_person_designation"
                                   value="{{ $hasContactPerson ? $company->company_contact_person->position : '' }}"
                                   class="form-control" placeholder="Enter Designation, eg, HR, Manager">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="">{{ __('Mobile Number') }}</label>
                        </div>
                        <div class="col-md-3">
                            <select name="dialcode" class="form-control select2-show-search" data-placeholder="ISO" id="contactIsoCode">
                                <option value="">{{ __('ISO') }}</option>
                                @foreach ($countries as $country)
                                    @php
                                        $dialcode = $hasContactPerson ? $company->company_contact_person->dialcode : '';
                                    @endphp
                                    <option value="{{ $country->phonecode }}"
                                        {{ $country->phonecode == $dialcode ? 'selected' : '' }}>
                                        {{ $country->phonecode }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="contact_person_mobile"
                                   placeholder="Enter Mobile Number"
                                   value="{{ $hasContactPerson ? $company->company_contact_person->phone : '' }}">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="">{{ __('Email') }}</label>
                        </div>
                        <div class="col-md-9">
                            <input type="email" class="form-control"
                                   value="{{ $hasContactPerson ? $company->company_contact_person->email : '' }}"
                                   name="contact_person_email" placeholder="Enter Email">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-12 mb-2">
        <div class="mb-2">
            <button type="button" class="btn btn-primary float-right text-center"
                    onclick="submitForm(event);">{{ __('Update Profile') }}</button>
        </div>
    </div>
</div>
