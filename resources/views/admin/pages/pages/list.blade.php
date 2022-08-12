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
        <div id="statusmsg" class="alert alert-success fade show flash" role="alert" style="position: fixed;z-index: 11;top: 60px !important;right:20px;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <i class="fa fa-check-circle-o mr-2" aria-hidden="true"></i> Page Deleted.</div>
    @else
        <div id="statusmsg" class="alert alert-danger fade show flash" role="alert" style="position: fixed;z-index: 11;top: 60px !important;right:20px;">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="fa fa-frown-o mr-2" aria-hidden="true"></i>Failed ! To Delete.</div>
    @endif
@endif
<div class="page-header">
    <h4 class="page-title">Pages</h4>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Modules</a></li>
        <li class="breadcrumb-item" aria-current="page"><a href="{{ route('admin.pages.list') }}">Page</a></li>
    </ol>
</div>
<div class="row">
    <div class="col-lg-12">
        
        <div class="card">
            <div class="card-header d-flex">
                <h3 class="card-title" style="width: 100%;">Pages List</h3>
                <div class="d-flex flex-row-reverse mb-2" >

                    <a type="button" class="btn btn-primary" href="{{ route('admin.pages.new') }}"><i class="fe fe-plus mr-2"></i>Add New</a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive border-top">
                    <table class="table table-bordered table-hover mb-0 text-nowrap">
                        <thead>
                            <tr>
                                {{-- <th>#id</th> --}}
                                <th>Title</th>
                                <th>Description</th>
                                <th>Slug</th>
                                <th>Is Active</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pages as $page)
                            <tr>
                                <td>{{$page->title}}</td>
                                <td>
                                    @php 
                                    $description = wordwrap($page->seo_description, 28);
                                    $description = explode("\n", $description);
                                    $description = $description[0] . '...';
                                    @endphp
                                    {{$description}}</td>
                                <td>{{$page->slug}}</td>
                                <td> @if ($page->is_active)
                                    <i class='fa fa-circle' style='color:green;font-size: 8px; padding:.5rem;'></i>
                                    <span>Active</span>
                                    @else
                                     <i class='fa fa-circle'style='color:rgb(247, 67, 36); font-size: 8px; padding:.5rem;'></i>Not Active
                                    @endif
                                </td>
                                <td>
                                    {{-- <button class="btn btn-danger" data-toggle="modal" data-target="#largeModal">View modal</button> --}}
                                    {{-- <div data-toggle="tooltip" data-original-title="View" style="display: inline-block;">
                                        <a class="btn btn-primary btn-sm text-white mb-1"  href="/page/{{$page->id}}" ><i class="fa fa-eye"></i></a>
                                    </div> --}}
                                     <div data-toggle="tooltip" data-original-title="Edit" style="display: inline-block;">
                                        <a class="btn btn-success btn-sm text-white mb-1"  href="{{route('admin.pages.edit',$page->id)}}"><i class="fa fa-pencil"></i></a>
                                    </div>
                                    <a class="btn btn-danger btn-sm text-white mb-1" data-toggle="modal" data-target="#dataDeleteModal" data-id="{{ $page->id }}" data-action="{{ route('admin.pages.delete', $page->id) }}" data-method="{{ getRouteMethodName('admin.pages.delete') }}" data-modaltitle="Delete Page">
                                        <i class="fa fa-trash-o"></i>
                                    </a><br>
                                    {{-- <a class="btn btn-danger btn-sm text-white mb-1" data-toggle="tooltip" data-original-title="Delete" href="/admin/pages/delete/{{$page->id}}"><i class="fa fa-trash-o"></i></a><br> --}}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-center mt-3">
                    {{ $pages->links('vendor.pagination.bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    window.setTimeout(function() {
        $(".flash").fadeTo(500, 0).slideUp(500, function(){
            $(this).remove();
        });
        }, 5000);
</script>
@endsection