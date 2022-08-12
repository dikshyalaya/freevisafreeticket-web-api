@auth
    @if (auth()->user()->user_type == 'candidate')
        @php
            $application = \DB::table('job_applications')
                ->where('job_id', $job->id)
                ->where('employ_id', $employ->id)
                ->first();
            $savedJob = App\Models\SavedJob::where('employ_id', $employ->id)->where('job_id', $job->id);
        @endphp
        <div class="col-md-6">
            @if ($savedJob->exists())
                <a href="javascript:void(0);" onclick="savejob({{ $job->id }}, $(this))" class="saveJobButton ico-grid-font btn btn-warning btn-block">
                    <i class="fa fa-heart"></i>
                    {{ __('Saved') }}
                </a>
            @else
                <a href="javascript:void(0);" onclick="savejob({{ $job->id }}, $(this))"
                    class="saveJobButton ico-grid-font btn btn-warning btn-block">
                    <i class="fa fa-heart-o"></i>
                    {{ __('Save Job') }}
                </a>
            @endif
        </div>
        <div class="col-md-6">
            @if ($application)
                <a href="javascript:void(0);" class="btn btn-primary mr-5 btn-block">{{ __('Applied') }}</a>
            @else
                <a href="{{ route('applyForJob', $job->id) }}" class="btn btn-primary mr-5 btn-block">
                    {{ __('Apply Now') }}</a>
            @endif
        </div>
        <div class="col-md-6 mt-3">
            <a href="{{ route('viewJob', $job->id) }}" target="_blank" class="ico-grid-font btn btn-success btn-block">
                <i class="fa fa-eye"></i>&nbsp;{{ __('View Details') }}
            </a>
        </div>
        <div class="col-md-6 mt-3">
            <div class="sharethis-inline-share-buttons" data-url="{{ route('viewJob', $job->id) }}">
            </div>
        </div>
    @elseif(auth()->user()->user_type == 'company')
        <div class="col-md-6 mt-3">
            <a href="{{ route('viewJob', $job->id) }}" target="_blank" class="ico-grid-font btn btn-success btn-block">
                <i class="fa fa-eye"></i>&nbsp;{{ __('View Details') }}
            </a>
        </div>
        <div class="col-md-6 mt-3">
            <div class="sharethis-inline-share-buttons" data-url="{{ route('viewJob', $job->id) }}">
            </div>
        </div>
    @endif
@else
    <div class="col-md-6">
        <a href="{{ route('applyForJob', $job->id) }}" class="btn btn-primary mr-3 btn-block">
            {{ __('Apply Now') }}</a>
    </div>
    <div class="col-md-6 mt-3">
        <a href="{{ route('viewJob', $job->id) }}" target="_blank" class="ico-grid-font btn btn-success btn-block">
            <i class="fa fa-eye"></i>&nbsp;{{ __('View Details') }}
        </a>
    </div>
    <div class="col-md-6 mt-3">
        <div class="sharethis-inline-share-buttons" data-url="{{ route('viewJob', $job->id) }}">
        </div>
    </div>
@endauth
