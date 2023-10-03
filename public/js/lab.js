$(document).ready(function() {
    var base_url = $("#base_url").attr("data-id");
    var form_submit = 1;
    $("#add_lab").on("submit", function(e) {
        var self = $(this);
        e.preventDefault();
        if (form_submit == 1) {
            form_submit++;
            $.ajax({
                url: base_url + "Lab/add_lab",
                method: "POST",
                data: $(this).serialize(),
                success: function(result) {
                    var data = $.parseJSON(result);
                    if (data.status > 0) {
                        iziToast.success({
                            title: 'SUCCESS',
                            message: data.msg,
                            position: 'topRight'
                        });
                        form_submit = 1;
                        self.trigger('reset');
                        $('#labModal').modal('hide');
                        loadPagination(0);
                    } else {
                        form_submit = 1;
                        iziToast.error({
                            title: 'ERROR',
                            message: data.msg,
                            position: 'topRight'
                        });
                    }
                    if (data.errors) {
                        form_submit = 1;
                        $(".form_errors").html(data.errors);
                    } else {
                        form_submit = 1;
                        $(".form_errors").html("");
                    }
                },
                error: function() {
                    form_submit = 1;
                    iziToast.error({
                        title: 'ERROR',
                        message: 'Something went wrong',
                        position: 'topRight'
                    });
                },
            });
        } else {
            iziToast.error({
                title: 'ERROR',
                message: 'FORM ALREADY SUBMIT',
                position: 'topRight'
            });
        }
    });

    var _tokken = $('meta[name="_tokken"]').attr("content");
    $(document).on('click', '.edit_lab', function() {
        var lab_id = $(this).data('one');
        $.ajax({
            type: 'post',
            url: base_url + 'Lab/get_lab_details',
            data: { _tokken: _tokken, lab_id: lab_id },
            success: function(data) {
                var record = $.parseJSON(data);
                $('#lab_id').val(btoa(record.lab_id));
                $('#lab_name').val(record.lab_name);
                $('#lab_desc').val(record.lab_desc);
            }
        })
    });

    var form_submit = 1;
    $("#edit_lab").on("submit", function(e) {
        e.preventDefault();
        if (form_submit == 1) {
            form_submit++;
            $.ajax({
                url: base_url + "Lab/edit_lab",
                method: "POST",
                data: $(this).serialize(),
                success: function(result) {
                    var data = $.parseJSON(result);
                    if (data.status > 0) {
                        iziToast.success({
                            title: 'SUCCESS',
                            message: data.msg,
                            position: 'topRight'
                        });
                        form_submit = 1;
                        $('#labEditModal').modal('hide');
                        loadPagination(pageno);
                    } else {
                        form_submit = 1;
                        iziToast.error({
                            title: 'ERROR',
                            message: data.msg,
                            position: 'topRight'
                        });
                    }
                    if (data.errors) {
                        form_submit = 1;
                        $(".form_errors").html(data.errors);
                    } else {
                        form_submit = 1;
                        $(".form_errors").html("");
                    }
                },
                error: function() {
                    form_submit = 1;
                    iziToast.error({
                        title: 'ERROR',
                        message: 'Something went wrong',
                        position: 'topRight'
                    });
                },
            });
        } else {
            iziToast.error({
                title: 'ERROR',
                message: 'FORM ALREADY SUBMIT',
                position: 'topRight'
            });
        }
    });

    var pageno = 0;
    $("#lab_pagination").on("click", "a", function(e) {
        e.preventDefault();
        pageno = $(this).attr("data-ci-pagination-page");
        loadPagination(pageno);
    });

    loadPagination(0);
    $(document).on("click", ".submit_listing", function() {
        pageno = 0;
        loadPagination(pageno);
    });
    $(document).on("click", ".clear_listing", function() {
        $("input").val("");
        $("#listing_filter").trigger("reset");
        pageno = 0;
        loadPagination(pageno);
    });

    function loadPagination(pagno) {
        var search = $(".search").val() ? btoa($(".search").val()) : "NULL";
        $.ajax({
            url: base_url +
                "Lab/lab_listing/" +
                search +
                "/" +
                pagno,
            type: "get",
            dataType: "json",
            success: function(response) {
                $("#lab_pagination").html(response.pagination);
                // console.log(response.result);
                createTable(response.result);
            },
        });
    }

    function createTable(result) {
        $("#lab_list").empty();
        $("#lab_list").html(result);
    }
});