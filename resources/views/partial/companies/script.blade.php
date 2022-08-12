<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script src="{{ env('APP_URL') }}js/location.js"></script>
<script src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>
<script>
    const _token = $('meta[name="csrf-token"]')[0].content;
    const state_id = {{ isset($company->state_id) ? $company->state_id : 'null' }};
    const city_id = {{ isset($company->city_id) ? $company->city_id : 'null' }};
    const appurl = "{{ env('APP_URL') }}";
</script>
<script>
    $(function() {
        $('.datetime').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true,
        });

        $(".opsince").datepicker({
            format: "yyyy",
            viewMode: "years",
            minViewMode: "years",
            autoclose: true,
        });
    });

    let body = "";
    let company_services = ""
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
    var quill = new Quill('#editor', {
        theme: 'snow',
        modules: {
            toolbar: toolbarOptions
        }
    });

    var quill1 = new Quill('#companyServices', {
        theme: 'snow',
        modules: {
            toolbar: toolbarOptions
        }
    });
    quill.on('text-change', function() {
        body = JSON.stringify(quill.getContents());
        $("#body_id")[0].value = body;
        $("#html_content_intro")[0].value = escapeHtml($('.ql-editor').html());
    });
    // // console.log($("#body_id")[0].value);
    // console.log(JSON.parse($("#body_id")[0].value));
    if ($("#body_id")[0].value != '') {
        quill.setContents(JSON.parse($("#body_id")[0].value))
    }

    // for services
    quill1.on('text-change', function() {
        // body = JSON.stringify(quill1.getContents());
        company_services = JSON.stringify(quill1.getContents());
        $("#company_service_id")[0].value = company_services;
        $("#html_content_service")[0].value = escapeHtml($('.ql-editor').html());
    });
    // quill1.setContents(JSON.parse($("#body_id")[0].value))
    if ($("#company_service_id")[0].value != '') {
        quill1.setContents(JSON.parse($("#company_service_id")[0].value))
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



    function submitForm(e) {
        e.preventDefault();
        $('.require').css('display', 'none');
        let url = $("#companyForm").attr('action');
        var data = new FormData($("#companyForm")[0]);
        data.append('_method', 'put');
        $.ajax({
            url: url,
            type: 'post',
            // _method: 'put',
            // data: data,
            data: new FormData($("#companyForm")[0]),
            processData: false,
            contentType: false,
            cache: false,
            success: function(response) {
                // return true;
                if (response.db_error) {
                    $(".alert-secondary").css('display', 'block');
                    $(".db_error").html(response.db_error);
                    toastr.warning(response.db_error);
                } else if (response.errors) {
                    toastr.error(response.errors[Object.keys(response.errors)[0]]);
                    var error_html = "";
                    $.each(response.errors, function(key, value) {
                        error_html = '<div>' + value + '</div>';
                        $('.' + key).css('display', 'block').html(error_html);
                    });
                } else if (!response.errors && !response.db_error) {
                    location.href = response.redirectRoute;
                    toastr.success(response.msg);
                }
            }
        });
    }

    function getIsoCode(country) {
        var isocode = $(country).select2().find(":selected").data('phonecode');
        if (isocode != '') {
            $("#dialCode").val(isocode).trigger('change');
            $("#contactIsoCode").val(isocode).trigger('change');
        }
    }
</script>
