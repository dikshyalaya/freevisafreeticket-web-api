@extends('themes.fvft.company.layouts.dashmaster')
@section('title', 'Applicant Detail')
@section('applicants', 'active')
@section('content')
        {{-- <div class="card">
            <div class="card-header">
                <h3 class="card-title">Applicant Detail</h3>
            </div>
        </div> --}}
        @include('partial/candidates/candidateShow')

@endsection
