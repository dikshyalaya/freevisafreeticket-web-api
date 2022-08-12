@if (isset($news) and !blank($news))
    <section class="sptb" style="background-color: #b2cae342">
        <div class="container">
            <div class="section-title center-block text-center">
                <h1>{{ __('News') }}</h1>
                <p>{{ __('Latest News by Free Visa Free Ticket') }}</p>
            </div>
            <div id="defaultCarousel" class="owl-carousel Card-owlcarousel owl-carousel-icons">
                @foreach ($news as $item)
                    <div class="item">
                        <div class="card mb-0">
                            <div class="item7-card-img">
                                <a href="news/{{ $item->slug }}"></a>
                                @if (!blank($item->feature_img))
                                    <img src="{{ asset($item->feature_img) }}" alt="img" class="cover-image">
                                @else
                                    <img src="{{ asset('/images/defaultimage.jpg') }}" alt="img"
                                        class="cover-image">
                                @endif
                            </div>
                            <div class="card-body p-4">
                                <div class="item7-card-desc d-flex mb-2">
                                    <a href="#">
                                        <i class="fa fa-calendar-o text-muted mr-2"></i>
                                        {{ \Carbon\Carbon::parse($item->updated_at)->diffForhumans() }}
                                    </a>
                                </div>
                                <a href="news/{{ $item->slug }}" class="text-dark news-header">
                                    <h4 class="font-weight-semibold">{{ $item->title }}</h4>
                                </a>
                                <p>{{ Str::limit($item->short_description, 50) }} </p>
                                <div class="d-flex align-items-center pt-2 mt-auto">
                                    <img src="{{ asset('/uploads/defaultimage.jpg') }}"
                                        class="avatar brround avatar-md mr-3" alt="avatar-img">
                                    <div>
                                        <a href="#" class="text-default">FreeVisaFreeTicket</a>
                                        <small
                                            class="d-block text-muted">{{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif
