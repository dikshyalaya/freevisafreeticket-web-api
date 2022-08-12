@if (isset($latest_jobs) and !blank($latest_jobs))
    <section class="sptb bg-white">
        <div class="container">
            <div class="section-title center-block text-center">
                <div class="row">
                    <div class="col-md-4">
                        <hr class="home_hr">
                    </div>
                    <div class="col-md-4 my-auto">
                        <h1>{{ __("Recent Jobs") }}</h1>
                    </div>
                    <div class="col-md-4">
                        <hr class="home_hr">
                    </div>
                </div>
            </div>
            <div class="text-center">
                @include('themes.fvft.site.components.lessLatestJob')
            </div>
            <div class="text-center">
                @include('themes.fvft.site.components.moreLatestJob')
            </div>
            <div class="mt-4 mx-auto">
                <a href="javascript:void(0);" id="moreRecentJobs"
                    class="btn btn-primary btn-outline-primary">{{ __('View All') }}</a>
                <a href="javascript:void(0);" id="lessRecentJobs"
                    class="btn btn-primary btn-outline-primary d-none">{{ __('View Less') }}</a>
            </div>
        </div>
        </div>
    </section>
@endif
