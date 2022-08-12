@extends('themes.fvft.company.layouts.dashmaster')
@section('jobs')
    active
@endsection
@section('title')
    Jobs
@endsection
@section('css')
    <!-- Data table css -->
    <link href="{{ asset('themes/fvft/assets/plugins/datatable/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('themes/fvft/assets/plugins/datatable/jquery.dataTables.min.css') }}" rel="stylesheet" />
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
            <h3 class="card-title">{{ strtoupper(__('Job Management')) }}</h3>
            @include('partial/companies/tabs')


            @if ($company->is_active == 1)
                {{--<div class="row mb-5 mt-5">--}}
                {{--<div class="col-md-6">--}}
                {{-- <a href="{{ route('company.addNewJob') }}" class="btn btn-success">Add New Job</a> --}}
                {{-- <a href="{{ route('company.newjob.get_job_detail') }}" class="btn btn-success">Add New Job</a> --}}
                {{--</div>--}}
                {{--<div class="col-md-6">--}}
                {{--<form action="{{ route('company.jobs') }}" method="GET">--}}
                {{--<div class="input-group input-icons mb-3">--}}
                {{--<i class="fa fa-search icon"></i>--}}
                {{--<input type="hidden" name="type" value="{{ request()->type }}">--}}
                {{--<input type="text" name="term" value="{{ request()->term }}" class="form-control"--}}
                {{--placeholder="{{ __('Search Your Job') }}" aria-label="Search your Job"--}}
                {{--aria-describedby="button-addon2">--}}
                {{--<div class="input-group-append">--}}
                {{--<button class="btn btn-outline-primary btn-rounded-0" type="submit">{{ __('Search') }}</button>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--</form>--}}
                {{--</div>--}}
                {{--</div>--}}
            @endif
            <div class="ads-tabs">
                <div class="tabs-menus">
                    <!-- Tabs -->
                    <ul class="nav panel-tabs">
                        <li class=""><a href="{{ route('company.jobs', ['type' => 'all']) }}" class="{{ !(request()->type == 'all') ?: 'active' }}">{{ __('All Jobs') }}</a>
                        </li>
                        <li><a href="{{ route('company.jobs', ['type' => 'draft_jobs']) }}" class="{{ !(request()->type == 'draft_jobs') ?: 'active' }}">{{ __('Draft Jobs') }}</a></li>
                        <li><a href="{{ route('company.jobs', ['type' => 'pending_jobs']) }}" class="{{ !(request()->type == 'pending_jobs') ?: 'active' }}">{{ __('Pending Jobs') }}</a></li>
                        <li><a href="{{ route('company.jobs', ['type' => 'published_jobs']) }}" class="{{ !(request()->type == 'published_jobs') ?: 'active' }}">{{ __('Published Jobs') }}</a></li>
                        <li><a href="{{ route('company.jobs', ['type' => 'expired_jobs']) }}" class="{{ !(request()->type == 'expired_jobs') ?: 'active' }}">{{ __('Expired Jobs') }}</a></li>
                        <li {{ !(app()->getLocale() == 'np') ?: 'class=mt-5' }}><a href="{{ route('company.jobs', ['type' => 'rejected_jobs']) }}" class="{{ !(request()->type == 'rejected_jobs') ?: 'active' }}">{{ __('Rejected Jobs') }}</a></li>
                    </ul>
                </div>

                @include('themes.fvft.company.components.jobs.joblist')

            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('themes/fvft/assets/plugins/datatable/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('themes/fvft/assets/plugins/datatable/dataTables.bootstrap4.min.js') }}"></script>

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

        $(function(e) {
            $('.data-table').DataTable();
        } );
    </script>
@endsection
