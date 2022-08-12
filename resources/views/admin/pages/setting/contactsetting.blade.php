@extends('admin.layouts.master')
@section('main')
    <?php
    use App\Enum\SettingKey;
    $setting_keys = [SettingKey::ADDRESS, SettingKey::PHONE1, SettingKey::PHONE2, SettingKey::EMAIL];
    ?>
    <div class="page-header">
        <h4 class="page-title">Contact Setting</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Modules</a></li>
            <li class="breadcrumb-item" aria-current="page"><a href="{{ route('admin.country.index') }}">Contact
                    Setting</a>
            </li>
        </ol>
    </div>
    <div class="row">
        <div class="col-lg-9">
            <form class="card" action="{{ route('admin.setting.saveContactSetting') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="card-header">
                    <h3 class="card-title">Contact Setting</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        @if (count($settings) > 0)
                            <div class="col-md-12">
                                @foreach ($settings as $key => $setting)
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-3 my-auto">
                                                <label for="">{{ ucfirst($setting->title) }}</label>
                                            </div>
                                            <div class="col-md-9">
                                                <input type="hidden" name="title[]" class="form-control"
                                                    value="{{ $setting->title }}">
                                                <input type="text" name="value[]" class="form-control"
                                                    placeholder="Enter {{ ucfirst($setting->title) }}" value="{{ $setting->value }}">
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
                                                <label for="">{{ ucfirst($setting_key) }} </label>
                                            </div>
                                            <div class="col-md-9">
                                                <input type="hidden" name="title[]" class="form-control"
                                                    value="{{ $setting_key }}">
                                                <input type="text" name="value[]" class="form-control"
                                                    placeholder="Enter {{ ucfirst($setting_key) }}" value="">
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
