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
    {{-- @dd($page?$page); --}}
    <div class="page-header">
        <h4 class="page-title">{{ $action }} Page</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Modules</a></li>
            <li class="breadcrumb-item" aria-current="page"><a href="{{ route('admin.pages.list') }}">Page</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add</li>
        </ol>
    </div>

    <div class="row">
        <div class="col-12">
            <form action="/admin/pages/save" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ $action }} Pages</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-9 col-lg-9">

                                <input type="text" name="id" style="display:none;"
                                    value="{{ isset($page->id) ? $page->id : '' }}">
                                <input type="text" name="body" id="body_id" style="display:none;"
                                    value="{{ isset($page->body) ? $page->body : old('body') }}">
                                <input type="text" name="html_content" id="html_content_id" style="display:none;"
                                    value="{{ isset($page->html_content) ? $page->html_content : old('html_content') }}">
                                <div class="form-group">
                                    <label class="form-label">Title</label>
                                    <input type="text" class="form-control" name="title" placeholder="Title"
                                        value="{{ isset($page->title) ? $page->title : old('title') }}" required>
                                    @error('title')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Body</label>
                                    <div id="editor" style="min-height: 20rem;">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-lg-3">
                                <div class="form-group">
                                    <label class="form-label">Seo Title</label>
                                    <input type="text" class="form-control" name="seo_title" placeholder="Seo Title"
                                        value="{{ isset($page->title) ? $page->title : old('seo_title') }}" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Seo Description</label>
                                    <textarea class="form-control" name="seo_description" rows="7"
                                        placeholder="Seo Description">{{ isset($page->seo_description) ? $page->seo_description : old('seo_description') }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Seo Keywords</label>
                                    <input type="text" class="form-control" data-role="tagsinput" name="seo_keywords"
                                        placeholder="Seo Keywords" value="{{ isset($page->seo_keywords) ? $page->seo_keywords : old('seo_keywords') }}"
                                        required>
                                </div>
                                {{-- <div class="form-group">
                                    <label class="form-label">Slug</label>
                                    <input type="text" class="form-control" name="slug" placeholder="Slug"
                                        value="{{ isset($page->slug) ? $page->slug : '' }}" required>
                                </div> --}}
                                <div class="form-group">
                                    <label class="custom-switch-checkbox">
                                        <input type="checkbox" name="is_active" class="custom-switch-input"
                                            {{ isset($page->is_active) ? ($page->is_active ? 'checked' : '') : 'checked' }}>
                                        <span class="custom-switch-indicator"></span>
                                        <span class="custom-switch-description">Active</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <div class="d-flex">
                            <a href="/admin/pages/" class="btn btn-link">Back</a>
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
            // $("#html_content_id")[0].value=$(".ql-editor")[0];
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
