@extends('admin.layouts.page_master')
@section('main')
    <!--Page-->
    <style>
        .invalid-feedback{
            display: block !important;
        }
    </style>
    <form action="/login" method="post">
        @csrf
        <div class="page custom-pages">
            <div class="page-content z-index-10">
                <div class="container">
                    <div class="row">

                        <div class="col-xl-4 col-md-12 col-md-12 d-block mx-auto">
                            <div class="card mb-0">
                                <div class="card-header text-center">
                                    <h3 class="card-title">Administrator Login </h3>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label class="form-label text-dark">Email address</label>
                                        <input type="email" name="email" class="form-control" placeholder="Enter email" required value="{{ old('email') }}">
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label text-dark">Password</label>
                                        <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password" required>
                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                    {{-- <div class="form-group">
                                        <label class="custom-control custom-checkbox">
                                            <a href="forgot-password.html" class="float-right small text-dark mt-1">I forgot password</a>
                                            <input type="checkbox" class="custom-control-input">
                                            <span class="custom-control-label text-dark">Remember me</span>
                                        </label>
                                    </div> --}}
                                    <div class="form-footer mt-2">
                                        <button type="submit" class="btn btn-primary btn-block">Login</button>
                                    </div>
                                    {{-- <div class="text-center  mt-3 text-dark">
                                        Don't have account yet? <a href="register.html">SignUp</a>
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </form>
@endsection
