@extends('themes.fvft.layouts.master')
@section('title')
    Search Jobs
@endsection
@section('style')
    <!-- jquery ui RangeSlider -->
    <link href="{{ asset('themes/fvft/') }}/assets/plugins/jquery-uislider/jquery-ui.css" rel="stylesheet">
@endsection
@section('main')
    @include('themes.fvft.site.components.header')

    @php
    if (checkUserType('candidate')) {
        $employ_id = App\Models\Employe::where('user_id', \Auth::user()->id)->first()->id;
        // dd($employ_id);
    } else {
        $employ_id = '';
    }
    @endphp
    <!--Job listing-->
    <section class="sptb">
        <div class="container">
            <div class="row">
                @include('themes.fvft.site.components.jobs.sidebar')
                <div class="col-xl-9 col-lg-8 col-md-12">
                    <!--Job lists-->
                    <div class=" mb-lg-0">
                        <div class="">
                            <div class="item2-gl">
                                <div class=" mb-0">
                                    <div class="">
                                        <div class="p-5 bg-white item2-gl-nav d-flex">
                                            <h6 class="mb-0 mt-3">{{ __('Showing') }} @if ($jobs->count() > 1)
                                                    <b>{{ __('1') }} {{ __('to') }} {{ __($jobs->count()) }}
                                                    @else
                                                        {{ __($jobs->count()) }}
                                                @endif
                                                </b> {{ __('of') }} {{ __($jobs->total()) }} {{ __('Entries') }}
                                            </h6>
                                            <ul class="nav item2-gl-menu mt-1 ml-auto">
                                                <li class=""><a href="#tab-11" class="active show"
                                                        data-toggle="tab" title="List style"><i
                                                            class="fa fa-list"></i></a></li>
                                                <li><a href="#tab-12" data-toggle="tab" class=""
                                                        title="Grid"><i class="fa fa-th"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab-11">
                                        @foreach ($jobs as $item)
                                            @include('themes.fvft._partials.job.preview-card', ['job' => $item])
                                        @endforeach
                                    </div>
                                    <div class="tab-pane " id="tab-12">
                                        <div class="row">
                                            @foreach ($jobs as $item)
                                                <div class="col-lg-6 col-md-6 col-sm-12 col-xl-6">
                                                    @include('themes.fvft._partials.job.preview-card-grid', ['job' => $item])
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="center-block text-center">
                                {{ $jobs->links('vendor.pagination.bootstrap-4') }}
                            </div>
                        </div>
                    </div>
                    <!--/Job lists-->
                </div>
            </div>
        </div>
    </section>
    <!--/Job Listings-->
    @include('themes.fvft.site.components.footer')
@endsection
@section('script')
    <script src="{{ env('APP_URL') }}js/location.js"></script>
    <script>
        const _token = $('meta[name="csrf-token"]')[0].content;
        const state_id = {{ isset($candidate->state_id) ? $candidate->state_id : '3871' }};
        const city_id = {{ isset($candidate->city_id) ? $candidate->city_id : 'null' }};
        const appurl = "{{ env('APP_URL') }}";
    </script>

    <script>
        function savejob(job_id) {
            var url = "{{ route('candidate.savedjob.saveJob') }}";
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    'job_id': job_id,
                    'employ_id': '{{ $employ_id }}',
                },
                beforeSend: function() {
                    $(".saveJobButton").attr('disabled', true);
                },
                success: function(response) {
                    if (response.db_error) {
                        toastr.warning(response.db_error);
                    } else if (response.error) {
                        toastr.warning(response.error);
                    } else if (response.redirectRoute) {
                        location.href = response.redirectRoute
                    } else {
                        toastr.success(response.msg);
                    }
                    window.location.reload()
                },
                complete: function() {
                    $(".saveJobButton").attr('disabled', false);
                },
            });
        }
    </script>
@endsection
