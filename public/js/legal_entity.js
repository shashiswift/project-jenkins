$(document).ready(function() {
    var _tokken = $('meta[name="_tokken"]').attr("content");
    var base_url = $("body").attr("data-url");
    var pageno = 0;
    $("#legalEntity_pagination").on("click", "a", function(e) {
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
                "Legal_Entity/legalEntity_listing/" +
                search +
                "/" +
                pagno,
            type: "get",
            dataType: "json",
            success: function(response) {
                $("#legalEntity_pagination").html(response.pagination);
                // console.log(response.result);
                createTable(response.result);
            },
        });
    }

    function createTable(result) {
        $("#legalEntity_list").empty();
        $("#legalEntity_list").html(result);
    }

    var form_submit = 1;
    $("#add_legalEntity").on("submit", function(e) {
        var self = $(this);
        e.preventDefault();
        if (form_submit == 1) {
            form_submit++;
            $.ajax({
                url: base_url + "Legal_Entity/add_legalEntity",
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
                        $('#legalEntityModal').modal('hide');
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
        $(document).on('click', '.edit_legalEntity', function() {
            var legal_entity_id = $(this).data('one');
            $.ajax({
                type: 'post',
                url: base_url + 'Legal_Entity/get_legalentity_details',
                data: { _tokken: _tokken, legal_entity_id: legal_entity_id },
                success: function(data) {
                    var record = $.parseJSON(data);
                    $('#legal_entity_id').val(btoa(record.legal_entity_id));
                    $('#legal_entity_name').val(record.legal_entity_name);
                    $('#legal_entity_desc').val(record.legal_entity_desc);
                }
            })
        });

        var form_submit = 1;
        $("#edit_legalentity").on("submit", function(e) {
            e.preventDefault();
            if (form_submit == 1) {
                form_submit++;
                $.ajax({
                    url: base_url + "Legal_Entity/edit_legalEntity",
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
                            $('#edit_legalEntity').modal('hide');
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