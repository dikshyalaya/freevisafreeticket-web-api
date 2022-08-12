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
        <h4 class="page-title">Edit Support</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Modules</a></li>
            <li class="breadcrumb-item" aria-current="page"><a href="{{ route('admin.support.index') }}">Support</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add</li>
        </ol>
    </div>

    <div class="row">
        <div class="col-12">
            <form action="{{ route('admin.support.update', $support->id) }}" method="post" enctype="multipart/form-data" id="form">
                @csrf
                @method('put')
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Edit Support</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 col-lg-6">
                                <input type="text" name="answer" id="body_id" style="display:none;"
                                    value="{{ isset($support->answer) ? $support->answer : null }}">
                                <input type="text" name="answer_html" id="html_content_id" style="display:none;"
                                    value="{{ isset($support->answer_html) ? $support->answer_html : null }}">
                                <div class="form-group">
                                    <label class="form-label">Support Category</label>
                                    <select name="support_category_id" class="form-control select2">
                                        <option value="">Select Support Category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" {{ !($category->id == $support->support_category_id) ?: 'selected' }}>{{ $category->title }}</option>
                                        @endforeach
                                    </select>
                                    <span class="require support_category_id text-danger"></span>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Support Question</label>
                                    <input type="text" value="{{ $support->question }}" class="form-control" name="question"
                                        placeholder="Enter Support Question">
                                    <span class="require question text-danger"></span>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Support Answer</label>
                                    <div id="editor" style="min-height: 20rem;">
                                    </div>
                                    <span class="require answer text-danger"></span>
                                    <span class="require answer_html text-danger"></span>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Support Types</label>
                                    <select name="support_types[]" class="form-control select2" multiple>
                                        @foreach ($support_types as $support_type)
                                            <option value="{{ $support_type->id }}" {{ in_array($support_type->id, $support->support_types->pluck('id')->toArray()) ? 'selected': '' }}>{{ $support_type->title }}</option>
                                        @endforeach
                                    </select>
                                    <span class="require support_types text-danger"></span>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <div class="d-flex">
                            <a href="{{ route('admin.support.index') }}" class="btn btn-link">Cancel</a>
                            <button id="saveButton" type="button" onclick="submitForm(event);"
                                class="btn btn-primary ml-auto">Save
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ env('APP_URL') }}js/location.js"></script>
    <script>
        const _token = $('meta[name="csrf-token"]')[0].content;
        const appurl = "{{ env('APP_URL') }}";
    </script>
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
        if($("#body_id")[0].value != ''){
            quill.setContents(JSON.parse($("#body_id")[0].value))
        }


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
                beforeSend: function() {
                    $("saveButton").attr('disabled', true);
                },
                success: function(data) {
                    if (data.db_error) {
                        $(".alert-warning").css('display', 'block');
                        $(".db_error").html(data.db_error);
                        toastr.warning(data.db_error);
                    } else if (!data.db_error) {
                        toastr.success(data.msg);
                        location.href = data.redirectRoute;
                    }
                },
                error: function(xhr) {
                    var response = xhr.responseJSON;
                    console.log(response.errors);
                    if($.isEmptyObject(response.errors) == false){
                        var error_html = "";
                        $.each(response.errors, function(key, value){
                            error_html = value;
                            $("."+key).css('display', 'block').html(error_html);
                        });
                    }
                },
                complete: function() {
                    $("#saveButton").attr('disabled', false);
                }
            });
        }
    </script>
@endsection
