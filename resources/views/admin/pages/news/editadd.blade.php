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
    {{-- @dd($news?$news); --}}
    <div class="page-header">
        <h4 class="page-title">{{ $action }} News</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Modules</a></li>
            <li class="breadcrumb-item" aria-current="news"><a href="/admin/news/">News</a></li>
        </ol>
    </div>

    <div class="row">
        <div class="col-12">
            <form action="/admin/news/save" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ $action }} News</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-9 col-lg-9">

                                <input type="text" name="id" style="display:none;"
                                    value="{{ isset($news->id) ? $news->id : '' }}">
                                <input type="text" name="body" id="body_id" style="display:none;"
                                    value="{{ isset($news->body) ? $news->body : null }}">
                                <input type="text" name="html_content" id="html_content_id" style="display:none;"
                                    value="{{ isset($news->html_content) ? $news->html_content : null }}">
                                <div class="form-group">
                                    <label class="form-label">Title</label>
                                    <input type="text" class="form-control" name="title" placeholder="Title"
                                        value="{{ isset($news->title) ? $news->title : '' }}" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Body</label>
                                    <div id="editor" style="min-height: 20rem;">
                                    </div>
                                </div>
                                {{--{{dd($news)}}--}}
                                <div class="form-group">
                                    <label class="form-label">Upload Logo</label>
                                    <input type="file" class="dropify" name="feature_img" data-default-file="{{ isset($news->feature_img) ? asset($news->feature_img) : null }}" data-height="180" data-allowed-file-extensions="jpg png jpeg svg" data-max-file-size="2M">
                                    @error('feature_img')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3 col-lg-3">
                                <div class="form-group">
                                    <label class="form-label">Seo Title</label>
                                    <input type="text" class="form-control" name="seo_title" placeholder="Seo titile"
                                        value="{{ isset($news->title) ? $news->title : '' }}" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Seo Description</label>
                                    <textarea class="form-control" name="seo_description" rows="7"
                                        placeholder="Seo Description">{{ isset($news->seo_description) ? $news->seo_description : '' }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Seo Keywords</label>
                                    <input type="text" class="form-control" data-role="tagsinput" name="seo_keywords"
                                        placeholder="Keywords" value="{{ isset($news->seo_keywords) ? $news->seo_keywords : '' }}"
                                        required>
                                </div>
                                {{-- <div class="form-group">
                                    <label class="form-label">Slug</label>
                                    <input type="text" class="form-control" name="slug" placeholder="Slug"
                                        value="{{ isset($news->slug) ? $news->slug : '' }}" required>
                                </div> --}}
                                <div class="form-group">
                                    <label class="custom-switch-checkbox">
                                        <input type="checkbox" name="is_active" class="custom-switch-input"
                                            {{ isset($news->is_active) ? ($news->is_active ? 'checked' : '') : 'checked' }}>
                                        <span class="custom-switch-indicator"></span>
                                        <span class="custom-switch-description">Active</span>
                                    </label>
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
