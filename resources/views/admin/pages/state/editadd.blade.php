@extends('admin.layouts.master')
@section('main')
    <div class="page-header">
        <h4 class="page-title">{{ $action }} State</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Modules</a></li>
            <li class="breadcrumb-item" aria-current="page"><a href="{{ route('admin.state.index') }}">State</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add</li>
        </ol>
    </div>
    <div class="row">
        <div class="col-12">
            <form action="{{ route('admin.state.store') }}" method="post" enctype="multipart/form-data" id="form">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">New State</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 col-lg-6">
                               <div class="form-group">
                                   <input type="hidden" name="id" value="{{ isset($state->id) ? $state->id : old('id') }}">
                               </div>
                                <div class="form-group">
                                    <label class="form-label">State Name</label>
                                    <input type="text" class="form-control" name="name" value="{{ isset($state->name) ? $state->name : old('name') }}" placeholder="State Name">
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>   
                                <div class="form-group">
                                    <label class="form-label">Select Country</label>
                                    <select name="country_id" class="form-control select2-show-search" data-placeholder="Select Country">
                                        <option value="">Select Country</option>
                                        @foreach($countries as $country)
                                        <option value="{{ $country->id }}" {{ isset($state) ? ($country->id == $state->country_id ? 'selected' : '') : (old('country_id') == $country->id ? 'selected' : '') }}>{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('country_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>                           
                                <div class="form-group">
                                    <label class="form-label">Fips Code</label>
                                    <input type="text" class="form-control" name="fips_code" value="{{ isset($state->fips_code) ? $state->fips_code : old('fips_code') }}" placeholder="Enter Fips code, eg, 54">
                                    @error('fips_code')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>                           
                                <div class="form-group">
                                    <label class="form-label">ISO2</label>
                                    <input type="text" class="form-control" name="iso2" value="{{ isset($state->iso2) ? $state->iso2 : old('iso2') }}" placeholder="Iso2">
                                    @error('iso2')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>                           
                            </div>
                            
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <div class="d-flex">
                            <a href="{{ route('admin.state.index') }}" class="btn btn-link">Cancel</a>
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
