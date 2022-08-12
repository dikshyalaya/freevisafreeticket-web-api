<script>
    const _token = $('meta[name="csrf-token"]')[0].content;
    const state_id = {{ isset($employ->state_id) ? $employ->state_id : '3871' }};
    const city_id = {{ isset($employ->city_id) ? $employ->city_id : 'null' }};
    const district_id = {{ isset($employ->district_id) ? $employ->district_id : 'null' }};
    const appurl = "{{ env('APP_URL') }}";
    const loadtrue = "no";
</script>
<script src="{{ env('APP_URL') }}js/location.js"></script>
<script src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>
<script>
    $(document).ready(function() {
        getDistricts($("#states").val());
        $('.datetime').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true,
        });

        var is_experience = $("input[name=is_experience]:checked").val();
        var isexp = "{{ $employ->is_experience }}";
        if (is_experience == "Yes" && isexp != '') {
            $("#experienceData").removeClass('d-none');
        } else if (is_experience == "No") {
            $("#experienceData").addClass('d-none');
        } else if (isexp == '') {
            $("#experienceData").addClass('d-none');
        }

        $("#fullPicture").on("change", function() {
            if ($("#fullPicture")[0].files.length > 5) {
                alert("You can select only 5 images");
                $("#fullPicture").val(null);
            }
        });
        $(".datetime").on('change', () => {
            let dateTime = $(".datetime").val();
            let dateObj = new Date(dateTime);
            let year = dateObj.getUTCFullYear();
            let month = dateObj.getUTCMonth() + 1;
            let day = dateObj.getUTCDate();
            let nepaliDate = NepaliFunctions.AD2BS({
                year: year,
                month: month,
                day: day
            });
            let nepaliYear = nepaliDate.year;
            let nepaliMonth = ("0" + nepaliDate.month).slice(-2);
            let nepaliDay = ("0" + nepaliDate.day).slice(-2);
            let nepaliValue = nepaliYear + '-' + nepaliMonth + '-' + nepaliDay;
            $("#nepali-datepicker").val(nepaliValue);
        });

        // $(".training").on('change', function(){
        //     updateSelectedList('training');
        //     disableSelectedList('training');
        // });

        $("#newTrainingModal").on('hidden.bs.modal', function() {
            $(this).find('form')[0].reset();
            $('.require').css('display', 'none');
        });

        $("#newSkillModal").on('hidden.bs.modal', function() {
            $(this).find('form')[0].reset();
            $('.require').css('display', 'none');
        });


        $('.dropify').dropify({
            error: {

                'imageFormat': 'The image format is not allowed (png, jpg, jpeg only).'
            }
        });

    });


    function submitForm(e) {
        e.preventDefault();
        $('.require').css('display', 'none');
        let url = $("#candidateForm").attr('action');
        var data = new FormData($("#candidateForm")[0]);
        data.append('_method', 'put');
        $.ajax({
            url: url,
            type: 'post',
            // _method: 'put',
            // data: data,
            data: new FormData($("#candidateForm")[0]),
            processData: false,
            contentType: false,
            cache: false,
            success: function(response) {
                if (response.db_error) {
                    $(".alert-secondary").css('display', 'block');
                    $(".db_error").html(response.db_error);
                    toastr.warning(response.db_error);
                } else if (response.errors) {
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

    // Experience Section
    var ecount = 0;
    $(function() {
        var myexperienceRadio = $("input[name=is_experience]");
        $(myexperienceRadio).on('change', function() {
            let this_value = $(this).val();
            if (this_value == 'Yes') {
                $("#experienceData").removeClass('d-none');
            } else if (this_value == 'No') {
                $("#experienceData").addClass('d-none');
            }
        });


        $("#addExperience").on('click', () => {
            let html = `<div class="form-group" id="eRow_` + ecount +
                `">
                                <div class="form-label">Experience <span class="float-right cur_sor btn btn-danger" onclick="removeRow('eRow_` +
                ecount + `')">Remove</span></div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Country</label>
                                            <select name="country_id[]" class="form-control select2-show-search" data-placeholder="Select Country">
                                                <option value="">Select Country</option>
                                                @foreach ($countries as $country)
                                                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Job Category</label>
                                            <select name="job_category_id[]" class="form-control select2-show-search" data-placeholder="Select Job Category">
                                                <option value="">Select Job Category</option>
                                                @foreach ($job_categories as $job_category)
                                                    <option value="{{ $job_category->id }}">
                                                        {{ $job_category->functional_area }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Industry</label>
                                            <select name="industry_id[]" class="form-control select2-show-search" data-placeholder="Select Industry">
                                                <option value="">Select Industry</option>
                                                @foreach ($industries as $industry)
                                                    <option value="{{ $industry->id }}">{{ $industry->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Working Duration</label>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <select name="working_year[]" class="form-control select2-show-search" data-placeholder="Select Year">
                                                        <option value="">{{ __('Year') }}</option>
                                                        @for ($i = 0; $i <= 10; $i++)
                                                            <option value="{{ $i }}">{{ $i }}
                                                            </option>
                                                        @endfor
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <select name="working_month[]" class="form-control select2-show-search" data-placeholder="Select Month">
                                                        <option value="">{{ __('Month') }}</option>
                                                        @for ($i = 0; $i <= 12; $i++)
                                                            <option value="{{ $i }}">{{ $i }}</option>
                                                        @endfor
                                                    </select>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>`;
            $("#appendExperience").append(html);
            ecount++;
        });
    });

    // End Experience Section


    // Ajax Add Training and Skill Section
    $("#addNewTraining").on('click', function(e) {
        $('.require').css('display', 'none');
        e.preventDefault();
        var formData = ($("#newTrainingForm").serialize());
        var action = $("#newTrainingForm").attr('action');
        $.ajax({
            url: action,
            type: 'post',
            data: formData,
            dataType: 'json',
            success: function(data) {
                if (data.errors) {
                    var error_html = "";
                    $.each(data.errors, function(key, value) {
                        error_html = '<div>' + value + '</div>';
                        $('.' + key).css('display', 'block');
                        $('.' + key).css('color', 'red');
                        $('.' + key).html(error_html);
                    });
                } else {
                    $("#newTrainingModal").modal('hide');
                    let new_option = $('<option></option>').val(data.training_id).html(data
                            .training_title)
                        .attr('selected', 'selected');
                    $("#training").append(new_option);

                }

            }
        });
    });

    $("#addNewSkill").on('click', function(e) {
        $('.require').css('display', 'none');
        e.preventDefault();
        var formData = ($("#newSkillForm").serialize());
        var action = $("#newSkillForm").attr('action');
        $.ajax({
            url: action,
            type: 'post',
            data: formData,
            dataType: 'json',
            success: function(data) {
                if (data.errors) {
                    var error_html = "";
                    $.each(data.errors, function(key, value) {
                        error_html = '<div>' + value + '</div>';
                        $('.' + key).css('display', 'block');
                        $('.' + key).css('color', 'red');
                        $('.' + key).html(error_html);
                    });
                } else {
                    $("#newSkillModal").modal('hide');
                    let new_option = $('<option></option>').val(data.skill_id).html(data
                            .skill_title)
                        .attr('selected', 'selected');
                    $("#skill").append(new_option);

                }

            }
        });
    });

    // End Ajax Add Training and Skill Section

    // Language Section
    var count = 0;
    $("#languageSelect").on('change', function() {

        let language_id = $(this).find(':selected').data('id');
        let language_name = $(this).find(':selected').data('name');
        let html = `<div class="row" id="languageRow_` + count + `">
                            <div class="col-md-4">
                                <label for="" class="">` + language_name + `</label>
                                <input type="hidden" name="language[]" class="form-control"
                                    value="` + language_id +
            `">
                            </div>
                            <div class="col-md-4">
                                <div class="custom-controls-stacked d-inline-flex">
                                    <label class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" value="Good" name="language_level_` +
            language_id +
            `[]">
                                        <span class="custom-control-label">Good</span>
                                    </label>
                                    <label class="custom-control custom-radio ml-2">
                                        <input type="radio" class="custom-control-input" value="Fair" name="language_level_` +
            language_id + `[]">
                                        <span class="custom-control-label">Fair</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-3">
                            <span class="text-danger cur_sor" onclick="removeRow('languageRow_` + count + `')">X</span>
                        </div>
                        </div>`;
        $("#appendLanguageDiv").append(html);
        count++;
    });


    $("#addLanguage").on('click', () => {
        let language_html = `<div class="row mt-5" id="languageRow_` + count + `">
                                <div class="col-md-6">
                                    <select name="language[]" class="form-control select2" id="lang_` + count + `">
                                        <option value="">Select Language</option>
                                        @foreach ($languages as $language)
                                            <option value="{{ $language->id }}">{{ $language->lang }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-5">
                                    <select name="language_level[]" class="form-control select2">
                                        <option value="">Select Level</option>
                                        <option value="Very Good">Very Good</option>
                                        <option value="Good">Good</option>
                                        <option value="Fair">Fair</option>
                                    </select>
                                </div>
                                <div class="col-md-1 mt-2">
                            <button class="text-danger btn btn-sm btn-default" onclick="removeRow('languageRow_` + count + `')"><i class="fa fa-minus"/></button>
                        </div>
                            </div>`;
        $("#appendLanguageDiv").append(language_html);
        count++;
    });
    // End Language Section

    function removeRow(idname) {
        $("#" + idname).remove();
    }

    var listData = [];

    function updateSelectedList(classname) {
        var listData = classname + 'selectedList';
        listData = [];
        var valuedata = classname + 'selectedValue';
        $("." + classname).each(function() {
            valuedata = $(this).find('option:selected').val();
            if (valuedata != "" && $.inArray(valuedata, listData) == "-1") {
                listData.push(valuedata);
            }
        });
    }

    function disableSelectedList(class_name) {
        $("." + class_name + ' option').each(function() {
            if ($.inArray(this.value, listData) != "-1") {
                $(this).hide();
            } else {
                $(this).show();
            }
        });
    }
</script>
