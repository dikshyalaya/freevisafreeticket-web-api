@extends('admin.layouts.master')
@section('main')
<style>
    .profile-img img {
        height: 180px;
        width: 180px !important;
        max-width: 180px !important;
    }
</style>
    {{-- @dd($company?$company); --}}
    <div class="page-header">
        <h4 class="page-title">Company Details</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Modules</a></li>
            <li class="breadcrumb-item" aria-current="page"><a href="/admin/companies/">Company</a></li>
            <li class="breadcrumb-item active" aria-current="page">View Detail</li>
        </ol>
    </div>

    <div class="row">
        <div class="col-12">
            <form action="/admin/companies/save" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Company Detail</h3>
                    </div>
                    
                    {{-- <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 col-lg-6">

                                <div class="form-group">
                                    {{ $company }}
                                </div>

                            </div>

                        </div>
                    </div> --}}
                    {{-- {"id":1,"company_name":"company
                    1","company_logo":"uploads\/company\/1643951932_D91a-06.png","company_cover":"uploads\/company\/1643951932_D91a-06.png","company_banner":"","user_id":11,"company_phone":"6557545635","company_email":"company1@gmail.com","industry_id":1,"company_details":"jhvhgasdhcva,jsd\r\njhvhgasdhcva,jsd\r\njhvhgasdhcva,jsd\r\njhvhgasdhcva,jsd\r\njhvhgasdhcva,jsd\r\njhvhgasdhcva,jsd\r\njhvhgasdhcva,jsd\r\njhvhgasdhcva,jsd\r\njhvhgasdhcva,jsd","country_id":132,"state_id":1939,"city":"76467","company_address":"","is_active":1,"is_featured":0,"created_at":"2021-12-31T09:16:32.000000Z","updated_at":"2022-02-04T05:18:52.000000Z","industry":{"id":1,"title":"Software
                    Development","slug":"software-development","is_active":1,"created_at":"2022-02-21T07:20:25.000000Z","updated_at":"2022-02-21T07:38:57.000000Z"}} --}}
                    <div class="card-body">
                        <h3><u>{{ strtoupper('Company Details') }}</u></h3>
                        <div class="row">
                            <div class="col-md-10 mb-5">
                                <div class="profile-img text-center">
                                    <img class="img-circle" src="{{ asset('/'.$company->company_logo) }}"
                                        alt="">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-5">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="name">Company Name: </label>
                                            </div>
                                            <div class="col-md-5">
                                                <span>{{ $company->company_name }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="">Company Email:</label>
                                            </div>
                                            <div class="col-md-5">
                                                <span>{{ $company->company_email }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="">Company Phone:</label>
                                            </div>
                                            <div class="col-md-5">
                                                <span>{{ $company->company_phone }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="">Company Description:</label>
                                            </div>
                                            <div class="col-md-5">
                                                <span>{{ $company->company_details }}</span>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                        @if ($company->company_contact_person)
                            <h3><u>{{ strtoupper('Contact Person Details') }}</u></h3>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label for="">Name:</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <span>
                                                        {{ $company->company_contact_person->name }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label for="">Email:</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <span>
                                                        {{ $company->company_contact_person->email }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label for="">Phone:</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <span>
                                                        {{ $company->company_contact_person->phone }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label for="">Position:</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <span>
                                                        {{ $company->company_contact_person->position }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        @endif
                        {{-- <h3><u>{{ strtoupper('Payment Detail') }}</u></h3>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="total_amount">Total Amount:</label>
                                            </div>
                                            <div class="col-md-8">
                                                <span>
                                                    {{ $booking_detail->total }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="paid">Paid Amount:</label>
                                            </div>
                                            <div class="col-md-8">
                                                <span>{{ $booking_detail->paid }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="change">Change:</label>
                                            </div>
                                            <div class="col-md-8">
                                                <span>{{ $booking_detail->change_amount }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="due">Due:</label>
                                            </div>
                                            <div class="col-md-8">
                                                <span>{{ $booking_detail->due }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <h3><u>{{ strtoupper('Room Details') }}</u></h3>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="no_of_room">No of Rooms:</label>
                                            </div>
                                            <div class="col-md-8">
                                                <span>{{ count($booking_detail->booking_rooms) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> --}}


                    </div>
                    <div class="card-footer text-right">
                        <div class="d-flex">
                            <a href="/admin/companies/" class="btn btn-link">Back</a>

                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ env('APP_URL') }}js/location.js"></script>
    <script>
        const _token = $('meta[name="csrf-token"]')[0].content;
        const state_id = {{ isset($company->state_id) ? $company->state_id : 'null' }};
        const city_id = {{ isset($company->city_id) ? $company->city_id : 'null' }};
        const appurl = "{{ env('APP_URL') }}";
    </script>
@endsection
