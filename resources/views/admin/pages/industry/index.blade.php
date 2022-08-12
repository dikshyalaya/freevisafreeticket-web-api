@extends('admin.layouts.master')
@section('main')
    <div class="page-header">
        <h4 class="page-title">Industries</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Modules</a></li>
            <li class="breadcrumb-item" aria-current="page"><a href="{{ route('admin.industry.index') }}">Industries</a>
            </li>
        </ol>
    </div>
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-header d-flex">
                    <h3 class="card-title" style="width: 100%;">Industries List</h3>
                    <div class="d-flex flex-row-reverse mb-2">

                        <a type="button" class="btn btn-primary" href="{{ route('admin.industry.create') }}"><i
                                class="fe fe-plus mr-2"></i>Add New</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive border-top">
                        <table class="table table-bordered table-hover mb-0 text-nowrap">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($industries as $industry)
                                    <tr>
                                        <td>{{ $industry->title }}</td>
                                        <td>
                                            <?php echo $industry->is_active ? '<span class="cur_sor label label-success" onclick="updateStatus(' . $industry->id . ',$(this))">Active</span>' : '<span class="label label-warning cur_sor" onclick="updateStatus(' . $industry->id . ',$(this))">Inactive</span>'; ?>
                                            {{-- <span class="label label-{{ $industry->is_active ? 'success' : 'warning' }}">{{ $industry->is_active ? 'Active' : 'Inactive' }}</span> --}}
                                        </td>
                                        <td>

                                            <div data-toggle="tooltip" data-original-title="Edit"
                                                style="display: inline-block;">
                                                <a class="btn btn-success btn-sm text-white mb-1"
                                                    href="{{ route('admin.industry.edit', $industry->id) }}"><i
                                                        class="fa fa-pencil"></i></a>
                                            </div>
                                            <a class="btn btn-danger btn-sm text-white mb-1" data-toggle="modal"
                                                data-target="#dataDeleteModal" data-id="{{ $industry->id }}" data-action="{{ route('admin.industry.delete', $industry->id) }}" data-method="{{ getRouteMethodName('admin.industry.delete') }}" data-modaltitle="Delete Industry">
                                                <i class="fa fa-trash-o"></i></a><br>
                                            {{-- <a class="btn btn-danger btn-sm text-white mb-1" data-toggle="tooltip"
                                                data-original-title="Delete"
                                                href="javascript:void(0);" onclick="deleteData({{ $industry->id }}, $(this));"><i
                                                    class="fa fa-trash-o"></i></a><br> --}}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center mt-3">
                        {{ $industries->links('vendor.pagination.bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        function updateStatus(id, el) {
            if (id) {
                $.ajax({
                    url: "{{ route('admin.industry.updateStatus') }}",
                    type: 'POST',
                    data: {
                        'industry_id': id
                    },
                    success: function(data) {
                        if (data.status == 0) {
                            el.text('Inactive');
                            el.removeClass('label-success').addClass('label-warning');
                        } else if (data.status == 1) {
                            el.text('Active');
                            el.removeClass('label-warning').addClass('label-success');
                        }
                        // toastr.success(data.msg);
                    }
                });
            }
        }

        function deleteData(id, el){
            if(id){
                var url = "{{ route('admin.industry.delete', ':id') }}",
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
