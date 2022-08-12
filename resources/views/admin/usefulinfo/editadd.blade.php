@extends('admin.layouts.master')
@section('style')
    <link rel="stylesheet" href="/css/tag.css">
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <style>
        .ql-editor {
            height: 100%;
        }

    </style>
@endsection
@section('main')
    <div class="page-header">
        <h4 class="page-title">{{ $action }} Useful Informations</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Modules</a></li>
            <li class="breadcrumb-item" aria-current="news"><a href="/admin/news/">Useful Informations</a></li>
        </ol>
    </div>

    <div class="row">
        <div class="col-12">
            <form action="{{ route('admin.usefulinfo.save') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ $action }} Useful Informations</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-9 col-lg-9">

                                <input type="text" name="id" style="display:none;"
                                    value="{{ isset($useful_info->id) ? $useful_info->id : '' }}">
                                <input type="text" name="desc" id="body_id" style="display:none;"
                                    value="{{ isset($useful_info->desc) ? $useful_info->desc : null }}">
                                <input type="text" name="desc_content" id="html_content_id" style="display:none;"
                                    value="{{ isset($useful_info->desc_content) ? $useful_info->desc_content : null }}">
                                <div class="form-group">
                                    <label class="form-label">Title</label>
                                    <input type="text" class="form-control" name="title" placeholder="Title"
                                        value="{{ isset($useful_info->title) ? $useful_info->title : '' }}">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Description</label>
                                    <div id="editor" style="min-height: 20rem;">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Upload Logo</label>
                                    <input type="file" class="dropify" name="logo" data-default-file="{{ isset($useful_info->logo) ? asset($useful_info->logo) : null }}" data-height="180" data-allowed-file-extensions="jpg png jpeg" data-max-file-size="2M">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <div class="d-flex">
                            <a href="/admin/news/" class="btn btn-link">Back</a>
                            <button type="submit" class="btn btn-primary ml-auto">Save </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('script')
    <script src="/js/tag.js"></script>
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
@endsection
