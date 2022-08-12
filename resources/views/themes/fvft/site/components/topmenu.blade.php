<!--Top Bar-->
<div class="top-bar">
    <div class="container">
        <div class="row">
            <div class="col-xl-7 col-lg-7 col-sm-4 col-7">
                <div class="top-bar-left d-flex">
                    <div class="clearfix">
                        @if (count($social_settings) > 0)
                            <ul class="socials">
                                @foreach ($social_settings as $social_setting)
                                    <li>
                                        <a class="social-icon" href="{{ $social_setting->value ?? '' }}" target="{{ $social_setting->value != null ? '_blank' : '' }}">
                                            <i class="fa fa-{{ strstr($social_setting->title, '_', true) }}"></i>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                            @else
                            <ul class="socials">
                                <li>
                                    <a class="social-icon" href="#"><i class="fa fa-facebook"></i></a>
                                </li>
                                <li>
                                    <a class="social-icon" href="#"><i class="fa fa-twitter"></i></a>
                                </li>
                                <li>
                                    <a class="social-icon" href="#"><i class="fa fa-linkedin"></i></a>
                                </li>
                                <li>
                                    <a class="social-icon" href="#"><i class="fa fa-google-plus"></i></a>
                                </li>
                            </ul>
                        @endif
                    </div>
                    {{-- <div class="clearfix">
                        <ul class="contact border-left">
                            <li class="d-lg-none">
                                <a href="#" class="callnumber"><span><i class="fa fa-phone mr-1"></i>: +425 3458765</span></a>
                            </li>
                            <li class="dropdown d-none d-xl-inline-block">
                                <a href="#" class="" data-toggle="dropdown"><span>
                                        {{ in_array($current_locale, array_keys($available_locales)) ? __($available_locales[$current_locale]) : __('English') }}
                                        <i class="fa fa-caret-down"></i></span> </a>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                    @if (in_array($current_locale, array_keys($available_locales)))
                                        <a class="dropdown-item" href="{{ url('lang/'.$current_locale) }}">
                                            {{ $available_locales[$current_locale] }}
                                        </a>
                                        @foreach ($available_locales as $key => $value)
                                            @if ($current_locale != $key)
                                                <a class="dropdown-item" href="{{ url('lang/'.$key) }}">
                                                    {{ $value }}
                                                </a>
                                            @endif
                                        @endforeach
                                    @else
                                        @foreach ($available_locales as $key => $value)
                                            <a class="dropdown-item" href="{{ url('lang/'.$key) }}">
                                                {{ $value }}
                                            </a>
                                        @endforeach
                                    @endif


                                </div>
                            </li>
                            
                        </ul>
                    </div> --}}
                </div>
            </div>
            {{-- <div class="col-xl-5 col-lg-5 col-sm-8 col-5">
                <div class="top-bar-right">
                    <ul class="custom">
                        @guest
                            <li>
                                <a href="{{ route('candidate.login', ['name' => 'register']) }}" class=""><i class="fa fa-user mr-1"></i> <span>{{ __('Register') }}</span></a>
                            </li>
                            <li>
                                <a href="{{ route('candidate.login', ['name' => 'login']) }}" class=""><i class="fa fa-sign-in mr-1"></i> <span>{{ __('Login') }}</span></a>
                            </li>
                        @endguest
                        @auth
                        @endauth
                    </ul>
                </div>
            </div> --}}
        </div>
    </div>
</div>
<!--Top Bar-->
