@extends('admin.layouts.master')
@section('main')
    <div class="page-header">
        <h4 class="page-title">About Santi Overseas</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Modules</a></li>
            <li class="breadcrumb-item" aria-current="page"><a href="{{ route('admin.santi.index') }}">Go Back</a>
            </li>
        </ol>
    </div>
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-header d-flex">
                    <h3 class="card-title" style="width: 100%;">Santi Overseas</h3>
                    <div class="d-flex flex-row-reverse mb-2">

                        <a type="button" class="btn btn-primary" href="{{ route('admin.santi.create') }}"><i
                                class="fe fe-plus mr-2"></i>Add New</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive border-top">
                        <table class="table table-bordered table-hover mb-0 text-nowrap">
                            <thead>
                                <tr>
                                    <th>Feature Image</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($abouts as $about)
                                    <tr>
                                        <td>
                                            <img style="height:50px; width:50px;" src="{{ asset($about->feature_image != null ? $about->feature_image : 'images/defaultimage.jpg') }}" alt="">
                                        </td>
                                        <td>{{ $about->title }}</td>
                                        <td><textarea name="" id="" cols="5" rows="5" style="width: 100%;">{!! html_entity_decode($about->html_content) !!}</textarea></td>
                                        <td>
                                            <?php echo $about->status ? '<span class="cur_sor label label-success" onclick="updateStatus(' . $about->id . ',$(this))">Active</span>' : '<span class="label label-warning cur_sor" onclick="updateStatus(' . $about->id . ',$(this))">Inactive</span>'; ?>
                                            {{-- <span class="label label-{{ $about->is_active ? 'success' : 'warning' }}">{{ $about->is_active ? 'Active' : 'Inactive' }}</span> --}}
                                        </td>
                                        <td>

                                            <div data-toggle="tooltip" data-original-title="Edit"
                                                style="display: inline-block;">
                                                <a class="btn btn-success btn-sm text-white mb-1"
                                                    href="{{ route('admin.about.edit', $about->id) }}"><i
                                                        class="fa fa-pencil"></i></a>
                                            </div>
                                            <a class="btn btn-danger btn-sm text-white mb-1" data-toggle="modal" data-target="#dataDeleteModal"
                                                data-id="{{ $about->id }}" data-action="{{ route('admin.santi.delete', $about->id) }}" data-method="{{ getRouteMethodName('admin.santi.delete') }}" data-modaltitle="Delete Data">
                                                <i class="fa fa-trash-o"></i></a><br>
                                            {{-- <a class="btn btn-danger btn-sm text-white mb-1" data-toggle="tooltip"
                                                data-original-title="Delete"
                                                href="javascript:void(0);" onclick="deleteData({{ $about->id }}, $(this));"><i
                                                    class="fa fa-trash-o"></i></a><br> --}}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center mt-3">
                        {{ $abouts->links('vendor.pagination.bootstrap-4') }}
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
                    url: "{{ route('admin.about.updateStatus') }}",
                    type: 'POST',
                    data: {
                        'about_id': id
                    },
                    success: function(data) {
                        console.log(data);
                        if (data.status == 0) {
                            el.text('Inactive');
                            el.removeClass('label-success').addClass('label-warning');
                        } else if (data.status == 1) {
                            el.text('Active');
                            el.removeClass('label-warning').addClass('label-success');
                        }
                        toastr.success(data.msg);
                    }
                });
            }
        }

        function deleteData(id, el){
            if(id){
                var url = "{{ route('admin.santi.delete', ':id') }}",
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
                        location.reload();
                    }
                });
            }
        }
    </script>
@endsection
