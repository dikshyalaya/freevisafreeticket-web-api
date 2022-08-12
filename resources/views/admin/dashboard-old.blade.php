@extends('admin.layouts.master')
@section('main')
        <div class="page-header">
            <h4 class="page-title">Dashboard</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="/admin">Dashboard</a></li>
            </ol>
        </div>

        <div class="row">
            @foreach ($totals as $item)
            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-3 ">
                <div class="card overflow-hidden">
                    <div class="card-header">
                        <h3 class="card-title">{{ $item["title"] }}</h3>
                        <div class="card-options"> <a class="btn btn-sm btn-primary" href="{{ env('APP_URL').$item["links"] }}">View</a> </div>
                    </div>
                    <div class="card-body ">
                        <h5 class="">Total {{ $item["title"]}}</h5>
                        <h2 class="text-dark  mt-0 ">{{ $item["total"] }}</h2>
                        <div class="progress progress-sm mt-0 mb-2">
                            <div class="progress-bar bg-primary w-75" role="progressbar"></div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>



        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Companies</div>
                    </div>
                    <div class="card-body">
                        <div class="ibox teams mb-30 bg-boxshadow">
                            <!-- Ibox Content -->
                            <div class="ibox-content teams">
                                <!-- Members -->
                                <div class="avatar-list avatar-list-stacked">
                                    @foreach ($companies as $item)
                                    <span class="avatar brround cover-image cover-image" data-image-src="{{asset('/')}}{{$item->company_logo}}" style="background: url(&quot;{{asset('themes/fvft/')}}/assets/images/users/female/12.jpg&quot;) center center;"></span>
                                    @endforeach

                                    <span class="avatar brround cover-image cover-image">{{ $totals[0]["total"]-10 >0?"+".$totals[0]["total"]-10:"" }}</span>
                                </div>
                                <!-- Team Board Details -->
                                <div class="teams-board-details mt-3">
                                    <h4 class="font-weight-semibold">About Companies Team</h4>
                                    <p>Companies are looking for employes .</p>
                                </div>
                                <!-- Progress Details -->
                                <span class="font-weight-semibold">Status of current JobSeekers:</span>
                                <div class="progress-details-teams mt-2 mb-4">
                                    <div class="stat-percent mb-2">{{ round((($totals[2]["total"]-$totals[3]["total"])/$totals[1]["total"])*100,2) }}%</div>
                                    <div class="progress progress-sm ">
                                        <div class="progress-bar bg-primary w-{{ round((($totals[2]["total"]-$totals[3]["total"])/$totals[1]["total"])*100)}}" role="progressbar"></div>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-4">
                                        <div class="teams-rank text-muted">Jobs</div>
                                        <span>{{$totals[1]["total"]}}</span>
                                    </div>
                                    <div class="col-4">
                                        <div class="teams-rank text-muted">Candidates</div>
                                        <span>{{$totals[2]["total"]}}</span>
                                    </div>
                                    <div class="col-4">
                                        <div class="teams-rank text-muted"> Application</div>
                                        <span>{{$totals[3]["total"]}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @foreach ($latest_jobs as $item)
            @php
                $job_shift=\DB::table('job_shifts')->find($item->job_shift_id);
                $company=\DB::table('companies')->find($item->company_id);
            @endphp
            <div class="col-xl-4 col-lg-6 col-md-12">
                <div class="item">
                <div class="card">
                    <div class="arrow-ribbon bg-info">{{$job_shift?$job_shift->job_shift:""}}</div>
                    <div class="item-card7-img">
                        <div class="item-card7-imgs">
                            <a href="/jobs/{{$item->id}}"></a>
                            <img src="{{asset('/')}}{{$item->feature_image_url}}" alt="img" class="cover-image">
                        </div>
                        <div class="item-card7-overlaytext">
                            <a href="/admin/jobs" class="text-white"> Jobs</a>
                            <h4 class="font-weight-semibold mb-0">Rs.{{$item->salary_from}} / Rs.{{$item->salary_to}}</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="item-card7-desc">
                            <a href="/admin/jobs/{{$item->id}}" class="text-dark"><h4 class="font-weight-semibold">{{$item->title}}</h4></a>
                        </div>
                        <div class="item-card7-text">
                            <ul class="icon-card mb-0">
                                <li class=""><a href="#" class="icons"><i class="si si-location-pin text-muted mr-1"></i>
                                        {{\DB::table('cities')->find($item->city_id)->name ?? ''}},{{\DB::table('countries')->find($item->country_id)->name ?? ''}}
                                    </a>
                                </li>
                                <li><a href="#" class="icons"><i class="si si-event text-muted mr-1"></i> {{$item->updated_at ?? ''}}</a></li>
                                <li class="mb-0"><a href="#" class="icons"><i class="si si-user text-muted mr-1"></i>{{$company->company_name ?? ''}}</a></li>
                                <li class="mb-0"><a href="#" class="icons"><i class="si si-phone text-muted mr-1"></i> {{$company->company_phone ?? ''}}</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            </div>
            @endforeach
        </div>
@endsection
