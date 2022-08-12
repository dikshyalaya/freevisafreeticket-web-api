@php 
$user=Auth::user();
@endphp
<div class="card dropify-image-avatar">
    <div class="card-header ">
        <h3 class="card-title">Personal Data</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label class="form-label text-dark">Avatar</label>
                    <input type="file" class="dropify" data-height="180" data-default-file="/{{isset($employe->avatar)?$employe->avatar:''}}">
                </div>
            </div>
            <div class="col-md-9">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label text-dark">First Name</label>
                            <input type="text" class="form-control text-dark" placeholder="First Name" name="first_name" required="" value="{{isset($employe->first_name)?$employe->first_name:''}}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label text-dark">Middle Name</label>
                            <input type="text" class="form-control text-dark" placeholder="Middle Name" name="middle_name" value="{{isset($employe->middle_name)?$employe->middle_name:''}}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label text-dark">Last Name</label>
                            <input type="text" class="form-control text-dark" placeholder="Last Name" name="last_name" value="{{isset($employe->last_name)?$employe->last_name:''}}">
                        </div>
                    </div>

                </div>
                <div class="form-group">
                    <label class="form-label text-dark">Email</label>
                    <input type="text" class="form-control text-dark" placeholder="Email" name="email" value="{{isset($user->email)?$user->email:''}}">
                </div>
                <div class="form-group">
                    <label class="form-label text-dark">Mobile Number</label>
                    <input type="number" class="form-control text-dark" placeholder="Mobile Number" name="mobile_phone" value="{{isset($employe->mobile_phone)?$employe->mobile_phone:''}}">
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label class="form-label text-dark">Date of Birth</label>
                    <input type="date" class="form-control text-dark" placeholder="Date" name="dob" value="{{isset($employe->dob)?$employe->dob:''}}">
                </div>
            </div>
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label text-dark">Gender</label>
                            <select class="form-control select2" data-placeholder="Gender"  name="gender">
                                <option >Choose Gender</option>
                                <option value="male" {{isset($employe->gender)?'male'==$employe->gender?"selected":"":null}}>Male</option>
                                <option value="female" {{isset($employe->gender)?'female'==$employe->gender?"selected":"":null}}>Female</option>
                                <option value="other"{{isset($employe->gender)?'other'==$employe->gender?"selected":"":null}}>Others</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label text-dark">Marital Status</label>
                            <select class="form-control select2" data-placeholder="Marital Status" name="marital_status">
                                <option >Choose Marital Status</option>
                                <option value="married" {{isset($employe->marital_status)?'married'==$employe->marital_status?"selected":"":null}}>Married</option>
                                <option value="unmarried" {{isset($employe->marital_status)?'unmarried'==$employe->marital_status?"selected":"":null}}>UnMarried</option>
                            </select>
                        </div>
                        
                        
                        <div class="form-group">
                            <label class="form-label text-dark">Nationality</label>
                            <input type="text" name="nationality" class="form-control text-dark" placeholder="Nationality" value="{{isset($employe->nationality)?$employe->nationality:''}}">
                        </div>
                    </div>
                </div>

                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">Country</label>
                            <select name="country_id" id="select-country" class="form-control select2 text-dark" value="{{isset($employe->country_id)?$employe->country_id:''}}" onchange="patchStates(this)">
                                @foreach ($countries as $item)
                                    <option value="{{$item->id}}" {{isset($employe->country_id)?$item->id==$employe->country_id?"selected":"":null}}>{{$item->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">States</label>
                            <select name="state_id" id="select-state" class="form-control select2 " value="{{isset($employe->state_id)?$employe->state_id:''}}" onchange="patchCities(this)">
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">Cities</label>
                            <select name="city_id" id="select-city" class="form-control select2 " value="{{isset($employe->city_id)?$employe->city_id:''}}">
                            </select>
                        </div>
                    </div>
                </div>
            </div>  
        </div>
    </div>
</div>