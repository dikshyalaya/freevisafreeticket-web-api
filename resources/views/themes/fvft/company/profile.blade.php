@extends('themes.fvft.company.layouts.dashmaster')
@section('css')
    <link href="{{ asset('/') }}themes/fvft/assets/plugins/fileuploads/css/dropify.css" rel="stylesheet" type="text/css">
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/datepicker.min.css') }}">
    <style>
        .form-control {
            color: #272626 !important;
        }

    </style>
    <style>
        .ql-editor {
            height: 100%;
        }

        .req {
            color: red;
        }

        .tempcolor {
            color: #1650e2;
            font-weight: bold;
        }

    </style>
@endsection
@section('title')
    Profile
@endsection
@section('edit_profile')
    active
@endsection
@section('content')
    <form action="{{ route('company.update_profile', $company->id) }}" method="post" enctype="multipart/form-data" id="companyForm">
        @csrf
        @method('put')
        @include('partial/companies/companyEdit')
    </form>
@endsection
@section('js')
    {{--<script src="{{ asset('/') }}themes/fvft/assets/plugins/fileuploads/js/dropify.js"></script>--}}
    <script src="{{ asset('themes/fvft/assets/plugins/fileuploads/js/dropfy-custom.js') }}"></script>
    @include('partial/companies/script')
@endsection
