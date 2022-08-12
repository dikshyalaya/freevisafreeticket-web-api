<script>
    $("#checkAll").click(function() {
        $(".rowCheck").prop('checked', $(this).prop('checked'));
    });

    $(".rowCheck").click(function() {
        $("#checkAll").prop('checked', false);
    });

    function checkIfRowChecked() {
        var allIds = getCheckedValues();
        if (allIds.length <= 0) {
            return false;
        } else {
            return true;
        }
    }

    function getCheckedValues() {
        var allIds = [];
        $(".rowCheck:checked").each(function() {
            allIds.push($(this).val());
        });
        return allIds;
    }

    $(document).ready(function() {
        $("#scheduleInterview").on('click', function(e) {
            if (checkIfRowChecked() == false) {
                rowSelectMessage();
                e.stopPropagation();
            }
        });

        $("#interviewModal").on('hide.bs.modal', function(e) {
            $('input:checkbox').prop('checked', false);
        });
    });

    function rowSelectMessage() {
        Swal.fire({
            title: 'Oops..',
            text: 'Please Select Row',
            icon: 'error'
        });
    }

    function scheduleInterview() {
        $('.require').css('display', 'none');
        var allIds = getCheckedValues();
        if (allIds.length <= 0) {
            rowSelectMessage();
        } else {
            Swal.fire({
                text: 'Are you sure you want to perform bulk operation?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: "Yes",
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
            }).then((result) => {
                if (result.isConfirmed) {
                    var joinCheckedValues = allIds.join(",");
                    var formData = new FormData($("#scheduleInterViewForm")[0]);
                    formData.append("ids", joinCheckedValues);

                    $.ajax({
                        url: "{{ route('bulkScheduleInterview') }}",
                        type: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        cache: false,
                        beforeSend: function() {
                            busySign();
                        },
                        success: function(data) {
                            if (data.success == false) {
                                if (data.errors) {
                                    var error_html = "";
                                    $.each(data.errors, function(key, value) {
                                        error_html =  value;
                                        $('.' + key).css('display', 'block').html(
                                            error_html);
                                    });
                                } else if(data.error){
                                    toastr.error(data.error);
                                }
                            } else if(data.success == true){
                                toastr.success(data.msg);
                                var statuses = JSON.parse(data.statuses);
                                $.each(statuses, function(k, v) {
                                    $.each(v, function(key, value) {
                                        var tableRow = $('tr[data-id="' + key +
                                            '"]');
                                        $(tableRow).find(".applicantStatus").text(
                                            value);
                                    });
                                });
                                $("#interviewModal").modal('hide');
                            }
                        },
                        complete: function() {
                            hideBusySign();
                        }
                    });

                }
            });
        }
    }

    function updateBulkApplicantStatus(applicantStatus) {
        var allIds = [];
        $(".rowCheck:checked").each(function() {
            allIds.push($(this).val());
        });
        if (allIds.length <= 0) {
            rowSelectMessage();
        } else {
            Swal.fire({
                text: 'Are you sure you want to perform bulk operation?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: "Yes",
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
            }).then((result) => {
                if (result.isConfirmed) {
                    var joinCheckedValues = allIds.join(",");
                    $.ajax({
                        url: "{{ route('bulkUpdateApplicationStatus') }}",
                        type: "POST",
                        data: {
                            "ids": joinCheckedValues,
                            "applicantStatus": applicantStatus,
                            _method: "PUT",
                        },
                        beforeSend: function() {
                            busySign();
                        },
                        success: function(response) {
                            if (response.success == false) {
                                if (response.db_error) {
                                    toastr.error(response.db_error);
                                } else if (response.error) {
                                    toastr.error(response.error);
                                }
                            }
                            if (response.success == true) {
                                var statuses = JSON.parse(response.statuses);
                                $.each(statuses, function(k, v) {
                                    $.each(v, function(key, value) {
                                        var tableRow = $('tr[data-id="' + key +
                                            '"]');
                                        $(tableRow).find(".applicantStatus").text(
                                            value);
                                    });
                                });
                                toastr.success(response.msg);
                                $('input:checkbox').prop('checked', false);
                            }
                        },
                        complete: function() {
                            hideBusySign();
                        }
                    });
                }
            });
        }
    }


    function bulkCvDownload() {
        var allIds = [];
        $(".rowCheck:checked").each(function() {
            allIds.push($(this).val());
        });
        if (allIds.length <= 0) {
            rowSelectMessage();
        } else {
            Swal.fire({
                text: 'Are you sure you want to perform bulk download?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: "Yes Download!",
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
            }).then((result) => {
                if (result.isConfirmed) {
                    var joinCheckedValues = allIds.join(",");
                    $.ajax({
                        url: "{{ route('bulkCvDownload') }}",
                        type: "GET",
                        data: {
                            "ids": joinCheckedValues
                        },
                        xhrFields: {
                            responseType: 'blob',
                        },
                        beforeSend: function() {
                            busySign();
                        },
                        success: function(data) {
                            if (data.success == false) {
                                if (data.error) {
                                    toastr.error(data.error);
                                }
                            }
                            var blob = new Blob([data], {
                                type: 'application/pdf'
                            });
                            var link = document.createElement('a');
                            link.href = window.URL.createObjectURL(blob);
                            link.download = "Applicants.pdf";
                            link.click();
                            toastr.success('Applicants CV Downloaded');
                            $('input:checkbox').prop('checked', false);
                        },
                        complete: function() {
                            hideBusySign();
                            $('input:checkbox').prop('checked', false);
                        }
                    });
                }
            });
        }
    }

    function bulkApplicationDelete() {
        var allIds = [];
        $(".rowCheck:checked").each(function() {
            allIds.push($(this).val());
        });
        if (allIds.length <= 0) {
            rowSelectMessage();
        } else {
            Swal.fire({
                text: 'Are you sure you want to perform bulk delete?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: "Yes Delete!",
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
            }).then((result) => {
                if (result.isConfirmed) {
                    var joinCheckedValues = allIds.join(",");
                    $.ajax({
                        url: "{{ route('bulkApplicationDelete') }}",
                        type: "POST",
                        data: {
                            "ids": joinCheckedValues,
                            _method: 'DELETE'
                        },
                        beforeSend: function() {
                            busySign();
                        },
                        success: function(data) {
                            if (data.success == false) {
                                if (data.error) {
                                    toastr.error(data.error);
                                }
                            }
                            $(".rowCheck:checked").each(function() {
                                $(this).parents("tr").remove();
                            });
                            toastr.success(data.msg);
                            $('input:checkbox').prop('checked', false);
                        },
                        complete: function() {
                            hideBusySign();
                        }
                    });
                }
            });
        }
    }
</script>