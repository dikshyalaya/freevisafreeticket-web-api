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
    @php
    if (checkUserType('candidate')) {
        $employ_id = App\Models\Employe::where('user_id', \Auth::user()->id)->first()->id;
        // dd($employ_id);
    } else {
        $employ_id = '';
    }
    @endphp
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
                    <div class="row">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">{{ __('Saved Jobs') }}</h3>
                            </div>
                            <div class="card-body">
                                @foreach ($saved_jobs as $item)
                                    @if (!blank(data_get($item, 'job')))
                                        @include('themes.fvft._partials.job.preview-card', [
                                            'job' => $item->job,
                                        ])
                                    @endif
                                @endforeach

                                <div class="center-block text-center">
                                    {{ $saved_jobs->links('vendor.pagination.bootstrap-4') }}
                                </div>
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

        function savejob(job_id) {
            var url = "{{ route('candidate.savedjob.saveJob') }}";
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    'job_id': job_id,
                    'employ_id': '{{ $employ_id }}',
                },
                beforeSend: function() {
                    $(".saveJobButton").attr('disabled', true);
                },
                success: function(response) {
                    if (response.db_error) {
                        toastr.warning(response.db_error);
                    } else if (response.error) {
                        toastr.warning(response.error);
                    } else if (response.redirectRoute) {
                        location.href = response.redirectRoute
                    } else {
                        toastr.success(response.msg);
                    }
                    window.location.reload()
                },
                complete: function() {
                    $(".saveJobButton").attr('disabled', false);
                },
            });
        }
    </script>
@endsection
