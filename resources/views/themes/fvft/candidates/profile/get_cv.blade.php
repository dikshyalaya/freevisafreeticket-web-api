@extends('themes.fvft.candidates.layouts.dashmaster')
@section('title') Save Page @stop
@section('style')
    <link href="{{ asset('themes/fvft/assets/plugins/fileuploads/css/dropify.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <style>
        .icon-service {
            width: 100px !important;
            height: 100px !important;
        }

    </style>
    <section>
        <div class="bannerimg cover-image bg-background3" data-image-src="/uploads/site/banner.png"
             style="background: url(/uploads/site/banner.png) center center;">
            <div class="header-text mb-0">
                <div class="text-center text-white">
                    <h1 class="">{{ __('My CV') }}</h1>
                    <ol class="breadcrumb text-center">
                        <li class="breadcrumb-item"><a href="#">{{ __('Home') }}</a></li>
                        <li class="breadcrumb-item"><a href="#">{{ __('Dashboard') }} </a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">{{ __('My CV') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="sptb">
        <div class="container">
            <div class="row">
                <div class="col-xl-3 col-lg-12 col-md-12">
                    @include('themes.fvft.candidates.components.sidebar')
                </div>
                <div class="col-xl-9 col-lg-12 col-md-12">
                    @include('partial/candidates/tabs', ['title' => __('My CV')])

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card mb-0">
                                <div class="card-body">
                                    <h3 class="card-title">{{ __('Upload CV') }} (PDF)</h3>
                                    <input type="file" class="form-control dropify" data-allowed-file-extensions="pdf" accept=".pdf"
                                           data-max-file-size="4M" id="employeeCv">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card mb-0">
                                <div class="card-header">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <h3 class="card-title">{{ __('Download Uploaded Cv') }}</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                            <th>File</th>
                                            <th class="text-right">Action</th>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td>
                                                    <h3 class="card-title">{{ __('CV generated from profile') }}</h3>
                                                </td>
                                                <td class="text-right">
                                                    <a href="{{ route('candidate.profile.downloadGeneratedCV', ['type' => 'preview']) }}"
                                                       target="_blank" class="btn btn-primary rounded-0">
                                                        <i class="fa fa-eye mr-3"></i>{{ __('Preview') }}
                                                    </a>

                                                    <a href="{{ route('candidate.profile.downloadGeneratedCV') }}"
                                                       class="btn btn-primary rounded-0">
                                                        <i class="fa fa-download mr-3"></i>{{ __('Download') }}
                                                    </a>
                                                </td>
                                            </tr>
                                            @if(!blank($employ->cv) AND file_exists($employ->cv))
                                                <tr>
                                                    <td>{{ $employ->full_name.'.pdf' }}</td>
                                                    <td class="text-right">
                                                            <a href="{{ route('candidate.profile.downloadUploadedCv', ['type' => 'preview']) }}"
                                                               target="_blank" class="btn btn-primary rounded-0">
                                                                <i class="fa fa-eye mr-3"></i>{{ __('Preview') }}
                                                            </a>

                                                            <a href="{{ route('candidate.profile.downloadUploadedCv') }}" target="_blank"
                                                               class="btn btn-primary rounded-0">
                                                                <i class="fa fa-download mr-3"></i>{{ __('Download') }}
                                                            </a>

                                                            <a href="{{ route('candidate.profile.removeCv') }}"
                                                               class="btn btn-danger rounded-0">
                                                                <i class="fa fa-trash mr-3"></i>{{ __('Remove') }}
                                                            </a>
                                                    </td>
                                                </tr>
                                            @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script src="{{ asset('themes/fvft/') }}/assets/plugins/fileuploads/js/dropify.js"></script>
    <script>
        var drevent = $(".dropify").dropify();
        $(document).ready(function() {
            $(".dropify").dropify();
            // $(".dropify").dropify();
            $(".dropify-message p:first").html('Upload CV (PDF)');
            $(".dropify-infos-message").html('Upload CV (PDF)')
        });
        $("#employeeCv").on('change', function() {
            if ($(this).val() != '') {
                upload(this);
            }
        });

        function resetDropify() {
            drevent = drevent.data('dropify');
            drevent.clearElement();
            drevent.resetPreview();
        }


        function upload(img) {
            var formData = new FormData();
            formData.append('cv', img.files[0]);
            formData.append('_token', '{{ csrf_token() }}');
            $.ajax({
                url: "{{ route('candidate.profile.uploadCv') }}",
                data: formData,
                type: 'POST',
                contentType: false,
                processData: false,
                success: function(data) {
                    if (data.error) {
                        toastr.error(data.error['cv']);
                        resetDropify();
                    } else if (data.db_error) {
                        toastr.error(data.db_error);
                        resetDropify();
                    } else {
                        toastr.success(data.msg);
                        location.reload();
                        setTimeout(() => {
                            resetDropify();
                        }, 10000);
                    }
                },
                error: function(xhr, status, error) {

                }
            });
        }
    </script>
@endsection
