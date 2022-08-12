@extends('admin.layouts.master')
@section('main')
    <div class="page-header">
        <h4 class="page-title">View Profile</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Modules</a></li>
            <li class="breadcrumb-item" aria-current="page">Profile</li>
            <li class="breadcrumb-item active" aria-current="page">View</li>
        </ol>
    </div>

    <div class="row">
        <div class="col-12">
            <form action="{{ route('admin.user.updateProfile') }}" method="post" enctype="multipart/form-data"
                id="updateForm">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">View Profile</h3>

                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 col-lg-6">
                                <div class="form-group">
                                    @if(!blank($admin_detail->avatar))
                                        <img src="{{ asset('/') }}{{ $admin_detail->avatar }}" alt="profile-img" class="avatar avatar-md brround">
                                    @else
                                        <img src="{{ asset('/defaults/profile.png') }}" alt="profile-img" class="avatar avatar-md brround">
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Name</label>
                                    {{ $admin_detail->name }}
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Email</label>
                                    {{ $admin->email }}
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-6 d-none editProfile">
                                <div class="form-group">
                                    <label for="form-label">Name</label>
                                    <input type="text" name="name" value="{{ $admin_detail->name }}"
                                        class="form-control">
                                    <div class="require name text-danger"></div>
                                </div>
                                <div class="form-group">
                                    <label for="form-label">Email</label>
                                    <input type="email" name="email" value="{{ $admin->email }}" class="form-control" readonly>
                                    <div class="require email text-danger"></div>
                                </div>
                                <div class="form-group">
                                    <label for="form-label">Password</label>
                                    <input type="password" class="form-control" name="password" autocomplete="off">
                                    <div class="require password text-danger"></div>
                                </div>
                                <div class="form-group">
                                    <label for="form-label">Upload Avatar</label>
                                    <input type="file" class="form-control" name="avatar" id="img"
                                        onchange="showImg(this, 'imgPreview')">
                                    <img src="" class="imgSize" id="imgPreview" alt="">
                                    <div class="require avatar text-danger d-none"></div>
                                </div>
                                <div class="form-group">
                                    <button type="button" onclick="submitForm(event);"
                                        class="btn btn-primary ml-auto">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <div class="d-flex">
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-link">Cancel</a>
                            <button type="button" onclick="showEditForm();" class="btn btn-primary ml-auto"
                                id="editbutton">Edit</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('script')
    <script>
        function showEditForm() {
            $(".editProfile").removeClass('d-none');
            $("#editbutton").text('Cancel Edit');
            $("#editbutton").attr('onclick', 'hideEditForm()');

        }

        function hideEditForm() {
            $(".editProfile").addClass('d-none');
            $("#editbutton").text('Edit');
            $("#editbutton").attr('onclick', 'showEditForm()');
            $("#updateForm").trigger("reset");
            $("#imgPreview").attr('src', '').width(0).height(0);
            // showImg($("#img"), 'imgPreview');
        }


        function submitForm(e) {
            e.preventDefault();
            $('.require').css('display', 'none');
            let url = $("#updateForm").attr("action");
            // console.log($("#updateForm").serialize())
            var data = new FormData($("#updateForm")[0]);
            data.append('_method', 'put');
            $.ajax({
                url: url,
                type: 'post',
                // data: new FormData($("#updateForm")[0]),
                data: data,
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
                        location.reload();
                        // hideEditForm();
                        // location.href = data.redirectRoute;
                        // toastr.success(data.msg);
                    }
                }
            });
        }
    </script>
@endsection
