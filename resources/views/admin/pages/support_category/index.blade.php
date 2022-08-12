@extends('admin.layouts.master')
@section('main')
    <div class="page-header">
        <h4 class="page-title">Support Categories</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Modules</a></li>
            <li class="breadcrumb-item" aria-current="page"><a href="{{ route('admin.support_category.index') }}">Support Categories</a>
            </li>
        </ol>
    </div>
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-header d-flex">
                    <h3 class="card-title" style="width: 100%;">Support Categories List</h3>
                    <div class="d-flex flex-row-reverse mb-2">

                        <a type="button" class="btn btn-primary" href="{{ route('admin.support_category.create') }}"><i
                                class="fe fe-plus mr-2"></i>Add New</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive border-top">
                        <table class="table table-bordered table-hover mb-0 text-nowrap">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Slug</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categories as $support_category)
                                    <tr>
                                        <td>{{ $support_category->title }}</td>
                                        <td>
                                            {{ $support_category->slug }}
                                        </td>
                                        <td>

                                            <div data-toggle="tooltip" data-original-title="Edit"
                                                style="display: inline-block;">
                                                <a class="btn btn-success btn-sm text-white mb-1"
                                                    href="{{ route('admin.support_category.edit', $support_category->id) }}"><i
                                                        class="fa fa-pencil"></i></a>
                                            </div>
                                            <a class="btn btn-danger btn-sm text-white mb-1" data-toggle="modal" data-target="#dataDeleteModal"
                                                data-id="{{ $support_category->id }}" data-action="{{ route('admin.support_category.delete', $support_category->id) }}" data-method="{{ getRouteMethodName('admin.support_category.delete') }}" data-modaltitle="Delete Support Category">
                                                <i class="fa fa-trash-o"></i>
                                            </a><br>
                                            {{-- <a class="btn btn-danger btn-sm text-white mb-1" data-toggle="tooltip"
                                                data-original-title="Delete"
                                                href="javascript:void(0);" onclick="deleteData({{ $support_category->id }}, $(this));"><i
                                                    class="fa fa-trash-o"></i></a><br> --}}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center mt-3">
                        {{ $categories->links('vendor.pagination.bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        function deleteData(id, el){
            if(id){
                var url = "{{ route('admin.support_category.delete', ':id') }}",
                url = url.replace(":id", id);
                $.ajax({
                    url: url,
                    type: 'POST',
                    data:{
                        _method: 'DELETE',
                    },
                    success: function(data){
                        el.closest('tr').remove();
                        toastr.success(data.msg);
                    }
                });
            }
        }
    </script>
@endsection
