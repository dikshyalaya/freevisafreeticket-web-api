<div class="card overflow-hidden shadow-none">
    <div class="d-md-flex">
        <div class="p-0 m-0 item-card9-img">
            <div class="item-card9-imgs">
                <a href="{{ route('viewJob', $job->id) }}"></a>
                @if (!blank($job, 'company') and !blank(data_get($job, 'company.company_logo')))
                    <img src="{{ asset(data_get($job, 'company.company_logo')) }}"
                         alt="img" class="h-100">
                @elseif ($job->feature_image_url)
                    <img src="{{ asset($job->feature_image_url) }}"
                         alt="img" class="h-100">
                @else
                    <img src="{{ asset('images/defaultimage.jpg') }}"
                         alt="img" class="h-100">
                @endif
            </div>
        </div>
        <div
            class="card overflow-hidden  border-0 box-shadow-0 border-left br-0 mb-0">
            <div class="card-body pt-0 pt-md-5">
                <div class="item-card9">
                    <a href="{{ route('viewJob', $job->id) }}"
                       class="text-dark">
                        <h4 class="font-weight-semibold mt-1">
                            {{ $job->title }}({{ $job->num_of_positions }})
                        </h4>
                    </a>
                    <div class="mt-2 mb-2">
                        @if (!blank(data_get($job, 'company.company_name')))
                            <a href="{{ route('site.companydetail', data_get($job, 'company.id')) }}" class="mr-4">
                                <span><i class="fa fa-building-o text-muted mr-1"></i>{{ data_get($job, 'company.company_name') }}</span>
                            </a>
                        @endif

                    </div>
                    <div class="mt-2 mb-2">
                        <a class="mr-4">
                            <span>
                                @if (!blank(data_get($job, 'country')))
                                    <img class="mb-1" src="{{ asset('https://flagcdn.com/16x12/' . strtolower(data_get($job, 'country.iso2')) . '.png') }}" alt="">
                                    {{ data_get($job, 'country.name') }}
                                @endif
                            </span>
                        </a>
                        <a class="mr-4">

                            <span>
                                Basic Salary:
                                <span style="color: blue">
                                    @if (!blank(data_get($job, 'country')))
                                        {{ data_get($job, 'country.currency') ?? '' }}&nbsp;{{ $job->country_salary ?? '' }}&nbsp;&nbsp;
                                    @endif

                                    @if (!blank(data_get($job, 'country')) and data_get($job, 'country.currency') != 'NPR')
                                        NPR: {{ $job->nepali_salary ?? '' }}
                                    @endif
                                </span>
                            </span>
                        </a>
                        <a class="mr-4">
                            <span>
                                Post On:
                                {{ $job->publish_date != null ? date('j M Y', strtotime($job->publish_date)) : '' }}
                            </span>
                        </a>
                        <a class="mr-4">
                            <span>
                                Apply Before:
                                {{ $job->expiry_date != null ? date('j M Y', strtotime($job->expiry_date)) : '' }}
                            </span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-footer pt-3 pb-3">
                <div class="item-card9-footer">
                    <div class="row">
                        @if (auth()->check() and auth()->user()->user_type == 'candidate')
                            <x-job-button :job="$job" :employ="$employ" />
                        @else
                            <x-job-button :job="$job" />
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
