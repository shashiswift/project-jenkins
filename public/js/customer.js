$(document).ready(function() {
    var base_url = $("#base_url").attr("data-id");
    var form_submit = 1;
    $("#add_customer").on("submit", function(e) {
        self = $(this);
        e.preventDefault();
        if (form_submit == 1) {
            form_submit++;
            $.ajax({
                async:true,
                url: base_url + "Customer/add_customer",
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
                        $('#customerModal').modal('hide');
                        self.trigger('reset');
                        loadPagination(0);
                    } else {
                        iziToast.error({
                            title: 'ERROR',
                            message: data.msg,
                            position: 'topRight'
                        });
                    }
                    if (data.errors) {
                        var error = data.errors;
                        $('.add_customer_form').remove();
                        $.each(error,function(i,v){
                          $('#customerModal input[name="'+i+'"]').after('<span class="text-danger add_customer_form">'+v+'</span>');
                          $('#customerModal select[name="'+i+'"]').after('<span class="text-danger add_customer_form">'+v+'</span>');
                        });
                    }else{
                        $('.add_customer_form').remove();
                    }
                    form_submit = 1;
                    // if (data.errors) {
                        //     form_submit = 1;
                        //     $(".form_errors").html(data.errors);
                        // } else {
                    //     form_submit = 1;
                    //     $(".form_errors").html("");
                    // }
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
    $(document).on('click', '.edit_customer', function() {
        var customer_id = $(this).data('one');
        $.ajax({
            async:true,
            type: 'post',
            url: base_url + 'Customer/get_customer_details',
            data: { _tokken: _tokken, customer_id: customer_id },
            success: function(data) {
                var record = $.parseJSON(data);
                $('#customers_id').val(btoa(record.customers_id));
                $("#customer_type option[value='" + record.customer_type + "']").attr('selected', 'selected');
                $("#country option[value='" + record.country + "']").attr('selected', 'selected');
                $('#entity_name').val(record.entity_name);
                $('#address').val(record.address);
                $('#contact_name').val(record.contact_name);
                $('#contact_title').val(record.contact_title);
                $('#department').val(record.department);
                $('#phn_no').val(record.phn_no);
                $('#email').val(record.email);
                $('#licence_no').val(record.licence_no);
            }
        })
    });

    var form_submit = 1;
    $(document).on("submit", "#edit_customer", function(e) {
        e.preventDefault();
        if (form_submit == 1) {
            form_submit++;
            $.ajax({
                async:true,
                url: base_url + "Customer/edit_customer",
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
                        $('#edit_customer_data').modal('hide');
                       // form_submit = 1;
                        loadPagination(pageno);
                    } else {
                        iziToast.error({
                            title: 'ERROR',
                            message: data.msg,
                            position: 'topRight'
                        });
                    }
                    form_submit = 1;
                    if (data.errors) {
                        var error = data.errors;
                        $('.edit_customer_form').remove();
                        $.each(error,function(i,v){
                          $('#edit_customer_data input[name="'+i+'"]').after('<span class="text-danger edit_customer_form">'+v+'</span>');
                          $('#edit_customer_data select[name="'+i+'"]').after('<span class="text-danger edit_customer_form">'+v+'</span>');
                        });
                    }else{
                        $('.edit_customer_form').remove();
                    }
                    // if (data.errors) {
                    //     form_submit = 1;
                    //     $(".form_errors").html(data.errors);
                    // } else {
                    //     form_submit = 1;
                    //     $(".form_errors").html("");
                    // }
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
    $("#customer_pagination").on("click", "a", function(e) {
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
        $("#listing_filter input").removeAttr('value');
        $("#listing_filter").trigger("reset");
        pageno = 0;
        loadPagination(pageno);
    });

    function loadPagination(pagno) {
        var type = $('#type_filter').val() ? $('#type_filter').val() : '0';
        var search = $(".search").val() ? btoa($(".search").val()) : "NULL";
        $.ajax({
            async:true,
            url: base_url +
                "Customer/customer_listing/" +  type + '/' +
                search +
                "/" +
                pagno,
            type: "get",
            dataType: "json",
            success: function(response) {
                $("#customer_pagination").html(response.pagination);
                // console.log(response.result);
                createTable(response.result);
            },
        });
    }

    function createTable(result) {
        $("#customer_list").empty();
        $("#customer_list").html(result);
    }
});