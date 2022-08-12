@extends('admin.layouts.master')
@section('main')
    <div class="page-header">
        <h4 class="page-title">General Setting</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Modules</a></li>
            <li class="breadcrumb-item" aria-current="page"><a href="{{ route('admin.country.index') }}">General
                    Setting</a>
            </li>
        </ol>
    </div>
    <div class="row">
        {{-- <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Site Settings</h3>

                </div>
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col text-center">
                            <img class="avatar avatar-xl"
                                src="{{ isset($general_setting->logo) ? asset($general_setting->logo) : 'themes/fvft/assets/images/users/male/25.jpg' }}" alt="Avatar-img">
                            <h3 class="mb-1 mt-3">{{ isset($general_setting->name) ? $general_setting->name :'Free Visa Free Ticket' }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
        <div class="col-lg-8">
            <form class="card" action="{{ route('admin.general_setting.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-header">
                    <h3 class="card-title">Edit Setting</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <input type="hidden" class="form-control" value="{{ isset($general_setting->id) ?? null }}" name="id">
                        <div class="col-md-8">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4 my-auto">
                                        <label for="">Site Name</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" name="name" class="form-control" placeholder="Enter Site Name"
                                            value="{{ isset($general_setting->name) ? $general_setting->name : '' }}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4 my-auto">
                                        <label for="">Site Logo</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="file" class="form-control dropify" name="logo" data-default-file="{{ isset($general_setting->logo) ? asset($general_setting->logo) : null }}" data-allowed-file-extensions="jpg png jpeg svg" data-max-file-size="4M">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4 my-auto">
                                        <label for="">Site Favicon</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="file" class="form-control dropify" name="favicon" data-default-file="{{ isset($general_setting->favicon) ? asset($general_setting->favicon) : null }}" data-allowed-file-extensions="jpg png jpeg svg" data-max-file-size="2M">
                                    </div>
                                </div>
                            </div>
                        </div>
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
