<!doctype html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="Description" content="Job board Admin template">
    <meta name="Author" content="Spruko Technologies Private Limited">
    <meta name="keywords" content="bootstrap job board template, bootstrap job template" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ !blank($general_setting) ? $general_setting->name : 'Free Visa Free Ticket' }} - @yield('title')</title>

    <link rel="stylesheet" href="{{ asset('themes/fvft/assets/fonts/fonts/font-awesome.min.css') }}">
    <!-- Bootstrap Css -->
    <link href="{{ asset('themes/fvft/assets/plugins/bootstrap-4.3.1-dist/css/bootstrap.min.css') }}" rel="stylesheet" />
    <!-- Sidemenu Css -->
    <link href="{{ asset('themes/fvft/assets/css/sidemenu.css') }}" rel="stylesheet" />
    <!-- Dashboard Css -->
    <link href="{{ asset('themes/fvft/assets/css/style.css') }}" rel="stylesheet" />
    <link href="{{ asset('themes/fvft/assets/css/admin-custom.css') }}" rel="stylesheet" />
    <!-- c3.js Charts Plugin -->
    <link href="{{ asset('themes/fvft/assets/plugins/charts-c3/c3-chart.css') }}" rel="stylesheet" />
    <!-- select2 Plugin -->
    <link href="{{ asset('themes/fvft/assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
    <!-- Time picker Plugin -->
    <link href="{{ asset('themes/fvft/assets/plugins/time-picker/jquery.timepicker.css') }}" rel="stylesheet" />
    <!-- Date Picker Plugin -->
    <link href="{{ asset('themes/fvft/assets/plugins/date-picker/spectrum.css') }}" rel="stylesheet" />
    <!--Bootstrap-datepicker css-->
    <link rel="stylesheet" href="{{ asset('themes/fvft/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.css') }}">
    <!--Bootstrap-datepicker css-->
    <link rel="stylesheet" href="{{ asset('themes/fvft/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.css') }}">
    <!-- p-scroll bar css-->
    <link href="{{ asset('themes/fvft/assets/plugins/pscrollbar/pscrollbar.css') }}" rel="stylesheet" />
    <!-- file Uploads -->
    <link href="{{ asset('themes/fvft/assets/plugins/fileuploads/css/dropify.css') }}" rel="stylesheet" type="text/css" />
    <!---Font icons-->
    <link href="{{ asset('themes/fvft/assets/css/icons.css') }}" rel="stylesheet" />
    <!-- Color-Skins -->
    <link id="theme" rel="stylesheet" type="text/css" media="all" href="{{ asset('themes/fvft/assets/color-skins/color-skins/color10.css') }}" />
    <!-- Data table css -->
    <link href="{{ asset('themes/fvft/assets/plugins/datatable/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('themes/fvft/assets/plugins/datatable/jquery.dataTables.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/main.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/admin/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/nepali.datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/fvft/assets/css/jquery-ui.css') }}">

    {{-- FAV ICONS --}}
    <link rel="shortcut icon" href="{{ asset('/uploads/site/fav/favicon.ico') }}" />
    <link rel="icon" href="{{ asset('/uploads/site/fav/favicon.ico') }}" />
    <link rel="icon" sizes="32x32" href="{{ asset('/uploads/site/fav/favicon-32x32.png') }}">
    <link rel="icon" sizes="16x16" href="{{ asset('/uploads/site/fav/favicon-16x16.png') }}">
    <link rel="icon" sizes="192x192" href="{{ asset('/uploads/site/fav/android-chrome-192x192.png') }}">
    <link rel="icon" sizes="512x512" href="{{ asset('/uploads/site/fav/android-chrome-512x512.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('/uploads/site/fav/apple-touch-icon.png') }}">

    <style>
        .toast-top-container {
            position: absolute;
            top: 65px;
            width: 280px;
            right: 40px;
            height: auto;
        }
        .select2-selection__choice__remove{
            border-radius: 3px;
            border: 1px;
        }

        #ajaxLoader {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, .8) url('{{ asset('themes/fvft/assets/images/loader.svg') }}') no-repeat 50%
        }

        .fog_div {
            display: none;
            position: fixed;
            top: 0px;
            left: 0px;
            height: 100%;
            width: 100%;
            z-index: 100;
            background-color: rgba(30, 30, 30, 0.5);
        }

        #ajaxLoader.show {
            display: block;
        }

    </style>
    @yield('style')
</head>

<body class="app sidebar-mini">

