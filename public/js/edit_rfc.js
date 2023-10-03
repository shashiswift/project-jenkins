$(document).ready(function () {
  const base_url = $("body").attr("data-url");
  const _tokken = $('meta[name="_tokken"]').attr("content");
  customer_list(".gmark_customer_list", "");
  country_list(".country_list", "");
  var product_count = $(".product tbody tr").length;
  currency();
  $(".add-row").click(function () {
    var dumy_tr =
      '<tr ><td><textarea  name="product_con[' +
      product_count +
      '][hs_code]" class="form-control"></textarea></td><td><textarea  name="product_con[' +
      product_count +
      '][product]" class="form-control"></textarea></td><td><textarea  name="product_con[' +
      product_count +
      '][trade_mark]" class="form-control"></textarea></td><td><textarea  name="product_con[' +
      product_count +
      '][mode_type_ref]" class="form-control"></textarea></td><td><textarea  name="product_con[' +
      product_count +
      '][technical_details]" class="form-control"></textarea></td><td><input type="checkbox" name="record"></td></tr>';

    $(".product tbody").append(dumy_tr);
    product_count++;
  });

  $(".delete-row").on("click", function () {
    $(".product tbody")
      .find('input[name="record"]')
      .each(function () {
        if ($(this).is(":checked")) {
          $(this).parents("tr").remove();
        }
      });
  });

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
              title: "SUCCESS",
              message: data.msg,
              position: "topRight",
            });
            $("#applicant_add").modal("hide");
            $("form[name='customer_add']").trigger("reset");
            customer_list(".gmark_customer_list", "");
          } else {
            iziToast.error({
              title: "ERROR",
              message: data.msg,
              position: "topRight",
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
            title: "ERROR",
            message: "Something went wrong",
            position: "topRight",
          });
        },
      });
    } else {
      iziToast.error({
        title: "ERROR",
        message: "Please fill all fields",
        position: "topRight",
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
              title: "SUCCESS",
              message: data.msg,
              position: "topRight",
            });
            $("#manufacture_Add_modal").modal("hide");
            $("form[name='manufacture_Add']").trigger("reset");
            customer_list(".gmark_customer_list", "");
          } else {
            iziToast.error({
              title: "ERROR",
              message: data.msg,
              position: "topRight",
            });
          }
          if (data.errors) {
            $(".error_manufacture_Add").html(data.errors);
          } else {
            $(".error_manufacture_Add").html("");
          }
        },
        error: function () {
          iziToast.error({
            title: "ERROR",
            message: "Something went wrong",
            position: "topRight",
          });
        },
      });
    } else {
      iziToast.error({
        title: "ERROR",
        message: "Please fill all fields",
        position: "topRight",
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
              title: "SUCCESS",
              message: data.msg,
              position: "topRight",
            });
            $("#factory_Add_modal").modal("hide");
            $("form[name='factory_Add']").trigger("reset");
            customer_list(".gmark_customer_list", "");
          } else {
            iziToast.error({
              title: "ERROR",
              message: data.msg,
              position: "topRight",
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
            title: "ERROR",
            message: "Something went wrong",
            position: "topRight",
          });
        },
      });
    } else {
      iziToast.error({
        title: "ERROR",
        message: "Please fill all fields",
        position: "topRight",
      });
    }
  });

  $(".shipment_method").on("click", () => {
    var radio = $("input[name='shipment_method']:checked").val();
    if (radio == "OTHER") {
      $(".shipment_method_desc").fadeIn();
    } else {
      $(".shipment_method_desc").fadeOut();
    }
  });
  $(".packing_details").on("click", () => {
    var radio = $("input[name='packing_details']:checked").val();
    if (radio == "X 20'FCL" || radio == "X 40'FCL") {
      $(".x-40").fadeIn();
    } else {
      $(".packing_details_desc").fadeOut();
    }
  });
  $(".iso_accredition").on("click", () => {
    var radio = $("input[name='iso_17025_accredition']:checked").val();
    if (radio == "OTHER") {
      $(".iso_accredition_other").fadeIn();
    } else {
      $(".iso_accredition_other").fadeOut();
    }
  });
  $(".shipment_method_desc").fadeOut();
  $(".packing_details_desc").fadeOut();
  $(".iso_accredition_other").fadeOut();
  var form_submit_rfc = 1;
  $(document).on("submit", ".rfc_form", function (e) {
    $('body').append('<div class="pageloader"></div>');
    e.preventDefault();
    if (form_submit_rfc == 1) {
      // form_submit_rfc++;
      $.ajax({
        method: "POST",
        url: base_url + "Gmark/submit_edit_rfc",
        data: $(this).serialize(),
        success: function (data) {
          $('.pageloader').remove();
          $('.error_remove').remove();
          data = $.parseJSON(data);
          if (data.status > 0) {
            iziToast.success({
              title: "SUCCESS",
              message: data.msg,
              position: "topRight",
            });
            setTimeout(function () {
              location.href = base_url + "Gmark/";
            }, 1000);
          } else {
            iziToast.error({
              title: "ERROR",
              message: data.msg,
              position: "topRight",
            });
          }
          if (data.errors) {
            $.each(data.errors,function(i,v){
              $(".rfc_form select[name='"+i+"']").after('<span class="error_remove text-danger">'+v+'</span>');
              $(".rfc_form input[name='"+i+"']").after('<span class="error_remove text-danger">'+v+'</span>');
              $(".rfc_form textarea[name='"+i+"']").after('<span class="error_remove text-danger">'+v+'</span>');
            });
            $("#error_rfc").html(data.errors);
          } else {
            $("#error_rfc").html("");
          }
          form_submit = 1;
        },
        error: function (e) {
          $('.pageloader').remove();
          console.log(e);
          form_submit = 1;
          iziToast.error({
            title: "ERROR",
            message: "Something went wrong",
            position: "topRight",
          });
        },
      });
    } else {
      iziToast.error({
        title: "ERROR",
        message: "FORM ALREADY SUBMIT WAIT FOR RESPONSE",
        position: "topRight",
      });
    }
  });
});
const base_url = $("body").attr("data-url");
const _tokken = $('meta[name="_tokken"]').attr("content");
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
function currency(selected){
  $.ajax({
    url: base_url + "Gmark/currency",
        method: "POST",
        data:{_tokken:_tokken},
        success: function (result) {
        var data = $.parseJSON(result);
        if (selected) {
          $.each(data,function(i,v){
            if (selected==v.code) {
              $('.currency').append('<option selected value="'+v.code+'">'+v.name+'</option>');
            } else {
              $('.currency').append($("<option>", {
                value: v.code,
                text: v.name,
              }));
            }
          });
        }else{
          $.each(data,function(i,v){
              $('.currency').append($("<option>", {
                value: v.code,
                text: v.name,
              }));
          });
        }
        },
        error: function (e) {
         console.log(e);
        },
  });
}
