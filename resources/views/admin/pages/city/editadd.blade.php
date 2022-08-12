@extends('admin.layouts.master')
@section('main')
    <div class="page-header">
        <h4 class="page-title">{{ $action }} City</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Modules</a></li>
            <li class="breadcrumb-item" aria-current="page"><a href="{{ route('admin.city.index') }}">City</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add</li>
        </ol>
    </div>
    <div class="row">
        <div class="col-12">
            <form action="{{ route('admin.city.store') }}" method="post" enctype="multipart/form-data" id="form">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">New City</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 col-lg-6">
                               <div class="form-group">
                                   <input type="hidden" name="id" value="{{ isset($city->id) ? $city->id : old('id') }}">
                               </div>
                                <div class="form-group">
                                    <label class="form-label">City Name</label>
                                    <input type="text" class="form-control" name="name" value="{{ isset($city->name) ? $city->name : old('name') }}" placeholder="City Name">
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>   
                                <div class="form-group">
                                    <label class="form-label">Select Country</label>
                                    <select name="country_id" class="form-control select2-show-search" data-placeholder="Select Country" id="select-country" value="{{ isset($country->id) ?? '' }}" onchange="patchStates(this);">
                                        <option value="">Select Country</option>
                                        @foreach($countries as $country)
                                        <option value="{{ $country->id }}" {{ isset($city) ? ($country->id == $city->country_id ? 'selected' : '') : (old('country_id') == $country->id ? 'selected' : '') }}>{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('country_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>                           
                                <div class="form-group">
                                    <label class="form-label">Select State</label>
                                    <select name="state_id" class="form-control select2-show-search" data-placeholder="Select State" id="select-state" value="{{ isset($city->state_id) ?? '' }}">
                                        
                                    </select>
                                    @error('state_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>                                                    
                            </div>
                            
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <div class="d-flex">
                            <a href="{{ route('admin.city.index') }}" class="btn btn-link">Cancel</a>
                            <button type="submit" class="btn btn-primary ml-auto">Save </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('script')
   <script src="{{ asset('js/location.js') }}"></script>
   <script>
       const appurl = "{{ env('APP_URL') }}";
       const country_id = "{{ isset($city->country_id) ? $city->country_id : '' }}";
       const state_id = "{{ isset($city->state_id) ? $city->state_id : '' }}"
       const _token = $('meta[name="csrf-token"]')[0].content;
   </script>
@endsection
