@extends('themes.fvft.company.layouts.dashmaster')
@section('title', 'Applicants')
@section('applicants', 'active')
@section('data')
    <link rel="stylesheet" href="{{ asset('css/datepicker.min.css') }}">
    <style>
        #rangeValue {
            position: absolute;
            margin-left: -0.9em;
            top: -24px;
        }

        .ui-slider-range.ui-corner-all.ui-widget-header {
            background-color: blue !important;
        }

        .ui-state-default,
        .ui-widget-content .ui-state-default,
        .ui-widget-header .ui-state-default,
        .ui-button,
        html .ui-button.ui-state-disabled:hover,
        html .ui-button.ui-state-disabled:active {
            background: #007bff;
        }

        .ui-slider-horizontal {
            background: #0006108f !important;
        }
    </style>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ __('Applicants Management') }}</h3>
        </div>

        <div id="app">
            <applicants></applicants>
        </div>
    </div>
@endsection

@section('js')
    @include('themes/fvft/company/newapplicant/script')
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>
@endsection
