@extends('themes.fvft.company.layouts.dashmaster')
@section('jobs')
    active
@endsection
@section('title')
    Jobs
@endsection
@section('data')
    <style>
        .input-icons i {
            position: absolute;
        }

        .input-icons input {
            text-indent: 20px;
        }

        .icon {
            padding: 10px;
            min-width: 40px;
            z-index: 99999
        }

    </style>
    {{-- <div class="card m-b-0">
        <div class="card-header">
            <h3 class="card-title">My Jobs</h3>
        </div>
    </div> --}}
    <div class="card m-b-0">
        {{-- <div class="card-header">
            
            <div class="col-md-6">
                <h3 class="">My Jobs</h3>
            </div>

        </div> --}}
        <div class="card-body">
            <h3 class="font-weight-bold">{{ strtoupper('Job Management') }}</h3>
            <div id="basicwizard" class="border pt-0">
                @include('partial/companies/tabs')
            </div>

            @if ($company->is_active == 1)
                <div class="row mb-5 mt-5">
                    <div class="col-md-6">
                        {{-- <a href="{{ route('company.addNewJob') }}" class="btn btn-success">Add New Job</a> --}}
                        {{-- <a href="{{ route('company.newjob.get_job_detail') }}" class="btn btn-success">Add New Job</a> --}}
                    </div>
                    <div class="col-md-6">
                        <form action="{{ route('company.jobs') }}" method="GET">
                            <div class="input-group input-icons mb-3">
                                <i class="fa fa-search icon"></i>
                                <input type="text" name="term" value="{{ request()->term }}" class="form-control"
                                    placeholder="Search Your Job" aria-label="Search your Job"
                                    aria-describedby="button-addon2">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-success" type="submit">Search</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            @endif
            <div class="ads-tabs">
                <div class="tabs-menus">
                    <!-- Tabs -->
                    <ul class="nav panel-tabs">
                        <li class=""><a href="#allJob" class="active" data-toggle="tab">All Jobs</a>
                        </li>
                        <li><a href="#draft" data-toggle="tab" class="">Draft</a></li>
                        <li><a href="#pendingjobs" data-toggle="tab" class="">Pending Jobs</a></li>
                        {{-- <li><a href="#approvedjobs" data-toggle="tab" class="">Approved</a></li>
                    <li><a href="#notapproved" data-toggle="tab" class="">Not Approved</a></li> --}}
                        <li><a href="#published" data-toggle="tab" class="">Published Jobs</a></li>
                        <li><a href="#expired" data-toggle="tab" class="">Expired Jobs</a></li>
                        <li><a href="#rejected" data-toggle="tab" class="">Rejected Jobs</a></li>
                    </ul>
                </div>
                <div class="tab-content">
                    <div class="tab-pane table-responsive border-top userprof-tab active" id="allJob">
                        @include(
                            'themes.fvft.company.components.jobs.joblist',
                            [
                                'items' => $all_jobs,
                                'action' => 'All Jobs',
                            ]
                        )
                    </div>
                    {{-- <div class="tab-pane table-responsive border-top userprof-tab" id="approvedjobs">
                    @include(
                        'themes.fvft.company.components.jobs.joblist',
                        [
                            'items' => $approved_jobs,
                            'action' => 'Approved',
                        ]
                    )
                </div> --}}
                    {{-- <div class="tab-pane table-responsive border-top userprof-tab" id="notapproved">
                    @include(
                        'themes.fvft.company.components.jobs.joblist',
                        [
                            'items' => $unapproved_jobs,
                            'action' => 'Not Approved Jobs',
                        ]
                    )
                </div> --}}
                    <div class="tab-pane table-responsive border-top userprof-tab " id="published">
                        @include(
                            'themes.fvft.company.components.jobs.joblist',
                            [
                                'items' => $published_jobs,
                                'action' => 'Published Jobs',
                            ]
                        )
                    </div>
                    <div class="tab-pane table-responsive border-top userprof-tab " id="expired">
                        @include(
                            'themes.fvft.company.components.jobs.joblist',
                            [
                                'items' => $expired_jobs,
                                'action' => 'Expired Jobs',
                            ]
                        )
                    </div>
                    <div class="tab-pane table-responsive border-top userprof-tab " id="draft">
                        @include(
                            'themes.fvft.company.components.jobs.joblist',
                            [
                                'items' => $draft_jobs,
                                'action' => 'Draft Jobs',
                            ]
                        )
                    </div>
                    <div class="tab-pane table-responsive border-top userprof-tab " id="pendingjobs">
                        @include(
                            'themes.fvft.company.components.jobs.joblist',
                            [
                                'items' => $pending_jobs,
                                'action' => 'Pending Jobs',
                            ]
                        )
                    </div>
                    <div class="tab-pane table-responsive border-top userprof-tab " id="rejected">
                        @include(
                            'themes.fvft.company.components.jobs.joblist',
                            [
                                'items' => $rejected_jobs,
                                'action' => 'Rejected Jobs',
                            ]
                        )
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        function cloneJob(item_id) {
            var url = "{{ route('company.cloneJob', ':id') }}",
                url = url.replace(':id', item_id);
            $.ajax({
                url: url,
                type: 'POST',
                success: function(response) {
                    if (!response.exception) {
                        toastr.success(response.msg);
                        location.href = response.redirectRoute;
                    } else if (response.exception) {
                        toastr.warning(response.exception);
                    }

                }
            });
        }
    </script>
@endsection
