@if (isset($job_categories) and !blank($job_categories))
    <section class="sptb">
        <div class="container">
            <div class="section-title center-block text-center">
                <div class="row">
                    <div class="col-md-4">
                        <hr class="home_hr">
                    </div>
                    <div class="col-md-4 my-auto">
                        <h1>{{ __('Jobs By Category') }}</h1>
                    </div>
                    <div class="col-md-4">
                        <hr class="home_hr">
                    </div>
                </div>
            </div>
            <div class="text-center">
                <div class="row" id="limitCategorySection">
                    @foreach (getJobCategories(8) as $job_category)
                        <div class="col-lg-3 col-md-4">
                            <div class="card card-aside">
                                <a href="{{ route('site.jobs', ['job_catagory' => $job_category->id]) }}" class="mx-auto">
                                    <div class="card-body ">
                                        <div class="card-item d-flex">
                                            <div class="ml-4 mx-auto">
                                                <h6 class="font-weight-bold mt-2">{{ $job_category->functional_area }}
                                                </h6>
                                                {{ $job_category->jobs_count }} {{ $job_category->jobs_count > 1 ? 'Jobs' : 'Job' }}
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
                @if (count($job_categories) > 8)
                    <div class="mt-4">
                        <a href="javascript:void(0);" id="moreCategory"
                            class="btn btn-primary btn-outline-primary">{{ __('View All') }}</a>
                        <a href="javascript:void(0);" id="lessCategory"
                            class="btn btn-primary btn-outline-primary d-none">{{ __('View Less') }}</a>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endif
