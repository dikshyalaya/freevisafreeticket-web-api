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
                <i class="fa fa-check-circle-o mr-2" aria-hidden="true"></i> Applicants Deleted.
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
            <li class="breadcrumb-item" aria-current="page"><a href="/admin/applicants/">Applicants</a></li>
        </ol>
    </div>
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-header d-flex">
                    <h3 class="card-title" style="width: 100%;">Applicants List</h3>
                    <div class="d-flex flex-row-reverse mb-2">

                        {{-- <a type="button" class="btn btn-primary" href="/admin/applicants/new"><i class="fe fe-plus mr-2"></i>Add New</a> --}}
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive border-top">
                        <table class="table table-bordered table-hover mb-0 text-nowrap">
                            <thead>
                                <tr>
                                    <th>SN</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Applied On</th>
                                    <th>Job Title</th>
                                    <th>Company Name</th>
                                    <th>Country</th>
                                    <th>Status</th>
                                    <th>Interview Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($applicants as $item)
                                    <tr>
                                        <td>{{ $sn++ }}</td>
                                        <td>{{ !($item->employe != null && $item->employe->full_name != null) ?: $item->employe->full_name }}
                                        </td>
                                        <td>{{ !($item->employe != null && $item->employe->user != null && $item->employe->user->email != null) ?: $item->employe->user->email }}</td>
                                        <td>
                                            {{ !($item->employe != null && $item->employe->mobile_phone != null) ?: $item->employe->mobile_phone }}
                                        </td>
                                        <td>{{ getFormattedDate($item->created_at, 'M j, Y') }}</td>
                                        <td>{{ !($item->job != null && $item->job->title != null) ?: $item->job->title }}</td>
                                        <td>{{ !($item->job != null && $item->job->company != null && $item->job->company->company_name != null) ?: $item->job->company->company_name }}</td>
                                        <td>{{ !($item->employe != null && $item->employe->country != null && $item->employe->country->name != null) ?: $item->employe->country->name }}</td>
                                        <td>
                                            @php
                                            $statuses = ['pending' => 'Unscreened', 'shortlisted' => 'Shortlisted', 'selectedForInterview' => 'Selected for Interview', 'interviewed' => 'Interviewed', 'accepted' => 'Selected', 'rejected' => 'Rejected', 'redlisted' => 'Red List'];
                                            $status_indicator_items = ['pending' => 'warning', 'shortlisted' => 'pink', 'selectedForInterview' => 'orange', 'interviewed' => 'orange', 'accepted' => 'green', 'rejected' => 'red', 'redlisted' => 'danger'];
                                            $status_indicator = $status_indicator_items[$item->status];
                                            $status_name = $statuses[$item->status];
                                            @endphp
                                            
                                            <span class="label bg-{{ $status_indicator }}">{{ $status_name }}</span>
                                        </td>
                                        <td>
                                            @php
                                                $interview_status_items = ['started' => 'primary', 'notstarted' => 'warning', 'fail' => 'danger', 'pass' => 'success'];   
                                                $interview_status_indicator = $interview_status_items[$item->interview_status];
                                            @endphp
                                            <span class="label label-{{ $interview_status_indicator }}">{{ $item->interview_status }}</span>
                                        </td>
                                        <td>
                                            <div data-toggle="tooltip" data-original-title="Edit"
                                                style="display: inline-block;">
                                                <a class="btn btn-success btn-sm text-white mb-1"
                                                    href="/admin/applicants/edit/{{ $item->id }}"><i
                                                        class="fa fa-pencil"></i></a>
                                            </div>
                                            <a class="btn btn-danger btn-sm text-white mb-1" data-id="{{ $item->id }}" data-action="{{ route('admin.applicants.delete', $item->id) }}" data-method="{{ getRouteMethodName('admin.applicants.delete') }}" data-modaltitle="Delete Applicant" data-toggle="modal" data-target="#dataDeleteModal">
                                                <i class="fa fa-trash-o"></i></a><br>
                                            {{-- <a class="btn btn-danger btn-sm text-white mb-1" data-toggle="tooltip"
                                                data-original-title="Delete"
                                                href="/admin/candidates/delete/{{ $item->id }}"><i
                                                    class="fa fa-trash-o"></i></a><br> --}}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center mt-3">
                        {{ $applicants->links('vendor.pagination.bootstrap-4') }}
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
