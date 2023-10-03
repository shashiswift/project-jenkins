$(document).ready(function() {
    var _tokken = $('meta[name="_tokken"]').attr("content");
    var base_url = $("body").attr("data-url");
    var pageno = 0;
    $("#sublab_pagination").on("click", "a", function(e) {
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
        var lab_type = $(".lab_type").val() ? btoa($(".lab_type").val()) : "NULL";
        $.ajax({
            url: base_url +
                "SubLab/sublab_listing/" +
                search +
                "/" +
                lab_type +
                "/" +
                pagno,
            type: "get",
            dataType: "json",
            success: function(response) {
                $("#sublab_pagination").html(response.pagination);
                // console.log(response.result);
                createTable(response.result);
            },
        });
    }

    function createTable(result) {
        $("#sublab_list").empty();
        $("#sublab_list").html(result);
    }

    var form_submit = 1;
    $("#add_sublab").on("submit", function(e) {
        var self = $(this);
        e.preventDefault();
        if (form_submit == 1) {
            form_submit++;
            $.ajax({
                url: base_url + "SubLab/add_sublab",
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
                        $('#subLabModal').modal('hide');
                        self.trigger('reset');
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

    $(document).ready(function() {
        // console.log('1');
        var base_url = $("#base_url").attr("data-id");
        var _tokken = $('meta[name="_tokken"]').attr("content");
        $(document).on('click', '.edit_sublab', function() {
            var subLab_id = $(this).data('one');
            $.ajax({
                type: 'post',
                url: base_url + 'SubLab/get_sublab_details',
                data: { _tokken: _tokken, subLab_id: subLab_id },
                success: function(data) {
                    var record = $.parseJSON(data);
                    $('#sublab_id').val(btoa(record.Sub_lab_id));
                    $("#lab_type option[value='" + record.gmark_laboratory_type_id + "']").attr('selected', 'selected');
                    // $('#lab_type').val(record.gmark_laboratory_type_id);
                    $('#sublab_name').val(record.Sub_lab_name);
                    $('#sublab_desc').val(record.Sub_lab_desc);
                }
            })
        });

        var form_submit = 1;
        $("#edit_sublab").on("submit", function(e) {
            e.preventDefault();
            if (form_submit == 1) {
                form_submit++;
                $.ajax({
                    url: base_url + "SubLab/edit_sublab",
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
                            $('#sublabEditModal').modal('hide');
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
    });
});