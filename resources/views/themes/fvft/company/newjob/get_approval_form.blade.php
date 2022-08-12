@extends('themes.fvft.company.layouts.dashmaster')
@section('title', 'Add New Job')
@section('jobs', 'active')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/datepicker.min.css') }}">
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <style>
        .req {
            color: red;
        }

        .tempcolor {
            color: #1650e2;
            font-weight: bold;
        }

        .ql-container {
            height: 0 !important;
        }

    </style>
@endsection
@section('data')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ __('Add New Job') }}</h3>
        </div>
    </div>
    @include('partial.job.step')
    <div class="alert alert-secondary d-none" role="alert"><button type="button" class="close" data-dismiss="alert"
            aria-hidden="true">×</button><span id="db_error" class="db_error"></span></div>
    <form action="{{ route('company.newjob.post_approval_form') }}" method="POST" enctype="multipart/form-data"
        id="jobForm">
        @csrf
        <input type="hidden" value="{{ setParameter($job, 'id') }}" name="job_id" class="form-control">
        <div class="col-xl-12">
            <div class="row">
                <div class="mx-auto">
                    {{-- @if (setParameter($job, 'status') == 'Draft')
                        <button onclick="submitForm(event, 'proceed_to_approval')" ;
                            class="btn btn-primary rounded-0 ml-5">Proceed To Approval</button>
                    @elseif(setParameter($job, 'status') == null)
                        <button onclick="submitForm(event, 'save_as_draft')" ; class="btn btn-primary rounded-0">Save as
                            Draft</button>
                        <button onclick="submitForm(event, 'proceed_to_approval')" ;
                            class="btn btn-primary rounded-0 ml-5">Proceed To Approval</button>
                    @else
                       <button onclick="submitForm(event, 'update')" ;
                            class="btn btn-primary rounded-0 ml-5">Update</button>
                    @endif --}}
                    <button onclick="submitForm(event, 'save_as_draft')" ; class="btn btn-primary rounded-0">{{ __('Save as Draft') }}</button>
                    <button onclick="submitForm(event, 'proceed_to_approval')" ;
                        class="btn btn-primary rounded-0 ml-5">{{ __('Proceed To Approval') }}</button>
                </div>
            </div>
        </div>
    </form>
@endsection
@section('script')
    <script>
        const _token = $('meta[name="csrf-token"]')[0].content;
        const appurl = "{{ env('APP_URL') }}";

        function submitForm(e, type) {
            e.preventDefault();
            $('.require').css('display', 'none');
            let url = $("#jobForm").attr("action");
            var formData = new FormData($("#jobForm")[0]);
            formData.append('saveType', type);
            $.ajax({
                url: url,
                type: 'post',
                data: formData,
                // data: new FormData($("#jobForm")[0]),
                processData: false,
                contentType: false,
                cache: false,
                success: function(data) {
                    // return true;
                    if (data.db_error) {
                        $(".alert-warning").css('display', 'block');
                        $(".db_error").html(data.db_error);
                        toastr.warning(data.db_error);
                    } else if (data.errors) {
                        var error_html = "";
                        $.each(data.errors, function(key, value) {
                            error_html = '<div>' + value + '</div>';
                            $('.' + key).css('display', 'block').html(error_html);
                        });
                    } else if (!data.errors && !data.db_error) {
                        toastr.success(data.msg);
                        location.href = data.redirectRoute;
                    }
                }
            });
        }
    </script>
@endsection
