@extends('admin.layouts.master')
@section('style')
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/datepicker.min.css') }}">
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

@section('main')
    <div class="page-header">
        <h4 class="page-title tempcolor">{{ strtoupper('Company Profile') }} &nbsp;({{ strtoupper($action) }})</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Modules</a></li>
            <li class="breadcrumb-item" aria-current="page"><a href="/admin/companies/">Company</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit</li>
        </ol>
    </div>
    <div class="alert alert-secondary d-none" role="alert"><button type="button" class="close" data-dismiss="alert"
            aria-hidden="true">×</button><span id="db_error" class="db_error"></span></div>
    <form action="{{ route('admin.companies.udpateCompany', $company->id) }}" id="companyForm" method="POST">
        @csrf
        @method('put')
        @include('partial/companies/companyEdit')
    </form>

    <!-- end row -->
    {{-- End Form Here --}}
@endsection
@section('script')
    @include('partial/companies/script')
@endsection
