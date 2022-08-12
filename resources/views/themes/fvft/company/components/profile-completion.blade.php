@if(isset($company) AND !blank($company))
<div class="row">
    <div class="col-md-12">
        <div class="progress">
            <?php $profile_completion = $company->calculateProfileCompletion(); ?>
            <div class="progress-bar" role="progressbar" style="width: {{$profile_completion}}%;"
                 aria-valuenow="{{$profile_completion}}" aria-valuemin="0" aria-valuemax="100">
                {{$profile_completion}}%
            </div>
        </div>
        <small class="text-warning">Profile completion status must be more than <strong>50%</strong> to be able to post new job.</small>
        @if ((int) $profile_completion < 100)
            <a href="{{ route('company.edit_profile') }}" class="float-right btn btn-link">{{ __('Complete your Profile') }}</a>
        @endif
    </div>
</div>
@endif
