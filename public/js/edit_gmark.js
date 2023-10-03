$(document).ready(function () {
  var product_count = $(".product tbody tr").length;
  $(".add-row").click(function () {
    var dumy_tr =
      '<tr class="table-primary"><td><textarea  name="product[' +
      product_count +
      '][hs_code]" class="form-control"></textarea></td><td><textarea  name="product[' +
      product_count +
      '][product]" class="form-control"></textarea></td><td><textarea  name="product[' +
      product_count +
      '][trade_mark]" class="form-control"></textarea></td><td><textarea  name="product[' +
      product_count +
      '][mode_type_ref]" class="form-control"></textarea></td><td><textarea  name="product[' +
      product_count +
      '][technical_details]" class="form-control"></textarea></td><td><input type="checkbox" class="record"></td></tr>';

    $(".product tbody").append(dumy_tr);
    product_count++;
  });

  $(".delete-row").on("click", function () {
    $(".product tbody")
      .find('input[class="record"]')
      .each(function () {
        if ($(this).is(":checked")) {
          $(this).parents("tr").remove();
        }
      });
  });
});

$(document).ready(function () {
  var base_url = $("#base_url").attr("data-id");
  var _tokken = $('meta[name="_tokken"]').attr("content");

  /* CALL FUNCTION */
  var country_id = [195, 234, 120, 180, 17, 167, 247];
  destination(country_id);
  customer_list(".gmark_customer_list", null);
  customer_list(".gmark_customer_list_licc", null);
  customer_list(".gmark_customer_list_manu", null);
  customer_list(".gmark_customer_list_factory", null);
  country_list(".country_list", null);
  ex_method_dropdown();
  signatory();
  legal_entityDropdown();
  laboratoryDropdown();
  applicationDropdown();
  /* END */

  var product_con_count = $(".con_table tbody tr").length;
  $(".add-row-con").click(function () {
    var dumy_tr =
      '<tr class="table-primary"><td><textarea name="product_con[' +
      product_con_count +
      '][hs_code]" class="form-control"></textarea></td><td><textarea name="product_con[' +
      product_con_count +
      '][product]" class="form-control"></textarea></td><td><textarea name="product_con[' +
      product_con_count +
      '][other_con_mark]" class="form-control"></textarea></td><td><textarea name="product_con[' +
      product_con_count +
      '][applicable_standard]" class="form-control"></textarea></td><td><textarea name="product_con[' +
      product_con_count +
      '][test_report]" class="form-control"></textarea></td><td><input type="checkbox" name="record"></td></tr>';

    $(".con_table tbody").append(dumy_tr);
    product_con_count++;
  });

  $(".delete-row-con").on("click", function () {
    $(".con_table tbody")
      .find('input[class="record"]')
      .each(function () {
        if ($(this).is(":checked")) {
          $(this).parents("tr").remove();
        }
      });
  });

  $(".link_check").on("change", function () {
    var link_check = $(this).val();
    if (link_check == "1") {
      $(".check_detail").css("display", "inline-block");
    }
    if (link_check == "0") {
      $(".check_detail").css("display", "none");
    }
  });

  // add more factory
  $("#add_factory").click(function () {
    var addForm = $(".parent").html();
    $(".more_factory_data").append(addForm);
  });

  // delete factory

  $(document).on("click", "#remove_factory", function () {
    $(this).parents(".factory_data_form").remove();
  });

  function get_applicant_detail() {
    var entity_type = $(".legel_entity").val();
    var emtity_addr = $(".emtity_addr").val();
    var entity_country = $(".entity_country").val();
    var name = $(".appli_name").val();
    var title = $(".appli_title").val();
    var dept = $(".appli_dept").val();
    var mob = $(".appli_mob").val();
    var email = $(".appli_email").val();
    var entity_name = $(".entity_name").val();

    var arr = [];
    arr.push(
      entity_type,
      emtity_addr,
      entity_country,
      name,
      title,
      dept,
      mob,
      email,
      entity_name
    );
    return arr;
  }

  $(".mf_same_as").on("change", function () {
    var arr = get_applicant_detail();
    var check_mf = $(".mf_same_as").val();
    if (check_mf == "1") {
      $("#gmark_customer_list_manu").val($("#gmark_customer_list").val());
      manufacture_details($("#gmark_customer_list").val());
    } else {
      customer_list(".gmark_customer_list_manu", null);
      $("#manufacture_html").html("");
    }
  });

  $(".fc_same_as").on("change", function () {
    get_applicant_detail();
    var check_mf = $(".fc_same_as").val();
    if (check_mf == "1") {
      $("#gmark_customer_list_factory").val($("#gmark_customer_list").val());
    } else {
      customer_list(".gmark_customer_list_factory", null);
    }
  });

  // validation of application

  $("form[name='submit_application']").validate({
    rules: {
      application_name: "required",
      application_desc: "required",
    },

    messages: {
      application_name: "This is required field please fill it",
      application_desc: "This is required field please fill it",
    },
  });

  // validation of laboratory

  $("form[name='submit_lab']").validate({
    rules: {
      lab_name: "required",
    },

    messages: {
      lab_name: "This is required field please fill it",
    },
  });
  $("form[name='Sub_submit_lab']").validate({
    rules: {
      gmark_laboratory_type_id: "required",
      Sub_lab_name: "required",
    },

    messages: {
      gmark_laboratory_type_id: "This is required field please Select Lab",
      Sub_lab_name: "This is required field please fill it",
    },
  });

  // validation of legal entity type

  $("form[name='submit_legal_entity']").validate({
    rules: {
      legal_entity_name: "required",
      legal_entity_desc: "required",
    },

    messages: {
      legal_entity_name: "This is required field please fill it",
      legal_entity_desc: "This is required field please fill it",
    },
  });

  // validation for examination method

  $("form[name='submit_ex_method']").validate({
    rules: {
      ex_method_name: "required",
      ex_method_desc: "required",
    },

    messages: {
      ex_method_name: "This is required field please fill it",
      ex_method_desc: "This is required field please fill it",
    },
  });
  // CUSTOMER VALIDATION

  $("form[name='customer_add']").validate({
    rules: {
      entity_name: "required",
      address: "required",
      country: "required",
      contact_name: "required",
      contact_title: "required",
      phn_no: "required",
      email: "required",
    },

    messages: {
      ex_method_name: "This is required field please fill it",
      entity_name: "This is required field please fill it",
      address: "This is required field please fill it",
      country: "This is required field please fill it",
      contact_name: "This is required field please fill it",
      contact_title: "This is required field please fill it",
      phn_no: "This is required field please fill it",
      email: "This is required field please fill it",
    },
  });
  $("form[name='manufacture_Add']").validate({
    rules: {
      entity_name: "required",
      address: "required",
      country: "required",
      contact_name: "required",
      contact_title: "required",
      phn_no: "required",
      email: "required",
      department: "required",
    },

    messages: {
      ex_method_name: "This is required field please fill it",
      entity_name: "This is required field please fill it",
      address: "This is required field please fill it",
      country: "This is required field please Select it",
      contact_name: "This is required field please fill it",
      contact_title: "This is required field please fill it",
      phn_no: "This is required field please fill it",
      email: "This is required field please fill it",
      department: "This is required field please fill it",
    },
  });
  $("form[name='licensee_customer_Addd']").validate({
    rules: {
      entity_name: "required",
      address: "required",
      country: "required",
      contact_name: "required",
      contact_title: "required",
      phn_no: "required",
      email: "required",
    },

    messages: {
      ex_method_name: "This is required field please fill it",
      entity_name: "This is required field please fill it",
      address: "This is required field please fill it",
      country: "This is required field please Select it",
      contact_name: "This is required field please fill it",
      contact_title: "This is required field please fill it",
      phn_no: "This is required field please fill it",
      email: "This is required field please fill it",
    },
  });
  $("form[name='factory_Add']").validate({
    rules: {
      entity_name: "required",
      address: "required",
      country: "required",
      contact_name: "required",
      contact_title: "required",
      phn_no: "required",
      email: "required",
      department: "required",
    },

    messages: {
      ex_method_name: "This is required field please fill it",
      entity_name: "This is required field please fill it",
      address: "This is required field please fill it",
      country: "This is required field please Select it",
      contact_name: "This is required field please fill it",
      contact_title: "This is required field please fill it",
      phn_no: "This is required field please fill it",
      email: "This is required field please fill it",
      department: "This is required field please fill it",
    },
  });

  // setting base url and tokken

  $(document).on("change", "#gmark_customer_list", function () {
    var id = $(this).val();
    applicant_details_set(id);
  });

  $(document).on("change", "#gmark_customer_list_manu", function () {
    var id = $(this).val();
    manufacture_details(id);
  });

  $(document).on("change", "#gmark_customer_list_licc", function () {
    var id = $(this).val();
    licc_details(id);
  });

  // submit application by ajax
  $(".add_application_submit").on("click", function () {
    var validation = $("form[name='submit_application']").valid();
    if (validation == true) {
      var app_name = $(".application_name").val();
      var app_desc = $(".application_desc").val();
      $.ajax({
        type: "ajax",
        async: true,
        dataType: "json",
        url: base_url + "Gmark/add_application",
        method: "POST",
        data: {
          app_name: app_name,
          app_desc: app_desc,
          _tokken: _tokken,
        },
        success: function (result) {
          // var data = $.parseJSON(result);
          if (result.errors) {
            $(".application_errors").html(result.errors);
          }
          if (result.status > 0) {
            iziToast.success({
              title: 'success',
              message: 'Application added successfully',
              position: 'topRight'
            });
            $("#add_application").modal("hide");
            $(".application_name").val("");
            $(".application_desc").val("");
            applicationDropdown();
          } else {
            iziToast.info({
              title: 'ERROR',
              message: result.msg,
              position: 'topRight'
            });
          }
        },
        error: function () {
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
        message: 'Please fill all fields',
        position: 'topRight'
      });
    }
  });

  $(".add_submit").on("submit", function (e) {
    e.preventDefault();
  });

  // laboratory ajax for submit start

  $(".add_laboratory_submit").on("click", function () {
    var validation = $("form[name='submit_lab']").valid();
    if (validation == true) {
      var lab_name = $(".lab_name").val();
      var lab_desc = $(".lab_desc").val();
      $.ajax({
        url: base_url + "Gmark/add_lab",
        method: "POST",
        data: {
          lab_name: lab_name,
          lab_desc: lab_desc,
          _tokken: _tokken,
        },
        success: function (result) {
          var data = $.parseJSON(result);

          if (data.status > 0) {
            iziToast.success({
              title: 'SUCCESS',
              message: data.msg,
              position: 'topRight'
            });
            $("#add_laboratory").modal("hide");
            $(".lab_name").val("");
            $(".lab_desc").val("");
            laboratoryDropdown();
          } else {
            iziToast.error({
              title: 'ERROR',
              message: data.msg,
              position: 'topRight'
            });
          }
          if (data.errors) {
            $("#p_lab").html(data.errors);
          } else {
            $("#p_lab").html("");
          }
        },
        error: function () {
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
        message: 'Please fill all fields',
        position: 'topRight'
      });
    }
  });
  $(".sub_laboratory_submit").on("click", function () {
    var validation = $("form[name='Sub_submit_lab']").valid();
    if (validation == true) {
      $.ajax({
        url: base_url + "Gmark/add_sub_lab",
        method: "POST",
        data: $("#sub_lab").serialize(),
        success: function (result) {
          var data = $.parseJSON(result);

          if (data.status > 0) {
            iziToast.success({
              title: 'SUCCESS',
              message: data.msg,
              position: 'topRight'
            });
            $("#sub_add_laboratory").modal("hide");
            $(".lab_name").val("");
            $(".lab_desc").val("");
            laboratoryDropdown();
          } else {
            iziToast.error({
              title: 'ERROR',
              message: data.msg,
              position: 'topRight'
            });
          }
          if (data.errors) {
            $("#p_sub_lab").html(data.errors);
          } else {
            $("#p_sub_lab").html("");
          }
        },
        error: function () {
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
        message: 'Please fill all fields',
        position: 'topRight'
      });
    }
  });
  $(".add_laboratory").on("submit", function (e) {
    e.preventDefault();
  });
  $(document).on("change", ".add_laboratory_type", function () {
    SublaboratoryDropdown($(this).val(), null);
  });
  $(".add_entity_submit").on("click", function () {
    var validation = $("form[name='submit_legal_entity']").valid();
    if (validation == true) {
      var legal_entity_name = $(".legal_entity_name").val();
      var legal_entity_desc = $(".legal_entity_desc").val();
      $.ajax({
        url: base_url + "Gmark/add_legal_entity",
        method: "POST",
        data: {
          legal_entity_name: legal_entity_name,
          legal_entity_desc: legal_entity_desc,
          _tokken: _tokken,
        },
        success: function (result) {
          var data = $.parseJSON(result);
          if (data.status > 0) {
            iziToast.success({
              title: 'SUCCESS',
              message: data.msg,
              position: 'topRight'
            });
            $("#add_legal_entity").modal("hide");
            $(".legal_entity_name").val("");
            $(".legal_entity_desc").val("");
            legal_entityDropdown();
          } else {
            iziToast.error({
              title: 'ERROR',
              message: data.msg,
              position: 'topRight'
            });
          }
          if (data.errors) {
            $(".legal_entity_error").html(data.errors);
          } else {
            $(".legal_entity_error").html("");
          }
        },
        error: function () {
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
        message: 'Please fill all fields',
        position: 'topRight'
      });
    }
  });
  $(".add_legal_class").on("submit", function (e) {
    e.preventDefault();
  });
  // add examination method
  $(".add_ex_submit").on("click", function () {
    var validation = $("form[name='submit_ex_method']").valid();
    if (validation == true) {
      var ex_method_name = $(".ex_method_name").val();
      var ex_method_desc = $(".ex_method_desc").val();
      $.ajax({
        url: base_url + "Gmark/add_ex_method",
        method: "POST",
        data: {
          ex_method_name: ex_method_name,
          ex_method_desc: ex_method_desc,
          _tokken: _tokken,
        },
        success: function (result) {
          var data = $.parseJSON(result);
          if (data.status > 0) {
            iziToast.success({
              title: 'SUCCESS',
              message: data.msg,
              position: 'topRight'
            });
            $("#add_ex_method").modal("hide");
            $(".ex_method_name").val("");
            $(".ex_method_desc").val("");
            ex_method_dropdown();
          } else {
            iziToast.error({
              title: 'ERROR',
              message: data.msg,
              position: 'topRight'
            });
          }
          if (data.errors) {
            $(".ex_method_error").html(data.errors);
          } else {
            $(".ex_method_error").html("");
          }
        },
        error: function () {
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
        message: 'Please fill all fields',
        position: 'topRight'
      });
    }
  });
  // CUSTOMER FORM ADD
  $(".customer_add").on("click", function () {
    var validation = $("form[name='customer_add']").valid();
    if (validation == true) {
      $.ajax({
        url: base_url + "Gmark/customer_Add",
        method: "POST",
        data: $("#customer_Addd").serialize(),
        success: function (result) {
          var data = $.parseJSON(result);
          if (data.status > 0) {
            iziToast.success({
              title: 'SUCCESS',
              message: data.msg,
              position: 'topRight'
            });
            $("#applicant_add").modal("hide");
            $("form[name='customer_add']").trigger("reset");
            customer_list(".gmark_customer_list", null);
          } else {
            iziToast.error({
              title: 'ERROR',
              message: data.msg,
              position: 'topRight'
            });
          }
          if (data.errors) {
            $(".error_custmer_add").html(data.errors);
          } else {
            $(".error_custmer_add").html("");
          }
        },
        error: function () {
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
        message: 'Please fill all fields',
        position: 'topRight'
      });
    }
  });
  $(".licensee_customer_Addd").on("click", function () {
    var validation = $("form[name='licensee_customer_Addd']").valid();
    if (validation == true) {
      $.ajax({
        url: base_url + "Gmark/customer_Add",
        method: "POST",
        data: $("#licensee_customer_Addd").serialize(),
        success: function (result) {
          var data = $.parseJSON(result);
          if (data.status > 0) {
            iziToast.success({
              title: 'SUCCESS',
              message: data.msg,
              position: 'topRight'
            });
            $("#licensee_add").modal("hide");
            $("form[name='licensee_customer_Addd']").trigger("reset");
            customer_list("#gmark_customer_list_licc", null);
          } else {
            iziToast.error({
              title: 'ERROR',
              message: data.msg,
              position: 'topRight'
            });
          }
          if (data.errors) {
            $(".error_licensee_customer_Addd").html(data.errors);
          } else {
            $(".error_licensee_customer_Addd").html("");
          }
        },
        error: function () {
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
        message: 'Please fill all fields',
        position: 'topRight'
      });
    }
  });
  $(".manufacture_customer_Addd").on("click", function () {
    var validation = $("form[name='manufacture_Add']").valid();
    if (validation == true) {
      $.ajax({
        url: base_url + "Gmark/customer_Add",
        method: "POST",
        data: $("#manufacture_Add").serialize(),
        success: function (result) {
          var data = $.parseJSON(result);
          if (data.status > 0) {
            iziToast.success({
              title: 'SUCCESS',
              message: data.msg,
              position: 'topRight'
            });
            $("#manufacture_Add_modal").modal("hide");
            $("form[name='manufacture_Add']").trigger("reset");
            customer_list(".gmark_customer_list_manu", null);
          } else {
            iziToast.error({
              title: 'ERROR',
              message: data.msg,
              position: 'topRight'
            });
          }
          if (data.errors) {
            $(".error_licensee_customer_Addd").html(data.errors);
          } else {
            $(".error_licensee_customer_Addd").html("");
          }
        },
        error: function () {
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
        message: 'Please fill all fields',
        position: 'topRight'
      });
    }
  });
  $(".factory_customer_Addd").on("click", function () {
    var validation = $("form[name='factory_Add']").valid();
    if (validation == true) {
      $.ajax({
        url: base_url + "Gmark/customer_Add",
        method: "POST",
        data: $("#factory_Add").serialize(),
        success: function (result) {
          var data = $.parseJSON(result);
          if (data.status > 0) {
            iziToast.success({
              title: 'SUCCESS',
              message: data.msg,
              position: 'topRight'
            });
            $("#factory_Add_modal").modal("hide");
            $("form[name='factory_Add']").trigger("reset");
            customer_list(".gmark_customer_list_factory", null);
          } else {
            iziToast.error({
              title: 'ERROR',
              message: data.msg,
              position: 'topRight'
            });
          }
          if (data.errors) {
            $(".error_licensee_customer_Addd").html(data.errors);
          } else {
            $(".error_licensee_customer_Addd").html("");
          }
        },
        error: function () {
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
        message: 'Please fill all fields',
        position: 'topRight'
      });
    }
  });

  $(".add_ex_class").on("submit", function (e) {
    e.preventDefault();
  });
  var form_submit = 1;
  $("#regForm").on("submit", function (e) {
    e.preventDefault();
    if (form_submit == 1) {      
      $.ajax({
        url: base_url + "Gmark/edit_submit_gmark_registration",
        method: "POST",
        data: $(this).serialize(),
        success: function (result) {
          var data = $.parseJSON(result);
          if (data.status > 0) {
            iziToast.success({
              title: 'SUCCESS',
              message: data.msg,
              position: 'topRight'
            });
            form_submit = 1;
            setTimeout(function () {
              location.href = base_url + "Gmark";
            }, 5000);
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
        error: function () {
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

  // setting examination method type into dropdown
});
var base_url = document.querySelector("body").getAttribute("data-url");
var _tokken = $('meta[name="_tokken"]').attr("content");
function applicationDropdown(selected) {
  $.ajax({
    url: base_url + "Gmark/get_application",
    method: "POST",
    data: {
      _tokken: _tokken,
    },
    success: function (result) {
      var data = $.parseJSON(result);
      if (data) {
        $(".application_type").html("");
        $(".application_type").append(
          $(
            '<option value="" selected disabled>Select Type of application</option>'
          )
        );
        if (selected) {
          $.each(data, function (index, value) {
            if (selected == value.application_id) {
              $(".application_type").append(
                $(
                  '<option selected value="' +
                    value.application_id +
                    '">' +
                    value.application_name +
                    "</option>"
                )
              );
            } else {
              $(".application_type").append(
                $(
                  '<option value="' +
                    value.application_id +
                    '">' +
                    value.application_name +
                    "</option>"
                )
              );
            }
          });
        } else {
          $.each(data, function (index, value) {
            $(".application_type").append(
              $(
                '<option value="' +
                  value.application_id +
                  '">' +
                  value.application_name +
                  "</option>"
              )
            );
          });
        }
      }
    },
  });
}
function laboratoryDropdown(selected) {
  $.ajax({
    url: base_url + "Gmark/get_lab",
    method: "POST",
    data: {
      _tokken: _tokken,
    },
    success: function (result) {
      var data = $.parseJSON(result);
      if (data) {
        $(".add_laboratory_type").html("");
        $(".add_laboratory_type").append(
          $('<option value="" selected disabled>Select laboratory</option>')
        );
        if (selected) {
          $.each(data, function (index, value) {
            if (selected == value.lab_id) {
              $(".add_laboratory_type").append(
                $(
                  '<option selected value="' +
                    value.lab_id +
                    '">' +
                    value.lab_name +
                    "</option>"
                )
              );
            } else {
              $(".add_laboratory_type").append(
                $(
                  '<option value="' +
                    value.lab_id +
                    '">' +
                    value.lab_name +
                    "</option>"
                )
              );
            }
          });
        } else {
          $.each(data, function (index, value) {
            $(".add_laboratory_type").append(
              $(
                '<option value="' +
                  value.lab_id +
                  '">' +
                  value.lab_name +
                  "</option>"
              )
            );
          });
        }
      }
    },
  });
}
function SublaboratoryDropdown(lab_id, selected) {
  $.ajax({
    url: base_url + "Gmark/get_sub_lab",
    method: "POST",
    data: {
      lab_id: lab_id,
      _tokken: _tokken,
    },
    success: function (result) {
      var data = $.parseJSON(result);
      if (data) {
        $(".subcontracted").html("");
        $(".subcontracted").append(
          $('<option value="" selected disabled>Select laboratory</option>')
        );
        if (selected) {
          $.each(data, function (index, value) {
            if (selected == value.Sub_lab_id) {
              $(".subcontracted").append(
                '<option selected value="' +
                  value.Sub_lab_id +
                  '">' +
                  value.Sub_lab_name +
                  "</option>"
              );
            } else {
              $(".subcontracted").append(
                $("<option>", {
                  value: value.Sub_lab_id,
                  text: value.Sub_lab_name,
                })
              );
            }
          });
        } else {
          $.each(data, function (index, value) {
            $(".subcontracted").append(
              $("<option>", {
                value: value.Sub_lab_id,
                text: value.Sub_lab_name,
              })
            );
          });
        }
      }
    },
  });
}
function legal_entityDropdown(selected) {
  $.ajax({
    url: base_url + "Gmark/get_legal_entity",
    method: "POST",
    data: {
      _tokken: _tokken,
    },
    success: function (result) {
      var data = $.parseJSON(result);
      if (data) {
        $(".legal_entity_type").html("");
        $(".legal_entity_type").append(
          $('<option value=""  disabled>Select entity type</option>')
        );
        if (selected) {
          $.each(data, function (index, value) {
            if (selected == value.legal_entity_id) {
              $(".legal_entity_type").append(
                $(
                  '<option selected value="' +
                    value.legal_entity_id +
                    '">' +
                    value.legal_entity_name +
                    "</option>"
                )
              );
            } else {
              $(".legal_entity_type").append(
                $(
                  '<option value="' +
                    value.legal_entity_id +
                    '">' +
                    value.legal_entity_name +
                    "</option>"
                )
              );
            }
          });
        } else {
          $.each(data, function (index, value) {
            $(".legal_entity_type").append(
              $(
                '<option value="' +
                  value.legal_entity_id +
                  '">' +
                  value.legal_entity_name +
                  "</option>"
              )
            );
          });
        }
      }
    },
  });
}
function licc_details(id) {
  $.ajax({
    method: "POST",
    url: base_url + "Gmark/get_customer_details",
    data: {
      customer_id: id,
      _tokken: _tokken,
    },
    success: function (data) {
      var html = $.parseJSON(data);
      if (html) {
        var data =
          '<div class="row"><div class="col-sm-4 p-2"><label for="mf_addr">Address:</span></label></div><div class="col-sm-8 p-2"><textarea readonly class="form-control form-control-sm mf_addr mendatory" id="" cols="30" rows="3">' +
          html.address +
          '</textarea></div></div><div class="row"><div class="col-sm-4 p-2"><label for="mf_country">Country:</label></div><div class="col-sm-8 p-2"><select disabled="true" class="form-control form-control-sm country_list_append_licensee mendatory" id=""></select></div></div><div class="row"><div class="col-sm-4 p-2"><label for="addr"><u><b>Contact details:</b></u></span></label></u></div></div><div class="row"><div class="col-sm-4 p-2"><label for="mf_name">Name:</span></label></div><div class="col-sm-8 p-2"><input readonly class="form-control form-control-sm mf_name mendatory" type="text" value="' +
          html.contact_name +
          '"  id=""></div></div><div class="row"><div class="col-sm-4 p-2"><label for="mf_title">Title:</span></label></div><div class="col-sm-8 p-2"><input readonly class="form-control form-control-sm mf_title mendatory" value="' +
          html.contact_title +
          '" type="text" id=""></div></div><div class="row"><div class="col-sm-4 p-2"><label for="mf_mob">Telephone number:</span></label></div><div class="col-sm-8 p-2"><input readonly class="form-control form-control-sm mf_mob mendatory" type="number" value="' +
          html.phn_no +
          '" id=""></div></div><div class="row"><div class="col-sm-4 p-2"><label for="mf_email">Email Address:</span></label></div><div class="col-sm-8 p-2"><input readonly class="form-control form-control-sm mf_email mendatory" type="email" value="' +
          html.email +
          '" id=""></div></div>';
        $("#licensee_html").html(data);
        setTimeout(function () {
          country_list(".country_list_append_licensee", html.country);
        }, 500);
      }
    },
  });
}
function checkValue(value, arr) {
  var status = 0;

  for (var i = 0; i < arr.length; i++) {
    var name = arr[i];
    if (name == value) {
      status = 1;
      break;
    }
  }

  return status;
}
function destination(country_id, selected) {
  $.ajax({
    method: "POST",
    url: base_url + "Gmark/get_country",
    data: {
      country_id: country_id,
      _tokken: _tokken,
    },
    success: function (data) {
      html = $.parseJSON(data);
      $(".destination").html("");
      if (selected) {
        $.each(html, function (index, value) {
          if (checkValue(value.country_id, selected) > 0) {
            $(".destination").append(
              $(
                '<input checked type="checkbox" name="destination[]" value="' +
                  value.country_id +
                  '"> ' +
                  value.country_name +
                  "  </input>"
              )
            );
          } else {
            $(".destination").append(
              $(
                '<input type="checkbox" name="destination[]" value="' +
                  value.country_id +
                  '"> ' +
                  value.country_name +
                  "  </input>"
              )
            );
          }
        });
      } else {
        $.each(html, function (index, value) {
          $(".destination").append(
            $(
              '<input type="checkbox" name="destination[]" value="' +
                value.country_id +
                '"> ' +
                value.country_name +
                "  </input>"
            )
          );
        });
      }
    },
  });
}
function customer_list(class_set, selected) {
  $.ajax({
    method: "POST",
    url: base_url + "Gmark/get_customer",
    data: {
      _tokken: _tokken,
    },
    success: function (data) {
      html = $.parseJSON(data);
      $(class_set).html('<option value="" >PLEASE SELECT</option>');
      $.each(html, function (index, value) {
        if (selected) {
          if (selected == value.customers_id) {
            $(class_set).append(
              '<option selected value="' +
                value.customers_id +
                '" >' +
                value.entity_name +
                "</option>"
            );
          } else {
            $(class_set).append(
              $("<option>", {
                value: value.customers_id,
                text: value.entity_name,
              })
            );
          }
        } else {
          $(class_set).append(
            $("<option>", {
              value: value.customers_id,
              text: value.entity_name,
            })
          );
        }
      });
    },
  });
}
function country_list(id_set, params) {
  $.ajax({
    method: "POST",
    url: base_url + "Gmark/fetch_country",
    data: {
      _tokken: _tokken,
    },
    success: function (data) {
      html = $.parseJSON(data);
      $(id_set).html('<option value="0">SELECT COUNTRY </option>');
      $.each(html, function (index, value) {
        if (params) {
          if (params == value.country_id) {
            $(id_set).append(
              '<option selected value="' +
                value.country_id +
                '">' +
                value.country_name +
                "</option>"
            );
          } else {
            $(id_set).append(
              $("<option>", {
                value: value.country_id,
                text: value.country_name,
              })
            );
          }
        } else {
          $(id_set).append(
            $("<option>", {
              value: value.country_id,
              text: value.country_name,
            })
          );
        }
      });
    },
  });
}
function manufacture_details(id) {
  $.ajax({
    method: "POST",
    url: base_url + "Gmark/get_customer_details",
    data: {
      customer_id: id,
      _tokken: _tokken,
    },
    success: function (data) {
      var html = $.parseJSON(data);
      if (html) {
        var data =
          '<div class="row"><div class="col-sm-4 p-2"><label for="mf_addr">Address:</span></label></div><div class="col-sm-8 p-2"><textarea readonly class="form-control form-control-sm mf_addr mendatory" id="" cols="30" rows="3">' +
          html.address +
          '</textarea></div></div><div class="row"><div class="col-sm-4 p-2"><label for="mf_country">Country:</label></div><div class="col-sm-8 p-2"><select disabled="true" class="form-control form-control-sm country_list_append_manufacture mendatory" id=""></select></div></div><div class="row"><div class="col-sm-4 p-2"><label for="addr"><u><b>Contact details:</b></u></span></label></u></div></div><div class="row"><div class="col-sm-4 p-2"><label for="mf_name">Name:</span></label></div><div class="col-sm-8 p-2"><input readonly class="form-control form-control-sm mf_name mendatory" type="text" value="' +
          html.contact_name +
          '"  id=""></div></div><div class="row"><div class="col-sm-4 p-2"><label for="mf_title">Title:</span></label></div><div class="col-sm-8 p-2"><input readonly class="form-control form-control-sm mf_title mendatory" value="' +
          html.contact_title +
          '" type="text" id=""></div></div><div class="row"><div class="col-sm-4 p-2"><label for="mf_department">Department:</span></label></div><div class="col-sm-8 p-2"><input readonly class="form-control form-control-sm mf_dept mendatory" type="text" value="' +
          html.department +
          '" id=""></div></div><div class="row"><div class="col-sm-4 p-2"><label for="mf_mob">Telephone number:</span></label></div><div class="col-sm-8 p-2"><input readonly class="form-control form-control-sm mf_mob mendatory" type="number" value="' +
          html.phn_no +
          '" id=""></div></div><div class="row"><div class="col-sm-4 p-2"><label for="mf_email">Email Address:</span></label></div><div class="col-sm-8 p-2"><input readonly class="form-control form-control-sm mf_email mendatory" type="email" value="' +
          html.email +
          '" id=""></div></div>';
        $("#manufacture_html").html(data);
        setTimeout(function () {
          country_list(".country_list_append_manufacture", html.country);
        }, 500);
      }
    },
  });
}
function ex_method_dropdown(selected) {
  $.ajax({
    url: base_url + "Gmark/get_ex_method",
    method: "POST",
    data: {
      _tokken: _tokken,
    },
    success: function (result) {
      var data = $.parseJSON(result);
      if (data) {
        $(".examination_mtd").html("");
        $(".examination_mtd").append(
          $('<option value="" disabled>Examinations method:</option>')
        );
        if (selected) {
          console.log(selected);
          $.each(data, function (index, value) {
            if (selected == value.ex_method_id) {
              $(".examination_mtd").append(
                $(
                  '<option selected value="' +
                    value.ex_method_id +
                    '">' +
                    value.ex_method_name +
                    "</option>"
                )
              );
            } else {
              $(".examination_mtd").append(
                $(
                  '<option value="' +
                    value.ex_method_id +
                    '">' +
                    value.ex_method_name +
                    "</option>"
                )
              );
            }
          });
        } else {
          $.each(data, function (index, value) {
            $(".examination_mtd").append(
              $(
                '<option value="' +
                  value.ex_method_id +
                  '">' +
                  value.ex_method_name +
                  "</option>"
              )
            );
          });
        }
      }
    },
  });
}
function applicant_details_set(id) {
  $.ajax({
    method: "POST",
    url: base_url + "Gmark/get_customer_details",
    data: {
      customer_id: id,
      _tokken: _tokken,
    },
    success: function (data) {
      var html = $.parseJSON(data);
      if (html) {
        var data =
          '<div class="row"><div class="col-sm-4 p-2"><label for="mf_addr">Address:</span></label></div><div class="col-sm-8 p-2"><textarea readonly class="form-control form-control-sm mf_addr mendatory" id="" cols="30" rows="3">' +
          html.address +
          '</textarea></div></div><div class="row"><div class="col-sm-4 p-2"><label for="mf_country">Country:</label></div><div class="col-sm-8 p-2"><select disabled="true" class="form-control form-control-sm country_list_append_applicant mendatory" id=""></select></div></div><div class="row"><div class="col-sm-4 p-2"><label for="addr"><u><b>Contact details:</b></u></span></label></u></div></div><div class="row"><div class="col-sm-4 p-2"><label for="mf_name">Name:</span></label></div><div class="col-sm-8 p-2"><input readonly class="form-control form-control-sm mf_name mendatory" type="text" value="' +
          html.contact_name +
          '"  id=""></div></div><div class="row"><div class="col-sm-4 p-2"><label for="mf_title">Title:</span></label></div><div class="col-sm-8 p-2"><input readonly class="form-control form-control-sm mf_title mendatory" value="' +
          html.contact_title +
          '" type="text" id=""></div></div><div class="row"><div class="col-sm-4 p-2"><label for="mf_department">Department:</span></label></div><div class="col-sm-8 p-2"><input readonly class="form-control form-control-sm mf_dept mendatory" type="text" value="' +
          html.department +
          '" id=""></div></div><div class="row"><div class="col-sm-4 p-2"><label for="mf_mob">Telephone number:</span></label></div><div class="col-sm-8 p-2"><input readonly class="form-control form-control-sm mf_mob mendatory" type="number" value="' +
          html.phn_no +
          '" id=""></div></div><div class="row"><div class="col-sm-4 p-2"><label for="mf_email">Email Address:</span></label></div><div class="col-sm-8 p-2"><input readonly class="form-control form-control-sm mf_email mendatory" type="email" value="' +
          html.email +
          '" id=""></div></div>';
        $("#applicant_deials_html").html(data);
        setTimeout(function () {
          country_list(".country_list_append_applicant", html.country);
        }, 500);
      }
    },
  });
}
function signatory(params) {
  $.ajax({
    url: base_url + "Gmark/user_signatory",
    method: "POST",
    data: {_tokken:_tokken},
    success: function (result) {
      var data = $.parseJSON(result);
      if (data) {
        $(".user_signatory").html('<option value=""> SELECT SIGNATORY </option>');
          $.each(data,function(i,v){
            if (params) {
                if (params == v.id) {
                  $(".user_signatory").append($('<option selected value="' +v.id + '">' + v.name + "</option>"));
                } else {
                  $(".user_signatory").append($('<option value="' +v.id + '">' + v.name + "</option>"));
                }
            } else {
              $(".user_signatory").append($('<option value="' +v.id + '">' + v.name + "</option>"));
            }
          }); 
      }
    },error:function(e){
      console.warn(e);
    }
  });
}
function count_factory(params, array) {
  var addForm = $(".parent").html();
  for (let index = 1; index < params; index++) {
    $(".more_factory_data").append(addForm);
  }
  var i = 0;
  $(".gmark_customer_list_factory").map(function () {
    if ($(this).parents("div.parent").length == 0 && !$(this).val()) {
      customer_list(".intro" + i, array[i]);
      $(this).addClass("intro" + i);
    }
    i++;
  });
}
