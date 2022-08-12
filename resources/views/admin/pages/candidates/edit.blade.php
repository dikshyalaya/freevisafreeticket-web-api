@extends('admin.layouts.master')
@section('style')
    <link rel="stylesheet" href="{{ asset('css/datepicker.min.css') }}">
@endsection
@section('main')
    <style>
        .req {
            color: #ff382b !important;
        }

        #profilePicture .dropify-wrapper {
            height: 120px !important;
            width: 50% !important;
            max-width: 50% !important;
        }

    </style>
    <div class="page-header">
        <h4 class="page-title">{{ $action }} Candidate</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Modules</a></li>
            <li class="breadcrumb-item" aria-current="page"><a href="/admin/candidates/">Candidate</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit</li>
        </ol>
    </div>
    <div class="alert alert-secondary d-none" role="alert"><button type="button" class="close" data-dismiss="alert"
            aria-hidden="true">×</button><span id="db_error" class="db_error"></span></div>
    <form action="{{ route('admin.candidates.update', $employ->id) }}" method="POST" enctype="multipart/form-data"
        id="candidateForm">
        @csrf
        @method('put')
        @include('partial/candidates/candidateEdit')
    </form>
@endsection
@section('script')
    @include('partial/candidates/script')
@endsection
