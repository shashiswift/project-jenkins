$(document).ready(function() {
    var base_url = $("#base_url").attr("data-id");
    var form_submit = 1;
    var pageno = 0;
    $("#add_document").on("submit", function(e) {
        var self = $(this);
        e.preventDefault();
        if (form_submit == 1) {
            form_submit++;
            $.ajax({
                url: base_url + "Document/add_document",
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
                        $('#documentModal').modal('hide');
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
    $(document).on('click', '.edit_document', function() {
        var document_id = $(this).data('one');
        $.ajax({
            type: 'post',
            url: base_url + 'Document/get_document_details',
            data: { _tokken: _tokken, document_id: document_id },
            success: function(data) {
                var record = $.parseJSON(data);
                $('#document_id').val(btoa(record.document_id));
                $("#doc_required option[value='" + record.doc_need + "']").attr('selected', 'selected');
                $('#document_name').val(record.document_name);
            }
        })
    });

    var form_submit = 1;
    $(document).on("submit", "#edit_document", function(e) {
        console.log(form_submit);
        e.preventDefault();
        if (form_submit == 1) {
            form_submit++;
            $.ajax({
                url: base_url + "Document/edit_document",
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
                        $('#documentEditModal').modal('hide');
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

    
    $("#doc_pagination").on("click", "a", function(e) {
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
                "Document/document_listing/" +
                search +
                "/" +
                pagno,
            type: "get",
            dataType: "json",
            success: function(response) {
                $("#doc_pagination").html(response.pagination);
                // console.log(response.result);
                createTable(response.result);
            },
        });
    }

    function createTable(result) {
        $("#doc_list").empty();
        $("#doc_list").html(result);
    }
});