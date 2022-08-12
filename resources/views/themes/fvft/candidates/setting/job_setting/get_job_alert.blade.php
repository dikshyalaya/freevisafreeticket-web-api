@extends('themes.fvft.candidates.layouts.dashmaster')
@section('title') Job Preference @stop
@section('content')
    <section>
        <div class="bannerimg cover-image bg-background3" data-image-src="../assets/images/banners/banner2.jpg"
            style="background: url(&quot;../assets/images/banners/banner2.jpg&quot;) center center;">
            <div class="header-text mb-0">
                <div class="text-center text-white">
                    <h1 class="">{{ __('Job Preference') }}</h1>
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
                        @include('partial/candidates/setting_tabs', ['title' => 'Settings - Job Alert Setting'])
                    </div>
                    <div class="row">
                        <div class="card mb-0">
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label class="custom-switch">
                                            <input type="checkbox" name="job_notify"
                                                onclick="updateJobNotification($(this),'job_notify', {{ $employe->job_notify }})"
                                                class="custom-switch-input" {{ $employe->job_notify ? 'checked' : '' }}>
                                            <span class="custom-switch-indicator"></span>
                                            <span
                                                class="custom-switch-description">{{ __('Notify me for preferred job') }}</span>
                                        </label>
                                    </div>

                                    <div class="form-group col-md-6 ">
                                        <label class="custom-switch">
                                            <input type="checkbox" name="all_job_notify"
                                                onclick="updateJobNotification($(this), 'all_job_notify', {{ $employe->all_job_notify }})"
                                                class="custom-switch-input"
                                                {{ $employe->all_job_notify ? 'checked' : '' }}>
                                            <span class="custom-switch-indicator"></span>
                                            <span
                                                class="custom-switch-description">{{ __('Notify me for all job') }}</span>
                                        </label>
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
    <script>
        function updateJobNotification(button, name, value) {
            $.ajax({
                url: "{{ route('candidate.job_setting.updateJobNotification') }}",
                type: 'POST',
                data: {
                    'notify': name,
                    'name': value
                },
                success: function(res) {
                    $(button).attr('onclick', 'updateJobNotification($(this), "'+name+'" , ' + res.value +
                        ')');
                    toastr.success(res.msg);
                }
            });
        }
    </script>
@endsection
