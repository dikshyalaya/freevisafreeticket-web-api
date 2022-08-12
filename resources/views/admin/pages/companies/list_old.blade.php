@php
$delete=[];
if(session()->get('delete')){
$delete=session()->get('delete');
session()->forget('delete');
}
@endphp
@extends('admin.layouts.master')
@section('main')
@if($delete)
@if($delete["status"]=="success")
<div id="statusmsg" class="alert alert-success fade show flash" role="alert" style="display:fixed;position: absolute;z-index: 11;top: 60px !important;right:20px;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <i class="fa fa-check-circle-o mr-2" aria-hidden="true"></i> Company Deleted.
</div>
@else
<div id="statusmsg" class="alert alert-danger fade show flash" role="alert" style="display:fixed;position: absolute;z-index: 11;top: 60px !important;right:20px;">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="fa fa-frown-o mr-2" aria-hidden="true"></i>Failed ! To Delete.
</div>
@endif
@endif
<div class="page-header">
    <h4 class="page-title">Companies</h4>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Modules</a></li>
        <li class="breadcrumb-item" aria-current="page"><a href="/admin/companies/">Company</a></li>
    </ol>
</div>
<div class="row">
    <div class="col-lg-12">

        <div class="card">
            <div class="card-header d-flex">
                <h3 class="card-title" style="width: 100%;">Companies List</h3>
                <div class="d-flex flex-row-reverse mb-2">

                    <a type="button" class="btn btn-primary" href="{{ route('admin.companies.create') }}"><i class="fe fe-plus mr-2"></i>Add New</a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive border-top">
                    <table class="table table-bordered table-hover mb-0 text-nowrap">
                        <thead>
                            <tr>
                                {{-- <th>#id</th> --}}
                                <th>Logo</th>
                                <th>Name</th>
                                <th>Industry</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Featured</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($companies as $company)
                            {{-- @dd($company->industry_id)                                 --}}
                            <tr>
                                {{-- <td>{{$company->id}}</td> --}}
                                <td><img src="{{asset($company->company_logo)}}" alt="" srcset="" width="50px"></td>
                                <td>{{$company->company_name}}</td>
                                <td>{{ $company->industry_id ? $company->industry->title : '' }}</td>
                                <td>{{$company->company_email}}</td>
                                <td>{{$company->company_phone}}</td>
                                <td>
                                    <i class="fa fa-{{$company->is_featured?'check-':''}}circle-o {{$company->is_featured?'text-success':'text-warning'}}"></i>
                                </td>
                                <td>
                                    <span class="label label-{{$company->is_active?'success':'warning'}}">{{$company->is_active?"Active":"Inactive"}}</span>
                                </td>
                                <td>
                                    <div data-toggle="tooltip" data-original-title="View" style="display: inline-block;">
                                        <a class="btn btn-primary btn-sm text-white mb-1"  href="{{ route('admin.companies.show', $company->id) }}" ><i class="fa fa-eye"></i></a>
                                    </div>
                                    <div data-toggle="tooltip" data-original-title="Edit" style="display: inline-block;">
                                        <a class="btn btn-success btn-sm text-white mb-1" href="{{route('admin.companies.editCompany',$company->id)}}"><i class="fa fa-pencil"></i></a>
                                        {{-- <a class="btn btn-success btn-sm text-white mb-1" href="/admin/companies/edit/{{$company->id}}"><i class="fa fa-pencil"></i></a> --}}
                                    </div>
                                    <a class="btn btn-danger btn-sm text-white mb-1" data-toggle="tooltip" data-original-title="Delete" href="/admin/companies/delete/{{$company->id}}"><i class="fa fa-trash-o"></i></a><br>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-center mt-3">
                    {{ $companies->links('vendor.pagination.bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    window.setTimeout(function() {
        $(".flash").fadeTo(500, 0).slideUp(500, function() {
            $(this).remove();
        });
    }, 5000);
</script>
@endsection