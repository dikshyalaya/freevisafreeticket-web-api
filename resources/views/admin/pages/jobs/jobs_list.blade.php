@extends('admin.layouts.master')
@section('title', 'Job List')
@section('main')
    <link rel="stylesheet" href="{{ asset('css/datepicker.min.css') }}">
    <style>
        .status_pane .tab-menu-heading {
            padding: 5px;
            border: none !important;
            border-bottom: 0;
        }

    </style>
    @php
    $images = '[';
    $countriesDOM = '[';
    @endphp
    {{-- @dd(Route::current()) --}}
    @if (request()->get('dstatus') == 'sucess')
        <div id="statusmsg" class="alert alert-success fade show" role="alert"
            style="display:fixed;position: absolute;z-index: 11;top: 60px !important;right:20px;"><button type="button"
                class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <i class="fa fa-check-circle-o mr-2" aria-hidden="true"></i> Job Deleted.
        </div>
    @elseif(request()->get('dstatus') == 'failed')
        <div id="statusmsg" class="alert alert-danger fade show" role="alert"
            style="display:fixed;position: absolute;z-index: 11;top: 60px !important;right:20px;">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i
                class="fa fa-frown-o mr-2" aria-hidden="true"></i>Failed ! To Delete.
        </div>
    @endif
    <div class="page-header">
        <h4 class="page-title">Jobs Listing</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Modules</a></li>
            <li class="breadcrumb-item active" aria-current="page">Jobs</li>
        </ol>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card status_pane">
                <div class="card-body">
                    <div class="panel panel-primary">
                       <div class="row">
                           <div class="col-md-10 col-lg-10 pl-2 mb-2">
                               <div class="tab-menu-heading">
                                   <div class="tabs-menu1 ">
                                       <!-- Tabs -->
                                       <ul class="nav panel-tabs">
                                           <li class="">
                                               <a href="{{ route('admin.jobs-list', ['title' => request('title', ''), 'category_id' => request('category_id',''), 'employer_id' => request('employer_id',''), 'country_id' => request('country_id',''), 'job_status' => 'Active']) }}" class="{{ !(request()->job_status=='Active') ?: 'active' }} ml-0">Active</a>
                                           </li>
                                           <li class="">
                                               <a href="{{ route('admin.jobs-list', ['title' => request('title', ''), 'category_id' => request('category_id',''), 'employer_id' => request('employer_id',''), 'country_id' => request('country_id',''), 'job_status' => 'Pending']) }}" class="{{ !(request()->job_status=='Pending') ?: 'active' }}">Pending</a>
                                           </li>
                                           <li>
                                               <a href="{{ route('admin.jobs-list', ['title' => request('title', ''), 'category_id' => request('category_id',''), 'employer_id' => request('employer_id',''), 'country_id' => request('country_id',''), 'job_status' => 'Approved']) }}" class="{{ !(request()->job_status=='Approved') ?: 'active' }}">Approved</a>
                                           </li>
                                           <li>
                                               <a href="{{ route('admin.jobs-list', ['title' => request('title', ''), 'category_id' => request('category_id',''), 'employer_id' => request('employer_id',''), 'country_id' => request('country_id',''), 'job_status' => 'Published']) }}" class="{{ !(request()->job_status=='Published') ?: 'active' }}">Published</a>
                                           </li>
                                           <li>
                                               <a href="{{ route('admin.jobs-list', ['title' => request('title', ''), 'category_id' => request('category_id',''), 'employer_id' => request('employer_id',''), 'country_id' => request('country_id',''), 'job_status' => 'Expired']) }}" class="{{ !(request()->job_status=='Expired') ?: 'active' }}">Expired</a>
                                           </li>
                                       </ul>
                                   </div>
                               </div>
                           </div>
                           <div class="col-md-2 col-lg-2">
                               <a href="/admin/jobs-new" class="btn btn-primary float-right mt-1">
                                   <i class="fe fe-plus mr-2"></i>Add New</a>
                           </div>
                           <div class="col-md-12 col-lg-12">
                               <form action="{{ route('admin.jobs-list') }}" method="GET">
                                   <div class="row">
                                       <div class="col-md-3 mb-3">
                                           <input type="text" name="title" value="{{ request('title') }}" class="form-control"
                                                  placeholder="Search By Title">
                                       </div>
                                       <div class="col-md-3 mb-3">
                                           <select name="category_id" class="form-control">
                                               <option value="">Select Category</option>
                                               @foreach ($job_categories as $job_category)
                                                   <option value="{{ $job_category->id }}"
                                                       {{ request('category_id') == $job_category->id ? 'selected' : '' }}>
                                                       {{ $job_category->functional_area }}
                                                   </option>
                                               @endforeach
                                           </select>
                                       </div>
                                       <div class="col-md-3 mb-3">
                                           <select name="employer_id" class="form-control">
                                               <option value="">Select Employer</option>
                                               @foreach ($companies as $company)
                                                   <option value="{{ $company->id }}"
                                                       {{ request('employer_id') == $company->id ? 'selected' : '' }}>
                                                       {{ $company->company_name }}
                                                   </option>
                                               @endforeach
                                           </select>
                                       </div>
                                       <div class="col-md-3 mb-3">
                                           <select name="country_id" class="form-control">
                                               <option value="">Select Country</option>
                                               @foreach ($countries as $country)
                                                   <option value="{{ $country->id }}"
                                                       {{ request('country_id') == $country->id ? 'selected' : '' }}>
                                                       {{ $country->name }}
                                                   </option>
                                               @endforeach
                                           </select>
                                       </div>
                                       {{--<div class="col-md-4 mb-3">--}}
                                       {{--@php--}}
                                       {{--$statuses = ['Active', 'Pending', 'Approved', 'Published', 'Expired'];--}}
                                       {{--@endphp--}}
                                       {{--<select name="job_status" class="form-control d-none">--}}
                                       {{--<option value="">Select Status</option>--}}
                                       {{--@foreach ($statuses as $value)--}}
                                       {{--<option value="{{ $value }}"--}}
                                       {{--{{ request('job_status') == $value ? 'selected' : '' }}>{{ $value }}--}}
                                       {{--</option>--}}
                                       {{--@endforeach--}}
                                       {{--</select>--}}
                                       {{--</div>--}}
                                       <div class="col-md-4">
                                           <button type="submit" class="btn btn-primary">Filter</button>
                                       </div>

                                   </div>
                               </form>
                           </div>
                       </div>

                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive border-top">
                        <table class="table table-bordered table-hover mb-0 text-nowrap">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Company</th>
                                    <th>Country</th>
                                    <th>Featured</th>
                                    <th>Status</th>
                                    <th>Created Date</th>
                                    {{-- <th>Job Status</th>
                                    <th>Publish Status</th> --}}
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($jobs as $job)
                                    <tr>

                                        <td><img src="/{{ $job->feature_image_url }}" alt="" srcset="" width="50px"></td>
                                        <td>{{ $job->title }}</td>
                                        <td>
                                            {{ !($job->job_category != null && $job->job_category->functional_area != null) ?:$job->job_category->functional_area }}
                                        </td>
                                        <td>
                                            {{-- {{ DB::table('companies')->find($job->company_id)->company_name ?? '' }} --}}
                                            {{ $job->company->company_name ?? 'Not-Available' }}
                                        </td>
                                        <td>
                                            {{ $job->country->name ?? 'Not-Available' }}
                                        </td>
                                        <td>
                                            <i class="fa fa-{{ $job->is_featured ? 'check-' : '' }}circle-o {{ $job->is_featured ? 'text-success' : 'text-warning' }}"></i>
                                        </td>
                                        {{-- <td>
                                            <span
                                                class="label label-{{ $job->is_active ? 'success' : 'warning' }}">{{ $job->is_active ? 'Active' : 'Inactive' }}</span>
                                        </td> --}}
                                        <td>
                                            @php
                                                $job_status = ['Draft' => 'primary', 'Pending' => 'warning', 'Active' => 'success', 'Approved' => 'success', 'Not Approved' => 'warning', 'Published' => 'success', 'Unpublished' => 'warning', 'Expired' => 'danger', 'Rejected' => 'danger'];
                                            @endphp
                                            <span class="label label-{{ $job_status[$job->status] ?? '' }}">
                                                {{ $job->status }}
                                            </span>
                                        </td>
                                        <td>{{ getFormattedDate($job->created_at, 'M j, Y') }}</td>
                                        {{-- <td>
                                            @php
                                                // $job_status = $job->status == 'Published' || $job->status == 'Approved' ? 'success' : ($job->status == 'Expired' ? 'danger' : 'warning');
                                                $job_status = $job->status == 'Approved' ? 'success' : 'warning';
                                            @endphp
                                            <span class="label label-{{ $job_status }}">
                                                {{ $job->status }}
                                            </span>

                                        </td> --}}
                                        {{-- <td>
                                            @php

                                                $job_status_color = $job->publish_status == 1 ? 'success' : 'warning';
                                                $published_status = $job->publish_status == 1 ? 'Published' : 'Not Published';
                                            @endphp
                                            <span class="label label-{{ $job_status_color }}">
                                                {{ $published_status }}
                                            </span>
                                        </td> --}}

                                        <td>

                                            {{-- @include('admin.pages.jobs.components.edit_model',[
                                            "action"=>"Edit",
                                            "job"=>$job,
                                            "companies"=>$companies,
                                            "experiencelevels"=>$experiencelevels,
                                            "job_shifts"=>$job_shifts,
                                            "job_categories"=>$job_categories,
                                            "educationlevels"=>$educationlevels
                                            ]) --}}
                                            {{-- onclick="patchOptions(countries,'#select-countries-{{ $job->id }}',{{ $job->country_id }});" --}}
                                            {{-- <div data-toggle="tooltip" data-original-title="Edit"
                                                style="display: inline-block;">
                                                <a class="btn btn-success btn-sm text-white mb-1" data-toggle="modal"
                                                    data-target="#EditJob{{ $job->id }}"><i
                                                        class="fa fa-pencil"></i></a>
                                            </div> --}}
                                            <a class="btn btn-primary btn-sm text-white mb-1" data-toggle="tooltip"
                                                data-original-title="Edit Job"
                                                href="{{ route('admin.editJob', $job->id) }}"><i
                                                    class="fa fa-edit"></i></a>
                                            <a class="btn btn-primary btn-sm text-white mb-1" data-toggle="tooltip"
                                                data-original-title="View Job"
                                                href="{{ route('admin.job.view', $job->id) }}"><i
                                                    class="fa fa-eye"></i></a>
                                            <a class="btn btn-danger btn-sm text-white mb-1" data-id="{{ $job->id }}" data-action="{{ route('admin.jobs.delete', $job->id) }}" data-method="{{ getRouteMethodName('admin.jobs.delete') }}" data-modaltitle="Delete Job" data-toggle="modal"
                                                data-target="#dataDeleteModal"><i class="fa fa-trash-o"></i></a><br>
                                            {{-- <a class="btn btn-danger btn-sm text-white mb-1" data-toggle="tooltip"
                                                data-original-title="Delete"
                                                href="http://127.0.0.1:8000/admin/jobs-delete?id={{ $job->id }}&from={{ $jobs->currentPage() }}"><i
                                                    class="fa fa-trash-o"></i></a><br> --}}
                                        </td>
                                    </tr>
                                    <?php
                                    $images = $images . "{'id':" . $job->id . ",'url':'" . env('APP_URL') . $job->feature_image_url . "'},";
                                    $countriesDOM = $countriesDOM . "{'id':'#select-countries-" . $job->id . "','active_id':" . $job->country_id . '},';
                                    ?>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center mt-3">
                        {{ $jobs->links('vendor.pagination.bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>
    <script>
        $(function() {
            $('.datetime').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                todayHighlight: true,
            });


        });

        $(".JobModal").on('hide.bs.modal', function(e) {
            $(".require").css('display', 'none');
        });

        function submitForm(e, JobId) {
            e.preventDefault();
            $('.require').css('display', 'none');
            let url = $("#jobForm" + JobId).attr("action");
            $.ajax({
                url: url,
                type: 'post',
                data: new FormData($("#jobForm" + JobId)[0]),
                processData: false,
                contentType: false,
                cache: false,
                success: function(data) {
                    //    return true;
                    if (data.db_error) {
                        $(".alert-warning").css('display', 'block');
                        $(".db_error").html(data.db_error);
                    } else if (data.errors) {
                        var error_html = "";
                        $.each(data.errors, function(key, value) {
                            error_html = '<div>' + value + '</div>';
                            $('.' + key).css('display', 'block').html(error_html);
                        });
                    } else if (!data.errors && !data.db_error) {
                        location.href = data.redirectRoute;
                        toastr.success(data.msg);
                    }
                }
            });
        }
    </script>
    <script>
        // const images = {
        //     !!$images = $images.
        //     "]"!!
        // };
        // const countriesDOM = {
        //     !!$countriesDOM = $countriesDOM.
        //     "]"!!
        // }
        $(document).ready(function() {
            loadCountries();
            // images.forEach(image => {
            //     loadImage('feature_image' + image.id, image.url);
            // });
            // loadCountries((countries)=>{
            //     // console.log(countriesDOM);
            // });
            // countriesDOM.forEach(cdom=>{
            //     patchOptions(countries,cdom.id,cdom.active_id)
            // });
            $("#statusmsg").delay(4000).slideUp(200, function() {
                $(this).alert('close');
            });
        });
        const _token = $('meta[name="csrf-token"]')[0].content;
        let countries = [];
        let states = [];
        let cities = [];

        const loadCountries = () => {
            fetch('http://127.0.0.1:8000/ajax/countries', {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    _token: _token
                })
            }).then(res => res.json()).then(json => {
                countries = json;
                // callback(countries);
            })
        }
        const loadStates = (country_id) => {
            fetch('http://127.0.0.1:8000/ajax/states', {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    _token: _token
                })
            }).then(res => res.json()).then(json => {
                states = json;
                callback(states);

            })
        }
        const loadCities = (state_id, callback) => {
            fetch('http://127.0.0.1:8000/ajax/cities', {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    _token: _token
                })
            }).then(res => res.json()).then(json => {
                cities = json;
                callback(cities);
            })
        }
        // const patchAllOptions=(country_id,state_id,city_id)=>{
        //     patchOptions()
        // }
    </script>
@endsection
