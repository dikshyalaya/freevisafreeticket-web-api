@extends('admin.layouts.master')
@section('main')
    <div class="page-header">
        <h4 class="page-title">Supports</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Modules</a></li>
            <li class="breadcrumb-item" aria-current="page"><a href="{{ route('admin.support.index') }}">Supports</a>
            </li>
        </ol>
    </div>
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-header d-flex">
                    <h3 class="card-title" style="width: 100%;">Supports List</h3>
                    <div class="d-flex flex-row-reverse mb-2">

                        <a type="button" class="btn btn-primary" href="{{ route('admin.support.create') }}"><i
                                class="fe fe-plus mr-2"></i>Add New</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive border-top">
                        <table class="table table-bordered table-hover mb-0 text-nowrap">
                            <thead>
                                <tr>
                                    <th>Category</th>
                                    <th>Support</th>
                                    <th>Slug</th>
                                    <th>Support Type</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($supports as $support)
                                    <tr>
                                        <td>{{ !($support->support_category != null && $support->support_category->title != null) ?:$support->support_category->title }}
                                        </td>
                                        <td>{{ $support->question }}</td>
                                        <td>{{ $support->slug }}</td>
                                        <td>
                                            {!! wrapInTag($support->support_types->pluck('title')->toArray(), 'span', 'class="badge badge-success"', ' ') !!}
                                        </td>
                                        <td>

                                            <div data-toggle="tooltip" data-original-title="Edit"
                                                style="display: inline-block;">
                                                <a class="btn btn-success btn-sm text-white mb-1"
                                                    href="{{ route('admin.support.edit', $support->id) }}"><i
                                                        class="fa fa-pencil"></i></a>
                                            </div>
                                            <a class="btn btn-danger btn-sm text-white mb-1" data-toggle="modal" data-target="#dataDeleteModal" data-id="{{ $support->id }}" data-action="{{ route('admin.support.delete', $support->id) }}" data-method="{{ getRouteMethodName('admin.support.delete') }}" data-modaltitle="Delete Support">
                                                <i class="fa fa-trash-o"></i></a><br>
                                            {{-- <a class="btn btn-danger btn-sm text-white mb-1" data-toggle="tooltip"
                                                data-original-title="Delete" href="javascript:void(0);"
                                                onclick="deleteData({{ $support->id }}, $(this));"><i
                                                    class="fa fa-trash-o"></i></a><br> --}}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center mt-3">
                        {{ $supports->links('vendor.pagination.bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        function deleteData(id, el) {
            if (id) {
                var url = "{{ route('admin.support.delete', ':id') }}",
                    url = url.replace(":id", id);
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        _method: 'DELETE',
                    },
                    success: function(data) {
                        if (data.db_error) {
                            toastr.warning(data.db_error);
                        } else {
                            el.closest('tr').remove();
                            toastr.success(data.msg);
                        }

                    }
                });
            }
        }
    </script>
@endsection
