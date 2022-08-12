@extends('themes.fvft.candidates.layouts.dashmaster')
@section('title') Account Setting @stop
@section('content')
    <section>
        <div class="bannerimg cover-image bg-background3" data-image-src="../assets/images/banners/banner2.jpg"
            style="background: url(&quot;../assets/images/banners/banner2.jpg&quot;) center center;">
            <div class="header-text mb-0">
                <div class="text-center text-white">
                    <h1 class="">{{ __('Account Setting') }}</h1>
                    <ol class="breadcrumb text-center">
                        <li class="breadcrumb-item"><a href="#">{{ __('Home') }}</a></li>
                        <li class="breadcrumb-item"><a href="#">{{ __('Dashboard') }} </a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">{{ __('Setting') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="sptb">
        <div class="container">
            <div class="row">
                <div class="col-xl-3 col-lg-12 col-md-12">
                    @include('themes.fvft.candidates.components.sidebar')
                </div>
                <div class="col-xl-9 col-lg-12 col-md-12">
                    <div class="row">
                        @include('partial/candidates/setting_tabs')
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card mb-2">
                                <div class="card-header">
                                    <h3 class="card-title">{{ strtoupper(__('My Profile')) }}</h3>
                                </div>
                                <div class="card-body">
                                    <div class="d-inline-flex justify-content-between">
                                        <img class="avatar cover-image avatar-lg brround"
                                            src="{{ asset($employ->avatar ?? 'uploads/defaultimage.jpg') }}" alt="">
                                        <h3 class="my-auto ml-5 text-center">{{ $employ->full_name }}</h3>
                                    </div>
                                    <div class="row mt-5">
                                        <div class="col-md-12">
                                            <form action="{{ route('candidate.account_setting.update_setting') }}"
                                                id="firstForm" method="POST">
                                                @csrf
                                                <div class="form-group">
                                                    <label for="">{{ __('Bio') }}</label>
                                                    <textarea name="bio" class="form-control" rows="5">{{ setParameter($employ, 'bio') }}</textarea>
                                                    <span class="require bio text-danger"></span>
                                                </div>
                                                <div class="form-group">
                                                    <label for="email">{{ __('Email Address') }}</label>
                                                    <input type="text" class="form-control" name="email"
                                                        value="{{ setParameter($employ->user, 'email') }}" readonly>
                                                    <span class="require email text-danger"></span>
                                                </div>
                                                <div class="form-group">
                                                    <label for="password">{{ __('Password') }}</label>
                                                    <input type="password" class="form-control" name="password"
                                                        placeholder="Enter Password" autocomplete="off">
                                                    <span class="require password text-danger"></span>
                                                </div>
                                                <div class="form-group">
                                                    <label for="password">{{ __('Website') }}</label>
                                                    <input type="text" class="form-control" name="website"
                                                        value="{{ setParameter($employ, 'website') }}">
                                                    <span class="require website text-danger"></span>
                                                </div>
                                                <div class="form-group">
                                                    <button type="button" onclick="submitForm(event, 'firstForm');"
                                                        class="btn btn-primary w-100">{{ __('Save') }}</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="card mb-2">
                                <div class="card-header">
                                    <h3 class="card-title">{{ __('Edit Profile') }}</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <form action="{{ route('candidate.account_setting.update_setting') }}"
                                                method="POST" id="settingForm">
                                                @csrf
                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <label for="first_name">{{ __('First Name') }}&nbsp;<span
                                                                class="req">*</span></label>
                                                        <input type="text" class="form-control" name="first_name"
                                                            value="{{ setParameter($employ, 'first_name') }}">
                                                        <span class="require first_name text-danger"></span>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="last_name">{{ __('Last Name') }}&nbsp;<span
                                                                class="req">*</span></label>
                                                        <input type="text" class="form-control" name="last_name"
                                                            value="{{ setParameter($employ, 'last_name') }}">
                                                        <span class="require last_name text-danger"></span>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-3">
                                                        <label for="gender">{{ __('Gender') }}&nbsp;<span
                                                                class="req">*</span></label>
                                                        <select name="gender" class="form-control select2">
                                                            <option value="">{{ __('Select Gender') }}</option>
                                                            <option value="Male"
                                                                {{ setParameter($employ, 'gender') == 'Male' ? 'selected' : '' }}>
                                                                {{ __('Male') }}</option>
                                                            <option value="Female"
                                                                {{ setParameter($employ, 'gender') == 'Female' ? 'selected' : '' }}>
                                                                {{ __('Female') }}</option>
                                                            <option value="Other"
                                                                {{ setParameter($employ, 'gender') == 'Other' ? 'selected' : '' }}>
                                                                {{ __('Other') }}</option>
                                                        </select>
                                                        <span class="require gender text-danger"></span>
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label for="mobile_phone">{{ __('Mobile Phone') }}&nbsp;<span
                                                                class="req">*</span></label>
                                                        <input type="text" class="form-control" name="mobile_phone"
                                                            value="{{ setParameter($employ, 'mobile_phone') }}">
                                                        <span class="require mobile_phone text-danger"></span>
                                                    </div>
                                                    <div class="form-group col-md-5">
                                                        <label for="email">{{ __('Email') }}&nbsp;<span
                                                                class="req">*</span></label>
                                                        <input type="text" class="form-control" name="email"
                                                            value="{{ setParameter($employ->user, 'email') }}" readonly>
                                                        <span class="require email text-danger"></span>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <label for="country">{{ __('Country') }}</label>
                                                        <select name="country_id" id="select-country"
                                                            onchange="patchStates(this)"
                                                            value="{{ setParameter($employ, 'country_id') }}"
                                                            class="form-control select2-show-search"
                                                            data-placeholder="Select Country">
                                                            <option value="">{{ __('Select Country') }}</option>
                                                            @foreach ($countries as $country)
                                                                <option value="{{ $country->id }}"
                                                                    {{ setParameter($employ, 'country_id') == $country->id ? 'selected' : '' }}>
                                                                    {{ $country->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        <span class="require country_id text-danger"></span>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="state">{{ __('State') }}</label>
                                                        <select name="state_id" id="select-state"
                                                            onchange="patchGetDistricts(this)"
                                                            value="{{ setParameter($employ, 'state_id') }}"
                                                            class="form-control select2-show-search"
                                                            data-placeholder="Select State">
                                                            <option value="">{{ __('Select State') }}</option>
                                                        </select>
                                                        <span class="require state_id text-danger"></span>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <label for="district">{{ __('District') }}</label>
                                                        <select name="district_id" id="districts"
                                                            value="{{ setParameter($employ, 'district_id') }}"
                                                            class="form-control select2-show-search"
                                                            data-placeholder="Select District">
                                                            <option value="">{{ __('Select District') }}</option>

                                                        </select>
                                                        <span class="require district_id text-danger"></span>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="municipality">{{ __('Municipality') }}</label>
                                                        <input type="text" name="municipality" class="form-control"
                                                            value="{{ setParameter($employ, 'municipality') }}">
                                                            <span class="require municipality text-danger"></span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="bio">{{ __('About Me') }}</label>
                                                    <textarea name="about_me" class="form-control" rows="5"></textarea>
                                                    <span class="require about_me text-danger"></span>
                                                </div>
                                                <div class="form-group">
                                                    <button type="button" onclick="submitForm(event, 'settingForm')"
                                                        class="btn btn-primary float-right w-25">{{ __('Update') }}</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script src="{{ env('APP_URL') }}js/location.js"></script>
    <script>
        function submitForm(e, formId) {
            e.preventDefault();
            $('.require').css('display', 'none');
            let url = $("#" + formId).attr("action");
            $.ajax({
                url: url,
                type: 'post',
                data: new FormData($("#" + formId)[0]),
                processData: false,
                contentType: false,
                cache: false,
                success: function(data) {
                    // return true;
                    if (data.db_error) {
                        $(".alert-secondary").css('display', 'block');
                        $(".db_error").html(data.db_error);
                        toastr.warning(data.db_error);
                    } else if (data.errors) {
                        var error_html = "";
                        $.each(data.errors, function(key, value) {
                            error_html = '<div>' + value + '</div>';
                            $('.' + key).css('display', 'block').html(error_html);
                        });
                    } else if (!data.errors && !data.db_error) {
                        location.href = data.redirectRoute;
                        toastr.success(data.msg);
                    }
                }
            });
        }
    </script>
    <script>
        const _token = $('meta[name="csrf-token"]')[0].content;
        const country_id = {{ isset($employ->country_id) ? $employ->country_id : '154' }}
        const state_id = {{ isset($employ->state_id) ? $employ->state_id : '5068' }};
        const city_id = {{ isset($employ->city_id) ? $employ->city_id : 'null' }};
        const district_id = {{ isset($employ->district_id) ? $employ->district_id : 'null' }};
        const appurl = "{{ env('APP_URL') }}";
    </script>
@endsection
