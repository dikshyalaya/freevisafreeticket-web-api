@extends('admin.layouts.master')
@section('main')
    <style>
        .status_pane .tab-menu-heading {
            padding: 5px;
            border: none !important;
            border-bottom: 0;
        }
    </style>
    <div class="page-header">
        <h4 class="page-title">Job Categories</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Modules</a></li>
            <li class="breadcrumb-item" aria-current="page"><a href="{{ route('admin.job_category.index') }}">Job
                    Categories</a>
            </li>
        </ol>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card status_pane">
                {{-- <div class="card-header d-flex">
                    <h3 class="card-title" style="width: 100%;">Job Categories List</h3>
                    <div class="d-flex flex-row-reverse mb-2">

                        <a type="button" class="btn btn-primary" href="{{ route('admin.job_category.create') }}"><i
                                class="fe fe-plus mr-2"></i>Add New</a>
                    </div>
                </div> --}}
                <div class="card-body">
                    <div class="panel panel-primary">
                        <div class="row">
                            <div class="col-md-10 col-lg-10 pl-2 mb-2">
                                <div class="tab-menu-heading">
                                    <div class="tabs-menu1 ">
                                        <!-- Tabs -->
                                        <ul class="nav panel-tabs">
                                            <li class="">
                                                <a href="{{ route('admin.job_category.index', ['title' => request('title', ''), 'status' => 'Active']) }}"
                                                    class="{{ !(request()->status == 'Active') ?: 'active' }} ml-0">Active</a>
                                            </li>
                                            <li class="">
                                                <a href="{{ route('admin.job_category.index', ['title' => request('title', ''), 'status' => 'Pending']) }}"
                                                    class="{{ !(request()->status == 'Pending') ?: 'active' }}">Pending</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 col-lg-2">
                                <a href="{{ route('admin.job_category.create') }}" class="btn btn-primary float-right mt-1">
                                    <i class="fe fe-plus mr-2"></i>Add New</a>
                            </div>
                            <div class="col-md-12 col-lg-12">
                                <form action="{{ route('admin.job_category.index') }}" method="GET">
                                    <div class="row">
                                        <div class="col-md-3 mb-3">
                                            <input type="text" name="title" value="{{ request('title') }}"
                                                class="form-control" placeholder="Search By Title">
                                        </div>
                                        <div class="col-md-4">
                                            <button type="submit" class="btn btn-primary">Filter</button>
                                        </div>

                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive border-top">
                        <table class="table table-bordered table-hover mb-0 text-nowrap">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Functional Area</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($job_categories as $job_category)
                                    <tr>
                                        <td>
                                            <img src="{{ asset($job_category->image_url) }}" class="imageSize"
                                                alt="">
                                        </td>
                                        <td>{{ $job_category->functional_area }}</td>

                                        <td>

                                            <div data-toggle="tooltip" data-original-title="Edit"
                                                style="display: inline-block;">
                                                <a class="btn btn-success btn-sm text-white mb-1"
                                                    href="{{ route('admin.job_category.edit', $job_category->id) }}"><i
                                                        class="fa fa-pencil"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center mt-3">
                        {{ $job_categories->links('vendor.pagination.bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script></script>
@endsection
