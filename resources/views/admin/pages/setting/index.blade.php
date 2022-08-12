@extends('admin.layouts.master')
@section('main')
    <?php
    use App\Enum\SettingKey;
    $setting_keys = [SettingKey::FB_URL => 'Facebook', SettingKey::GOOGLE_URL => 'Google', SettingKey::LINKEDIN_URL => 'LinkedIn', SettingKey::TWITTER_URL => 'Twitter', SettingKey::GOOGLE_PLAY_STORE => 'Google Play Store', SettingKey::APPLE_PLAY_STORE => 'Apple Play Store'];
    ?>
    <div class="page-header">
        <h4 class="page-title">Social Network Setting</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Modules</a></li>
            <li class="breadcrumb-item" aria-current="page"><a href="{{ route('admin.country.index') }}">Social Network
                    Setting</a>
            </li>
        </ol>
    </div>
    <div class="row">
        <div class="col-lg-9">
            <form class="card" action="{{ route('admin.setting.store') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="card-header">
                    <h3 class="card-title">Social Setting</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        @if (count($settings) > 0)
                            <div class="col-md-12">
                                @foreach ($settings as $key => $setting)
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-3 my-auto">
                                                <label for="">{{ ucwords(str_replace('_', ' ', $setting->title)) }}</label>
                                            </div>
                                            <div class="col-md-9">
                                                <input type="hidden" name="title[]" class="form-control"
                                                    value="{{ $setting->title }}">
                                                <input type="text" name="value[]" class="form-control"
                                                    placeholder="Enter {{ ucwords(str_replace('_', ' ', $setting->title)) }}" value="{{ $setting->value }}">
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="col-md-12">
                                @foreach ($setting_keys as $key => $setting_key)
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-3 my-auto">
                                                <label for="">{{ $setting_key }} Url</label>
                                            </div>
                                            <div class="col-md-9">
                                                <input type="hidden" name="title[]" class="form-control"
                                                    value="{{ $key }}">
                                                <input type="text" name="value[]" class="form-control"
                                                    placeholder="Enter {{ $setting_key }} Url" value="">
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
                <div class="card-footer text-right">
                    <button type="submit" class="btn btn-primary">Update Setting</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('script')
@endsection
