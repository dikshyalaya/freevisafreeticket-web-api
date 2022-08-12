@if(isset($industries) AND !blank($industries))
    <section class="sptb">
        <div class="container">
            <div class="section-title center-block text-center">
                <h1>{{ __('Job Industries') }}</h1>
                <p>{{ __('Find jobs by industries.') }}</p>
            </div>
            <div class="item-all-cat center-block text-center education-categories">
                <div class="row">
                    @foreach($industries as $industry)
                        <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6" title="{{ $industry->title }}">
                            <div class="item-all-card text-dark text-center">
                                <a href="javascript:void();"></a>
                                <div class="iteam-all-icon">
                                    <img src="{{asset('themes/fvft/assets/images/products/categories/cashier.png')}}" class="imag-service" alt="Cashier">
                                </div>
                                <div class="item-all-text mt-3" style="height: 15px;">
                                    <h5 class="mb-0 text-body" title="{{ $industry->title }}">{{ Str::limit($industry->title ?? '', 27) }}</h5>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-4">
                    <a href="{{ route('site.jobs') }}" class="btn btn-primary btn-outline-primary">{{ __('View More') }}</a>
                </div>
            </div>
        </div>
    </section>
@endif
