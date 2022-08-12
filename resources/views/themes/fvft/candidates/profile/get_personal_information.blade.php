@extends('themes.fvft.candidates.layouts.dashmaster')
@section('title') Personal Information @stop
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
                    @include('partial/candidates/tabs', ['title' => 'Edit My Profile - Personal Information'])
                    <form action="{{ route('candidate.profile.post_personal_information') }}" method="POST" id="candidateForm">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card mb-2">
                                    <div class="card-header">
                                        @include('partial/candidates/step')
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h3 class="card-title">{{ __('Personal Information') }}</h3>
                                                <div class="form-group">
                                                    <input type="hidden" class="form-control" name="user_id"
                                                        value="{{ setParameter($employ, 'user_id') }}">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label class="form-label"
                                                                for="first_name">{{ __('First Name') }}&nbsp;<span
                                                                    class="req">*</span></label>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <input type="text" class="form-control"
                                                                value="{{ setParameter($employ, 'first_name') }}"
                                                                id="first_name" name="first_name"
                                                                placeholder="Enter First Name">
                                                            <div class="require text-danger first_name"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label for=""
                                                                class="form-label">{{ __('Middle Name') }}</label>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <input type="text" class="form-control"
                                                                value="{{ setParameter($employ, 'middle_name') }}"
                                                                id="middle_name" name="middle_name"
                                                                placeholder="Enter Middle Name">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label for="last_name"
                                                                class="form-label">{{ __('Last Name') }}&nbsp;<span
                                                                    class="req">*</span></label>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <input type="text" class="form-control"
                                                                value="{{ setParameter($employ, 'last_name') }}"
                                                                id="last_name" name="last_name"
                                                                placeholder="Enter Last Name">
                                                            <div class="require text-danger last_name"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label for="gender"
                                                                class="form-label">{{ __('Gender') }}&nbsp;<span
                                                                    class="req">*</span></label>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <select name="gender" class="form-control select2">
                                                                <option value="">{{ __('Select Gender') }}</option>
                                                                <option value="Male"
                                                                    {{ setParameter($employ, 'gender') == 'Male' ? 'selected' : '' }}>
                                                                    {{ __('Male') }}
                                                                </option>
                                                                <option value="Female"
                                                                    {{ setParameter($employ, 'gender') == 'Female' ? 'selected' : '' }}>
                                                                    {{ __('Female') }}
                                                                </option>
                                                                <option value="Other"
                                                                    {{ setParameter($employ, 'gender') == 'Other' ? 'selected' : '' }}>
                                                                    {{ __('Other') }}
                                                                </option>
                                                            </select>
                                                            <div class="require text-danger gender"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label for="marital_status"
                                                                class="form-label">{{ __('Marital Status') }}&nbsp;<span
                                                                    class="req">*</span></label>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <select name="marital_status" class="form-control select2">
                                                                <option value="">{{ __('Select Marital Status') }}
                                                                </option>
                                                                <option value="Unmarried"
                                                                    {{ setParameter($employ, 'marital_status') == 'Unmarried' ? 'selected' : '' }}>
                                                                    {{ __('Unmarried') }}
                                                                </option>
                                                                <option value="Married"
                                                                    {{ setParameter($employ, 'marital_status') == 'Married' ? 'selected' : '' }}>
                                                                    {{ __('Married') }}</option>
                                                                <option value="Divorced"
                                                                    {{ setParameter($employ, 'marital_status') == 'Divorced' ? 'selected' : '' }}>
                                                                    {{ __('Divorced') }}
                                                                </option>
                                                                <option value="Widow"
                                                                    {{ setParameter($employ, 'marital_status') == 'Widow' ? 'selected' : '' }}>
                                                                    {{ __('Widow') }}</option>
                                                            </select>
                                                            <div class="require text-danger marital_status"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label for="" class="form-label">
                                                                {{ __('Date of Birth(Nepali B.S)') }}
                                                                <span class="req">*</span>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <input type="text" class="form-control nepaliDatePicker"
                                                                value="{{ setParameter($employ, 'dob_in_bs') }}"
                                                                name="nepali_dob" readonly placeholder="Enter Birth Date"
                                                                id="nepali-datepicker">
                                                            <div class="require text-danger nepali_dob"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label for=""
                                                                class="form-label">{{ __('Date of Birth(English A.D)') }}&nbsp;</label>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <input type="text" class="form-control datetime"
                                                                value="{{ setParameter($employ, 'dob') }}"
                                                                name="english_dob" readonly placeholder="Enter Birth Date">
                                                            {{-- <div class="require text-danger english_dob"></div> --}}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label for=""
                                                                class="form-label">{{ __('Passport Number') }}</label>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <input type="text" name="passport_number"
                                                                value="{{ setParameter($employ, 'passport_number') }}"
                                                                class="form-control" placeholder="Enter Passport Number">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label for=""
                                                                class="form-label">{{ __('Passport Expiry Date') }}</label>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <input type="text" name="passport_expiry_date"
                                                                value="{{ setParameter($employ, 'passport_expiry_date') }}"
                                                                class="form-control datetimepicker"
                                                                placeholder="Enter Passport Expiry Date, eg:2020-01-02">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label for=""
                                                                class="form-label">{{ __('Height') }}</label>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control"
                                                                    value="{{ setParameter($employ, 'height') }}"
                                                                    name="height" placeholder="000">
                                                                <div class="input-group-append">
                                                                    <button type="button"
                                                                        class="btn btn-primary">{{ __('CM') }}</button>
                                                                </div>
                                                            </div>
                                                            <div class="require text-danger height"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label for=""
                                                                class="form-label">{{ __('Weight') }}</label>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control"
                                                                    value="{{ setParameter($employ, 'weight') }}"
                                                                    name="weight" placeholder="000">
                                                                <div class="input-group-append">
                                                                    <button type="button"
                                                                        class="btn btn-primary">{{ __('KG') }}</button>
                                                                </div>
                                                            </div>
                                                            <div class="require text-danger weight"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="card-body">
                                                    <div class="form-group profilePicture" id="profilePicture">
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <label for="">{{ __('Profile Picture') }}</label>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <input type="file" name="profile_picture"
                                                                    data-default-file="{{ $employ->avatar != null && file_exists($employ->avatar) ? asset($employ->avatar) : '' }}"
                                                                    class="dropify"
                                                                    data-allowed-file-extensions="png jpg jpeg"
                                                                    data-height="180">
                                                                <div class="require text-danger profile_picture"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body mx-auto">
                                        <div class="mx-auto">
                                            <button type="button" onclick="submitForm(event);"
                                                class="btn btn-success rounded-0">{{ __('Next') }}
                                                <i
                                                    class="fa fa-arrow-right"></i></button>&nbsp;&nbsp;&nbsp;<span>{{ __('Contact Information') }}</span>
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
    <!-- file Uploads -->
    <!-- file uploads js -->
    <script src="/themes/fvft/assets/plugins/fileuploads/js/dropify.js"></script>
    <script src="/themes/fvft/assets/plugins/fileuploads/js/dropfy-custom.js"></script>
    <script src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>
    <!--Upload Js-->
    {{-- <script src="/themes/fvft/assets/js/upload.js"></script> --}}

    <script>
        $(document).ready(function() {
            $('.datetime').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                todayHighlight: true,
            });

            $(".datetime").on('change', () => {
                let dateTime = $(".datetime").val();
                let dateObj = new Date(dateTime);
                let year = dateObj.getUTCFullYear();
                let month = dateObj.getUTCMonth() + 1;
                let day = dateObj.getUTCDate();
                let nepaliDate = NepaliFunctions.AD2BS({
                    year: year,
                    month: month,
                    day: day
                });
                let nepaliYear = nepaliDate.year;
                let nepaliMonth = ("0" + nepaliDate.month).slice(-2);
                let nepaliDay = ("0" + nepaliDate.day).slice(-2);
                let nepaliValue = nepaliYear + '-' + nepaliMonth + '-' + nepaliDay;
                $("#nepali-datepicker").val(nepaliValue);
            });
        });
        $('.dropify').dropify({
            error: {

                'imageFormat': 'The image format is not allowed (png, jpg, jpeg only).'
            }
        });



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
@endsection
