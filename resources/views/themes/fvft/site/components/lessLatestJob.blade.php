<div class="row" id="lessLatestJobs">
    <div class="mb-lg-0 col-xl-12 col-lg-12 col-md-12 col-sm-6">
        <div class="">
            <div class="item2-gl">
                <div class="tab-content">
                    <div class="tab-pane active" id="tab-11">
                        @foreach (getLatestJobs(4) as $latest_job)
                            @include('themes.fvft._partials.job.preview-card', ['job' => $latest_job])
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
