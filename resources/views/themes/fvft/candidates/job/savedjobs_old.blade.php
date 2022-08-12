@extends('themes.fvft.candidates.layouts.dashmaster')
@section('title', 'Saved Jobs')
@section('style')
    <!-- file Uploads -->
    <link href="/themes/fvft/assets/plugins/fileuploads/css/dropify.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ asset('css/datepicker.min.css') }}">
@endsection

@section('content')
    <style>
        .form-control {
            color: #272626 !important;
        }

    </style>
    <section>
        <div class="bannerimg cover-image bg-background3" data-image-src="../assets/images/banners/banner2.jpg"
            style="background: url(&quot;../assets/images/banners/banner2.jpg&quot;) center center;">
            <div class="header-text mb-0">
                <div class="text-center text-white">
                    <h1 class="">{{ __('Saved Jobs') }}</h1>
                    <ol class="breadcrumb text-center">
                        <li class="breadcrumb-item"><a href="#">{{ __('Home') }}</a></li>
                        <li class="breadcrumb-item"><a href="#">{{ __('Dashboard') }} </a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">{{ __('Saved Jobs') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="sptb">
        <div class="container">
            <div class="row ">
                <div class="col-xl-3 col-lg-12 col-md-12">
                    @include('themes.fvft.candidates.components.sidebar')
                </div>
                <div class="col-xl-9 col-lg-12 col-md-12">
                    <div class="card mb-0">
                        <div class="card-header">
                            <h3 class="card-title">{{ __('Saved Jobs') }}</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-hover mb-0 text-nowrap">
                                <thead>
                                    <tr>
                                        <th>{{ __('Job Position') }}</th>
                                        <th>{{ __('Company') }}</th>
                                        <th>{{ __('Apply Before') }}</th>
                                        <th>{{ __('Detail') }}</th>
                                        <th>{{ __('Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(count($saved_jobs) > 0)
                                    @foreach ($saved_jobs as $item)
                                        <tr>
                                            <td>
                                                {{ !empty($item->job) ? $item->job->title : '' }}
                                            </td>
                                            <td>
                                                <a
                                                    href="{{ !empty($item->job) && !empty($item->job->company)? route('site.companydetail', $item->job->company->id): '#' }}">
                                                    {{ !empty($item->job) && !empty($item->job->company) ? $item->job->company->company_name : '' }}
                                                </a>
                                            </td>

                                            <td>
                                                @php
                                                    $deadline = !empty($item->job) ? $item->job->expiry_date : '';
                                                    
                                                @endphp
                                                {{ $deadline != '' ? date('Y-m-d', strtotime($deadline)) : '----' }}

                                            </td>
                                            <td>
                                                <a href="{{ route('viewJob', $item->job_id) }}" class="">{{ __('View Details') }}</a>
                                            </td>
                                            <td>
                                                <button class="btn btn-danger btn-sm text-white" data-toggle="modal"
                                                    data-id="{{ $item->id }}" data-target="#deleteModal">{{ __('Remove') }}</button>

                                                {{-- <a class="btn btn-danger btn-sm text-white" data-toggle="tooltip"
                                                    data-original-title="Delete"
                                                    href="{{ route('candidate.savedjob.delete', $item->id) }}"><i
                                                        class="fa fa-trash-o"></i></a> --}}
                                            </td>
                                        </tr>
                                    @endforeach
                                    @else
                                    <p>{{ __('No Saved Jobs') }}</p>
                                    @endif
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-center mt-3">
                                {{ $saved_jobs->links('vendor.pagination.bootstrap-4') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Delete Modal --}}
    <!-- Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white font-weight-bold">
                    <h5 class="modal-title" id="deleteModalLabel">{{ __('Delete Saved Job') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>{{ __('Are you sure, you want to delete this saved job?') }}</p>
                    <form action="#" method="POSt" id="deleteForm">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-gray" data-dismiss="modal">{{ __('Close') }}</button>
                    <button type="button" class="btn btn-secondary" id="deleteJob">{{ __('Delete') }}</button>
                </div>
            </div>
        </div>
    </div>
    {{-- End Delete Modal --}}
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $("#deleteModal").on('show.bs.modal', function(e) {
                var button = $(e.relatedTarget);
                var jobId = $(button).data("id");
                var action = "{{ route('candidate.savedjob.delete', ':id') }}";
                action = action.replace(':id', jobId);
                $("#deleteForm").attr("action", action);
            });

            $("#deleteJob").on('click', function(e) {
                e.preventDefault();
                $("#deleteForm").submit();
            });

            $("#deleteModal").on("hide.bs.modal", function() {
                $("#deleteForm").attr("action", "#");
            });
        });
    </script>
@endsection
