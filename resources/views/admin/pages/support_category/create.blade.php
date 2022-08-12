@extends('admin.layouts.master')
@section('main')
    <div class="page-header">
        <h4 class="page-title">Create Support Category</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Modules</a></li>
            <li class="breadcrumb-item" aria-current="page"><a href="{{ route('admin.support_category.index') }}">Support
                    Category</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add</li>
        </ol>
    </div>

    <div class="row">
        <div class="col-12">
            <form action="{{ route('admin.support_category.store') }}" method="post" enctype="multipart/form-data"
                id="form">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">New Support Category</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 col-lg-6">

                                <div class="form-group">
                                    <label class="form-label">Support Category Title</label>
                                    <input type="text" class="form-control" name="title"
                                        placeholder="Support Category Title">
                                    <span class="require title text-danger"></span>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <div class="d-flex">
                            <a href="{{ route('admin.support_category.index') }}" class="btn btn-link">Cancel</a>
                            <button id="saveButton" type="button" onclick="submitForm(event);" class="btn btn-primary ml-auto">Save
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
                beforeSend: function(){
                    $("saveButton").attr('disabled', true);
                },
                success: function(data) {
                    if (data.db_error) {
                        $(".alert-warning").css('display', 'block');
                        $(".db_error").html(data.db_error);
                    } else if (!data.db_error) {
                        toastr.success(data.msg);
                        location.href = data.redirectRoute;
                    }
                },
                error: function(xhr){
                    var response = xhr.responseJSON;
                    if($.isEmptyObject(response.errors) == false){
                        var error_html = "";
                        $.each(response.errors, function(key, value){
                            error_html = value;
                            $("."+key).css('display', 'block').html(error_html);
                        });
                    }
                },
                complete: function(){
                    $("#saveButton").attr('disabled', false);   
                }
            });
        }
    </script>
@endsection
