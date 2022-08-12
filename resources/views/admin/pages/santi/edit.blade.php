@extends('admin.layouts.master')
@section('style')
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <style>
        .ql-editor {
            height: 100%;
        }

    </style>
@endsection
@section('main')
    <div class="page-header">
        <h4 class="page-title">Edit About</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Modules</a></li>
            <li class="breadcrumb-item" aria-current="page"><a href="{{ route('admin.about.index') }}">About</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit</li>
        </ol>
    </div>

    <div class="row">
        <div class="col-12">
            <form action="{{ route('admin.santi.update', $about->id) }}" method="post" enctype="multipart/form-data" id="form">
                @csrf
                @method('put')
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Edit About</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 col-lg-6">
                               
                                <div class="form-group">
                                    <label class="form-label">About Title</label>
                                    <input type="text" class="form-control" name="title" value="{{ $about->title }}" placeholder="About Title">
                                    <div class="require title text-danger"></div>
                                </div>                           
                               
                                <input type="text" name="description" id="body_id" value="{{ $about->description }}" style="display:none;">
                                <input type="text" name="html_content" value="{{ $about->html_content }}" id="html_content_id" style="display:none;">
                                <div class="form-group">
                                    <label class="form-label">Body</label>
                                    <div id="editor" style="min-height: 20rem;">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Featured Image</label>
                                    <input type="file" class="dropify" name="feature_image" data-default-file="{{ asset($about->feature_image) }}" data-allowed-file-extensions="png jpg jpeg" data-max-file-size="4M" data-height="180">
                                </div>
                                <div class="form-group">
                                    <label class="custom-switch-checkbox">
                                        <input type="checkbox" name="status" class="custom-switch-input" {{ $about->status ? 'checked' : '' }}>
                                        <span class="custom-switch-indicator"></span>
                                        <span class="custom-switch-description">Active</span>
                                    </label>
                                </div>

                            </div>
                            
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <div class="d-flex">
                            <a href="{{ route('admin.about.index') }}" class="btn btn-link">Cancel</a>
                            <button type="button" onclick="submitForm(event);" class="btn btn-success ml-auto">Save </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('script')
    {{-- <script src="{{ env('APP_URL') }}js/location.js"></script> --}}
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <script>
        let body = "";
        var toolbarOptions = [
            [{
                'header': [1, 2, 3, 4, 5, 6, false]
            }],
            [{
                'color': []
            }, {
                'background': []
            }], // dropdown with defaults from theme
            // [{ 'font': [] }],
            // [{ 'list': 'ordered'}, { 'list': 'bullet' }],
            [{
                'align': []
            }],
            ['bold', 'italic', 'underline'],
            ['link', 'image']
        ];
        var quill = new Quill('#editor', {
            theme: 'snow',
            modules: {
                toolbar: toolbarOptions
            }
        });
        quill.on('text-change', function() {
            body = JSON.stringify(quill.getContents());
            $("#body_id")[0].value = body;
            $("#html_content_id")[0].value = escapeHtml($('.ql-editor').html());
        });
        quill.setContents(JSON.parse($("#body_id")[0].value))

        function escapeHtml(text) {
            const map = {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            };

            return text.replace(/[&<>"']/g, function(m) {
                return map[m];
            });
        }
    </script>
    <script>
        const _token = $('meta[name="csrf-token"]')[0].content;
        const appurl = "{{ env('APP_URL') }}";
    </script>
    <script>
        function submitForm(e) {
            e.preventDefault();
            $('.require').css('display', 'none');
            let url = $("#form").attr("action");
            $.ajax({
                url: url,
                type: 'post',
                data: new FormData(this.form),
                processData: false,
                contentType: false,
                cache: false,
                success: function(data) {
                    if (data.db_error) {
                        $(".alert-warning").css('display', 'block');
                        $(".db_error").html(data.db_error);
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
