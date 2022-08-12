@include('partial.candidates.job_search.jobs_by_company_style')
@if (!request()->has('company_id'))
    <div class="row">
        @foreach ($companies as $company)
            <div class="col-md-6">
                <div class="row {{ $loop->iteration % 2 == 0 ? 'ml-auto' : '' }}">
                    <div class="card card-aside">
                        <div class="card-body" style="padding: 1rem 1rem;">
                            <div class="row">
                                <div class="col-md-9">
                                    <a
                                        href="{{ route('candidate.job_search.index', ['type' => request()->type,'company_id' => $company->id,'is_active' => 'about']) }}">
                                        <div class="card-item d-flex my-auto">
                                            <img src="{{ asset('/') }}{{ $company->company_logo ?? 'images/defaultimage.jpg' }}"
                                                alt="img" class="w-8 h-8">
                                            <div class="my-auto ml-5">
                                                <h6 class="font-weight-bold">
                                                    {{ $company->company_name }}&nbsp;({{ $company->jobs_count }})
                                                </h6>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-3 my-auto">
                                    <div class="follow-section">
                                        @if (Auth::check() && Auth::user()->user_type == 'candidate')
                                            @if (count($employ->followings->where('company_id', $company->id)->all()) > 0)
                                                <button type="button" class="btn btn-primary">Following</button>
                                            @else
                                                <button type="button" class="btn btn-primary"
                                                    onclick="follow_company({{ $company->id }}, {{ $employ->id }}, $(this))"
                                                    id="follow">Follow</button>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif
@if (request()->has('company_id'))
    @php
        $company = App\Models\Company::where('id', request()->company_id)
            ->with(['industry:id,title', 'country:id,iso2,iso3'])
            ->withCount('followers')
            ->first();
    @endphp
    @if ($company->company_cover != null && file_exists($company->company_cover))
        <style>
            .banner_content {
                background-image: url("{{ asset($company->company_cover) }}");
            }

        </style>
    @else
        <style>
            .banner_content {
                background-image: url("{{ asset('images/banner.jpg') }}");
            }

        </style>
    @endif
    <div class="row">
        <section class="card">
            <section class="banner banner_content">

            </section>
            <section class="job_detail_section pt-5 pb-4">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-8 col-md-12">
                            <div class="row">
                                <div class="col-lg-4 col-md-6">
                                    <div class="logo_image">
                                        @if ($company->company_logo != null && file_exists($company->company_logo))
                                            <img src="{{ asset($company->company_logo) }}" alt="">
                                        @else
                                            <img src="{{ asset('/images/defaultimage.jpg') }}" alt="">
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-8 col-md-6">
                                    <div class="job_detail">
                                        <h3 class="job_title">{{ $company->company_name }}</h3>
                                        <p>{{ $company->industry != null && $company->industry->title != null ? $company->industry->title : '' }}
                                        </p>
                                        <p>{{ $company->company_address }}
                                            <span><img
                                                    src="{{ asset('https://flagcdn.com/16x12/' . strtolower($company->country->iso2) . '.png') }}"
                                                    alt=""></span>
                                        </p>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-12">
                            <div class="float-right">
                                <div class="btn_section">
                                    @if (Auth::check() && Auth::user()->user_type == 'candidate')
                                        @if (count($employ->followings->where('company_id', $company->id)->all()) > 0)
                                            <button type="button" class="btn btn-primary">Following</button>
                                        @else
                                            <button type="button" class="btn btn-primary"
                                                onclick="follow_company({{ $company->id }}, {{ $employ->id }}, $(this))"
                                                id="follow">Follow</button>
                                        @endif
                                    @endif

                                </div>

                                <div class="btn_section margin-top-1">
                                    <button class="btn btn-outline-primary">{{ $company->followers_count }}
                                        Followers</button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </section>
            <section class="about_us pb-3">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 col-lg-12">
                            <div class="about_us_header">
                                <a href="{{ route('candidate.job_search.index', ['type' => request()->type,'company_id' => $company->id,'is_active' => 'about']) }}"
                                    class="{{ request()->has('is_active') ? 'btn btn-primary' : 'link' }} mr-4">About
                                    Us</a>
                                <a class="{{ request()->has('is_active') ? 'link' : 'btn btn-primary' }}"
                                    href="{{ route('candidate.job_search.index', ['type' => request()->type, 'company_id' => $company->id]) }}">Company
                                    Job</a>
                            </div>

                        </div>
                    </div>
                </div>
                @if (request()->has('is_active'))
                    <section class="about_desc pt-3">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-12 col-md-12">
                                    {!! html_entity_decode($company->html_content_intro) !!}
                                </div>
                            </div>
                        </div>
                    </section>
            </section>
            <section class="data pb-3">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6 col-lg-4">
                            <p>Website : </p>
                            <p>Facebook : </p>
                            <p>Industries Category : </p>
                            <p>Company Size : </p>
                            <p>Company Established : </p>
                        </div>
                        <div class="col-md-6 col-lg-8">
                            <p>{{ $company->company_website ?? '' }}</p>
                            <p>{{ $company->company_fb_page ?? '' }}</p>
                            <p>{{ $company->industry != null && $company->industry->title != null ? $company->industry->title : '' }}
                            </p>
                            <p>{{ $company->no_of_employee ?? '' }} employees</p>
                            <p>{{ $company->operating_since ? $company->operating_since . ' AD' : '' }}</p>
                        </div>
                    </div>
                </div>
            </section>
@endif
</section>
</div>
@endif
