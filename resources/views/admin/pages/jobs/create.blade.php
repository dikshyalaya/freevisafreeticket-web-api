@extends('admin.layouts.master')
@section('title', 'Create Job')
@section('main')
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/datepicker.min.css') }}">
<style>
    .req {
        color: red;
    }

    .tempcolor {
        color: #1650e2;
        font-weight: bold;
    }

    .ql-container {
        height: 0 !important;
    }
</style>
<div class="page-header">
    <h4 class="page-title">Post a New Job</h4>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Modules</a></li>
        <li class="breadcrumb-item" aria-current="page">Jobs</li>
        <li class="breadcrumb-item active" aria-current="page">Add</li>
    </ol>
</div>
<div class="row-">

    <div class="card">
        <div class="card-body">
            <div class="alert alert-secondary d-none" role="alert"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span id="db_error" class="db_error"></span></div>
            <form action="{{ route('admin.saveNewJob') }}" method="post" enctype="multipart/form-data" id="jobForm">
                @csrf
                @include('partial/job/createJob')
            </form>
        </div>
    </div>

</div>
@endsection

@section('script')
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/location.js') }}"></script>
<script>
    const _token = $('meta[name="csrf-token"]')[0].content;
    var state_id = "{{isset($job->state_id) ? $job->state_id : 'null'}}";
    var city_id = "{{isset($job->city_id) ? $job->city_id : 'null'}}";
    const appurl = "{{ env('APP_URL') }}";


    $(function() {
        $('.datetime').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true,
        });

        $("[name='company_id']").change(function() {
            console.log("company id: " + $(this).val());
            $.ajax({
                url: "/api/v1/company/" + $(this).val(),
                method: "get",
                complete: function(response) {
                    var company = response.responseJSON.data.company;
                    // var country = company.country;
                    // console.log(country.id);
                    state_id = company.state.id;
                    city_id = company.city.id;

                    console.log(state_id + " :: " + city_id);

                    $("#select-country").val(company.country_id).trigger('change');
                }
            });
        });



        $("#Picture").on("change", function() {
            if ($("#Picture")[0].files.length > 5) {
                alert("You can select only 5 images");
                $("#Picture").val(null);
            }
        });

        $('.dropify').dropify({
            error: {

                'imageFormat': 'The image format is not allowed (png, jpg, jpeg only).'
            }
        });

        var currency_name = $("#select-country option:selected").data('name');
        $(".countrylabel").html(currency_name);


        $("#select-country").on('change', function() {
            console.log("#select-country");
            var currency_name = $(this).find('option:selected').data('name');
            $(".countrylabel").html(currency_name);

            //console.log("patch statees");
            console.log("country id: " + $(this).val());
            //console.log(patchStates);
            loadStates($(this).val());
        });


    });

    function submitForm(e) {
        e.preventDefault();
        $('.require').css('display', 'none');
        let url = $("#jobForm").attr("action");
        $.ajax({
            url: url,
            type: 'post',
            data: new FormData($("#jobForm")[0]),
            processData: false,
            contentType: false,
            cache: false,
            success: function(data) {
                // return true;
                if (data.db_error) {
                    $(".alert-secondary").css('display', 'block');
                    $(".db_error").html(data.db_error);
                    toastr.warning(data.db_error);
                } else if (data.errors) {
                    var error_html = "";
                    $.each(data.errors, function(key, value) {
                        error_html = '<div>' + value + '</div>';
                        $('.' + key).css('display', 'block').html(error_html);
                    });
                } else if (!data.errors && !data.db_error) {
                    location.href = data.redirectRoute;
                    toastr.success(data.msg);
                }
            }
        });
    }



    let requirement = "";
    let benefits = "";
    let job_description = "";
    var toolbarOptions = [
        [{
            'header': [1, 2, 3, 4, 5, 6, false]
        }],
        [{
            'color': []
        }, {
            'background': []
        }], // dropdown with defaults from theme
        // [{ 'font': [] }],
        // [{ 'list': 'ordered'}, { 'list': 'bullet' }],
        [{
            'align': []
        }],
        ['bold', 'italic', 'underline'],
        ['link', 'image']
    ];
    var req_quill = new Quill('#editor', {
        theme: 'snow',
        modules: {
            toolbar: toolbarOptions
        }
    });

    var ben_quill = new Quill('#benefitEditor', {
        theme: 'snow',
        modules: {
            toolbar: toolbarOptions
        }
    });

    var jd_quill = new Quill('#JobDescription', {
        theme: 'snow',
        modules: {
            toolbar: toolbarOptions
        }
    });

    req_quill.on('text-change', function() {
        requirement = JSON.stringify(req_quill.getContents());
        $("#requirementID")[0].value = requirement;
        $("#requirement_intro")[0].value = escapeHtml($('.ql-editor').html());
    });
    if ($("#requirementID")[0].value != '') {
        req_quill.setContents(JSON.parse($("#requirementID")[0].value))
    }

    // for benefits
    ben_quill.on('text-change', function() {
        benefits = JSON.stringify(ben_quill.getContents());
        $("#benefitID")[0].value = benefits;
        $("#benefit_intro")[0].value = escapeHtml($('.ql-editor').html());
    });
    if ($("#benefitID")[0].value != '') {
        ben_quill.setContents(JSON.parse($("#benefitID")[0].value))
    }

    // for job_description
    jd_quill.on('text-change', function() {
        job_description = JSON.stringify(jd_quill.getContents());
        $("#jobdescriptionID")[0].value = job_description;
        $("#job_description_intro")[0].value = escapeHtml($('.ql-editor').html());
    });
    if ($("#jobdescriptionID")[0].value != '') {
        jd_quill.setContents(JSON.parse($("#jobdescriptionID")[0].value))
    }


    function escapeHtml(text) {
        const map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };

        return text.replace(/[&<>"']/g, function(m) {
            return map[m];
        });
    }
</script>
@endsection