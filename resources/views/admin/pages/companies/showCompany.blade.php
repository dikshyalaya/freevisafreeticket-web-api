@extends('admin.layouts.master')
@section('style')
    <link rel="stylesheet" href="{{ asset('css/datepicker.min.css') }}">
@endsection
@section('main')
 @include('partial/companies/companyShow')
@endsection
@section('script')
@endsection