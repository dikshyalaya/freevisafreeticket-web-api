<div class="card mb-0">
    <div class="card-body">
        <h3 class="card-title">{{ __('Profile Status') }}</h3>
        <div class="row">
            <div class="col-md-12">
                <div class="progress">
                    <?php $profile_completion = $employee->calculateProfileCompletion(); ?>
                    <div class="progress-bar" role="progressbar" style="width: {{$profile_completion}}%; font-size: 12px;"
                         aria-valuenow="{{$profile_completion}}" aria-valuemin="0" aria-valuemax="100">
                        {{$profile_completion}}%
                    </div>
                </div>
                <small class="text-warning">Profile completion status must be more than <strong>50%</strong> to be able to apply for job.</small>
                @if ((int) $profile_completion < 100)
                    <a href="{{ route('candidate.profile.get_personal_information') }}" class="float-right btn btn-link">{{ __('Complete your Profile') }}</a>
                @endif
            </div>
        </div>
    </div>
</div>
