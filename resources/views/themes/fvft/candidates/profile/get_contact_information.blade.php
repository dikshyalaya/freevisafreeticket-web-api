@extends('themes.fvft.candidates.layouts.dashmaster')
@section('title') Contact Information @stop
@section('style')
    <!-- file Uploads -->
    <link href="/themes/fvft/assets/plugins/fileuploads/css/dropify.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ asset('css/datepicker.min.css') }}">
@endsection
@section('content')
    <section>
        <div class="bannerimg cover-image bg-background3" data-image-src="/uploads/site/banner.png"
             style="background: url(/uploads/site/banner.png) center center;">
            <div class="header-text mb-0">
                <div class="text-center text-white">
                    <h1 class="">{{ __('My Profile') }}</h1>
                    <ol class="breadcrumb text-center">
                        <li class="breadcrumb-item"><a href="#">{{ __('Home') }}</a></li>
                        <li class="breadcrumb-item"><a href="#">{{ __('Dashboard') }} </a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">{{ __('My Profile') }}</li>
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

                    @include('partial/candidates/tabs', ['title' => 'Edit My Profile - Contact Information'])

                    <form action="{{ route('candidate.profile.post_contact_information') }}" method="POST" id="candidateForm">
                        @csrf

                        <div class="row">
                            <div class="col-md-12">
                                <div class="card mb-2">
                                    <div class="card-header">
                                        @include('partial/candidates/step')
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="card-body">
                                                <h3 class="card-title">{{ __('Contact Information') }}</h3>

                                                <div class="form-group">
                                                    <input type="hidden" class="form-control" name="user_id"
                                                           value="{{ setParameter($employ, 'user_id') }}">
                                                    <label for="">{{ __('Mobile Number') }}&nbsp;<span
                                                            class="req">*</span></label>
                                                    <div class="d-inline-flex">
                                                        <input type="text" name="mobile_number1"
                                                               value="{{ setParameter($employ, 'mobile_phone') }}"
                                                               class="form-control" placeholder="Enter Mobile Number 1">
                                                        <input type="text" name="mobile_number2"
                                                               value="{{ setParameter($employ, 'mobile_phone2') }}"
                                                               class="form-control ml-3" placeholder="Enter Mobile Number 2">
                                                    </div>
                                                    <div class="require text-danger mobile_number1"></div>
                                                    <div class="require text-danger mobile_number2"></div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="" class="form-label">{{ __('Email ID') }}</label>
                                                    <input type="email" class="form-control" name="email"
                                                           value="{{ setParameter($employ->user, 'email') }}"
                                                           placeholder="Enter Email ID" readonly>
                                                    <div class="require text-danger email"></div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="" class="form-label">{{ __('Address') }}</label>
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <select name="country_id" class="form-control select2-show-search" data-placeholder="Select Country" onchange="patchStates(this)" value="{{ setParameter($employ, 'country_id') ?? $defaultCountryId }}" id="select-country">
                                                                <option value="">{{ __('Select Country') }}</option>
                                                                @foreach ($countries as $country)
                                                                    <option value="{{ $country->id }}"
                                                                        {{ $country->id == (setParameter($employ, 'country_id') ?? $defaultCountryId) ? 'selected' : '' }}>
                                                                        {{ $country->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-6">
                                                            <select name="state_id" class="form-control select2-show-search"
                                                                    id="states" data-placeholder="Select State"
                                                                    onchange="patchDistricts(this)"
                                                                    value="{{ setParameter($employ, 'state_id') }}">
                                                            </select>
                                                        </div>
                                                        <div class="col-6 mt-3">
                                                            <select name="district_id" class="form-control select2-show-search"
                                                                    id="districts"
                                                                    value="{{ setParameter($employ, 'district_id') }}"
                                                                    data-placeholder="Select District">
                                                                <option value="">{{ __('Select District') }}</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-6 mt-3">
                                                            <input type="text" name="municipality"
                                                                   value="{{ setParameter($employ, 'municipality') }}"
                                                                   class="form-control" placeholder="Municipality">
                                                        </div>
                                                        <div class="col-6 mt-3">
                                                            <input type="text" name="ward" class="form-control"
                                                                   value="{{ setParameter($employ, 'ward') }}"
                                                                   placeholder="Ward">
                                                        </div>
                                                        <div class="col-12 mt-3">
                                                            <input type="text" name="city_street"
                                                                   value="{{ setParameter($employ, 'city_street') }}"
                                                                   class="form-control"
                                                                   placeholder="City/Street/Tole/Town/Village">
                                                        </div>
                                                        <div class="col-12 mt-3">
                                                            <input type="text" name="address_line"
                                                                   value="{{ setParameter($employ, 'address') }}"
                                                                   class="form-control" placeholder="Address Line">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body mx-auto">
                                        <div class="mx-auto">
                                            <span>{{ __('Personal Information') }}</span> &nbsp;&nbsp;&nbsp;<a
                                                href="{{ route('candidate.profile.get_personal_information') }}"
                                                class="btn btn-success rounded-0"><i class="fa fa-arrow-left"></i>{{ __('Back') }} </a>
                                            <button type="button" onclick="submitForm(event);"
                                                    class="btn btn-success ml-3 rounded-0">{{ __('Next') }} <i
                                                    class="fa fa-arrow-right"></i></button>&nbsp;&nbsp;&nbsp;<span>{{ __('Qualification') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('script')
    <script src="{{ env('APP_URL') }}js/contact.js"></script>

    <script>

        function submitForm(e, redirect='proceed') {
            e.preventDefault();
            $('.require').css('display', 'none');
            let url = $("#candidateForm").attr('action');
            var data = new FormData($("#candidateForm")[0]);
            $.ajax({
                url: url,
                type: 'post',
                // _method: 'put',
                // data: data,
                data: new FormData($("#candidateForm")[0]),
                processData: false,
                contentType: false,
                cache: false,
                success: function(response) {
                    if (response.db_error) {
                        $(".alert-secondary").css('display', 'block');
                        $(".db_error").html(response.db_error);
                        toastr.warning(response.db_error);
                    } else if (response.errors) {
                        var error_html = "";
                        $.each(response.errors, function(key, value) {
                            toastr.error(value);
                            error_html = '<div>' + value + '</div>';
                            $('.' + key).css('display', 'block').html(error_html);
                        });
                    } else if (!response.errors && !response.db_error) {
                        if (redirect && redirect === 'reload') {
                            window.location.reload()
                        }else{
                            location.href = response.redirectRoute;
                        }
                    }
                }
            });
        }
    </script>
    <script>
        const _token = $('meta[name="csrf-token"]')[0].content;
        const country_id = {{ isset($employ->country_id) ? $employ->country_id : $defaultCountryId }};
        const state_id = {{ isset($employ->state_id) ? $employ->state_id : '3871' }};
        // const city_id = {{ isset($employ->city_id) ? $employ->city_id : 'null' }};
        const district_id = {{ isset($employ->district_id) ? $employ->district_id : 'null' }};
        const appurl = "{{ env('APP_URL') }}";
    </script>
@endsection
