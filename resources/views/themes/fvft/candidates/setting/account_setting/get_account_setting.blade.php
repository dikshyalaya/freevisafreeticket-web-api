@extends('themes.fvft.candidates.layouts.dashmaster')
@section('title') Account Setting @stop
@section('content')
    <section>
        <div class="bannerimg cover-image bg-background3" data-image-src="../assets/images/banners/banner2.jpg"
            style="background: url(&quot;../assets/images/banners/banner2.jpg&quot;) center center;">
            <div class="header-text mb-0">
                <div class="text-center text-white">
                    <h1 class="">{{ __('Account Setting') }}</h1>
                    <ol class="breadcrumb text-center">
                        <li class="breadcrumb-item"><a href="#">{{ __('Home') }}</a></li>
                        <li class="breadcrumb-item"><a href="#">{{ __('Dashboard') }} </a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">{{ __('Setting') }}</li>
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
                    <div class="row">
                        @include('partial/candidates/setting_tabs', ['title' => 'Settings - Deactivate My Account'])
                    </div>
                    <div class="row">
                        <div class="card mb-0">
                            <div class="card-header">
                                <h3 class="card-title">{{ strtoupper(__('Deactivate My Account')) }}</h3>
                            </div>
                            <div class="card-body">
                                <h6>{{ __('Fill your password to deactivate your account.') }}</h6>
                                <div class="w-100">
                                    <p style="background-color: #f3a19c;" class="p-1 w-100"><i
                                            class="fa fa-warning text-danger"></i> {{ __('You can reactivate whenever you want') }}</p>
                                </div>
                                <form action="{{ route('candidate.account_setting.post_account_setting') }}" method="POST" id="activateForm">
                                    @csrf
                                    <div class="form-group">
                                        <label for="password">{{ __('Password') }}&nbsp;<span class="req">*</span></label>
                                        <input type="password" class="form-control" name="password" id="Password"
                                            autocomplete="off">
                                        @error('password')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        <input type="hidden" class="form-control" name="saveType" id="saveType">
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <button type="reset" class="btn btn-gray w-75">{{ __('Cancel') }}</button>
                                            </div>
                                            <div class="col-md-4">
                                                <button type="button" data-toggle="modal" data-target="#activateModal"
                                                    data-savetype="Deactivated" data-msg="deactivate"
                                                    data-id="{{ Auth::user()->id }}"
                                                    data-action="{{ route('candidate.account_setting.post_account_setting') }}"
                                                    class="btn btn-warning w-75">{{ __('Deactivate Account') }}</button>
                                            </div>
                                            <div class="col-md-4">
                                                <button type="button" data-toggle="modal" data-target="#activateModal"
                                                    data-msg="delete" data-savetype="Deleted"
                                                    data-id="{{ Auth::user()->id }}"
                                                    data-action="{{ route('candidate.account_setting.post_account_setting') }}"
                                                    class="btn btn-secondary w-75">{{ __('Delete Account') }}</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- ItemDelete Modal --}}
    <!-- Modal -->
    <div class="modal fade" id="activateModal" tabindex="-1" role="dialog" aria-labelledby="activateModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white font-weight-bold">
                    <h5 class="modal-title" id="activateModalLabel"><span id="messagebox"></span> Account</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure, you want to <span id="msgbox"></span> your account?</p>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-gray" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="ButtonID">Delete</button>
                </div>
            </div>
        </div>
    </div>
    {{-- End Delete Modal --}}
@endsection

@section('script')
    {{-- Deactivate or Delete Modal --}}
    <script>
        $(document).ready(function() {
            $("#activateModal").on('show.bs.modal', function(e) {

                var $_this = $(e.relatedTarget),
                    dataId = $($_this).data("id"),
                    msg = $($_this).data('msg'),
                    action = $($_this).data("action");
                $("#msgbox").html(msg);
                $("#messagebox").html(capitalizeFirstLetter(msg));
                $("#ButtonID").html(capitalizeFirstLetter(msg) + ' Account');
                $("#saveType").val($($_this).data('savetype'));


            });

            $("#ButtonID").on('click', function(e) {
                e.preventDefault();
                $("#activateForm").submit();
            });

            $("#activateModal").on('hide.bs.modal', function() {
                $("#activateForm").attr('action', '#');
            });
        });
    </script>
    {{-- End Deactivate or Delete Modal --}}
@endsection
