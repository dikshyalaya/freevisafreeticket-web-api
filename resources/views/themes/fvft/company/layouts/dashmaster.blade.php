@extends('themes.fvft.layouts.master')
@section('style')
    <style>
        .form-control {
            color: #272626 !important;
        }

    </style>
    <link href="{{ asset('themes/fvft/') }}/assets/plugins/fileuploads/css/dropify.css" rel="stylesheet"
        type="text/css" />
    <link rel="stylesheet" href="{{ asset('css/form_step.css') }}">
    @yield('css')
@endsection
@section('main')
    @include('themes.fvft.site.components.header')
    @include('themes.fvft.site.components.breadcrumb',[
    "page" =>[
    "title" => $GLOBALS['page-name'] ?? "My Dashboard",
    "img_url" => ""
    ]
    ])
    <section class="sptb">
        <div class="container">
            <div class="row">
                <div class="col-xl-3 col-lg-12 col-md-12">
                    @include('themes.fvft.company.components.sidebar')
                </div>
                <div class="col-xl-9 col-lg-12 col-md-12">
                    <div class="card mb-0 bg-transparent">
                        @if($GLOBALS['this_action'] != '')
                        <div class="card-header">
                            <h3 class="card-title">{{ $GLOBALS['this_action'] }}</h3>
                        </div>
                        @endif
                        @yield('content')
                    </div>
                    @yield('data')
                </div>
            </div>
        </div>
    </section>
    @include('themes.fvft.site.components.footer')
@endsection

@section('scripts')
    {{-- <script src="{{ asset('js/location.js') }}"></script> --}}
    <script src="{{ asset('themes/fvft/') }}/assets/plugins/fileuploads/js/dropify.js"></script>
    <script>
		$(document).ready(function(){
			$('.dropify').dropify();
		});
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        function showImg(img, previewId) {
            readInputURL(img, previewId);
        }

        function readInputURL(input, idName) {
            if (input.files && input.files[0]) {
                let reader = new FileReader();
                reader.onload = function(e) {
                    $("#" + idName).attr('src', e.target.result).width(100).height(100);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        $(function() {
            var mainInput = document.getElementsByClassName("nepaliDatePicker");

            if (!mainInput.length){
                return;
            }

            mainInput.nepaliDatePicker({
                language: "english",
                onChange: function() {
                    let nepalidate = $(".nepaliDatePicker").val();
                    let dateObj = NepaliFunctions.ParseDate(nepalidate);
                    let engDate = NepaliFunctions.BS2AD(dateObj.parsedDate);
                    let year = engDate.year;
                    let month = NepaliFunctions.Get2DigitNo(engDate.month);
                    let day = NepaliFunctions.Get2DigitNo(engDate.day);
                    let engValue = year + '-' + month + '-' + day;
                    $(".datetime").val(engValue);
                },
                ndpYear: true,
                ndpMonth: true,
                ndpYearCount: 200
            });


            $(".datetimepicker").datepicker({
                format: 'yyyy-mm-dd',
                todayHighlight: true,
                autoclose: true,
            });
        });
    </script>
    @yield('js')
@endsection
