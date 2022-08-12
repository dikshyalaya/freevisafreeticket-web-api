@extends('themes.fvft.layouts.master')
@section('title')
    Find Jobs & Vacancy
@endsection
{{-- @dd($countries) --}}
@section('main')
    @php
    if (auth()->check() and auth()->user()->user_type == 'candidate') {
        $employ = App\Models\Employe::where('user_id', auth()->user()->id)->first();
    }
    @endphp
    @include('themes.fvft.site.components.header')
    @include('themes.fvft.site.components.hero')
    @include('themes.fvft.site.components.job_categories')
    {{-- @include('themes.fvft.site.components.recentjobs_scroll') --}}
    @include('themes.fvft.site.components.recentjobs')
    @include('themes.fvft.site.components.topcompany')
    @include('themes.fvft.site.components.news')
    @include('themes.fvft.site.components.actions')
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
        $(document).ready(function() {

            $("#moreCategory").on('click', function() {
                $("#moreCategory").addClass('d-none');
                $("#lessCategory").removeClass('d-none');

                let html = `@foreach (getJobCategories() as $job_category)
                    <div class="col-lg-3 col-md-4">
                        <div class="card card-aside">
                            <a href="{{ route('site.jobs', ['job_catagory' => $job_category->id]) }}" class="mx-auto">
                                <div class="card-body ">
                                    <div class="card-item d-flex">
                                        <div class="ml-4 mx-auto">
                                            <h6 class="font-weight-bold mt-2">{{ $job_category->functional_area }}
                                            </h6>
                                            {{ $job_category->jobs_count }} {{ $job_category->jobs_count > 1 ? 'Jobs' : 'Job' }}
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach`;
                $("#limitCategorySection").html(html);
            });

            $("#lessCategory").on('click', function() {
                $("#lessCategory").addClass('d-none');
                $("#moreCategory").removeClass('d-none');

                let html = `@foreach (getJobCategories(8) as $job_category)
                    <div class="col-lg-3 col-md-4">
                        <div class="card card-aside">
                            <a href="{{ route('site.jobs', ['job_catagory' => $job_category->id]) }}" class="mx-auto">
                                <div class="card-body ">
                                    <div class="card-item d-flex">
                                        <div class="ml-4 mx-auto">
                                            <h6 class="font-weight-bold mt-2">{{ $job_category->functional_area }}
                                            </h6>
                                            {{ $job_category->jobs_count }} {{ $job_category->jobs_count > 1 ? 'Jobs' : 'Job' }}
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach`;
                $("#limitCategorySection").html(html);
            });

            $("#moreRecentJobs").on('click', function() {
                $("#moreRecentJobs").addClass('d-none');
                $("#moreLatestJobs").removeClass('d-none');
                $("#lessLatestJobs").addClass('d-none');
                $("#lessRecentJobs").removeClass('d-none');
            });
            $("#lessRecentJobs").on('click', function() {
                $("#lessRecentJobs").addClass('d-none');
                $("#lessLatestJobs").removeClass('d-none');
                $("#moreLatestJobs").addClass('d-none');
                $("#moreRecentJobs").removeClass('d-none');
            });
        });

        @if (auth()->check() and auth()->user()->user_type == 'candidate')
            function savejob(job_id, this_button) {
                console.log(job_id, this_button);
            var url = "{{ route('candidate.savedjob.saveJob') }}";
            $.ajax({
            url: url,
            type: 'POST',
            data: {
            'job_id': job_id,
            'employ_id': '{{ $employ->id }}',
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
            $(this_button).removeAttr('onclick').html('<i class="fa fa-heart"></i> Saved');
            toastr.success(response.msg);
            }
            },
            complete: function() {
            $(".saveJobButton").attr('disabled', false);
            },
            });
            }
        @endif
    </script>
@endsection
