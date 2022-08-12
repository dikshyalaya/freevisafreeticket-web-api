@extends('admin.layouts.master')
@section('main')
    <div class="page-header">
        <h4 class="page-title">Admin</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Modules</a></li>
            <li class="breadcrumb-item" aria-current="page"><a href="/admin/candidates/">Admin</a></li>
        </ol>
    </div>
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-header d-flex">
                    <h3 class="card-title" style="width: 100%;">Admin List</h3>
                    <div class="d-flex flex-row-reverse mb-2">

                        {{-- <a type="button" class="btn btn-primary" href="{{ route('admin.candidates.create') }}"><i
                                class="fe fe-plus mr-2"></i>Add New</a> --}}
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive border-top">
                        <table class="table table-bordered table-hover mb-0 text-nowrap">
                            <thead>
                                <tr>
                                    {{-- <th>#id</th> --}}
                                    <th>Avatar</th>
                                    <th>Full Name</th>
                                    <th>Email</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($admins as $admin)
                                    <tr>
                                        <td>
                                            <img src="{{ asset($admin->admin_profile->avatar) }}" class="imageSize"
                                                alt="">
                                        </td>
                                        <td>{{ $admin->admin_profile->name }}</td>
                                        <td>{{ $admin->email }}</td>
                                        <td>
                                            @if (Auth::user()->id != $admin->id)
                                                <a class="btn btn-danger btn-sm text-white mb-1" data-toggle="tooltip"
                                                    data-original-title="Delete" href="javascript:void(0);"
                                                    onclick="deleteData({{ $admin->id }}, $(this));"><i
                                                        class="fa fa-trash-o"></i></a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center mt-3">
                        {{ $admins->links('vendor.pagination.bootstrap-4') }}
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

        function deleteData(id, el) {
            if (id) {
                var url = "{{ route('admin.user.delete', ':id') }}",
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
                            toastr.success(data.msg);
                            el.closest('tr').remove();
                        }
                    }
                });
            }
        }
    </script>
@endsection
