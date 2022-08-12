@extends('admin.layouts.master')
@section('main')
    <div class="page-header">
        <h4 class="page-title">Cities</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Modules</a></li>
            <li class="breadcrumb-item" aria-current="page"><a href="{{ route('admin.city.index') }}">Cities</a>
            </li>
        </ol>
    </div>
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-header d-flex">
                    <h3 class="card-title" style="width: 100%;">Cities List</h3>
                    <div class="d-flex flex-row-reverse mb-2">

                        <a type="button" class="btn btn-primary" href="{{ route('admin.city.create') }}"><i
                                class="fe fe-plus mr-2"></i>Add New</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive border-top">
                        <table class="table table-bordered table-hover mb-0 text-nowrap">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Country Name</th>
                                    <th>Country Code</th>
                                    <th>State Name</th>
                                    <th>State Code</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cities as $city)
                                    <tr>
                                        <td>{{ $city->name }}</td>
                                        <td>{{ $city->country != null ? $city->country->name : '' }}</td>
                                        <td>{{ $city->country_code }}</td>
                                        <td>{{ $city->state != null ? $city->state->name : '' }}</td>
                                        <td>{{ $city->state_code }}</td>
                                        <td>

                                            <div data-toggle="tooltip" data-original-title="Edit"
                                                style="display: inline-block;">
                                                <a class="btn btn-success btn-sm text-white mb-1"
                                                    href="{{ route('admin.city.edit', $city->id) }}"><i
                                                        class="fa fa-pencil"></i></a>
                                            </div>
                                            {{-- <a class="btn btn-danger btn-sm text-white mb-1" data-toggle="tooltip"
                                                data-original-title="Delete"
                                                href="javascript:void(0);" onclick="deleteData({{ $city->id }}, $(this));"><i
                                                    class="fa fa-trash-o"></i></a><br> --}}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center mt-3">
                        {{ $cities->links('vendor.pagination.bootstrap-4') }}
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
                var url = "{{ route('admin.city.delete', ':id') }}",
                url = url.replace(":id", id);
                $.ajax({
                    url: url,
                    type: 'POST',
                    data:{
                        _method: 'DELETE',
                    },
                    success: function(data){
                        el.closest('tr').remove();
                    }
                });
            }
        }
    </script>
@endsection
