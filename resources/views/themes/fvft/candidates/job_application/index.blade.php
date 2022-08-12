@extends('themes.fvft.candidates.layouts.dashmaster')
@section('title') Job Application @stop
@section('content')
    <style>
        .tabs-menu1 .nav {
            flex-wrap: nowrap;
            padding-left: 15px;
        }

        .tabs-menu1 li a:not(:active) {
            background-color: #868e96;
            border-color: #868e96;
            color: #171a1d;
        }

        .tabs-menu1 li a:focus {
            background-color: #868e96;
            border-color: #868e96;
            color: #171a1d;
        }

        .tabs-menu1 li a.active {
            background-color: #2861b1;
            border-color: #2861b1;
            color: #fff;
        }

        .admin-custom-icon {
            width: 60px;
            height: 60px;
            line-height: 60px;
            margin: 0 auto;
            text-align: center;
            background: rgba(0, 0, 0, 0.12);
            border-radius: 50%;
        }

    </style>
    <section>
        <div class="bannerimg cover-image bg-background3"
            data-image-src="{{ asset('/themes/fvft/') }}/assets/images/banners/banner2.jpg"
            style="background: url(&quot;{{ asset('/themes/fvft/') }}/assets/images/banners/banner2.jpg&quot;) center center;">
            <div class="header-text mb-0">
                <div class="text-center text-white">
                    <h1 class="">{{ __('My Job Applications') }}</h1>
                    <ol class="breadcrumb text-center">
                        <li class="breadcrumb-item"><a href="#">{{ __('Home') }}</a></li>
                        <li class="breadcrumb-item"><a href="#">{{ __('Dashboard') }} </a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">{{ __('Job Applications') }}</li>
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
                        <div class="card mb-0">
                            <div class="card-header">
                                <h3 class="card-title">{{ __('My Job Application Status') }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="card mb-0">
                            <div class="card-body">
                                <div class="row">
                                    @foreach ($datas as $data)
                                        <div class="col-xl-3 col-md-6">
                                            <a href="{{ $data['link'] }}">
                                                <div class="card {{ $data['bg-color'] }} text-center p-4 text-white">
                                                    <div class="admin-custom-icon">
                                                        <img src="{{ asset('/themes/fvft/assets/images/svg/' . $data['image']) }}"
                                                            alt="{{ strtok($data['image'], '.') }}"
                                                            class="w-30">
                                                    </div>
                                                    <div class="item-all-text mt-3">
                                                        <p class="mb-0">{{ __($data['title']) }}</p>
                                                        <h1 class="mb-0 mt-1">{{ $data['totalcount'] }}</h1>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <h3 class="mt-1 mb-1 ml-1">{{ __($action) }}</h3>
                        <div class="card mb-0">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table card-table table-vcenter text-nowrap">
                                        <thead>
                                            <tr>
                                                <th>{{ __('SN') }}</th>
                                                <th>{{ __('Job Title') }}</th>
                                                <th>{{ __('Company Name') }}</th>
                                                <th>{{ __('Country') }}</th>
                                                <th>{{ __('Applied On') }}</th>
                                                <th>{{ __('Status') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($applications as $application)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td><a href="/job/{{ setParameter($application->job, 'id') }}">{{ setParameter($application->job, 'title') }}</a></td>
                                                    <td>{{ setParameter($application->job->company, 'company_name') }}</td>
                                                    <td>{{ setParameter($application->job->country, 'name') }}</td>
                                                    <td>{{ date('Y-m-d', strtotime($application->created_at)) }}</td>
                                                    <td>
                                                        @php
                                                            $statuses = ['pending' => 'Unscreened', 'shortlisted' => 'Shortlisted', 'selectedForInterview' => 'Selected for Interview', 'interviewed' => 'Interviewed', 'accepted' => 'Selected', 'rejected' => 'Rejected', 'redlisted' => 'Red List'];
                                                            $status_indicator_items = ['pending' => 'gray', 'shortlisted' => 'pink', 'selectedForInterview' => 'orange', 'interviewed' => 'orange', 'accepted' => 'green', 'rejected' => 'red', 'redlisted' => 'danger'];
                                                            $status_indicator = $status_indicator_items[$application->status];
                                                            $status_name = $statuses[$application->status];
                                                        @endphp
                                                        <span class="label bg-{{ $status_indicator }}">{{ $status_name }}</span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="center-block align-items-center text-center">
                                    {{ $applications->links('vendor.pagination.bootstrap-4') }}
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


@endsection
