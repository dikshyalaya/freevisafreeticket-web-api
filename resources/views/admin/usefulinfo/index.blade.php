@extends('admin.layouts.master')
@section('main')
    <div class="page-header">
        <h4 class="page-title">Useful Informations</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Modules</a></li>
            <li class="breadcrumb-item" aria-current="page"><a href="{{ route('admin.usefulinfo.index') }}">Useful Informations</a>
            </li>
        </ol>
    </div>
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-header d-flex">
                    <h3 class="card-title" style="width: 100%;">Useful Informations List</h3>
                    <div class="d-flex flex-row-reverse mb-2">

                        <a type="button" class="btn btn-primary" href="{{ route('admin.usefulinfo.create') }}"><i
                                class="fe fe-plus mr-2"></i>Add New</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered" id="Training">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($useful_informations as $usefulinfo)
                                    <tr>
                                        <td>{{ $usefulinfo->title }}</td>
                                        <td>

                                            <div data-toggle="tooltip" data-original-title="Edit"
                                                style="display: inline-block;">
                                                <a class="btn btn-success btn-sm text-white mb-1"
                                                    href="{{ route('admin.usefulinfo.edit', $usefulinfo->id) }}"><i
                                                        class="fa fa-pencil"></i></a>
                                            </div>
                                            <a class="btn btn-danger btn-sm text-white mb-1" data-toggle="modal"
                                                data-target="#dataDeleteModal" data-id="{{ $usefulinfo->id }}" data-action="{{ route('admin.usefulinfo.delete', $usefulinfo->id) }}" data-method="{{ getRouteMethodName('admin.usefulinfo.delete') }}" data-modaltitle="Delete Useful Information">
                                                <i class="fa fa-trash-o"></i></a><br>
                                            {{-- <a class="btn btn-danger btn-sm text-white mb-1" data-toggle="tooltip"
                                                data-original-title="Delete"
                                                href="javascript:void(0);" onclick="deleteData({{ $usefulinfo->id }}, $(this));"><i
                                                    class="fa fa-trash-o"></i></a><br> --}}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(function(){
            $("#Training").DataTable();
        });
        

        function deleteData(id, el){
            if(id){
                var url = "{{ route('admin.usefulinfo.delete', ':id') }}",
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
                        location.href = data.redirectRoute;
                    }
                });
            }
        }
    </script>
@endsection
