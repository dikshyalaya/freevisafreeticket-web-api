@extends('themes.fvft.candidates.layouts.dashmaster')
@section('title') My Profile @stop
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
                    @include('partial/candidates/tabs', ['title' => 'My Profile'])

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card mb-2">
                                <div class="card-body">
                                    <div class="d-inline-flex justify-content-between">
                                        <img src="{{ asset($employ->avatar ?? 'uploads/defaultimage.jpg') }}"
                                             style="width: 100px;" alt="">
                                        <h3 class="mt-6 ml-5 text-center">{{ $employ->full_name }}</h3>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="card-body">
                                            <h4 class="mb-4 card-title bg-primary text-white p-2">
                                                {{ __('Personal Information') }}</h4>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label for="" class="form-label">{{ __('Name') }}&nbsp;:</label>
                                                    </div>
                                                    <div class="col-md-8">
                                                        {{ $employ->full_name }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label for=""
                                                               class="form-label">{{ __('Gender') }}&nbsp;:</label>
                                                    </div>
                                                    <div class="col-md-8">
                                                        {{ $employ->gender }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label for=""
                                                               class="form-label">{{ __('Marital Status') }}&nbsp;:</label>
                                                    </div>
                                                    <div class="col-md-8">
                                                        {{ $employ->marital_status }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label for="" class="form-label">Date of Birth&nbsp;:</label>
                                                    </div>
                                                    <div class="col-md-8">
                                                        {{ !blank($employ->dob) ? date('Y F d', strtotime($employ->dob)) : '' }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label for=""
                                                               class="form-label">{{ __('Height') }}&nbsp;:</label>
                                                    </div>
                                                    <div class="col-md-8">
                                                        {{ $employ->height ? $employ->height . ' ' . __('CM') : '' }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label for=""
                                                               class="form-label">{{ __('Weight') }}&nbsp;:</label>
                                                    </div>
                                                    <div class="col-md-8">
                                                        {{ $employ->weight ? $employ->weight . ' ' . __('KG') : '' }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <h4 class="mb-4 card-title bg-primary text-white p-2">
                                                {{ __('Contact Information') }}</h4>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label for=""
                                                               class="form-label">{{ __('Mobile Phone') }}&nbsp;:</label>
                                                    </div>
                                                    <div class="col-md-8">
                                                        {{ $employ->mobile_phone }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label for=""
                                                               class="form-label">{{ __('Email ID') }}&nbsp;:</label>
                                                    </div>
                                                    <div class="col-md-8">
                                                        {{ $employ->user != null ? $employ->user->email : '' }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label for=""
                                                               class="form-label">{{ __('Address') }}&nbsp;:</label>
                                                    </div>
                                                    <div class="col-md-8">
                                                        {{ $employ->state != null ? $employ->state->name : '' }}
                                                        {{ $employ->country != null ? ', ' . $employ->country->name : '' }}
                                                        {{ $employ->city != null ? ', ' . $employ->city->name : '' }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card-body">
                                            <h4 class="mb-4 card-title bg-primary text-white p-2">{{ __('Qualification') }}
                                            </h4>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label for=""
                                                               class="form-label">{{ __('Education') }}&nbsp;:</label>
                                                    </div>
                                                    <div class="col-md-8">
                                                        {{ $employ->education_level != null ? $employ->education_level->title : '' }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label for=""
                                                               class="form-label">{{ __('Training') }}&nbsp;:</label>
                                                    </div>
                                                    <div class="col-md-8">
                                                        @if ($employ->employeeTrainings != null)
                                                            @foreach ($employ->employeeTrainings as $etraining)
                                                                @if ($etraining->training != null)
                                                                    <span>{{ $loop->iteration }}.&nbsp;</span>{{ $etraining->training != null ? $etraining->training->title : '' }}
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label for=""
                                                               class="form-label">{{ __('Skills') }}&nbsp;:</label>
                                                    </div>
                                                    <div class="col-md-8">
                                                        @if ($employ->employeeSkills != null)
                                                            @foreach ($employ->employeeSkills as $eskill)
                                                                @if ($eskill->skill != null)
                                                                    <span>{{ $loop->iteration }}.&nbsp;</span>{{ $eskill->skill != null ? $eskill->skill->title : '' }}
                                                                    <br>
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label for=""
                                                               class="form-label">{{ __('Languages') }}&nbsp;:</label>
                                                    </div>
                                                    <div class="col-md-8">
                                                        @if ($employ->employeeLanguage != null)
                                                            @foreach ($employ->employeeLanguage as $elanguage)
                                                                @if ($elanguage->language != null)
                                                                    <span>{{ $loop->iteration }}.&nbsp;</span>{{ $elanguage->language != null ? $elanguage->language->lang : '' }}
                                                                    : {{ $elanguage->language_level }} <br>
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <h4 class="mb-4 card-title bg-primary text-white p-2">{{ __('Experience') }}</h4>
                                            @if ($employ->experience != null)
                                                @foreach ($employ->experience as $eexperience)
                                                    <h6 class="form-label">{{ __('Experience') }}
                                                        {{ $loop->iteration }}</h6>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <label for=""
                                                                       class="form-label">{{ __('Country') }}&nbsp;:</label>
                                                            </div>
                                                            <div class="col-md-8">
                                                                {{ $eexperience->country != null ? $eexperience->country->name : '' }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <label for=""
                                                                       class="form-label">{{ __('Job Category') }}&nbsp;:</label>
                                                            </div>
                                                            <div class="col-md-8">
                                                                {{ $eexperience->job_category != null ? $eexperience->job_category->functional_area : '' }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <label for=""
                                                                       class="form-label">{{ __('Industry') }}&nbsp;:</label>
                                                            </div>
                                                            <div class="col-md-8">
                                                                {{ $eexperience->industry != null ? $eexperience->industry->title : '' }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <label for=""
                                                                       class="form-label">{{ __('Working Duration') }}&nbsp;:</label>
                                                            </div>
                                                            <div class="col-md-8">
                                                                {{ $eexperience->working_year != null ? $eexperience->working_year . ' '. getYearForm($eexperience->working_year) : '' }}
                                                                {{ $eexperience->working_month != null ? $eexperience->working_month . ' '. getMonthForm($eexperience->working_month) : '' }}

                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>

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
