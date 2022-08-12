
{{-- <style>
    .my-button {
        padding: 0.175rem 0.95rem !important;
    }

</style> // TODO work in new design section
<div class="row">
    <div class="col-md-6">
        <div class="row">
            <div class="card card-aside">
                <div class="card-body ">
                    <div class="card-item d-flex">
                        <img src="{{ asset('images/defaultimage.jpg') }}" alt="img" class="w-8 h-8">
                        <div class="ml-4">
                            <h6 class="font-weight-bold mt-2">Company 1 (102)</h6>
                            <div class="image-section d-inline-flex">
                                <span class="my-auto">
                                    <img src="{{ 'https://flagcdn.com/16x12/my.png' }}" alt="">
                                </span>
                                <span class="my-auto ml-2">Malaysia</span>
                                <span><button class="btn btn-gray my-button ml-5">200 Jobs</button></span>
                                <span><button class="btn btn-primary my-button ml-5 w-100">Follow</button></span>
                            </div>
                            <div class="job-section">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> --}}
<div class="row">
    @foreach ($companies as $company)
        <div class="col-md-6">
            <div class="row {{ $loop->iteration % 2 == 0 ? 'ml-auto' : '' }}">
                <div class="card card-aside">
                    <div class="card-body" style="padding: 1rem 1rem;">
                        <div class="row">
                            <div class="col-md-9">
                                <a
                                    href="{{ route('candidate.job_search.index', ['type' => request()->type, 'company_id' => $company->id]) }}">
                                    <div class="card-item d-flex my-auto">
                                        <img src="{{ asset('/') }}{{ $company->company_logo ?? 'images/defaultimage.jpg' }}"
                                            alt="img" class="w-8 h-8">
                                        <div class="my-auto ml-5">
                                            <h6 class="font-weight-bold">
                                                {{ $company->company_name }}&nbsp;({{ $company->jobs_count }})</h6>
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
                                                onclick="follow_company({{ $company->id }}, {{ $employ->id }})"
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
@if (request()->has('company_id'))
    @php
        $data = App\Models\Company::where('id', request()->company_id)
            ->select('company_name', 'company_logo')
            ->first();
    @endphp
    <div class="row">
        <div class="card mb-0">
            <div class="card-header">
                <div class="d-flex mx-auto">
                    <img src="{{ asset('/') }}{{ $data->company_logo ?? 'images/defaultimage.jpg' }}" alt=""
                        class="w-8 h-8">
                    <h5 class="card-title my-auto ml-5">Jobs From {{ $data->company_name }}</h5>
                </div>
            </div>
        </div>
    </div>
@endif
