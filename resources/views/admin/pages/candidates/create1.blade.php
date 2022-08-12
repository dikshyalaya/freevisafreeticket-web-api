@extends('admin.layouts.master')
@section('main')
    <style>
        .req {
            color: #ff382b !important;
        }

    </style>
    <div class="page-header">
        <h4 class="page-title">{{ $action }} Candidate</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Modules</a></li>
            <li class="breadcrumb-item" aria-current="page"><a href="/admin/candidates/">Candidate</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add</li>
        </ol>
    </div>


    <form action="">
        <div class="row">
            <div class="col-md-12">
                <div class="card m-b-20">
                    {{-- <div class="card-header">
                    <h3 class="card-title">Profile Picture</h3>
                </div> --}}
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-4">
                                <div class="form-group">
                                    <label for="">Profile Picture</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="example-file-input-custom">
                                        <label class="custom-file-label">Choose file</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="form-group">
                                    <label for="">Full Picture</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="example-file-input-custom">
                                        <label class="custom-file-label">Choose file</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-6">
                <div class="card m-b-20">
                    <div class="card-header">
                        <h3 class="card-title">{{ strtoupper('Personal Information') }}</h3>
                    </div>
                    <div class="card-body">

                        <div class="form-group">
                            <label class="form-label" for="first_name">First Name&nbsp;<span
                                    class="req">*</span></label>
                            <input type="text" class="form-control" id="first_name" name="first_name"
                                placeholder="Enter First Name">
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">Middle Name</label>
                            <input type="text" class="form-control" id="middle_name" name="middle_name"
                                placeholder="Enter Middle Name">
                        </div>
                        <div class="form-group">
                            <label for="last_name" class="form-label">Last Name&nbsp;<span
                                    class="req">*</span></label>
                            <input type="text" class="form-control" id="last_name" name="last_name"
                                placeholder="Enter Last Name">
                        </div>
                        <div class="d-inline-flex">
                            <div class="form-group">
                                <div class="form-label">Gender&nbsp;<span class="req">*</span></div>
                                <div class="custom-controls-stacked d-inline-flex">
                                    <label for="" class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" value="Male" name="gender">
                                        <span class="custom-control-label">Male</span>
                                    </label>
                                    <label for="" class="custom-control custom-radio ml-2">
                                        <input type="radio" class="custom-control-input" value="Female" name="gender">
                                        <span class="custom-control-label">Female</span>
                                    </label>
                                    <label for="" class="custom-control custom-radio ml-2">
                                        <input type="radio" class="custom-control-input" value="Other" name="gender">
                                        <span class="custom-control-label">Other</span>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group ml-5">
                                <div class="form-label">Marital Status&nbsp;<span class="req">*</span></div>
                                <select name="marital_status" class="form-control-select2">
                                    <option value="Unmarried">Unmarried</option>
                                    <option value="Married">Married</option>
                                    <option value="Divorced">Divorced</option>
                                    <option value="Widow">Widow</option>
                                </select>
                                {{-- <div class="custom-controls-stacked d-inline-flex">
                                    <label for="" class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" value="Married" name="gender">
                                        <span class="custom-control-label">Married</span>
                                    </label>
                                    <label for="" class="custom-control custom-radio ml-2">
                                        <input type="radio" class="custom-control-input" value="Unmarried" name="gender">
                                        <span class="custom-control-label">Unmarried</span>
                                    </label>
                                </div> --}}
                            </div>
                        </div>
                        {{-- <div class="form-group">
                            <div class="form-label">Date of Birth(Nepali B.S)</div>
                            <div class="d-inline-flex">
                                <select name="" class="form-control" id="">
                                    <option value="2060" selected>2060</option>
                                </select>
                                <select name="" class="form-control ml-5" id="">
                                    <option value="2060" selected>Baisakh</option>
                                </select>
                                <select name="" class="form-control ml-5" id="">
                                    <option value="2060" selected>15</option>
                                </select>
                            </div>
                        </div> --}}
                        <div class="form-group">
                            <label for="" class="form-label">Date of Birth(Nepali B.S)</label>
                            <input type="text" class="form-control" name="nepali_dob" readonly
                                placeholder="Enter Birth Date">
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">Date of Birth(English A.D)</label>
                            <input type="text" class="form-control" name="english_dob" readonly
                                placeholder="Enter Birth Date">
                        </div>
                        {{-- <div class="form-group">
                            <div class="form-label">Date of Birth(English A.D)</div>
                            <div class="d-inline-flex">
                                <select name="" class="form-control" id="">
                                    <option value="2060" selected>2002</option>
                                </select>
                                <select name="" class="form-control ml-5" id="">
                                    <option value="2060" selected>June</option>
                                </select>
                                <select name="" class="form-control ml-5" id="">
                                    <option value="2060" selected>15</option>
                                </select>
                            </div>
                        </div> --}}


                    </div>
                </div>

                <div class="card m-b-20">
                    <div class="card-header">
                        <h3 class="card-title">{{ strtoupper('Education/Training/Skill') }}</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="">Education Level&nbsp;<span class="req">*</span></label>
                            <select name="education_level_id" class="form-control select2">
                                <option value="">Select Level</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="">Training</label><br>
                            <div class="d-inline-flex">
                                <select name="training[]" class="form-control select2">
                                    <option value="">Select Training</option>
                                </select>
                                <span>Add Training <span><i class="fa fa-plus"></i></span></span>
                            </div>
                        </div>
                        {{-- <div class="form-group"> --}}

                        {{-- </div> --}}

                        <div class="d-inline-flex">
                            <div class="form-group">
                                <label for="">Skill</label>
                                <select name="training[]" class="form-control select2">
                                    <option value="">Select Skill</option>
                                </select>
                            </div>
                            {{-- <div class="form-group"> --}}
                            <span>Add Skill <span><i class="fa fa-plus"></i></span></span>
                            {{-- </div> --}}
                        </div>

                        <div class="form-group">
                            <div class="form-label">Language</div>
                            <div class="d-inline-flex">
                                <label for="" class="mr-5">English</label>

                                <div class="custom-controls-stacked d-inline-flex">

                                    <label for="" class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" value="Good" name="language[]">
                                        <span class="custom-control-label">Good</span>
                                    </label>
                                    <label for="" class="custom-control custom-radio ml-2">
                                        <input type="radio" class="custom-control-input" value="Fair" name="language[]">
                                        <span class="custom-control-label">Fair</span>
                                    </label>
                                    <label for="" class="custom-control custom-radio ml-2">
                                        <input type="radio" class="custom-control-input" value="No" name="language[]">
                                        <span class="custom-control-label">No</span>
                                    </label>
                                </div>
                            </div>
                            <br>
                            <div class="d-inline-flex">
                                <label for="" class="mr-5">Nepali</label>

                                <div class="custom-controls-stacked d-inline-flex">

                                    <label for="" class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" value="Good" name="language[]">
                                        <span class="custom-control-label">Good</span>
                                    </label>
                                    <label for="" class="custom-control custom-radio ml-2">
                                        <input type="radio" class="custom-control-input" value="Fair" name="language[]">
                                        <span class="custom-control-label">Fair</span>
                                    </label>
                                    <label for="" class="custom-control custom-radio ml-2">
                                        <input type="radio" class="custom-control-input" value="No" name="language[]">
                                        <span class="custom-control-label">No</span>
                                    </label>
                                </div>
                            </div>
                            <br>

                            <div class="d-inline-flex">
                                <span>Add New Language</span>
                                <select name="" class="form-control select2" id="">
                                    <option value="">Select Language</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end col -->
            <div class="col-xl-6">
                <div class="card m-b-20">
                    <div class="card-header">
                        <h3 class="card-title">{{ strtoupper('Contact Information') }}</h3>

                    </div>
                    <div class="card-body mb-0">
                        <div class="form-group">
                            <label for="">Mobile Number&nbsp;<span class="req">*</span></label>
                            <div class="d-inline-flex">
                                <input type="text" name="mobile_number1" class="form-control"
                                    placeholder="Enter Mobile Number 1">
                                <input type="text" name="mobile_number2" class="form-control ml-3"
                                    placeholder="Enter Mobile Number 2">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">Email ID</label>
                            <input type="email" class="form-control" name="email" placeholder="Enter Email ID">
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">Address</label>
                            <div class="row">
                                <div class="col-4">
                                    <select name="state_id" class="form-control select2" id="">
                                        <option value="">State</option>
                                    </select>
                                </div>
                                <div class="col-4">
                                    <select name="district_id" class="form-control" id="">
                                        <option value="">District</option>
                                    </select>
                                </div>
                                <div class="col-4">
                                    <input type="text" name="municipality" class="form-control"
                                        placeholder="Municipality">
                                </div>
                                <div class="col-4 mt-3">
                                    <input type="text" name="ward" class="form-control" placeholder="Ward">
                                </div>
                                <div class="col-4 mt-3">
                                    <input type="text" name="address_line" class="form-control"
                                        placeholder="City/Street/Tole/Town/Village">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card m-b-20">
                    <div class="card-header">
                        <h3 class="card-title">{{ strtoupper('Passport Details') }}</h3>

                    </div>
                    <div class="card-body mb-0">
                       <div class="form-group">
                           <label for="" class="form-label">Passport Number</label>
                           <input type="text" name="passport_number" class="form-control" placeholder="Enter Passport Number">
                       </div>
                       <div class="form-group">
                           <label for="" class="form-label">Passport Expiry Date</label>
                           <input type="text" name="passport_expiry_date" class="form-control" placeholder="Enter Passport Expiry Date, eg:2020-01-02">
                       </div>
                    </div>
                </div>

                

                <div class="card m-b-20">
                    <div class="card-header">
                        <h3 class="card-title">{{ strtoupper('Experience') }}</h3>
                    </div>
                    <div class="card-body">
                        <div class="card p-2" style="width: 15rem">

                            <div class="custom-controls-stacked d-inline-flex">
                                <label for="" class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" value="Yes" name="is_experience">
                                    <span class="custom-control-label">Yes</span>
                                </label>
                                <label for="" class="custom-control custom-radio ml-5">
                                    <input type="radio" class="custom-control-input" value="No" name="is_experience">
                                    <span class="custom-control-label">No</span>
                                </label>
                            </div>

                        </div>
                        <div class="form-group">
                            <div class="form-label">Experience 1</div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Country</label>
                                        <select name="country_id" class="form-control select2" id="">
                                            <option value="">Nepal</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Job Category</label>
                                        <select name="country_id" class="form-control select2" id="">
                                            <option value="">Select Job Category</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Job Title</label>
                                        <select name="job_title" class="form-control select2" id="">
                                            <option value="">Select Job Title</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Working Duration</label>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <select name="year" class="form-control select2" id="">
                                                    <option value="">Year</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <select name="month" class="form-control select2" id="">
                                                    <option value="">Month</option>
                                                </select>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <span>Add Experience <i class="fa fa-plus"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!-- end row -->
    {{-- End Form Here --}}

    {{-- <div class="row">
        <div class="col-12">
            <form action="/admin/candidates/save" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ $action }} Candidates</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 col-lg-6">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label">First Name</label>
                                            <input type="text" class="form-control" name="first_name"
                                                placeholder="First Name"
                                                value="{{ isset($candidate->first_name) ? $candidate->first_name : '' }}"
                                                required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label">Middle Name</label>
                                            <input type="text" class="form-control" name="middle_name"
                                                placeholder="Middle Name"
                                                value="{{ isset($candidate->middle_name) ? $candidate->middle_name : '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label">Last Name</label>
                                            <input type="text" class="form-control" name="last_name"
                                                placeholder="Last Name"
                                                value="{{ isset($candidate->last_name) ? $candidate->last_name : '' }}"
                                                required>
                                        </div>
                                    </div>
                                </div>
                                <input type="text" name="id" style="display:none;"
                                    value="{{ isset($candidate->id) ? $candidate->id : '' }}">
                                <input type="text" name="user_id" style="display:none;"
                                    value="{{ isset($candidate->user_id) ? $candidate->user_id : '' }}">
                                <div class="form-group">
                                    <label class="form-label">Date Of Birth</label>
                                    <input type="date" class="form-control" name="dob" placeholder="Date of Birth"
                                        value="{{ isset($candidate->dob) ? $candidate->dob : '' }}" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Gender</label>
                                    <select name="gender" class="form-control select2 "
                                        value="{{ isset($candidate->gender) ? $candidate->gender : '' }}">
                                        <option value="male"
                                            {{ isset($candidate->gender) ? ($candidate->gender == 'male' ? 'selected' : '') : '' }}>
                                            Male
                                        </option>
                                        <option value="female"
                                            {{ isset($candidate->gender) ? ($candidate->gender == 'female' ? 'selected' : '') : '' }}>
                                            Female</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Marital Status</label>
                                    <select name="marital_status" class="form-control select2 "
                                        value="{{ isset($candidate->marital_status) ? $candidate->marital_status : '' }}">
                                        <option value="married"
                                            {{ isset($candidate->marital_status) ? ($candidate->marital_status == 'married' ? 'selected' : '') : '' }}>
                                            Married</option>
                                        <option value="single"
                                            {{ isset($candidate->marital_status) ? ($candidate->marital_status == 'single' ? 'selected' : '') : '' }}>
                                            Single</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Nationality</label>
                                    <input type="text" class="form-control" name="nationality" placeholder="nationality"
                                        value="{{ isset($candidate->nationality) ? $candidate->nationality : '' }}"
                                        required>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label">Country</label>
                                            <select name="country_id" id="select-country" class="form-control select2 "
                                                value="{{ isset($candidate->country_id) ? $candidate->country_id : '' }}"
                                                onchange="patchStates(this)">
                                                @foreach ($countries as $item)
                                                    <option value="{{ $item->id }}"
                                                        {{ isset($candidate->country_id) ? ($item->id == $candidate->country_id ? 'selected' : '') : null }}>
                                                        {{ $item->name }}</option>
                                                @endforeach

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label">States</label>
                                            <select name="state_id" id="select-state" class="form-control select2 "
                                                value="{{ isset($candidate->state_id) ? $candidate->state_id : '' }}"
                                                onchange="patchCities(this)">
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label">Cities</label>
                                            <select name="city_id" id="select-city" class="form-control select2 "
                                                value="{{ isset($candidate->city_id) ? $candidate->city_id : '' }}">
                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label class="form-label">Avatar</label>
                                    <input type="file" class="dropify" name="avatar" data-height="180"
                                        data-default-file="{{ isset($candidate->avatar) ? env('APP_URL') . $candidate->avatar : '' }}">
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Street Address</label>
                                    <input type="text" class="form-control" name="address" placeholder="Street Address"
                                        value="{{ isset($candidate->address) ? $candidate->address : '' }}">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Email</label>
                                    <input type="text" class="form-control" name="email" placeholder="Email"
                                        value="{{ isset($candidate_user->email) ? $candidate_user->email : '' }}"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Phone Number</label>
                                    <input type="text" class="form-control" name="mobile_phone"
                                        placeholder="Phone Number"
                                        value="{{ isset($candidate->mobile_phone) ? $candidate->mobile_phone : '' }}">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">{{ $action == 'New' ? '' : 'New' }} Password</label>
                                    <input type="password" class="form-control" name="password"
                                        placeholder="{{ $action == 'New' ? '' : 'New' }} Password"
                                        {{ $action == 'New' ? 'required' : '' }}>
                                </div>
                                <div class="form-group">
                                    <label class="custom-switch-checkbox">
                                        <input type="checkbox" name="is_active" class="custom-switch-input"
                                            {{ isset($candidate->is_active) ? ($candidate->is_active ? 'checked' : '') : 'checked' }}>
                                        <span class="custom-switch-indicator"></span>
                                        <span class="custom-switch-description">Active</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <div class="d-flex">
                            <a href="/admin/candidates/" class="btn btn-link">Back</a>
                            <button type="submit" class="btn btn-success ml-auto">Save </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div> --}}
@endsection
@section('script')
    <script src="{{ env('APP_URL') }}js/location.js"></script>
    <script>
        const _token = $('meta[name="csrf-token"]')[0].content;
        const state_id = {{ isset($candidate->state_id) ? $candidate->state_id : '3871' }};
        const city_id = {{ isset($candidate->city_id) ? $candidate->city_id : 'null' }};
        const appurl = "{{ env('APP_URL') }}";
    </script>
@endsection
