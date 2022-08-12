<div class="row d-none" id="moreLatestJobs">
    <div class="mb-lg-0 col-xl-12 col-lg-12 col-md-12 col-sm-6">
        <div class="">
            <div class="item2-gl">
                <div class="tab-content">
                    <div class="tab-pane active" id="tab-11">
                        @foreach (getLatestJobs() as $latest_job)
                            <div class="card overflow-hidden  shadow-none">
                                <div class="d-md-flex">
                                    <div class="p-0 m-0 item-card9-img">
                                        <div class="item-card9-imgs">
                                            <a href="{{ route('viewJob', $latest_job->id) }}"></a>
                                            @if ($latest_job->feature_image_url)
                                                <img src="{{ asset($latest_job->feature_image_url) }}" alt="img"
                                                     class="h-100">
                                            @else
                                                <img src="{{ asset('images/defaultimage.jpg') }}" alt="img"
                                                     class="h-100">
                                            @endif
                                        </div>
                                    </div>
                                    <div class="card overflow-hidden  border-0 box-shadow-0 border-left br-0 mb-0">
                                        <div class="card-body pt-0 pt-md-5">
                                            <div class="item-card9">
                                                <a href="{{ route('viewJob', $latest_job->id) }}"
                                                   class="text-dark">
                                                    <h4 class="font-weight-semibold mt-1">
                                                        {{ $latest_job->title }}({{ $latest_job->num_of_positions }})
                                                    </h4>
                                                </a>
                                                <div class="mt-2 mb-2">
                                                    @if (!blank(data_get($latest_job, 'company.company_name')))
                                                        <a href="{{ route('site.companydetail', data_get($latest_job, 'company.id')) }}"
                                                           class="mr-4"><span><i class="fa fa-building-o text-muted mr-1"></i>
                                                                {{ data_get($latest_job, 'company.company_name') }}</span></a>
                                                    @else
                                                        <a href="#" class="mr-4">
                                                            <span><i class="fa fa-building-o text-muted mr-1"></i>Not-Available</span>
                                                        </a>
                                                    @endif
                                                </div>
                                                <div class="mt-2 mb-2">
                                                    <a class="mr-4">
                                                    <span>
                                                        @if (!blank(data_get($latest_job, 'country')))
                                                            <img class="mb-1"
                                                                 src="{{ asset('https://flagcdn.com/16x12/' . strtolower(data_get($latest_job, 'country.iso2')) . '.png') }}"
                                                                 alt="">
                                                            {{ data_get($latest_job, 'country.name') }}
                                                        @else
                                                           Address Unavailable
                                                        @endif
                                                    </span>
                                                    </a>
                                                    <a class="mr-4">
                                                    <span>
                                                        Basic Salary:
                                                        <span style="color: blue">
                                                            @if (!blank(data_get($latest_job, 'country')))
                                                                {{ data_get($latest_job, 'country.currency') ?? '' }}&nbsp;{{ $latest_job->country_salary ?? '' }}&nbsp;&nbsp;
                                                            @endif
                                                            @if (!blank($latest_job, 'country') and data_get($latest_job, 'country.currency') != 'NPR')
                                                                NPR:
                                                                {{ $latest_job->nepali_salary ?? '' }}
                                                            @endif

                                                        </span>
                                                    </span>
                                                    </a>
                                                    <a class="mr-4">
                                                    <span>
                                                        Post On:
                                                        {{ $latest_job->publish_date != null ? date('j M Y', strtotime($latest_job->publish_date)) : '' }}
                                                    </span>
                                                    </a>
                                                    <a class="mr-4">
                                                    <span>
                                                        Apply Before:
                                                        {{ $latest_job->expiry_date != null ? date('j M Y', strtotime($latest_job->expiry_date)) : '' }}
                                                    </span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer pt-3 pb-3">
                                            <div class="item-card9-footer">
                                                <div class="row">
                                                    @auth
                                                        @if (auth()->user()->user_type == 'candidate')
                                                            @php
                                                                $application = \DB::table('job_applications')
                                                                    ->where('job_id', $latest_job->id)
                                                                    ->where('employ_id', $employ->id)
                                                                    ->first();
                                                                $savedJob = App\Models\SavedJob::where('employ_id', $employ->id)->where('job_id', $latest_job->id);
                                                            @endphp

                                                            <div class="col-md-3">
                                                                @if ($application)
                                                                    <a href="javascript:void(0);"
                                                                       class="btn btn-primary mr-5 btn-block">{{ __('Applied') }}</a>
                                                                @else
                                                                    <a href="{{ route('applyForJob', $latest_job->id) }}}}"
                                                                       class="btn btn-primary mr-5 btn-block">
                                                                        {{ __('Apply Now') }}</a>
                                                                @endif
                                                            </div>
                                                            <div class="col-md-3">
                                                                @if ($savedJob->exists())
                                                                    <a href="javascript:void(0);"
                                                                       class="saveJobButton btn btn-warning btn-block">
                                                                        <i class="fa fa-heart"></i>
                                                                        {{ __('Saved') }}
                                                                    </a>
                                                                @else
                                                                    <a href="javascript:void(0);"
                                                                       onclick="savejob({{ $latest_job->id }}, $(this))"
                                                                       class="saveJobButton btn btn-block btn-warning">
                                                                        <i class="fa fa-heart-o"></i>
                                                                        {{ __('Save Job') }}
                                                                    </a>
                                                                @endif
                                                            </div>
                                                            <div class="col-md-3">
                                                                <a href="{{ route('viewJob', $latest_job->id) }}}}"
                                                                   class="btn btn-warning btn-block">
                                                                    <i
                                                                        class="fa fa-eye"></i>&nbsp;{{ __('View Details') }}
                                                                </a>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="sharethis-inline-share-buttons"
                                                                     data-url="{{ route('viewJob', $latest_job->id) }}">
                                                                </div>
                                                            </div>
                                                        @elseif(auth()->user()->user_type == 'company')
                                                            <div class="col-md-3">
                                                                <a href="{{ route('viewJob', $latest_job->id) }}}}"
                                                                   class="btn btn-warning btn-block">
                                                                    <i
                                                                        class="fa fa-eye"></i>&nbsp;{{ __('View Details') }}
                                                                </a>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="sharethis-inline-share-buttons"
                                                                     data-url="{{ route('viewJob', $latest_job->id) }}">
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @else
                                                        <div class="col-md-3">
                                                            <a href="{{ route('applyForJob', $latest_job->id) }}}}"
                                                               class="btn btn-primary mr-3 btn-block">
                                                                {{ __('Apply Now') }}</a>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <a href="{{ route('candidate.login', ['name' => 'login']) }}"
                                                               class="saveJobButton btn btn-warning btn-block">
                                                                <i class="fa fa-heart-o"></i>
                                                                {{ __('Save Job') }}
                                                            </a>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <a href="{{ route('viewJob', $latest_job->id) }}}}"
                                                               class="btn btn-warning btn-block">
                                                                <i
                                                                    class="fa fa-eye"></i>&nbsp;{{ __('View Details') }}
                                                            </a>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="sharethis-inline-share-buttons"
                                                                 data-url="{{ route('viewJob', $latest_job->id) }}"></div>
                                                        </div>

                                                    @endauth
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
