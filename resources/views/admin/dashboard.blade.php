@extends('admin.layouts.master')
@section('title', 'Dashboard')
@section('main')
    <style>
        .gray-round {
            background-color: rgb(166 181 217);
        }

        .img-custom-icon {
            width: 60px;
            height: 60px;
            line-height: 60px;
            text-align: center;
            border-radius: 50%;

        }

        .img-custom-icon>img {
            padding: 17px;

        }

    </style>
    <div class="row">
        <div class="col-md-12">
            <h4 class="font-weight-bold">Dashboard</h4>
            <p class="text-default text-muted mt-1"><small>Administrator panel for customizing Application</small></p>
        </div>
    </div>
    <div class="row">
        @foreach ($first_datas as $f_data)
            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
                <a href="{{ $f_data['link'] }}">
                    <div class="card">
                        <div class="card-body p-4 text-center feature">
                            <div class="fa-stack fa-lg fa-1x icons shadow-default bg-primary-transparent">
                                <i class="{{ $f_data['icon'] }} text-primary"></i>
                            </div>
                            <p class="card-text mt-3 mb-3">{{ __($f_data['title']) }}</p>
                            <p class="h2 text-center text-primary">{{ $f_data['totalcount'] }}</p>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
    {{-- <div class="row">
        @foreach ($second_datas as $s_data)
            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
                <a href="{{ $s_data['link'] }}">
                    <div class="card bg-blue">
                        <div class="card-body p-4 text-center feature">
                            <div class="fa-stack fa-lg fa-1x icons shadow-default gray-round">
                                <i class="{{ $s_data['icon'] }}"></i>
                            </div>
                            <p class="card-text mt-3 mb-3">{{ __($s_data['title']) }}</p>
                            <p class="h2 text-center">{{ $s_data['totalcount'] }}</p>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div> --}}
    <div class="row">
        @foreach ($job_datas as $job_data)
            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
                <a href="{{ $job_data['link'] }}">
                    <div class="card">
                        <div class="card-body p-4 text-center feature">
                            <div class="fa-stack fa-lg fa-1x icons shadow-default bg-primary-transparent">
                                <i class="{{ $job_data['icon'] }}"></i>
                            </div>
                            <p class="card-text mt-3 mb-3">{{ __($job_data['title']) }}</p>
                            <p class="h2 text-center">{{ $job_data['totalcount'] }}</p>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
    <div class="row">
        @foreach ($application_datas as $application_data)
            <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4">
                <div class=" {{ $loop->iteration % 2 == 0 ? 'ml-auto' : '' }}">
                    <div class="card card-aside">
                        <div class="card-body" style="padding: 1rem 1rem;">
                            <div class="col-md-12">
                                <a href="{{ $application_data['link'] }}">
                                    <div class="card-item d-flex mx-auto my-auto">
                                        <div class="img-custom-icon bg-primary">
                                            <img src="{{ asset('themes/fvft/assets/images/svg/' . $application_data['img']) }}"
                                                alt="img" class="w-8 h-8">
                                        </div>
                                        <div class="my-auto ml-5">
                                            <h6 class="font-weight-bold">
                                                {{ $application_data['title'] }}
                                            </h6>
                                        </div>
                                        <div class="my-auto ml-5">
                                            <h6 class="font-weight-bold">
                                                {{ $application_data['totalcount'] }}
                                            </h6>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="row">
        <div class="col-xl-6 col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="chart-wrapper">
                        <canvas id="user-applicant" class="chart-dropshadow h-280"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="chart-wrapper" style="max-height: 310px !important;">
                        <div id="chart-monthly" class="chart-dropshadow h-280"></div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="card">
                <div class="card-header">
                    <div class="row col-md-12">
                        <div class="col-md-6">
                            <div class="row">
                                <h3 class="card-title">New Job Requests</h3>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row float-right">
                                <a href="{{ route('admin.jobs-list') }}" class="text-primary">View All</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table card-table table-vcenter text-nowrap">
                        <thead>
                            <tr>
                                <th>SN</th>
                                <th>Job Title</th>
                                <th>Country</th>
                                <th>Company</th>
                                <th>Applied On</th>
                                <th>View</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($job_requests) > 0)
                                @foreach ($job_requests as $job_request)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $job_request->title }}</td>
                                        <td>{{ !($job_request->country != null && $job_request->country->name != null) ?: $job_request->country->name }}
                                        </td>
                                        <td>{{ !($job_request->company != null && $job_request->company->company_name != null) ?:$job_request->company->company_name }}
                                        </td>
                                        <td>{{ getFormattedDate($job_request->created_at, 'M j, Y') }}</td>
                                        <td>
                                            <a href="{{ route('admin.job.view', $job_request->id) }}"><i
                                                    class="fa fa-eye text-green"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td class="text-center">No Data Found</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <!-- table-responsive -->
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row col-md-12">
                                <div class="col-md-6">
                                    <div class="row">
                                        <h3 class="card-title">Recent Applicants</h3>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row float-right">
                                        <a href="{{ route('admin.applicants.list') }}" class="text-primary">View
                                            All</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table card-table table-vcenter text-nowrap">
                                <thead>
                                    <tr>
                                        <th>SN</th>
                                        <th>Name</th>
                                        <th>Job Title</th>
                                        <th>Applied Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($recent_applicants) > 0)
                                        @foreach ($recent_applicants as $recent_applicant)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ !($recent_applicant->employe != null && $recent_applicant->employe->full_name != null) ?:$recent_applicant->employe->full_name }}
                                                </td>
                                                <td>{{ !($recent_applicant->job != null && $recent_applicant->job->title != null) ?: $recent_applicant->job->title }}
                                                </td>
                                                <td>{{ getFormattedDate($recent_applicant->created_at, 'd/m/Y') }}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td>No Data Found</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-md-6">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row col-md-12">
                                <div class="col-md-6">
                                    <div class="row">
                                        <h3 class="card-title">Recently Published Jobs</h3>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row float-right">
                                        <a href="{{ route('admin.jobs-list') }}" class="text-primary">View All</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table card-table table-vcenter text-nowrap">
                                <thead>
                                    <tr>
                                        <th>SN</th>
                                        <th>Job Title</th>
                                        <th>Company</th>
                                        <th>Posted Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($recent_published_jobs) > 0)
                                        @foreach ($recent_published_jobs as $recent_published_job)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $recent_published_job->title }}</td>
                                                <td>{{ !($recent_published_job->company != null && $recent_published_job->company->company_name != null) ?:$recent_published_job->company->company_name }}
                                                </td>
                                                <td>{{ getFormattedDate($recent_published_job->created_at, 'd/m/Y') }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td>No Data Found</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row col-md-12">
                                <div class="col-md-6">
                                    <div class="row">
                                        <h3 class="card-title">Recently Registered Employers</h3>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row float-right">
                                        <a href="{{ route('admin.companies.list') }}" class="text-primary">View
                                            All</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table card-table table-vcenter text-nowrap">
                                <thead>
                                    <tr>
                                        <th>SN</th>
                                        <th>Name</th>
                                        <th>Country</th>
                                        <th>Registered Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($recent_registered_employers) > 0)
                                        @foreach ($recent_registered_employers as $recent_registered_employer)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $recent_registered_employer->company_name }}
                                                </td>
                                                <td>{{ $recent_registered_employer->country != null && $recent_registered_employer->country->name != null? $recent_registered_employer->country->name: '' }}
                                                </td>
                                                <td>{{ getFormattedDate($recent_registered_employer->created_at, 'd/m/Y') }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td>No Data Found</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row col-md-12">
                                <div class="col-md-6">
                                    <div class="row">
                                        <h3 class="card-title">Recently Registered Users</h3>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row float-right">
                                        <a href="{{ route('admin.jobs-list') }}" class="text-primary">View All</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table card-table table-vcenter text-nowrap">
                                <thead>
                                    <tr>
                                        <th>SN</th>
                                        <th>Name</th>
                                        <th>Gender</th>
                                        <th>Age</th>
                                        <th>Registered Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($recent_registered_users) > 0)
                                        @foreach ($recent_registered_users as $recent_registered_user)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $recent_registered_user->full_name }}</td>
                                                <td>{{ $recent_registered_user->gender }}
                                                <td>{{ $recent_registered_user->calculateAgeFromDateOfBirth() }}
                                                </td>
                                                <td>{{ getFormattedDate($recent_registered_user->created_at, 'd/m/Y') }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td>No Data Found</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <!-- CHARTJS CHART -->
    <script src="{{ asset('/themes/fvft/') }}/assets/plugins/chart/Chart.bundle.js"></script>
    <script src="{{ asset('/themes/fvft/') }}/assets/plugins/chart/utils.js"></script>
    <!-- c3.js Charts Plugin -->
    <script src="{{ asset('/themes/fvft/') }}/assets/plugins/charts-c3/d3.v5.min.js"></script>
    <script src="{{ asset('/themes/fvft/') }}/assets/plugins/charts-c3/c3-chart.js"></script>
    <script>
        $(function(e) {
            'use strict'
            const monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun",
                "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
            ];
            // User Chart Data
            let Dates = new Array();
            let monthName = new Array();
            let UserCount = new Array();
            var userDatas = '<?php echo json_encode($userChartData); ?>';
            userDatas = JSON.parse(userDatas);
            $.each(userDatas, function(key, value) {
                let date = new Date(key);
                monthName.push(monthNames[date.getMonth()]);
                Dates.push(key);
                UserCount.push(value);
            });
            // Applicant Chart Data
            let Aplicantcount = new Array();
            let ApplicantMonthName = new Array();
            let ApplicantDate = new Array();
            var applicantDatas = '<?php echo json_encode($applicantChartData); ?>';
            applicantDatas = JSON.parse(applicantDatas);
            $.each(applicantDatas, function(key, value) {
                let date = new Date(key);
                ApplicantMonthName.push(monthNames[date.getMonth()]);
                ApplicantDate.push(key);
                Aplicantcount.push(value);
            });
            /* chartjs (#user-applicant) */

            var ctx = $('#user-applicant');
            ctx.height(310);
            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: monthNames,
                    type: 'line',
                    datasets: [{
                        label: "Users",
                        data: UserCount,
                        backgroundColor: 'rgb(22, 80, 226,0.1)',
                        borderColor: 'rgb(22, 80, 226) ',
                        borderWidth: 3,
                        pointStyle: 'circle',
                        pointRadius: 0,
                        pointBorderColor: 'transparent',
                        pointBackgroundColor: 'rgb(22, 80, 226)',
                    }, {
                        label: "Applicants",
                        data: Aplicantcount,
                        backgroundColor: 'transparent',
                        borderColor: 'rgb(110, 81, 236)',
                        borderWidth: 3,
                        pointStyle: 'circle',
                        pointRadius: 0,
                        pointBorderColor: 'transparent',
                        pointBackgroundColor: 'rgb(110, 81, 236)',
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    tooltips: {
                        mode: 'index',
                        titleFontSize: 12,
                        titleFontColor: '#000',
                        bodyFontColor: '#000',
                        backgroundColor: '#fff',
                        cornerRadius: 3,
                        intersect: false,
                    },
                    legend: {
                        display: true,
                        labels: {
                            usePointStyle: false,
                        },
                    },
                    scales: {
                        xAxes: [{
                            ticks: {
                                fontColor: "#605e7e",
                            },
                            display: true,
                            gridLines: {
                                display: true,
                                color: 'rgba(96, 94, 126, 0.1)',
                                drawBorder: false
                            },
                            scaleLabel: {
                                display: false,
                                labelString: 'Month',
                                fontColor: 'transparent'
                            }
                        }],
                        yAxes: [{
                            ticks: {
                                fontColor: "#605e7e",
                            },
                            display: true,
                            gridLines: {
                                display: true,
                                color: 'rgba(96, 94, 126, 0.1)',
                                drawBorder: false
                            },
                            scaleLabel: {
                                display: false,
                                labelString: 'sales',
                                fontColor: 'transparent'
                            }
                        }]
                    },
                    title: {
                        display: false,
                        text: 'Normal Legend'
                    }
                }
            });
            /* chartjs (#user-applicant) closed */

        });


        $(document).ready(function() {
            // C3 ChartJS
            var registeredUser = '<?php echo json_encode($registeredUserChartData); ?>';
            registeredUser = Object.values(JSON.parse(registeredUser));
            registeredUser.unshift('data1');
            var chart = c3.generate({
                bindto: '#chart-monthly', // id of chart wrapper
                data: {
                    columns: [
                        // each columns data
                        registeredUser
                    ],
                    type: 'bar', // default type of chart
                    colors: {
                        data1: '#1650e2'
                    },
                    names: {
                        // name of each serie
                        'data1': 'Total Registered Users'
                    }
                },
                axis: {
                    x: {
                        type: 'category',
                        // name of each category
                        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct',
                            'Nov', 'Dec'
                        ]
                    },
                },
                bar: {
                    width: 30
                },
                legend: {
                    show: true, //hide legend
                },
                padding: {
                    bottom: 0,
                    top: 0
                },
            });
        });
    </script>
@endsection
