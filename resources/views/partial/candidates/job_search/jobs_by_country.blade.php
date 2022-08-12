<div class="row">
    @foreach ($Countries as $country)
        <div class="col-md-4">
            <a
                href="{{ route('candidate.job_search.index', ['type' => request()->type, 'country_id' => $country->id]) }}">
                <div class="row {{ $loop->iteration % 3 == 0 || $loop->iteration % 3 == 2 ? 'ml-auto' : '' }}">

                    <div class="card card-aside">
                        <div class="card-body" style="padding: 1rem 1rem;">
                            <div class="card-item d-flex">
                                <img src="{{ 'https://ipdata.co/flags/' . strtolower($country->iso2) . '.png' }}"
                                    alt="img" class="w-8 h-8">
                                <div class="ml-5 my-auto">
                                    <h6 class="font-weight-bold">
                                        {{ $country->name }}&nbsp;({{ $country->jobs_count }})</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    @endforeach
</div>
@if (request()->has('country_id'))
    @php
        $data = App\Models\Country::where('id', request()->country_id)
            ->select('name', 'iso2', 'iso3')
            ->first();
    @endphp
    <div class="row">
        <div class="card mb-0">
            <div class="card-header">
                <div class="d-flex mx-auto">
                    <img src="{{ 'https://ipdata.co/flags/' . strtolower($data->iso2) . '.png' }}"
                                    alt="img" class="w-7 h-7">
                    <h5 class="card-title my-auto ml-5">Jobs From {{ $data->name }}</h5>
                </div>
            </div>
        </div>
    </div>
@endif
