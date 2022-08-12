@extends('themes.fvft.company.layouts.dashmaster')
@section('css')
    <link href="{{ asset('/') }}themes/fvft/assets/plugins/fileuploads/css/dropify.css" rel="stylesheet" type="text/css">
@endsection
@section('setting')
    active
@endsection
@section('title')
    Settings
@endsection
@section('data')
    <div class="card dropify-image-avatar">
        <div class="card-header ">
            <h3 class="card-title">{{ __('Account Settings') }}</h3>
        </div>
        <form action="{{ route('company.saveSettings') }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label text-dark">{{ __('Email') }}</label>
                            <input type="text" class="form-control text-dark" placeholder="Email" name="email"
                                value="{{ isset($user->email) ? $user->email : '' }}" readonly>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label text-dark">{{ __('New Password') }}</label>
                            <input type="password" class="form-control text-dark" placeholder="Enter Password"
                                value="{{ old('password') }}" name="password" autocomplete="off">
                            @error('password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label text-dark">{{ __('Confirm Password') }}</label>
                            <input type="password" class="form-control text-dark" placeholder="Re-type Password"
                                value="{{ old('confirm-password') }}" name="confirm-password" autocomplete="off">
                            @error('confirm-password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                </div>
                <div class="float-right mb-4 mb-lg-4">
                    <button class="btn btn-primary w-150" type="submit">{{ __('Save') }}</button>
                </div>
            </div>
        </form>
    </div>
    </div>
@endsection
@section('js')
@endsection
