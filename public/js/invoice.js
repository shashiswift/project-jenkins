$(document).ready(function() {
    var base_url = $("#base_url").attr("data-id");
    var form_submit = 1;
    $("#add_invoice").on("submit", function(e) {
        var self = $(this);
        e.preventDefault();
        if (form_submit == 1) {
            form_submit++;
            $('body').append('<div class="pageloader"></div>');
            $.ajax({ async:true,
                url: base_url + "Invoice/add_invoice",
                method: "POST",
                data: $(this).serialize(),
                success: function(result) {
                    $('.pageloader').remove();
                    var data = $.parseJSON(result);
                    if (data.status > 0) {
                        iziToast.success({
                            title: 'SUCCESS',
                            message: data.msg,
                            position: 'topRight'
                        });
                        form_submit = 1;
                        self.trigger('reset');
                        $('#addInvoiceModal').modal('hide');
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
                    $('.pageloader').remove();
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
    $(document).on('click', '.edit_invoice', function() {
        var invoice_id = $(this).data('one');
        $.ajax({ async:true,
            type: 'post',
            url: base_url + 'Invoice/get_invoice_details',
            data: { _tokken: _tokken, invoice_id: invoice_id },
            success: function(data) {
                var record = $.parseJSON(data);
                console.log(record.country_tax);
                $('#invoice_id').val(btoa(record.invoice_id));
                $("#country_tax_edit option[value='" + record.country_tax + "']").attr('selected', 'selected');
                $("#company_country_edit option[value='" + record.company_country + "']").attr('selected', 'selected');
                $('#discount').val(record.discount);
                $('#taxtype_edit').val(record.tax_type);
                $('#taxval_edit').val(record.tax_type_value);
                $('#company_name_edit').val(record.company_name);
                $('#comp_address_edit').val(record.company_location);
                $('#payment_amount').val(record.payment_amount);
                $('#note').val(record.note);
                $('#invoice_number').val(record.invoice_number);
                if (record.country_tax == "others") {
                    $('#edit_input_tax').css('display', 'block');
                }
            }
        })
    });
    $(document).on("keyup", ".focusout_autosuggestion", function () {
        var text = $(this).val();
        var self = $(this);
        if (text) {
          $.ajax({ async:true,
            url: base_url + "Gmark/search",
            type: "POST",
            data: {
              key: text,
              _tokken: _tokken,
              table: "gmark_customers",
              coloum: "entity_name",
              select: "customers_id,entity_name",
            },
            success: function (result) {
              var data = $.parseJSON(result);
              var html = "";
              if (data) {
                $.each(data, function (i, v) {
                  html +=
                    '<li class="list-group-item list-group-item-action li-state" data-id="' +
                    v.customers_id +
                    '">' +
                    v.entity_name +
                    "</li>";
                });
                html += "";
              } else {
                html +=
                  '<li class="list-group-item list-group-item-action li-state" data-id="NULL">NO RECORD FOUND</li>';
                $(".applicant_id").val("NULL");
              }
              self
                .siblings("div.drop_down_ul.posiotio")
                .children("ul.itemList1")
                .html(html)
                .fadeIn();
            },
            error: function (e) {
              console.log(e);
            },
          });
        } else {
          self.siblings('input[type="hidden"]').val("NULL");
        }
      });
      $(".itemList1").on("click", "li", function () {
        $(this).parents().siblings('input[type="text"]').val($(this).text());
        $(this).parents().siblings('input[type="hidden"]').val($(this).data("id"));
        $(".itemList1").fadeOut();
      });
      $(".focusout_autosuggestion").focusout(function () {
        $(this)
          .siblings("div.drop_down_ul.posiotio")
          .children("ul.itemList1")
          .fadeOut();
      });
    var form_submit = 1;
    $(document).on("submit", "#edit_invoice", function(e) {
        e.preventDefault();
        if (form_submit == 1) {
            form_submit++;
            $('body').append('<div class="pageloader"></div>');
            $.ajax({ async:true,
                url: base_url + "Invoice/edit_invoice",
                method: "POST",
                data: $(this).serialize(),
                success: function(result) {
                    $('.pageloader').remove();
                    var data = $.parseJSON(result);
                    if (data.status > 0) {
                        iziToast.success({
                            title: 'SUCCESS',
                            message: data.msg,
                            position: 'topRight'
                        });
                        form_submit = 1;
                        $('#editInvoiceModal').modal('hide');
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
                    $('.pageloader').remove();
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
    $("#invoice_pagination").on("click", "a", function(e) {
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
        var applicant_id = $(".applicant_id").val()
        ? $(".applicant_id").val()
        : "NULL";
      var manufacture_id = $(".manufacture_id").val()
        ? $(".manufacture_id").val()
        : "NULL";
      var factory_id = $(".factory_id").val() ? $(".factory_id").val() : "NULL";
      var lab_name = $(".lab_name").val() ? $(".lab_name").val() : "NULL";
      var start_Date = $(".start_Date").val() ? $(".start_Date").val() : "NULL";
      var end_Date = $(".end_Date").val() ? $(".end_Date").val() : "NULL";
      var destinaition = $(".destinaition").val()
        ? $(".destinaition").val()
        : "NULL";
      var application = $(".application").val()
        ? $(".application").val()
        : "NULL";
      var search = $(".search").val() ? btoa($(".search").val()) : "NULL";
        $.ajax({ async:true,
            url: base_url +
                "Invoice/invoice_listing/" +
                applicant_id +
                "/" +
                manufacture_id +
                "/" +
                factory_id +
                "/" +
                lab_name +
                "/" +
                start_Date +
                "/" +
                end_Date +
                "/" +
                destinaition +
                "/" +
                application +
                "/" +
                search +
                "/" +
                pagno,
            type: "get",
            dataType: "json",
            success: function(response) {
                $("#invoice_pagination").html(response.pagination);
                // console.log(response.result);
                createTable(response.result);
            },
        });
    }

    function createTable(result) {
        $("#invoice_list").empty();
        $("#invoice_list").html(result);
    }

    $(document).on('change', '#company_country', function() {
        var country = $("#company_country").val();
        $.ajax({ async:true,
            type: 'post',
            url: base_url + 'Invoice/get_country',
            data: { _tokken: _tokken, country: country },
            success: function(data) {
                var company = JSON.parse(data);
                $('#company_name').val(company.company_name)
                $('#comp_address').val(company.address)
            }
        })
    });

    $(document).on('change', '#company_country_edit', function() {
        var country = $("#company_country_edit").val();
        $.ajax({ async:true,
            type: 'post',
            url: base_url + 'Invoice/get_country',
            data: { _tokken: _tokken, country: country },
            success: function(data) {
                var company = JSON.parse(data);
                $('#company_name_edit').val(company.company_name)
                $('#comp_address_edit').val(company.address)
            }
        })
    });
});