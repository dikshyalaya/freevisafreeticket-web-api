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
            <i class="fa fa-check-circle-o mr-2" aria-hidden="true"></i> News Deleted.</div>
    @else
        <div id="statusmsg" class="alert alert-danger fade show flash" role="alert" style="position: fixed;z-index: 11;top: 60px !important;right:20px;">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="fa fa-frown-o mr-2" aria-hidden="true"></i>Failed ! To Delete.</div>
    @endif
@endif
<div class="page-header">
    <h4 class="page-title">News</h4>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Modules</a></li>
        <li class="breadcrumb-item" aria-current="news"><a href="{{ route('admin.news.list') }}">news</a></li>
    </ol>
</div>
<div class="row">
    <div class="col-lg-12">

        <div class="card">
            <div class="card-header d-flex">
                <h3 class="card-title" style="width: 100%;">News List</h3>
                <div class="d-flex flex-row-reverse mb-2" >

                    <a type="button" class="btn btn-primary" href="{{ route('admin.news.new') }}"><i class="fe fe-plus mr-2"></i>Add New</a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive border-top">
                    <table class="table table-bordered table-hover mb-0 text-nowrap">
                        <thead>
                            <tr>
                                <th>Title</th>
                                {{--<th>Slug</th>--}}
                                <th>Is Active</th>
                                <th style="width: 150px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($news as $item)
                            <tr>
                                <td>
                                    <a href="{{ route('admin.news.edit', $item->id) }}">{{$item->title}}</a> <br>
                                    <small>Created at {{ $item->created_at }}</small>
                                </td>
                                {{--<td>{{$item->slug}}</td>--}}
                                <td> @if ($item->is_active)
                                    <i class='fa fa-circle' style='color:green;font-size: 8px; padding:.5rem;'></i>
                                    <span>Active</span>
                                    @else
                                     <i class='fa fa-circle' style='color:rgb(247, 67, 36); font-size: 8px; padding:.5rem;'></i>Not Active
                                    @endif
                                </td>
                                <td>
                                    <div data-toggle="tooltip" data-original-title="View" style="display: inline-block;">
                                        <a class="btn btn-primary btn-sm text-white mb-1" target="_blank"  href="{{ route('news.details', $item->slug) }}" ><i class="fa fa-eye"></i></a>
                                    </div>
                                     <div data-toggle="tooltip" data-original-title="Edit" style="display: inline-block;">
                                        <a class="btn btn-success btn-sm text-white mb-1"  href="{{ route('admin.news.edit', $item->id) }}"><i class="fa fa-pencil"></i></a>
                                    </div>
                                    <a class="btn btn-danger btn-sm text-white mb-1" data-toggle="modal" data-target="#dataDeleteModal" data-id="{{ $item->id }}" data-action="{{ route('admin.news.delete', $item->id) }}" data-method="{{ getRouteMethodName('admin.news.delete') }}" data-modaltitle="Delete News">
                                        <i class="fa fa-trash-o"></i>
                                    </a><br>
                                    {{-- <a class="btn btn-danger btn-sm text-white mb-1" data-toggle="tooltip" data-original-title="Delete" href="/admin/news/delete/{{$item->id}}"><i class="fa fa-trash-o"></i></a><br> --}}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-center mt-3">
                    {{ $news->links('vendor.pagination.bootstrap-4') }}
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
