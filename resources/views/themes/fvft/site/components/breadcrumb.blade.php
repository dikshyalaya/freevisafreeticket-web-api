<section>
    <div class="bannerimg cover-image bg-background3"
         data-image-src="{{ !blank($page["img_url"]) ? env("APP_URL").$page["img_url"] : asset('/uploads/site/banner.png') }}">

        <div class="header-text mb-0">
            <div class="container">
                <div class="text-center text-white">
                    <h1 class="">{{__($page["title"])}}</h1>
                    <ol class="breadcrumb text-center">
                        <li class="breadcrumb-item"><a href="#">{{ __('Home') }}</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">{{__($page["title"])}}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</section>
