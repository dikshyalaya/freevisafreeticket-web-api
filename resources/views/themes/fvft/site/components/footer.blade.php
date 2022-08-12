@php
use App\Enum\SettingKey;
$footer_cats = DB::table('job_categories')
    ->limit(5)
    ->get();
$job_shifts = DB::table('job_shifts')->get();
$pages = DB::table('pages')
    ->limit(5)
    ->get();
@endphp
<style>
    .pages {
        float: none;
    }

    .pages li {
        float: none;
        margin-left: 15px;
        display: inline-block;
        list-style: none;
        font-size: 15px;
    }

    .pages li a {
        color: #fff;
    }

    .social {
        float: left;
    }

    .footer-main .social li {
        float: left;
        margin-right: 6px;
    }

    .subscribe_gradient {
        background: linear-gradient(90deg, rgba(0, 212, 255, 1) 0%, rgba(9, 9, 121, 1) 32%);
        border-color: #fff !important;
    }

    .social i {
        background-color: #fff;
        border-radius: 50%;
        color: black;
        height: 30px;
        width: 30px;
        font-size: 14px;
        padding: 8px 0px 0px 0px;
        text-align: center;
    }

    /* .social i.fa {
        display: inline-block;
        border-radius: 60px;
        box-shadow: 0 0 2px #888;
        padding: 0.5em 0.6em;

    } */

</style>
<!--Footer Section-->
<section class="main-footer">
    <footer class="bg-gray text-white cover-image"
        data-image-src="{{ asset('themes/fvft/') }}/assets/images/banners/banner3.jpg">
        <div class="footer-main">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-12">
                        <h6>{{ __('Job') }} {{ __('Categories') }}</h6>
                        {{-- <hr class="deep-purple  accent-2 mb-4 mt-0 d-inline-block mx-auto"> --}}
                        <ul class="list-unstyled mb-0">
                            @foreach ($footer_cats as $item)
                                <li><a href="{{ route('site.jobs', ['job_category' => $item->id]) }}">
                                        {{ $item->functional_area }} </a></li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="col-lg-3 col-md-12">
                        <h6>{{ __('Job Seeker') }}</h6>
                        {{-- <hr class="deep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto"> --}}
                        <ul class="list-unstyled mb-0">
                            <li><a
                                    href="{{ route('candidate.login', ['name' => 'register']) }}">{{ __('Register') }}</a>
                            </li>
                            <li><a href="{{ route('candidate.login', ['name' => 'login']) }}">{{ __('Login') }}</a>
                            </li>
                            <li><a href="{{ route('site.jobs') }}">{{ __('Search Jobs') }}</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-3 col-md-12">
                        <h6>{{ __('Contact Us') }}</h6>
                        {{-- <hr class="deep-purple  accent-2 mb-4 mt-0 d-inline-block mx-auto"> --}}
                        @if (count($contact_settings) > 0)
                            @foreach ($contact_settings as $contact_setting)
                                @if ($contact_setting->title == SettingKey::ADDRESS or $contact_setting->title == SettingKey::EMAIL)
                                    <p>
                                        <i
                                            class="fa fa-{{ $contact_setting->title == SettingKey::EMAIL ? 'envelope' : 'map-marker' }}"></i>&nbsp;&nbsp;
                                        <span>{{ $contact_setting->value }}</span>
                                    </p>
                                @endif
                                @if ($contact_setting->title == SettingKey::PHONE1 or $contact_setting->title == SettingKey::PHONE2)
                                    <p>
                                        <a
                                            href="tel:{{ $contact_setting->value }}">&nbsp;&nbsp;{{ $contact_setting->value }}</a>
                                    </p>
                                @endif
                            @endforeach
                        @else
                            <p><i class="fa fa-map-marker"></i>&nbsp;&nbsp;<span>Mitranagar, New Bus Park, Kathmandu,
                                    Nepal</span></p>
                            <p><a href="tel:+97714256457">&nbsp;&nbsp;+97714256457</a></p>
                            <p><a href="tel:+97714256457">&nbsp;&nbsp;+97714256457</a></p>
                            <p><i class="fa fa-envelope"></i>&nbsp;&nbsp;<span>info@freevisafreeticket.com</span></p>
                        @endif
                    </div>
                    <div class="col-lg-3 col-md-12">
                        <h6 class="mb-2">{{ __('Follow us') }}</h6>
                        {{-- <hr class="deep-purple  accent-2 mb-4 mt-0 d-inline-block mx-auto"> --}}
                        <div>
                            @if (count($social_settings) > 0)
                                <ul class="social mb-5">
                                    @foreach ($social_settings as $social_setting)
                                        <li>
                                            <a class="social-icon" href="{{ $social_setting->value ?? '' }}"
                                                target="{{ $social_setting->value != null ? '_blank' : '' }}">
                                                <i class="fa fa-{{ strstr($social_setting->title, '_', true) }}"></i>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <ul class="social mb-5">
                                    <li>
                                        <a class="social-icon" href=""><i class="fa fa-facebook"></i></a>
                                    </li>
                                    <li>
                                        <a class="social-icon" href=""><i class="fa fa-google"></i></a>
                                    </li>
                                    <li>
                                        <a class="social-icon" href=""><i class="fa fa-linkedin"></i></a>
                                    </li>
                                    <li>
                                        <a class="social-icon" href=""><i class="fa fa-twitter"></i></a>
                                    </li>
                                </ul>
                            @endif
                        </div>
                        <div class="d-flex mt-2 w-100">
                            @if (count($store_settings) > 0)
                                @foreach ($store_settings as $store_setting)
                                    <div class="w-50">
                                        <a href="{{ $store_setting->value != null ? $store_setting->value : '' }}" target="{{ $store_setting->value != null ? '_blank' : '' }}"><img
                                                src="{{ $store_setting->title == SettingKey::APPLE_PLAY_STORE ? asset('images/app-store-badge.png') : asset('images/google-play3.png') }}"
                                                alt="" class="img-fluid w-100 {{ $loop->first ? '' : 'ml-2' }}"></a>
                                    </div>
                                @endforeach
                            @else
                                <div class="w-50">
                                    <a href=""><img src="{{ asset('images/google-play3.png') }}" alt=""
                                            class="img-fluid w-100"></a>
                                </div>
                                <div class="w-50">
                                    <a href=""><img src="{{ asset('images/app-store-badge.png') }}" alt=""
                                            class="img-fluid w-100 ml-2"></a>
                                </div>
                            @endif
                        </div>
                        <div class="input-group w-100 mt-5">
                            <input type="text" class="form-control " placeholder="{{ __('Email') }}">
                            <div class="input-group-append ">
                                <button type="button" class="btn btn-primary subscribe_gradient">
                                    {{ __('Subscribe') }} </button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="text-white-50 border-top p-0 bg-azure">
            <div class="container">
                <div class="row d-flex">
                    <div class="col-lg-5 col-sm-12  mt-2 mb-2 text-left ">
                        Copyright © 2022&nbsp;&nbsp;<a href="/"
                            class="fs-14 text-white">{{ !blank($general_setting) ? $general_setting->name : 'Free Visa Free Ticket' }}</a>.All
                        rights reserved.
                    </div>
                    <div class="col-lg-7 col-sm-12 ml-auto mb-2 mt-2 d-none d-lg-block">
                        <ul class="pages mb-0">
                            @foreach ($pages as $page)
                                <li>
                                    <a class="social-icon"
                                        href="{{ route('viewPage', $page->slug) }}">{{ __($page->title) }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</section>
<!--Footer Section-->
