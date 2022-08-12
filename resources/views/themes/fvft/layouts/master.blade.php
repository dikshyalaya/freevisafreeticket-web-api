<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="Description" content="">
    <meta name="Author" content="ByteRays Technology Pvt. Ltd.">
    <meta name="keywords" content="" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ !blank($general_setting) ? $general_setting->name : 'Free Visa Free Ticket' }} -@yield('title')
    </title>

    {{-- FAV ICONS --}}
    <link rel="shortcut icon" href="{{ asset('/uploads/site/fav/favicon.ico') }}" />
    <link rel="icon" href="{{ asset('/uploads/site/fav/favicon.ico') }}" />
    <link rel="icon" sizes="32x32" href="{{ asset('/uploads/site/fav/favicon-32x32.png') }}">
    <link rel="icon" sizes="16x16"
          href="{{ !blank($general_setting) ? asset($general_setting->favicon) : asset('/uploads/site/fav/favicon-16x16.png') }}">
    <link rel="icon" sizes="192x192"
          href="{{ !blank($general_setting) ? asset($general_setting->favicon) : asset('/uploads/site/fav/android-chrome-192x192.png') }}">
    <link rel="icon" sizes="512x512"
          href="{{ !blank($general_setting) ? asset($general_setting->favicon) : asset('/uploads/site/fav/android-chrome-512x512.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('/uploads/site/fav/apple-touch-icon.png') }}">

    <link href="{{ asset('themes/fvft/assets/plugins/bootstrap-4.3.1-dist/css/bootstrap.min.css') }}"
          rel="stylesheet" />
    <link href="{{ asset('themes/fvft/assets/css/style.css') }}" rel="stylesheet" />
    <link href="{{ asset('themes/fvft/assets/css/icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('themes/fvft/assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('themes/fvft/assets/plugins/cookie/cookie.css') }}" rel="stylesheet">
    <link href="{{ asset('themes/fvft/assets/plugins/owl-carousel/owl.carousel.css') }}" rel="stylesheet" />
    <link href="{{ asset('themes/fvft/assets/plugins/scroll-bar/jquery.mCustomScrollbar.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <!-- COLOR-SKINS -->
    <link href="{{ asset('themes/fvft/assets/color-skins/color-skins/color10.css') }}" id="theme" rel="stylesheet"
          type="text/css" media="all" />
    <link href="{{ asset('themes/fvft/assets/css/main.css') }}" id="theme" rel="stylesheet" type="text/css"
          media="all" />
    <link rel="stylesheet" href="{{ asset('themes/fvft/assets/css/jquery-ui.css') }}">
    <link rel="stylesheet" href="{{ asset('css/nepali.datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/form_step.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @if(app()->getLocale() == 'np')
        <link rel="stylesheet" href="{{ asset('css/nepali-font.css') }}">
    @endif
    <style>
        .toast-top-container {
            position: absolute;
            top: 65px;
            width: 280px;
            right: 40px;
            height: auto;
        }

        .cur_sor {
            cursor: pointer;
        }

        .req {
            color: red;
        }

        .home_hr {
            border-top: 1px solid black;
        }


        .toast {
            opacity: 1 !important;
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
        .toast{
            opacity: 1 !important;
        }

    </style>
    @yield('style')
    <script type='text/javascript'
            src='https://platform-api.sharethis.com/js/sharethis.js#property=626a7f190ebd0700197cc4c1&product=sop'
            async='async'></script>
</head>

<body class="main-body">
<div id="ajaxLoader" class="fog_div">
    <div></div>
</div>
{{--<div id="app">--}}
@yield('main')
{{--</div>--}}
<!-- Back to top -->
<a href="#top" id="back-to-top"><i class="fa fa-arrow-up"></i></a>

<!-- JQuery js-->
<script src="{{ asset('themes/fvft/') }}/assets/js/vendors/jquery-3.2.1.min.js"></script>

<!-- Bootstrap js -->
<script src="{{ asset('themes/fvft/') }}/assets/plugins/bootstrap-4.3.1-dist/js/popper.min.js"></script>
<script src="{{ asset('themes/fvft/') }}/assets/plugins/bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>

<!--JQuery Sparkline Js-->
<script src="{{ asset('themes/fvft/') }}/assets/js/vendors/jquery.sparkline.min.js"></script>

<!-- Circle Progress Js-->
<script src="{{ asset('themes/fvft/') }}/assets/js/vendors/circle-progress.min.js"></script>

<!-- Star Rating Js-->
<script src="{{ asset('themes/fvft/') }}/assets/plugins/rating/jquery.rating-stars.js"></script>

<!--Counters -->
<script src="{{ asset('themes/fvft/') }}/assets/plugins/counters/counterup.min.js"></script>
<script src="{{ asset('themes/fvft/') }}/assets/plugins/counters/waypoints.min.js"></script>
<script src="{{ asset('themes/fvft/') }}/assets/plugins/counters/numeric-counter.js"></script>

<!--Owl Carousel js -->
<script src="{{ asset('themes/fvft/') }}/assets/plugins/owl-carousel/owl.carousel.js"></script>

<!--Horizontal Menu-->
<script src="{{ asset('themes/fvft/') }}/assets/plugins/horizontal/horizontal-menu/horizontal.js"></script>

<!--JQuery TouchSwipe js-->
<script src="{{ asset('themes/fvft/') }}/assets/js/jquery.touchSwipe.min.js"></script>

<!--Select2 js -->
<script src="{{ asset('themes/fvft/') }}/assets/plugins/select2/select2.full.min.js"></script>
<script src="{{ asset('themes/fvft/') }}/assets/js/select2.js"></script>

<!-- sticky Js-->
<script src="{{ asset('themes/fvft/') }}/assets/js/sticky.js"></script>

<!-- Ion.RangeSlider -->
<script src="{{ asset('themes/fvft/') }}/assets/plugins/jquery-uislider/jquery-ui.js"></script>

<!--Showmore Js-->
<script src="{{ asset('themes/fvft/') }}/assets/js/jquery.showmore.js"></script>
<script src="{{ asset('themes/fvft/') }}/assets/js/showmore.js"></script>

<!-- Cookie js -->
<script src="{{ asset('themes/fvft/') }}/assets/plugins/cookie/jquery.ihavecookies.js"></script>
<script src="{{ asset('themes/fvft/') }}/assets/plugins/cookie/cookie.js"></script>

<!-- Custom scroll bar Js-->
<script src="{{ asset('themes/fvft/') }}/assets/plugins/scroll-bar/jquery.mCustomScrollbar.concat.min.js"></script>

<!-- Swipe Js-->
<script src="{{ asset('themes/fvft/') }}/assets/js/swipe.js"></script>

<!-- Scripts Js-->
<script src="{{ asset('themes/fvft/') }}/assets/js/scripts2.js"></script>

<!-- Custom Js-->
<script src="{{ asset('themes/fvft/') }}/assets/js/custom.js"></script>
<script src="{{ asset('themes/fvft/assets/js/jquery-ui.js') }}"></script>
<script src="{{ asset('js/nepali.datepicker.min.js') }}"></script>
<script src="{{ asset('js/toastr.min.js') }}"></script>
<script src="{{ asset('js/sweetalert2.js') }}"></script>
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
        if (!mainInput.length) {
            return;
        }
        mainInput.nepaliDatePicker({
            language: "english",
            onChange: function() {
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
        $(".datetimepicker").datepicker({
            format: 'yyyy-mm-dd',
            todayHighlight: true,
            autoclose: true,
        });
    });

    function preventNegativeNo(this_value) {
        if (!!$(this_value).val() && Math.abs($(this_value).val()) >= 1) {
            $(this_value).val(Math.abs($(this_value).val()));
        } else {
            $(this_value).val(null);
        }
    }

    function capitalizeFirstLetter(string) {
        return string.charAt(0).toUpperCase() + string.slice(1);
    }
    // Smart Search start
    $("#jobSearch").autocomplete({
        source: function(data, cb) {
            $.ajax({
                url: "{{ route('getJobsByTitle') }}",
                type: 'POST',
                data: {
                    'job_title': data.term
                },
                dataType: 'json',
                autoFocus: true,
                showHintOnFocus: true,
                autoSelect: true,
                selectInitial: true,
                success: function(res) {
                    if (res.length) {
                        var datas = $.map(res, function(value) {
                            return {
                                label: value.title,
                                id: value.id,
                                job_title: value.title,
                            }
                        });
                    }
                    cb(datas);
                },
                error: function() {},
            });
        },
        search: function(e, ui) {
            console.log('searching');
        },
        response: function(e, el) {
            if (el.content == undefined) {} else if (el.content.length == 1) {
                // $(this).data('ui-autocomplete')._trigger('select', 'autocompleteselect', el);
                // $(this).autocomplete("close");
            }
            console.log('hiding');
        },
        open: function() {},
        select: function(e, ui) {
            e.preventDefault();
            if (typeof ui.content != 'undefined') {
                if (isNaN(ui.content[0].id)) {
                    return;
                }
                var jobtitle = ui.content[0].job_title;
                var job_id = ui.content[0].id;
            } else {
                var jobtitle = ui.item.job_title;
                var job_id = ui.item.id;
            }
            $("#jobSearch").val(jobtitle);
        }
    });
    $("#jobSearch").bind('paste', (e) => {
        $("#jobSearch").autocomplete('search');
    });
    // End Smart Search
</script>

<script>
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": true,
        "preventDuplicates": true,
        "onclick": onClick,
        "showDuration": "300",
        "hideDuration": "400",
        "timeOut": 0,
        "extendedTimeOut": 0,
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut",
        "positionClass": "toast-top-full-width",
    };

        @if (Session::has('message'))
    var type = "{{ Session::get('alert-type', 'info') }}";
    switch (type) {
        case 'info':
            toastr.info("{{ Session::get('message') }}");
            break;

        case 'warning':
            toastr.info("{{ Session::get('message') }}");
            break;

        case 'success':
            toastr.success("{{ Session::get('message') }}");
            break;

        case 'error':
            toastr.error("{{ Session::get('message') }}");
            break;
    }
    @endif

    @if (Session::has('swalMessage'))
    Swal.fire({
        title: "{{ Session::get('swalTitle') }}",
        text: "{{ Session::get('swalMessage') }}",
        icon: "{{ Session::get('swalIcon') }}",
        // confirmButtonText: 'Ok'
    });
    @endif


    function onClick() {
        toastr.clear()
    }

    function busySign() {
        $('#ajaxLoader').css('display', 'block');
    }

    function hideBusySign() {
        $('#ajaxLoader').css('display', 'none');
    }
</script>
@yield('script')
@yield('scripts')
</body>

</html>
