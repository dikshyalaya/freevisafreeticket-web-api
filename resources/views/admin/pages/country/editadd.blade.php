@extends('admin.layouts.master')
@section('main')
    <div class="page-header">
        <h4 class="page-title">{{ $action }} Country</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Modules</a></li>
            <li class="breadcrumb-item" aria-current="page"><a href="{{ route('admin.country.index') }}">Country</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add</li>
        </ol>
    </div>
    <div class="row">
        <div class="col-12">
            <form action="{{ route('admin.country.store') }}" method="post" enctype="multipart/form-data" id="form">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">New Country</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 col-lg-6">
                                <div class="form-group">
                                    <input type="hidden" name="id"
                                        value="{{ isset($country->id) ? $country->id : old('id') }}">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Country Name</label>
                                    <input type="text" class="form-control" name="name"
                                        value="{{ isset($country->name) ? $country->name : old('name') }}"
                                        placeholder="Country Name">
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="form-label">ISO2</label>
                                    <input type="text" class="form-control" name="iso2"
                                        value="{{ isset($country->iso2) ? $country->iso2 : old('iso2') }}"
                                        placeholder="Enter country iso2, eg, NE">
                                    @error('iso2')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="form-label">ISO3</label>
                                    <input type="text" class="form-control" name="iso3"
                                        value="{{ isset($country->iso3) ? $country->iso3 : old('iso3') }}"
                                        placeholder="Enter Country ISO3, eg, NEP">
                                    @error('iso3')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Phonecode</label>
                                    <input type="text" class="form-control" name="phonecode"
                                        value="{{ isset($country->phonecode) ? $country->phonecode : old('phonecode') }}"
                                        placeholder="PhoneCode">
                                    @error('phonecode')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Currency</label>
                                    <input type="text" class="form-control" name="currency"
                                        value="{{ isset($country->currency) ? $country->currency : old('currency') }}"
                                        placeholder="Currency">
                                    @error('currency')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Currency Name</label>
                                    <input type="text" class="form-control" name="currency_name"
                                        value="{{ isset($country->currency_name) ? $country->currency_name : old('currency_name') }}"
                                        placeholder="Currency Name">
                                    @error('currency_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Currency Symbol</label>
                                    <input type="text" class="form-control" name="currency_symbol"
                                        value="{{ isset($country->currency_symbol) ? $country->currency_symbol : old('currency_symbol') }}"
                                        placeholder="Currency Symbol">
                                    @error('currency_symbol')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="custom-switch-checkbox">
                                        <input type="checkbox" name="is_active" class="custom-switch-input"
                                            {{ isset($country->is_active) ? ($country->is_active == 1 ? 'checked' : '') : '' }}>
                                        <span class="custom-switch-indicator"></span>
                                        <span class="custom-switch-description">Active</span>
                                    </label>
                                </div>

                            </div>

                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <div class="d-flex">
                            <a href="{{ route('admin.country.index') }}" class="btn btn-link">Cancel</a>
                            <button type="submit" class="btn btn-primary ml-auto">Save </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('script')
@endsection