<!--Loader-->
{{--<div id="global-loader">--}}
{{--<img src="{{ asset('themes/fvft/') }}/assets/images/loader.svg" class="loader-img" alt="">--}}
{{--</div>--}}
<div class="page">
    <div class="page-main">
    @include('admin.components.header')
    <!-- Sidebar menu-->
        @include('admin.components.sidebar')

        <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
            <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
        </div>
        <div class="ps__rail-y" style="top: 0px; height: 663px; right: 0px;">
            <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 518px;"></div>
        </div>
        {{--</aside>--}}
        <div class="app-content">
            <div class="side-app">
                @yield('main')
            </div>
        </div>
    </div>
@include('modals.deleteModal')
    <!--footer-->
@include('admin.components.footer')
<!-- End Footer-->
</div>
<!-- Back to top -->
<a href="#top" id="back-to-top"><i class="fa fa-rocket"></i></a>

<!-- Dashboard Css -->
<script src="{{ asset('themes/fvft/') }}/assets/js/vendors/jquery-3.2.1.min.js"></script>
<script src="{{ asset('themes/fvft/') }}/assets/plugins/bootstrap-4.3.1-dist/js/popper.min.js"></script>
<script src="{{ asset('themes/fvft/') }}/assets/plugins/bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>
<script src="{{ asset('themes/fvft/') }}/assets/js/vendors/jquery.sparkline.min.js"></script>
<script src="{{ asset('themes/fvft/') }}/assets/js/vendors/selectize.min.js"></script>
<script src="{{ asset('themes/fvft/') }}/assets/js/vendors/jquery.tablesorter.min.js"></script>
<script src="{{ asset('themes/fvft/') }}/assets/js/vendors/circle-progress.min.js"></script>
<script src="{{ asset('themes/fvft/') }}/assets/plugins/rating/jquery.rating-stars.js"></script>
<!-- Fullside-menu Js-->
<script src="{{ asset('themes/fvft/') }}/assets/plugins/toggle-sidebar/sidemenu.js"></script>
<!--Select2 js -->
<script src="{{ asset('themes/fvft/') }}/assets/plugins/select2/select2.full.min.js"></script>
<!-- Timepicker js -->
<script src="{{ asset('themes/fvft/') }}/assets/plugins/time-picker/jquery.timepicker.js"></script>
<script src="{{ asset('themes/fvft/') }}/assets/plugins/time-picker/toggles.min.js"></script>
<!-- Datepicker js -->
<script src="{{ asset('themes/fvft/') }}/assets/plugins/date-picker/spectrum.js"></script>
<script src="{{ asset('themes/fvft/') }}/assets/plugins/date-picker/jquery-ui.js"></script>
<script src="{{ asset('themes/fvft/') }}/assets/plugins/input-mask/jquery.maskedinput.js"></script>
<!-- Inline js -->
<script src="{{ asset('themes/fvft/') }}/assets/js/select2.js"></script>
<script src="{{ asset('themes/fvft/') }}/assets/js/formelements.js"></script>
<!-- file uploads js -->
<script src="{{ asset('themes/fvft/') }}/assets/plugins/fileuploads/js/dropify.js"></script>
<!--InputMask Js-->
<script src="{{ asset('themes/fvft/') }}/assets/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js"></script>
<!-- p-scroll bar Js-->
<script src="{{ asset('themes/fvft/') }}/assets/plugins/pscrollbar/pscrollbar.js"></script>
<script src="{{ asset('themes/fvft/') }}/assets/plugins/pscrollbar/pscroll.js"></script>
<!--Bootstrap-datepicker js-->
<script src="{{ asset('themes/fvft/') }}/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.js"></script>
<!--Counters -->
<script src="{{ asset('themes/fvft/') }}/assets/plugins/counters/counterup.min.js"></script>
<script src="{{ asset('themes/fvft/') }}/assets/plugins/counters/waypoints.min.js"></script>
<script src="{{ asset('themes/fvft/') }}/assets/plugins/counters/numeric-counter.js"></script>
<!-- Data tables -->
<script src="{{ asset('themes/fvft/') }}/assets/plugins/datatable/jquery.dataTables.min.js"></script>
<script src="{{ asset('themes/fvft/') }}/assets/plugins/datatable/dataTables.bootstrap4.min.js"></script>
<!-- Custom Js-->
<script src="{{ asset('themes/fvft/') }}/assets/js/admin-custom.js"></script>
<script src="{{ asset('js/main.js') }}"></script>
<script src="{{ asset('js/toastr.min.js') }}"></script>
<script src="{{ asset('js/nepali.datepicker.min.js') }}"></script>
<script src="{{ asset('js/sweetalert2.js') }}"></script>
<script src="{{ asset('themes/fvft/') }}/assets/plugins/jquery-uislider/jquery-ui.js"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


    function showImg(img, previewId) {
        readInputURL(img, previewId);
    }

    function readInputURL(input, idName) {
        if (input.files && input.files[0]) {
            let reader = new FileReader();
            reader.onload = function(e) {
                $("#" + idName).attr('src', e.target.result).width(100).height(100);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    $(function() {
        var mainInput = document.getElementsByClassName("nepaliDatePicker");
        if (mainInput.length) {
            mainInput.nepaliDatePicker({
                language: "english",
                onChange: function () {
                    let nepalidate = $(".nepaliDatePicker").val();
                    let dateObj = NepaliFunctions.ParseDate(nepalidate);
                    let engDate = NepaliFunctions.BS2AD(dateObj.parsedDate);
                    let year = engDate.year;
                    let month = NepaliFunctions.Get2DigitNo(engDate.month);
                    let day = NepaliFunctions.Get2DigitNo(engDate.day);
                    let engValue = year + '-' + month + '-' + day;
                    $(".datetime").val(engValue);
                },
                ndpYear: true,
                ndpMonth: true,
                ndpYearCount: 200
            });
        }

        $(".datetimepicker").datepicker({
            format: 'yyyy-mm-dd',
            todayHighlight: true,
            autoclose: true,
        });
    });


    function preventNegativeNo(this_value){
        if(!!$(this_value).val() && Math.abs($(this_value).val()) >= 1){
            $(this_value).val(Math.abs($(this_value).val()));
        } else {
            $(this_value).val(null);
        }
    }
</script>
<script>
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": true,
        "positionClass": "toast-top-container",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };
        @if (Session::has('message'))
    var type = "{{ Session::get('alert-type', 'info') }}";
    switch (type) {
        case 'info':
            toastr.info("{{ Session::get('message') }}");
            break;

        case 'warning':
            toastr.warning("{{ Session::get('message') }}");
            break;

        case 'success':
            toastr.success("{{ Session::get('message') }}");
            break;

        case 'error':
            toastr.error("{{ Session::get('message') }}");
            break;
    }
    @endif
</script>
{{-- Delete Modal Script --}}
<script>
    $(document).ready(function(){
        $("#dataDeleteModal").on('show.bs.modal', function(e){
            var delBtn = $(e.relatedTarget),
                dataId = $(delBtn).data("id")
                action = $(delBtn).data("action"),
                methodName = $(delBtn).data('method'),
                modalTitle = $(delBtn).data('modaltitle');
                if(methodName == 'DELETE'){
                    $("#deleteDataForm").append('@method('DELETE')');
                }
                $("#modalTitle").html(modalTitle);
                $("#deleteDataForm").attr('action', action);
                if(methodName == 'DELETE' || methodName == 'POST'){
                    $("#deleteDataForm").attr('method', 'POST')
                } else {
                    $("#deleteDataForm").attr('method', 'GET');
                }

        });

        $("#dataDelBtn").on('click', function(e){
            e.preventDefault();
            $("#deleteDataForm").submit();
        });

        $("#dataDeleteModal").on('hidden.bs.modal', function(e){
            $("#deleteDataForm").attr('action', '#');
            $("#deleteDataForm").attr('method', '#');
            if($('input[name="_method"]').length > 0){
                // console.log($("#deleteDataForm").find('input[name="_method"]').remove()); //do not remove this console
                $("#deleteDataForm").find('input[name^="_method"]').remove()
            }
        });
    });

    function capitalizeFirstLetter(string) {
        return string.charAt(0).toUpperCase() + string.slice(1);
    }

    @if (Session::has('swalMessage'))
            Swal.fire({
                title: "{{ Session::get('swalTitle') }}",
                text: "{{ Session::get('swalMessage') }}",
                icon: "{{ Session::get('swalIcon') }}",
                // confirmButtonText: 'Ok'
            });
        @endif

        function busySign() {
            $('#ajaxLoader').css('display', 'block');
        }

        function hideBusySign() {
            $('#ajaxLoader').css('display', 'none');
        }

    $(function(e) {
        $('.data-table').DataTable();
    } );
</script>
@yield('script')
</body>
</html>
