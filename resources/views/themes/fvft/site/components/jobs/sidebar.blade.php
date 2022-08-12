
{{-- @dd(Request::query()) --}}
@php
 $salary_range=explode(",",Request::get("salary_from"));   
@endphp
<!--Left Side Content-->
<div class="col-xl-3 col-lg-4 col-md-12">
    <form action="/jobs" method="get">
    
    
    <div class="card">
        <div class="card-body">
            <div class="input-group">
                <input type="text" class="form-control br-tl-3 br-bl-3 text-dark" placeholder="{{ __('Search') }}" name="search" value="{{Request::get('search')}}">
                <div class="input-group-append ">
                    <button type="submit" class="btn btn-primary br-tr-3 br-br-3">
                        {{ __('Search') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h2 class="card-title" >{{ __('Country') }}</h2>
        </div>
        <div class="card-body">
            <select data-placeholder="Choose a Country" class="form-control select2-show-search custom-select " name="country_id">
                <option value="All Countries">{{ __('Choose Country') }}</option>
                @foreach ($countries as $item)  
                    <option value="{{ $item->id }}" @if(Request::has("country_id")) @if(@Request::get('country_id')==$item->id) selected @endif @else @if(@$job_preference->country_id == $item->id) selected @endif @endif>{{ $item->name }}</option>
                @endforeach
            </select>
            
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ __('Categories') }}</h3>
        </div>
        <div class="card-body">
            <div class="" id="container">
                <div class="filter-product-checkboxs">
                    @foreach ($job_categories as $item)                        
                    <label class="custom-control custom-checkbox mb-3">
                        {{-- <input type="checkbox" class="custom-control-input" name="job_catagory[{{ $item->id }}]" value="{{$item->id}}"  @if(Request::has("job_catagory")) @if((@Request::get('job_catagory')[$item->id]==$item->id) || (@Request::get('job_catagory')==$item->id)) checked @endif @else @if(@$job_preference->job_category_id == $item->id) checked @endif @endif > --}}
                        <input type="checkbox" class="custom-control-input" name="job_catagory[]" value="{{$item->id}}"  @if(Request::has("job_catagory")) {{ (request()->job_catagory == $item->id) || (gettype(request()->job_catagory) == 'array' AND in_array($item->id, request()->job_catagory)) ? 'checked' : '' }} @endif >
                        <span class="custom-control-label">
                            <a href="#" class="text-dark">{{ $item->functional_area }}<span class="label label-secondary float-right">{{DB::table('jobs')->where("job_categories_id",$item->id)->count()}}</span></a>
                        </span>
                    </label>
                    @endforeach
                </div>

            </div>
        </div>
        {{-- <div class="card-header border-top">
            <h3 class="card-title">Salary Range</h3>
        </div>
        <div class="card-body">
            <h6>
               <label for="price">Salary Range:</label>
               <input type="text" id="price" >
               <input type="text" id="salary_from" name="salary_from"  style="display:none;" value="{{@Request::get("salary_from")}}">
               <input type="text" id="salary_to" name="salary_to"  style="display:none;" value="{{@Request::get("salary_to")}}">

            </h6>
            <div id="mySlider"></div>
        </div> --}}
        {{-- <div class="card-header border-top">
            <h3 class="card-title">{{ __('Job Type') }}</h3>
        </div>
        <div class="card-body">
            <div class="filter-product-checkboxs">
                @foreach ($job_shifts as $item)
                    
                <label class="custom-control custom-checkbox mb-2">
                    <input type="checkbox" class="custom-control-input" name="job_shift[{{$item->id}}]" value="{{ $item->id}}" @if(@Request::get('job_shift')[$item->id]==$item->id) checked @endif>
                    <span class="custom-control-label">
                       {{ $item->job_shift}}
                    </span>
                </label>
                @endforeach
                
            </div>
        </div> --}}
        
        <div class="card-footer">
            <button  class="btn btn-warning btn-block" type="submit">{{ __('Apply Filter') }}</button>
        </div>
    </div>
</form>
</div>
<!--/Left Side Content-->