@extends('admin.layouts.master')
@section('main')
{{-- @dd($candidate?$candidate); --}}
    <div class="page-header">
        <h4 class="page-title">{{$action}} Candidate</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Modules</a></li>
            <li class="breadcrumb-item" aria-current="page"><a href="/admin/candidates/">Candidate</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add</li>
        </ol>
    </div>

    <div class="row">
        <div class="col-12">
            <form action="/admin/candidates/save" method="post"  enctype="multipart/form-data">
                @csrf
                            <div   class="card">
                                <div class="card-header">
                                    <h3 class="card-title">{{$action}} Candidates</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 col-lg-6">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="form-label">First Name</label>
                                                        <input type="text" class="form-control" name="first_name" placeholder="First Name" value="{{isset($candidate->first_name)?$candidate->first_name:''}}" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="form-label">Middle Name</label>
                                                        <input type="text" class="form-control" name="middle_name" placeholder="Middle Name" value="{{isset($candidate->middle_name)?$candidate->middle_name:''}}" >
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="form-label">Last Name</label>
                                                        <input type="text" class="form-control" name="last_name" placeholder="Last Name" value="{{isset($candidate->last_name)?$candidate->last_name:''}}" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="text" name="id" style="display:none;" value="{{isset($candidate->id)?$candidate->id:''}}">
                                            <input type="text" name="user_id" style="display:none;" value="{{isset($candidate->user_id)?$candidate->user_id:''}}">
                                            <div class="form-group">
                                                <label class="form-label">Date Of Birth</label>
                                                <input type="date" class="form-control" name="dob" placeholder="Date of Birth" value="{{isset($candidate->dob)?$candidate->dob:''}}" required>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Gender</label>
                                                <select name="gender"  class="form-control select2 " value="{{isset($candidate->gender)?$candidate->gender:''}}" >
                                                    <option value="male" {{isset($candidate->gender)?$candidate->gender=="male"?"selected":'':''}} >Male</option>
                                                    <option value="female" {{isset($candidate->gender)?$candidate->gender=="female"?"selected":'':''}}>Female</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Marital Status</label>
                                                <select name="marital_status" class="form-control select2 " value="{{isset($candidate->marital_status)?$candidate->marital_status:''}}">
                                                    <option value="married" {{isset($candidate->marital_status)?$candidate->marital_status=="married"?"selected":'':''}} >Married</option>
                                                    <option value="single" {{isset($candidate->marital_status)?$candidate->marital_status=="single"?"selected":'':''}}>Single</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Nationality</label>
                                                <input type="text" class="form-control" name="nationality" placeholder="nationality" value="{{isset($candidate->nationality)?$candidate->nationality:''}}" required>
                                            </div>
                                        
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="form-label">Country</label>
                                                        <select name="country_id" id="select-country" class="form-control select2 " value="{{isset($candidate->country_id)?$candidate->country_id:''}}" onchange="patchStates(this)">
                                                            @foreach ($countries as $item)
                                                                <option value="{{$item->id}}" {{isset($candidate->country_id)?$item->id==$candidate->country_id?"selected":"":null}}>{{$item->name}}</option>
                                                            @endforeach
                                                    
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="form-label">States</label>
                                                        <select name="state_id" id="select-state" class="form-control select2 " value="{{isset($candidate->state_id)?$candidate->state_id:''}}" onchange="patchCities(this)">
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="form-label">Cities</label>
                                                        <select name="city_id" id="select-city" class="form-control select2 " value="{{isset($candidate->city_id)?$candidate->city_id:''}}">
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                            
                                        </div>
                                        <div class="col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label">Avatar</label>
                                                <input type="file" class="dropify" name="avatar" data-height="180" data-default-file="{{isset($candidate->avatar)?env('APP_URL').$candidate->avatar:''}}">
                                            </div>

                                            <div class="form-group">
                                                <label class="form-label">Street Address</label>
                                                <input type="text" class="form-control" name="address" placeholder="Street Address" value="{{isset($candidate->address)?$candidate->address:''}}">
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Email</label>
                                                <input type="text" class="form-control" name="email" placeholder="Email" value="{{isset($candidate_user->email)?$candidate_user->email:''}}" required>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Phone Number</label>
                                                <input type="text" class="form-control" name="mobile_phone" placeholder="Phone Number" value="{{isset($candidate->mobile_phone)?$candidate->mobile_phone:''}}">
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">{{$action=="New"?"":"New"}} Password</label>
                                                <input type="password" class="form-control" name="password" placeholder="{{$action=="New"?"":"New"}} Password" {{$action=="New"?"required":""}}>
                                            </div>
                                            <div class="form-group">
                                                <label class="custom-switch-checkbox">
                                                    <input type="checkbox" name="is_active" class="custom-switch-input"  {{isset($candidate->is_active)?$candidate->is_active?"checked":'':'checked'}}>
                                                    <span class="custom-switch-indicator"></span>
                                                    <span class="custom-switch-description">Active</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-right">
                                    <div class="d-flex">
                                        <a href="/admin/candidates/" class="btn btn-link">Back</a>
                                        <button type="submit" class="btn btn-success ml-auto">Save </button>
                                    </div>
                                </div>
                            </div>
            </form>
        </div>
    </div>
@endsection
@section('script')
<script src="{{env('APP_URL')}}js/location.js"></script>
<script>
    const _token=$('meta[name="csrf-token"]')[0].content;
    const state_id={{isset($candidate->state_id)?$candidate->state_id:"3871" }};
    const city_id={{isset($candidate->city_id)?$candidate->city_id:"null" }};
    const appurl="{{env('APP_URL')}}";
</script>
@endsection