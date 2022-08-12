@extends('themes.fvft.layouts.master')
@section('title')
    Search Company
@endsection
@section('main')
    @include('themes.fvft.site.components.header')
    <section class="sptb">
        <div class="container" data-select2-id="select2-data-26-4lsz">
            <div class="row" data-select2-id="select2-data-25-ya1n">
                <div class="col-xl-12 col-lg-12 col-md-12" data-select2-id="select2-data-24-0sf6">
                    <!--Job lists-->
                    <div class=" mb-lg-0" data-select2-id="select2-data-23-9f05">
                        <div class="" data-select2-id="select2-data-22-dd0m">
                            <div class="item2-gl" data-select2-id="select2-data-21-xo98">
                                <div class=" mb-0">
                                    <div class="">
                                        <div class="p-5 bg-white item2-gl-nav d-flex">
                                            <h6 class="mb-0 mt-3">{{ __('Showing') }} @if ($companies->count() > 1)
                                                    <b>{{ __('1') }} {{ __('to') }}
                                                        {{ __($companies->count()) }}
                                                    @else
                                                        {{ __($companies->count()) }}
                                                @endif
                                                </b> {{ __('of') }} {{ __($companies->total()) }}
                                                {{ __('Entries') }}
                                            </h6>
                                            <ul class="nav item2-gl-menu mt-1 ml-auto">
                                                <li class=""><a href="#tab-11" class="show active"
                                                        data-toggle="tab" title="List style"><i
                                                            class="fa fa-list"></i></a></li>
                                                {{-- <li><a href="#tab-12" data-toggle="tab" class="" title="Grid"><i class="fa fa-th"></i></a></li> --}}
                                            </ul>
                                            {{-- <div class="d-flex" data-select2-id="select2-data-20-x57y">
                                                <label class="mr-2 mt-2 mb-sm-1">Sort By:</label>
                                                <select name="item" class="form-control select2-no-search w-70 select2-hidden-accessible" data-select2-id="select2-data-16-civz" tabindex="-1" aria-hidden="true">
                                                    <option value="1" data-select2-id="select2-data-18-i9q6">Relavant</option>
                                                    <option value="2" data-select2-id="select2-data-30-tcmv">Newest First</option>
                                                    <option value="3" data-select2-id="select2-data-31-9fn3">Highest Paid</option>
                                                    <option value="4" data-select2-id="select2-data-32-0nj2">Lowest Paid</option>
                                                    <option value="5" data-select2-id="select2-data-33-8sf2">High Ratings</option>
                                                    <option value="6" data-select2-id="select2-data-34-9tqx">Popular</option>
                                                </select><span class="select2 select2-container select2-container--default select2-container--below" dir="ltr" data-select2-id="select2-data-17-nrbq" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-disabled="false" aria-labelledby="select2-item-h2-container"><span class="select2-selection__rendered" id="select2-item-h2-container" role="textbox" aria-readonly="true" title="Relavant">Relavant</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
                                            </div> --}}
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-content company-list">
                                    <div class="tab-pane active" id="tab-11">
                                        <div class="row">
                                            @foreach ($companies as $item)
                                                <div class="col-lg-6">
                                                    <div class="card overflow-hidden br-0 overflow-hidden">
                                                        <div class="d-sm-flex card-body p-3">
                                                            <div class="p-0 m-0 mr-3">
                                                                <div class="">
                                                                    <a href="javascript:void(0)"></a>
                                                                    @if (!blank($item->company_logo) && file_exists($item->company_logo))
                                                                        <img src="{{ asset($item->company_logo) }}"
                                                                            alt="img" class="w-100 h-9">
                                                                    @else
                                                                        <img src="/uploads/defaultimage.jpg" alt="img"
                                                                            class="w-9 h-9">
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="item-card9 mt-3 mt-md-5">
                                                                <a href="/company-view/{{ $item->id }}"
                                                                    class="text-dark">
                                                                    <h4 class="font-weight-semibold mt-1">
                                                                        {{ $item->company_name }}</h4>
                                                                </a>
                                                                <div class="rating-stars d-inline-flex">
                                                                    <h6 class="font-weight-bold">Followers <span
                                                                            id="count_{{ $item->id }}">({{ $item->followers->count() }})</span>
                                                                    </h6>
                                                                    {{-- (245 Reviews) --}}
                                                                </div>
                                                            </div>
                                                            {{-- <div class="ml-auto">
                                                                <a class="btn btn-light mt-3 mt-md-6 mr-4 font-weight-semibold text-dark" href="company-details.html"><i class="fa fa-briefcase"></i> 12 vacancies</a>
                                                            </div> --}}
                                                        </div>
                                                        <div class="card overflow-hidden border-0 box-shadow-0 br-0 mb-0">
                                                            <div class="card-body table-responsive border-top">
                                                                <table
                                                                    class="table table-borderless w-100 m-0 text-nowrap ">
                                                                    <tbody class="p-0">
                                                                        <tr>
                                                                            <td class="px-0 py-1"><span
                                                                                    class="font-weight-semibold">{{ __('Address') }}</span>
                                                                            </td>
                                                                            <td class="p-1"><span>:</span></td>
                                                                            <td class="p-1">
                                                                                <span>
                                                                                    {{ @DB::table('cities')->find($item->city_id)->name . ',' }}{{ @DB::table('countries')->find($item->country_id)->name }}
                                                                                </span>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class="px-0 py-1"><span
                                                                                    class="font-weight-semibold">Website</span>
                                                                            </td>
                                                                            <td class="p-1"><span>:</span></td>
                                                                            <td class="p-1"><span><a
                                                                                        href="{{ $item->company_website ?? '#' }}">{{ $item->company_website ?? 'Not-Available' }}</a></span>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                                <div class="row">
                                                                    <div class="mt-3 col-md-3">
                                                                        <a class="btn btn-primary btn-block"
                                                                            href="/company-view/{{ $item->id }}">{{ __('Learn More') }}</a>
                                                                    </div>
                                                                    <div class="col-md-6"></div>
                                                                    <div class="col-md-3 mt-3">

                                                                        @if (Auth::check() && Auth::user()->user_type == 'candidate')
                                                                            @if (count($employe->followings->where('company_id', $item->id)->all()) > 0)
                                                                                <a class="btn btn-primary btn-block"
                                                                                    href="javascript:void(0);">{{ __('Following') }}</a>
                                                                            @else
                                                                                <a class="btn btn-primary btn-block"
                                                                                    onclick="follow_company({{ $item->id }}, {{ $employe->id }}, $(this))"
                                                                                    href="javascript:void(0);">{{ __('Follow') }}</a>
                                                                            @endif
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="center-block text-center">
                                {{ $companies->links('vendor.pagination.bootstrap-4') }}
                            </div>
                        </div>
                    </div>
                    <!--/Job lists-->
                </div>
            </div>
        </div>
    </section>
    @include('themes.fvft.site.components.footer')
@endsection

@section('script')
    <script>
        function follow_company(company_id, employ_id, follow_button) {
            $.ajax({
                type: "POST",
                url: "{{ route('candidate.follow_company') }}",
                data: {
                    'company_id': company_id,
                    'employ_id': employ_id
                },
                beforeSend: function() {
                    $(follow_button).text('Wait Submitting...')
                },
                success: function(data) {
                    if (data.db_error) {
                        toastr.warning(data.db_error)
                    } else if (data.alreadyFollowed == true) {
                        toastr.info(data.msg);
                        $(follow_button).text('Following');
                    } else if (data.alreadyFollowed == false) {
                        toastr.success(data.msg);
                        $("#count_" + company_id).text('(' + data.followers + ')');
                        $(follow_button).text('Following');
                    }
                },
            });
        }
    </script>
@endsection
