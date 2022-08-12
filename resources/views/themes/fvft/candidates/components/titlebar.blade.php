<section>
    <div class="bannerimg cover-image bg-background3" data-image-src="../assets/images/banners/banner2.jpg" style="background: url(&quot;../assets/images/banners/banner2.jpg&quot;) center center;">
        <div class="header-text mb-0">
            <div class="text-center text-white">
                <h1 class="">{{ $data['title']}}</h1>
                <ol class="breadcrumb text-center">
                    @foreach ($data['pages'] as $item)
                    @if($item["action"]=="active") <li  class="breadcrumb-item active text-white" aria-current="page"><a href=" {{$item["link"]}}">{{$item["name"]}}</a></li>
                    @else
                    <li class="breadcrumb-item"><a href="{{$item["link"]}}">{{$item["name"]}}</a></li>
                    @endif
                    @endforeach
                </ol>
            </div>
        </div>
    </div>
</section>