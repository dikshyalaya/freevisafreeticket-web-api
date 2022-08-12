<!--Loader-->
<div id="global-loader">
    <img src="{{asset('themes/fvft/assets/images/loader.svg')}}" class="loader-img" alt="">
</div>

<!--Header Main-->
<div class="header-main">
@include('themes.fvft.site.components.topmenu')
<!-- Mobile Header -->
    <div class="sticky">
        <div class="horizontal-header clearfix">
            <div class="container">
                <a id="horizontal-navtoggle" class="animated-arrow"><span></span></a>
                <span class="smllogo"><img src="{{asset('uploads/site/logo.png')}}" width="120" alt="img"/></span>
                <a href="#" class="callusbtn bg-light"><i class="fa fa-bell text-body" aria-hidden="true"></i></a>
            </div>
        </div>
    </div>
    <!-- /Mobile Header -->

    <!--Horizontal-main-->
    <div class="horizontal-main clearfix">
        <div class="horizontal-mainwrapper container clearfix">
            <div class="desktoplogo" style="padding: 12px 0 !important;">
                <a href="/">
                    <img src="{{asset('uploads/site/logo.png')}}" alt="Free Visa Free Ticket" style="width: 165px;">
                </a>
            </div>
            <div class="desktoplogo-1">
                <a href="/">
                    <img src="{{asset('uploads/site/logo.png')}}" alt="Free Visa Free Ticket"  style="width: 165px;">
                </a>
            </div>
            <!--Nav-->
        @include('themes.fvft.site.components.navbar')
        <!--/Nav-->
        </div>
    </div>
    <!--/Horizontal-main-->
</div>
<!--/Header Main-->
