<html lang="en" dir="ltr"><head>
    <meta charset="UTF-8">
       <meta name="viewport" content="width=device-width, initial-scale=1">
       <meta http-equiv="X-UA-Compatible" content="IE=edge">
       <meta name="Description" content="Job board Admin template">
       <meta name="Author" content="Spruko Technologies Private Limited">
       <meta name="keywords" content="bootstrap job board template, bootstrap job template">
       <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
       <meta name="apple-mobile-web-app-capable" content="yes">
       <meta name="mobile-web-app-capable" content="yes">
       <meta name="HandheldFriendly" content="True">
       <meta name="MobileOptimized" content="320">
       <link rel="icon" href="{{asset('uploads/imgs/')}}/fvft_favicon.png" type="image/x-icon"/>
       <link rel="shortcut icon" type="image/x-icon" href="{{asset('uploads/imgs/')}}/fvft_favicon.png"/>

   <!-- Title -->
   <title>FVFT-Login</title>
    <link rel="stylesheet" href="{{asset('themes/fvft/')}}/assets/fonts/fonts/font-awesome.min.css">

    <!-- Bootstrap Css -->
    <link href="{{asset('themes/fvft/')}}/assets/plugins/bootstrap-4.3.1-dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Sidemenu Css -->
    <link href="{{asset('themes/fvft/')}}/assets/css/sidemenu.css" rel="stylesheet">


    <!-- Dashboard css -->
    <link href="{{asset('themes/fvft/')}}/assets/css/style.css" rel="stylesheet">
    <link href="{{asset('themes/fvft/')}}/assets/css/admin-custom.css" rel="stylesheet">

    <!-- c3.js Charts Plugin -->
    <link href="{{asset('themes/fvft/')}}/assets/plugins/charts-c3/c3-chart.css" rel="stylesheet">

    <!---Font icons-->
    <link href="{{asset('themes/fvft/')}}/assets/css/icons.css" rel="stylesheet">

<style type="text/css">.jqstooltip { position: absolute;left: 0px;top: 0px;visibility: hidden;background: rgb(0, 0, 0) transparent;background-color: rgba(0,0,0,0.6);filter:progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000, endColorstr=#99000000);-ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000, endColorstr=#99000000)";color: white;font: 10px arial, san serif;text-align: left;white-space: nowrap;padding: 5px;border: 1px solid white;z-index: 10000;}.jqsfield { color: white;font: 10px arial, san serif;text-align: left;}</style></head>
<body class="">
    <!--Loader-->
    <div id="global-loader" style="display: none;">
        <img src="{{asset('themes/fvft/')}}/assets/images/loader.svg" class="loader-img" alt="">
    </div>

   @yield('main')



    <!-- Dashboard js -->
    <script src="{{asset('themes/fvft/')}}/assets/js/vendors/jquery-3.2.1.min.js"></script>
    <script src="{{asset('themes/fvft/')}}/assets/plugins/bootstrap-4.3.1-dist/js/popper.min.js"></script>
    <script src="{{asset('themes/fvft/')}}/assets/plugins/bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>
    <script src="{{asset('themes/fvft/')}}/assets/js/vendors/jquery.sparkline.min.js"></script>
    <script src="{{asset('themes/fvft/')}}/assets/js/vendors/selectize.min.js"></script>
    <script src="{{asset('themes/fvft/')}}/assets/js/vendors/jquery.tablesorter.min.js"></script>
    <script src="{{asset('themes/fvft/')}}/assets/js/vendors/circle-progress.min.js"></script>
    <script src="{{asset('themes/fvft/')}}/assets/plugins/rating/jquery.rating-stars.js"></script>
    <!-- p-scroll bar Js-->
    <script src="{{asset('themes/fvft/')}}/assets/plugins/pscrollbar/pscrollbar.js"></script>
    <script src="{{asset('themes/fvft/')}}/assets/plugins/pscrollbar/pscroll.js"></script>

    <!-- Fullside-menu Js-->
    <script src="{{asset('themes/fvft/')}}/assets/plugins/toggle-sidebar/sidemenu.js"></script>


    <!--Counters -->
    <script src="{{asset('themes/fvft/')}}/assets/plugins/counters/counterup.min.js"></script>
    <script src="{{asset('themes/fvft/')}}/assets/plugins/counters/waypoints.min.js"></script>
    <script src="{{asset('themes/fvft/')}}/assets/plugins/counters/numeric-counter.js"></script>


    <!-- Custom Js-->
    <script src="{{asset('themes/fvft/')}}/assets/js/admin-custom.js"></script>
    @yield('script')
</body></html>
