$(document).ready(function() {
    var base_url = $("#base_url").attr("data-id");
    var form_submit = 1;
    var pageno = 0;
    $("#add_examination").on("submit", function(e) {
        var self = $(this);
        e.preventDefault();
        if (form_submit == 1) {
            form_submit++;
            $.ajax({
                url: base_url + "ExaminationMethod/add_examination",
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
                        loadPagination(0);
                        $('#examinationModal').modal('hide');
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
    $(document).on('click', '.edit_examination', function() {
        var examination_id = $(this).data('one');
        $.ajax({
            type: 'post',
            url: base_url + 'ExaminationMethod/get_examination_details',
            data: { _tokken: _tokken, examination_id: examination_id },
            success: function(data) {
                var record = $.parseJSON(data);
                $('#ex_method_id').val(btoa(record.ex_method_id));
                $('#ex_method_name').val(record.ex_method_name);
                $('#ex_method_desc').val(record.ex_method_desc);
            }
        })
    });

    var form_submit = 1;
    $(document).on("submit", "#edit_examination", function(e) {
        console.log(form_submit);
        e.preventDefault();
        if (form_submit == 1) {
            form_submit++;
            $.ajax({
                url: base_url + "ExaminationMethod/edit_examination",
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
                        loadPagination(pageno);
                        $('#edit_examination_data').modal('hide');
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

   
    $("#examination_pagination").on("click", "a", function(e) {
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
                "ExaminationMethod/examination_listing/" +
                search +
                "/" +
                pagno,
            type: "get",
            dataType: "json",
            success: function(response) {
                $("#examination_pagination").html(response.pagination);
                // console.log(response.result);
                createTable(response.result);
            },
        });
    }

    function createTable(result) {
        $("#examination_list").empty();
        $("#examination_list").html(result);
    }
});