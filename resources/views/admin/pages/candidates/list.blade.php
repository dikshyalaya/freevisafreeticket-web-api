@php
$delete = [];
if (session()->get('delete')) {
    $delete = session()->get('delete');
    session()->forget('delete');
}
@endphp
@extends('admin.layouts.master')
@section('main')
    @if ($delete)
        @if ($delete['status'] == 'success')
            <div id="statusmsg" class="alert alert-success fade show flash" role="alert"
                style="position: fixed;z-index: 11;top: 60px !important;right:20px;"><button type="button"
                    class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <i class="fa fa-check-circle-o mr-2" aria-hidden="true"></i> Candidate Deleted.
            </div>
        @else
            <div id="statusmsg" class="alert alert-danger fade show flash" role="alert"
                style="position: fixed;z-index: 11;top: 60px !important;right:20px;">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i
                    class="fa fa-frown-o mr-2" aria-hidden="true"></i>Failed ! To Delete.
            </div>
        @endif
    @endif
    <div class="page-header">
        <h4 class="page-title">Candidates</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Modules</a></li>
            <li class="breadcrumb-item" aria-current="page"><a href="{{ route('admin.candidates.list') }}">Candidate</a></li>
        </ol>
    </div>
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-header d-flex">
                    <h3 class="card-title" style="width: 100%;">Candidates List</h3>
                    <div class="d-flex flex-row-reverse mb-2">

                        <a type="button" class="btn btn-primary" href="{{ route('admin.candidates.create') }}"><i
                                class="fe fe-plus mr-2"></i>Add New</a>
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
                                    <th>Phone</th>
                                    <th>Gender</th>
                                    <th>Address</th>
                                    <th>Active</th>
                                    <th>Registered At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($candidates as $candidate)
                                    <tr>
                                        <td><img src="/{{ $candidate->avatar }}" alt="" srcset="" width="50px"></td>
                                        <td>{{ $candidate->first_name }}{{ ' ' . $candidate->middle_name . ' ' }}{{ $candidate->last_name }}
                                        </td>
                                        <td>{{ DB::table('users')->find($candidate->user_id)->email }}</td>
                                        <td>{{ $candidate->mobile_phone }}</td>
                                        <td>{{ $candidate->gender }}</td>
                                        <td>{{ $candidate->address }}</td>

                                        <td>
                                            <span
                                                class="label label-{{ $candidate->is_active ? 'success' : 'warning' }}">{{ $candidate->is_active ? 'Active' : 'Inactive' }}</span>
                                        </td>
                                        <td>
                                            {{ date('Y-m-d', strtotime($candidate->created_at)) }}
                                        </td>
                                        <td>
                                            {{-- <button class="btn btn-danger" data-toggle="modal" data-target="#largeModal">View modal</button> --}}
                                            <div data-toggle="tooltip" data-original-title="View"
                                                style="display: inline-block;">
                                                <a class="btn btn-primary btn-sm text-white mb-1"
                                                    href="{{ route('admin.candidates.show', $candidate->id) }}"><i
                                                        class="fa fa-eye"></i></a>
                                            </div>
                                            <div data-toggle="tooltip" data-original-title="Edit"
                                                style="display: inline-block;">
                                                <a class="btn btn-success btn-sm text-white mb-1"
                                                    href="{{ route('admin.candidates.editCandidate', $candidate->id) }}"><i
                                                        class="fa fa-pencil"></i></a>
                                                {{-- <a class="btn btn-success btn-sm text-white mb-1"
                                                    href="/admin/candidates/edit/{{ $candidate->id }}"><i
                                                        class="fa fa-pencil"></i></a> --}}
                                            </div>
                                            <div data-toggle="tooltip" data-original-title="Edit"
                                                style="display: inline-block;">
                                                <a class="btn btn-danger btn-sm text-white mb-1" data-toggle="modal" data-target="#dataDeleteModal" data-id="{{ $candidate->id }}" data-action="{{ route('admin.candidates.delete', $candidate->id) }}" data-method="{{ getRouteMethodName('admin.candidates.delete') }}" data-modaltitle="Delete Candidate"
                                                    ><i
                                                        class="fa fa-trash-o"></i></a>
                                            </div>
                                            {{-- <a class="btn btn-danger btn-sm text-white mb-1" data-toggle="tooltip"
                                                data-original-title="Delete"
                                                href="/admin/candidates/delete/{{ $candidate->id }}"><i
                                                    class="fa fa-trash-o"></i></a><br> --}}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center mt-3">
                        {{ $candidates->links('vendor.pagination.bootstrap-4') }}
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
