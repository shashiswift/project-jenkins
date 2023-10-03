"use strict";
$(document).ready(function () {



  var _tokken = $('meta[name="_tokken"]').attr("content");

  var base_url = $("body").attr("data-url");

  var pageno = 0;

  var product_count = 1;

  let list_of_url = '';

  let list_of_no = '';






  $(document).on("click", ".content_edit", function () {
    $('#edit_content_upload').trigger('reset');
    var id = $(this).data("id");
    $(".contant_id").val(id);
    $.ajax({
      async: true,
      url: base_url + "Reports/get_content",
      type: "post",
      data: {
        _tokken: _tokken,
        id: id
      },
      success: function (data) {
        $('#edit_content_upload input[name="means_other"]').remove();
        $(".edit_content_report_error").remove();
        var data = $.parseJSON(data);
        if (data) {
          list_of_url = base_url + 'Reports/list_of_contain/' + data.registration_id + '/' + 10 + '/';
          if (data.date_of_issuance) {
            $('#edit_content_upload input[name="date_of_issuance"]').val(
              data.date_of_issuance
            );
          }
          if (data.cab_method) {
            $('#edit_content_upload input[name="cab_method"]').val(
              data.cab_method
            );
          }
          if (data.technical_regulation) {
            $('#edit_content_upload input[name="technical_regulation"]').val(
              data.technical_regulation
            );
          }
          if (data.notify_body) {
            $('#edit_content_upload input[name="notify_body"]').val(
              data.notify_body
            );
          }
          if (data.means_shipping) {
            $('#edit_content_upload select[name="means_shipping"]').val(
              data.means_shipping
            );
            if (data.means_shipping == "OTHER") {
              $('#edit_content_upload select[name="means_shipping"]').after(
                '<input placeholder="ENTER THE VALUE" type="text" name="means_other" value="' +
                data.means_other +
                '" class="form-control form-control-sm mt-2">'
              );
            }
          }

          if (data.shipment_doc) {
            $('#edit_content_upload input[name="shipment_doc"]').val(
              data.shipment_doc
            );
          }
          if (data.pro_name) {
            $('#edit_content_upload input[name="pro_name"]').val(data.pro_name);
          }
          if (data.trade_brand) {
            $('#edit_content_upload input[name="trade_brand"]').val(
              data.trade_brand
            );
          }
          if (data.country_origin) {
            $('#edit_content_upload select[name="country_origin"]').val(
              data.country_origin
            );
          }
          if (data.designation) {
            $('#edit_content_upload textarea[name="designation"]').val(
              data.designation
            );
          }
          if (data.lot_no) {
            $('#edit_content_upload input[name="lot_no"]').val(data.lot_no);
          }
          if (data.standard_applies) {
            var array = data.standard_applies.split(",");
            $.each(array, function (i, v) {
              $('#edit_content_upload select[name="standard_applies"]').val(v);
            });
            // $('#edit_content_upload select[name="standard_applies"]').selectize()[0].selectize.setValue([data.standard_applies]);
          }
          if (data.country_complains) {
            var array = data.country_complains.split(",");
            $('#edit_content_upload input[name="country_complains[]"]').each(function (i, v) {
              if (jQuery.inArray($(this).val(), array) !== -1) {
                $(this).prop("checked", true);
              }
            });
          }
          if (data.file_ref) {
            $('#edit_content_upload input[name="file_ref"]').val(data.file_ref);
          }
          if (data.certified_pro) {
            $('#edit_content_upload textarea[name="certified_pro"]').val(
              data.certified_pro
            );
          }
          if (data.electrical_rating) {
            $('#edit_content_upload textarea[name="electrical_rating"]').val(
              data.electrical_rating
            );
          }
          if (data.invoice_no) {
            $('#edit_content_upload input[name="invoice_no"]').val(
              data.invoice_no
            );
          }
          if (data.inv_date) {
            $('#edit_content_upload input[name="inv_date"]').val(
              data.inv_date
            );
          }
          if (data.report_ref) {
            $('#edit_content_upload textarea[name="report_ref"]').val(
              data.report_ref
            );
          }
          if (data.pro_dimension) {
            $('#edit_content_upload select[name="pro_dimension"]').val(
              data.pro_dimension
            );
          }
          if (data.coc_type) {
            $("#edit_content_upload #coc_type").val(data.coc_type.coc_type);
          }
          if (data.length) {
            $("#edit_content_upload input[name='length']").val(data.length);
          }
          if (data.width) {
            $("#edit_content_upload input[name='width']").val(data.width);
          }
          if (data.height) {
            $("#edit_content_upload input[name='height']").val(data.height);
          }
          $(".product tbody").html("");
          list_of_contain(list_of_url + 1);
        }
      },
      error: function (e) {
        console.log(e);
      },
    });
  });




  $("#dataTable_pagination").on("click", "a", function (e) {
    e.preventDefault();
    list_of_no = $(this).attr("data-ci-pagination-page");
    list_of_contain(list_of_url + list_of_no);
  });




  function list_of_contain(list_of_url) {
    $.ajax({
      async: true,
      url: list_of_url,
      type: "get",
      dataType: "json",
      success: function (response) {
        $("#dataTable_pagination").html(response.pagination);
        $("#dataTable").html(response.result);
      },
    });
  }



  $(document).on('focusout', '.key_update', function (e) {
    var id = $(this).closest('tr').data("id");
    var req = $(this).closest('tr').data("req");
    if (!req) {
      req = $('#report_content_edit .contant_id').val();
    }
    var field = $(this).data('field');
    var value = $(this).val();
   
      update_on_key(id,req,field,value);
    

  });



  function update_on_key(id,req,field,value) {
      $.ajax({
        async: true,
        url: base_url + "Reports/update_report_content",
        type: "post",
        data: {
          _tokken: _tokken,
          id:id,
          req:req,
          field:field,
          value:value
        },
        success: function (data) {
          var data = $.parseJSON(data);
          if (data.status > 0) {
          iziToast.success({
            title: "success",
            message: data.msg,
            position: "topRight",
          });
        }else{
          iziToast.warning({
            title: "success",
            message: data.msg,
            position: "topRight",
          });
        }
        },
        error: function (e) {
          console.log(e);
        },
      });
  }






  $(document).on('click', '.delete_row_list_of_certif', function () {
    var id = $(this).closest('tr').data("id");
    var req = $(this).closest('tr').data("req");
    var self = $(this);
    $.ajax({
      async: true,
      url: base_url+'Reports/update_list_content/'+id+'/'+req,
      type: "get",
      dataType: "json",
      success: function (response) {
        if (response.status>0) {
          iziToast.success({
            title: "success",
            message: response.msg,
            position: "topRight",
          });
          self.closest('tr').remove();
          list_of_contain(list_of_url + list_of_no);
        }else{
          iziToast.warning({
            title: "success",
            message: response.msg,
            position: "topRight",
          });
        }
      },
    });
  });




  $.ajax({
    async: true,
    url: base_url + "Gmark/fetch_country",
    type: "post",
    data: {
      _tokken: _tokken
    },
    success: function (data) {
      var data = $.parseJSON(data);
      if (data) {
        $.each(data, function (i, v) {
          $(".country_list").append(
            $(
              '<option value="' +
              v.country_id +
              '">' +
              v.country_name +
              "</option>"
            )
          );
        });
      }
    },
    error: function (e) {
      console.log(e);
    },
  });





  var country_id = [195, 234, 120, 180, 17, 167, 247];



  $.ajax({
    method: "POST",
    url: base_url + "Gmark/get_country",
    data: {
      country_id: country_id,
      _tokken: _tokken,
    },
    success: function (data) {
      var html = $.parseJSON(data);
      $.each(html, function (index, value) {
        $(".destination").append(
          $('<div class="form-check form-check-inline"><label class="form-check-label"><input class="form-check-input" name="country_complains[]" type="checkbox" id="inlineCheckbox1" value="' + value.country_id + '"> ' + value.country_name + '</label></div>')
        );
      });
    },
  });








  $.ajax({
    async: true,
    url: base_url + "Reports/standard_applies",
    type: "post",
    data: {
      _tokken: _tokken
    },
    success: function (data) {
      var data = $.parseJSON(data);
      if (data) {
        $.each(data, function (i, v) {
          $(".standard_applies").append(
            $('<option value="' + v.id + '">' + v.standard + "</option>")
          );
        });
      }
    },
    error: function (e) {
      console.log(e);
    },
  });










  $(document).on("change", "#excelfile1", function () {
    //Reference the FileUpload element.
    var fileUpload = $("#excelfile1")[0];
    var id = $('#report_content_edit .contant_id').val();
    //Validate whether File is valid Excel file.
    var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.xls|.xlsx)$/;
    if (regex.test(fileUpload.value.toLowerCase())) {
      if (typeof FileReader != "undefined") {
        var reader = new FileReader();

        if (reader.readAsBinaryString) {
          reader.onload = function (e) {
            ProcessExcel(e.target.result, "#dataTable",atob(id));
          };
          reader.readAsBinaryString(fileUpload.files[0]);
        } else {
          //For IE Browser.
          reader.onload = function (e) {
            var data = "";
            var bytes = new Uint8Array(e.target.result);
            for (var i = 0; i < bytes.byteLength; i++) {
              data += String.fromCharCode(bytes[i]);
            }
            ProcessExcel(data, "#dataTable",atob(id));
          };
          reader.readAsArrayBuffer(fileUpload.files[0]);
        }
      } else {
        alert("This browser does not support HTML5.");
      }
    } else {
      alert("Please upload a valid Excel file.");
    }
  });









  $(document).on("change", "#excelfile", function () {
    //Reference the FileUpload element.
    var fileUpload = $("#excelfile")[0];
    var id = $('#report_content_add .contant_id').val();
    //Validate whether File is valid Excel file.
    var regex = /^([a-zA-Z0-9\\.\-:])+(.xls|.xlsx)$/;
    if (regex.test(fileUpload.value.toLowerCase())) {
      if (typeof FileReader != "undefined") {
        var reader = new FileReader();

        if (reader.readAsBinaryString) {
          reader.onload = function (e) {
            ProcessExcel(e.target.result, "#dataTable1",atob(id));
          };
          reader.readAsBinaryString(fileUpload.files[0]);
        } else {
          //For IE Browser.
          reader.onload = function (e) {
            var data = "";
            var bytes = new Uint8Array(e.target.result);
            for (var i = 0; i < bytes.byteLength; i++) {
              data += String.fromCharCode(bytes[i]);
            }
            ProcessExcel(data, "#dataTable1",atob(id));
          };
          reader.readAsArrayBuffer(fileUpload.files[0]);
        }
      } else {
        alert("This browser does not support HTML5.");
      }
    } else {
      alert("Please upload a valid Excel file.");
    }
  });





  function ProcessExcel(data, select,id) {
    //Read the Excel File data.
    var workbook = XLSX.read(data, {
      type: "binary",
    });

    //Fetch the name of First Sheet.
    var firstSheet = workbook.SheetNames[0];

    //Read all rows from First Sheet into an JSON array.
    var excelRows = XLSX.utils.sheet_to_row_object_array(
      workbook.Sheets[firstSheet]
    );
    truncate(id);
      var html = "";
      let chunk = 20;
      for (i = 0; i < excelRows.length; i += chunk) {

        let tempArray;
        tempArray = excelRows.slice(i, i + chunk);
        ajax_product(tempArray, 'insert_record',id);
      }
  }

function truncate(id) {
  $.ajax({
    async: true,
    url: base_url+'Reports/trun_list/'+id,
    type: "get",
    dataType: "json",
    success: function (response) {

    },
  });
}


  function ajax_product(excel, type,id) {
    if (excel) {
      $.ajax({
        async: true,
        url: base_url + "Reports/" + type,
        type: "POST",
        data: {
          _tokken: _tokken,
          id:id,
          data: excel,
        },
        success: function (result) {
          var data = $.parseJSON(result);
          if (data.status > 0) {
            iziToast.success({
              title: "success",
              message: "RECORD SUCCESSFULLY SUBMIT",
              position: "topRight",
            });
          } else {
            iziToast.warning({
              title: "ERROR",
              message: "SOMETHING WRONG",
              position: "topRight",
            });
          }
        },
        error: function (e) {
          console.log(e);
        },
      });
    }
  }



  $(".add-row").click(function () {
    var dumy_tr =
      '<tr ><td><textarea  name="product[' +
      product_count +
      '][description]" class="form-control"></textarea></td><td><textarea  name="product[' +
      product_count +
      '][dimensions]" class="form-control"></textarea></td><td><textarea  name="product[' +
      product_count +
      '][manufacturer]" class="form-control"></textarea></td><td><textarea  name="product[' +
      product_count +
      '][test_report_details]" class="form-control"></textarea></td><td><textarea  name="product[' +
      product_count +
      '][standards]" class="form-control"></textarea></td><td><input type="checkbox" class="record"></td></tr>';

    $(".product tbody").append(dumy_tr);
    product_count++;
  });
  // $(".add-row").click(function () {
  //   var dumy_tr =
  //     '<tr><td><textarea class="form-control form-control-sm key_update" data-field="description" class="form-control"></textarea></td><td><textarea class="form-control form-control-sm key_update" data-field="dimensions" class="form-control"></textarea></td><td><textarea class="form-control form-control-sm key_update" data-field="manufacturer" class="form-control"></textarea></td><td><textarea class="form-control form-control-sm key_update" data-field="test_report_details" class="form-control"></textarea></td><td><textarea class="form-control form-control-sm key_update" data-field="standards" class="form-control"></textarea></td><td><input type="checkbox" class="record"></td></tr>';

  //   $(".product tbody").append(dumy_tr);
  //   product_count++;
  // });






  $(".delete-row").on("click", function () {
    $(".product tbody")
      .find('input[class="record"]')
      .each(function () {
        if ($(this).is(":checked")) {
          $(this).parents("tr").remove();
        }
      });
  });





  $("#gmark_pagination").on("click", "a", function (e) {
    e.preventDefault();
    pageno = $(this).attr("data-ci-pagination-page");
    loadPagination(pageno);
  });




  loadPagination(0);


  $(document).on("click", ".submit_listing", function () {
    pageno = 0;
    loadPagination(pageno);
  });



  $(document).on("click", ".clear_listing", function () {
    $("#listing_filter input").removeAttr('value');
    $("#listing_filter").trigger("reset");
    pageno = 0;
    loadPagination(pageno);
  });




  function loadPagination(pagno) {
    var applicant_id = $(".applicant_id").val() ?
      $(".applicant_id").val() :
      "NULL";
    var manufacture_id = $(".manufacture_id").val() ?
      $(".manufacture_id").val() :
      "NULL";
    var factory_id = $(".factory_id").val() ? $(".factory_id").val() : "NULL";
    var lab_name = $(".lab_name").val() ? $(".lab_name").val() : "NULL";
    var start_Date = $(".start_Date").val() ? $(".start_Date").val() : "NULL";
    var end_Date = $(".end_Date").val() ? $(".end_Date").val() : "NULL";
    var destinaition = $(".destinaition").val() ?
      $(".destinaition").val() :
      "NULL";
    var application = $(".application").val() ?
      $(".application").val() :
      "NULL";
    var search = $(".search").val() ? btoa($(".search").val()) : "NULL";
    $.ajax({
      async: true,
      url: base_url +
        "Reports/report_listing/" +
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
      success: function (response) {
        $("#gmark_pagination").html(response.pagination);
        // console.log(response.result);
        createTable(response.result);
      },
    });
  }




  function createTable(result) {
    $("#gmark_list").empty();
    $("#gmark_list").html(result);
  }




  $(document).on("keyup", ".focusout_autosuggestion", function () {
    var text = $(this).val();
    var self = $(this);
    if (text) {
      $.ajax({
        async: true,
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



  var i = 1;


  let view_sample_images_modal;



  $(document).on("click", ".rear_image", function () {
    var id = $(this).data("id");
    get_images(id);
    view_sample_images_modal = id;
  });





  $(document).on("click", ".upload_image_rear", function () {
    var id = $(this).data("id");
    $(".doc_upload_request").val(id);
  });






  function get_images(id) {
    $.ajax({
      async: true,
      url: base_url + "Reports/get_image",
      type: "post",
      data: {
        _tokken: _tokken,
        registration_id: id
      },
      success: function (data) {
        var data = $.parseJSON(data);
        if (data) {
          iziToast.success({
            title: "success",
            message: "RECORD FOUND",
            position: "topRight",
          });
          if (data) {
            $(".view_products_photo").html(data);
          }
        } else {
          iziToast.warning({
            title: "ERROR",
            message: "RECORD NOT FOUND",
            position: "topRight",
          });
        }
      },
      error: function (e) {
        console.log(e);
      },
    });
  }





  $(document).on("click", ".delete_img_product", function () {
    var id = $(this).data("id");
    $.ajax({
      url: base_url + "Reports/delete_product_image",
      data: {
        id: id,
        _tokken: _tokken
      },
      type: "POST",
      success: function (data) {
        var data = $.parseJSON(data);
        if (data.status > 0) {

          iziToast.success({
            title: "success",
            message: data.msg,
            position: "topRight",
          });
          get_images(view_sample_images_modal);
        } else {
          iziToast.warning({
            title: "ERROR",
            message: data.msg,
            position: "topRight",
          });

        }
      },
      error: function (e) {
        console.log(e);
      },
    });
  });





  var count_upload = 1;
  $(document).on("submit", "#product_upload_image", function (e) {
    e.preventDefault();
    var self = $(this);
    var formData = new FormData(this);
    if (count_upload < 2) {
      count_upload++;
      $('body').append('<div class="pageloader"></div>');
      $(".myprogress").text("0%");
      $(".myprogress").css("width", "0%");
      $.ajax({
        async: true,
        url: base_url + "Reports/image_upload",
        type: "POST",
        processData: false,
        contentType: false,
        data: formData,
        xhr: function () {
          var xhr = new window.XMLHttpRequest();
          xhr.upload.addEventListener(
            "progress",
            function (evt) {
              if (evt.lengthComputable) {
                var percentComplete = evt.loaded / evt.total;
                percentComplete = Math.floor(percentComplete * 100);
                $(".myprogress").text(percentComplete + "%");
                $(".myprogress").animate({
                  width: percentComplete + "%"
                }, {
                  duration: 500
                });
              }
            },
            false
          );
          return xhr;
        },
        success: function (result) {
          $(".error_document_upload").html("");
          $('.pageloader').remove();
          var data = $.parseJSON(result);
          if (data.status > 0) {
            $(".myprogress").text(0 + "%");
            $(".myprogress").css("width", "0%");
            count_upload = 1;
            iziToast.success({
              title: "success",
              message: data.msg,
              position: "topRight",
            });
            $('#report_add button[data-dismiss="modal"]').click();
            self.trigger("reset");
          } else {
            $(".myprogress").text("0%");
            $(".myprogress").css("width", "0%");
            count_upload = 1;
            iziToast.warning({
              title: "ERROR",
              message: data.msg,
              position: "topRight",
            });
          }
          if (data.errors) {
            $(".error_document_upload").html(data.errors);
          }
        },
        error: function (e) {
          $('.pageloader').remove();
          count_upload = 1;
          console.log(e);
        },
      });
    } else {
      iziToast.warning({
        title: "WAIT",
        message: "WAIT FOR UPLOAD",
        position: "topRight",
      });
    }
  });



  $(document).on("click", ".release_document_upload", function () {
    var id = $(this).data("id");
    $('#release_document input[name="registration_id"]').val(id);
  });




  $(document).on("submit", "#release_document_upload", function (e) {
    e.preventDefault();
    var self = $(this);
    var formData = new FormData(this);
    if (count_upload < 2) {
      $("body").append('<div class="pageloader"></div>');
      count_upload++;
      $.ajax({
        async: true,
        url: base_url + "Reports/send_email",
        type: "POST",
        processData: false,
        contentType: false,
        data: formData,
        success: function (result) {
          $(".pageloader").remove();
          $(".error_document_upload").html("");
          var data = $.parseJSON(result);
          if (data.status > 0) {
            count_upload = 1;
            iziToast.success({
              title: "success",
              message: data.msg,
              position: "topRight",
            });
            $('#release_document button[data-dismiss="modal"]').click();
            self.trigger("reset");
          } else {
            count_upload = 1;
            iziToast.warning({
              title: "ERROR",
              message: data.msg,
              position: "topRight",
            });
          }
          if (data.errors) {
            var error = data.errors;
            $(".edit_content_report_error").remove();
            $.each(error, function (i, v) {
              $('#release_document input[name="' + i + '"]').after(
                '<span class="text-danger edit_content_report_error">' +
                v +
                "</span>"
              );
              $('#release_document textarea[name="' + i + '"]').after(
                '<span class="text-danger edit_content_report_error">' +
                v +
                "</span>"
              );
            });
          } else {
            $(".edit_content_report_error").remove();
          }
        },
        error: function (e) {
          $(".pageloader").remove();
          count_upload = 1;
          console.log(e);
        },
      });
    } else {
      iziToast.warning({
        title: "WAIT",
        message: "WAIT FOR UPLOAD",
        position: "topRight",
      });
    }
  });




  $(document).on(
    "change",
    '#report_content_edit select[name="means_shipping"]',
    function () {

      var self = $(this);
      var data = $(this).val();
      if (data == "OTHER") {
        self.after(
          '<input placeholder="ENTER THE VALUE" type="text" name="means_other" value="" class="form-control form-control-sm mt-2">'
        );
      } else {
        self.siblings('input[name="means_other"]').remove();
      }
    }
  );



  $(document).on(
    "change",
    '#content_upload select[name="means_shipping"]',
    function () {
      var self = $(this);
      var data = $(this).val();
      if (data == "OTHER") {
        self.after(
          '<input placeholder="ENTER THE VALUE" type="text" name="means_other" value="" class="form-control form-control-sm mt-2">'
        );
      } else {
        self.siblings('input[name="means_other"]').remove();
      }
    }
  );
  $(document).on("click", ".content_add", function () {
    var id = $(this).data("id");
    $(".contant_id").val(id);
  });



  $(document).on("click", ".qrcode_update", function () {
    var id = $(this).data("id");
    $("#qr_code_upadte_onpdf input[name='registration_id']").val(id);
  });




  $(document).on("submit", "#qr_code_upadte_onpdf", function (e) {
    e.preventDefault();
    var self = $(this);
    var formData = new FormData(this);
    $("body").append('<div class="pageloader"></div>');
    $.ajax({
      async: true,
      url: base_url + "Reports/gmark_code_update",
      type: "POST",
      processData: false,
      contentType: false,
      data: formData,
      success: function (result) {
        $('.pageloader').remove();
        var result = $.parseJSON(result);
        if (result.status > 0) {
          iziToast.success({
            title: "success",
            message: result.msg,
            position: "topRight",
          });
          $('#qr_code_update').modal('hide');
        } else {
          iziToast.warning({
            title: "ERROR",
            message: result.msg,
            position: "topRight",
          });
        }
        loadPagination(pageno);
      },
      error: function (e) {
        console.log(e);
      },
    });
  });



  $(document).on("click", ".re_generate_request", function () {
    var id = $(this).data("id");
    $(".registration_id_regenrate").val(id);
  });
  $(document).on("click", ".release_document_list", function () {
    var id = $(this).data("id");
    $.ajax({
      async: true,
      url: base_url + "Reports/get_release_document",
      type: "post",
      data: {
        id: id,
        _tokken: _tokken
      },
      success: function (data) {
        $(".release_do_view").empty();
        var data = $.parseJSON(data);
        if (data) {
          $.each(data, function (i, v) {
            $(".release_do_view").append(
              '<tr><th scope="row">' +
              (i + 1) +
              "</th><td>" +
              v.document_no +
              "</td><td>" +
              v.user_name +
              "</td><td>" +
              v.created_on +
              '</td><td><a class="btn btn-sm" target="_blank" href="' +
              v.upload_path +
              '">VIEW</a></td></tr>'
            );
          });
        }
      },
      error: function (e) {
        console.log(e);
      },
    });
  });



  $(document).on("click", ".content_edit", function () {
    var id = $(this).data("id");
    $(".contant_id").val(id);
  });
  var content_upload = 1;
  $(document).on("submit", "#content_upload", function (e) {
    var self = $(this);
    e.preventDefault();
    if (content_upload < 2) {
      content_upload++;
      $.ajax({
        async: true,
        url: base_url + "Reports/content_upload",
        type: "post",
        data: $(this).serialize(),
        success: function (data) {
          $("#error_add_content").html("");
          var data = $.parseJSON(data);
          if (data.status > 0) {
            loadPagination(pageno);
            content_upload = 1;
            iziToast.success({
              title: "success",
              message: data.msg,
              position: "topRight",
            });
            $('#report_content_add button[data-dismiss="modal"]').click();
            self.trigger("reset");
          } else {
            content_upload = 1;
            iziToast.warning({
              title: "ERROR",
              message: data.msg,
              position: "topRight",
            });
          }
          if (data.errors) {
            var error = data.errors;
            $(".add_content_report_error").remove();
            $.each(error, function (i, v) {
              $('#report_content_add input[name="' + i + '"]').after(
                '<span class="text-danger add_content_report_error">' +
                v +
                "</span>"
              );
              $('#report_content_add select[name="' + i + '"]').after(
                '<span class="text-danger add_content_report_error">' +
                v +
                "</span>"
              );
            });
          } else {
            $(".add_content_report_error").remove();
          }
        },
        error: function (e) {
          console.log(e);
        },
      });
    } else {
      iziToast.warning({
        title: "ERROR",
        message: "WAIT FOR RESPONSE",
        position: "topRight",
      });
    }

  });


  $(document).on("submit", "#edit_content_upload", function (e) {
    var self = $(this);
    e.preventDefault();
    if (content_upload < 2) {
      content_upload++;
      $.ajax({
        async: true,
        url: base_url + "Reports/edit_content_upload",
        type: "post",
        data: $(this).serialize(),
        success: function (data) {
          $("#error_edit_content").html("");
          var data = $.parseJSON(data);
          if (data.status > 0) {
            loadPagination(pageno);
            content_upload = 1;
            iziToast.success({
              title: "success",
              message: data.msg,
              position: "topRight",
            });
            $('#report_content_edit button[data-dismiss="modal"]').click();
            self.trigger("reset");
          } else {
            content_upload = 1;
            iziToast.warning({
              title: "ERROR",
              message: data.msg,
              position: "topRight",
            });
          }
          if (data.errors) {
            var error = data.errors;
            $(".edit_content_report_error").remove();
            $.each(error, function (i, v) {
              $('#report_content_edit input[name="' + i + '"]').after(
                '<span class="text-danger edit_content_report_error">' +
                v +
                "</span>"
              );
              $('#report_content_edit select[name="' + i + '"]').after(
                '<span class="text-danger edit_content_report_error">' +
                v +
                "</span>"
              );
            });
          } else {
            $(".edit_content_report_error").remove();
          }
        },
        error: function (e) {
          console.log(e);
        },
      });
    } else {
      iziToast.warning({
        title: "ERROR",
        message: "WAIT FOR RESPONSE",
        position: "topRight",
      });
    }
  });




  $(document).on("click", ".pdf_view", function () {
    var url = $(this).data("url");
    var id = $(this).data("id");
    var approved = $(this).data("approved");
    $("#iframe_pdf").html(
      '<iframe height="400px" width="100%" src="' +
      url +
      '" frameborder="0"></iframe>'
    );
    if (approved > 0) {
      $("#release_pdf").html(
        '<a data-id="' +
        id +
        '" href="javascript:void(0);" class="btn btn-sm btn-primary release_pdf">RELEASE</a>'
      );
    } else {
      $("#release_pdf").html(
        '<div class="row"><div class="col-sm-12"><h6>PLEASE FIRST APPROVED FOR RELEASE</h6></div></div>'
      );
    }
  });




  $(document).on("click", ".pdf_report", function () {
    var id = $(this).data("id");
    swal({
      title: "Are you sure?",
      text: "Once APPROVED, you will not be able to REJECT this REPORT!",
      icon: "warning",
      buttons: true,
      dangerMode: true,
    }).then((approved) => {
      if (approved) {
        $.ajax({
          async: true,
          url: base_url + "Reports/approved_pdf",
          type: "post",
          data: {
            id: id,
            _tokken: _tokken
          },
          success: function (data) {
            var data = $.parseJSON(data);
            if (data.status > 0) {
              swal("Your REPORT file has been APPROVED!", {
                icon: "success",
              });
              iziToast.success({
                title: "success",
                message: data.msg,
                position: "topRight",
              });
              loadPagination(pageno);
            } else {
              iziToast.warning({
                title: "ERROR",
                message: data.msg,
                position: "topRight",
              });
            }
          },
          error: function (e) {
            console.log(e);
          },
        });
      } else {
        swal("Your REPORT is NOT APPROVED!");
      }
    });
  });



  var release_pdf = 1;



  $(document).on("click", ".release_pdf", function () {
    var id = $(this).data("id");
    if (release_pdf == 1) {
      release_pdf++;
      swal({
        title: "Are you sure?",
        text: "Once RELEASE, you will not be able to EDIT ANY THING IN this REPORT!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      }).then((release) => {
        if (release) {
          $("body").append('<div class="pageloader"></div>');
          $.ajax({
            async: true,
            url: base_url + "Reports/release_pdf",
            type: "post",
            data: {
              id: id,
              _tokken: _tokken
            },
            success: function (data) {
              $(".pageloader").remove();
              release_pdf = 1;
              var data = $.parseJSON(data);
              if (data.status > 0) {
                swal("Your REPORT file has been RELEASE!", {
                  icon: "success",
                });
                iziToast.success({
                  title: "success",
                  message: data.msg,
                  position: "topRight",
                });
                loadPagination(pageno);
                $(
                  '#report_content_approved button[data-dismiss="modal"]'
                ).click();
              } else {
                iziToast.warning({
                  title: "ERROR",
                  message: data.msg,
                  position: "topRight",
                });
              }
            },
            error: function (e) {
              $(".pageloader").remove();
              release_pdf = 1;
              console.log(e);
            },
          });
        } else {
          release_pdf = 1;
          swal("Your REPORT is NOT RELEASE!");
        }
      });
    } else {
      release_pdf = 1;
      iziToast.warning({
        title: "ERROR",
        message: "WAIT FOR RESPONSE",
        position: "topRight",
      });
    }
  });




  $(document).on("click", ".pdf_type", function () {
    var id = $(this).data("reg");
    var type = $(this).data("id");
    var type_name = null;
    if (type == 1) {
      type_name = "GULF TYPE EXAMINATION CERTIFICATE";
    } else {
      type_name = "CERTIFICATION OF CONFORMITY";
    }
    swal({
      title: "Are you sure?",
      text: "Once " +
        type_name +
        " MARK, you will not be able to CHANGE this REPORT!",
      icon: "warning",
      buttons: true,
      dangerMode: true,
    }).then((approved) => {
      if (approved) {
        $("body").append('<div class="pageloader"></div>');
        $.ajax({
          async: true,
          url: base_url + "Reports/pdf_mark",
          type: "post",
          data: {
            id: id,
            type: type,
            _tokken: _tokken
          },
          success: function (data) {
            $(".pageloader").remove();
            var data = $.parseJSON(data);
            if (data.status > 0) {
              swal("Your REPORT file has been MARK " + type_name, {
                icon: "success",
              });
              iziToast.success({
                title: "success",
                message: data.msg,
                position: "topRight",
              });
              loadPagination(pageno);
            } else {
              iziToast.warning({
                title: "ERROR",
                message: data.msg,
                position: "topRight",
              });
            }
          },
          error: function (e) {
            console.log(e);
          },
        });
      } else {
        swal("Your REPORT is NOT MARK");
      }
    });
  });




  var re_genrate_request = 1;


  $(document).on("submit", "#regenrate_approval", function (e) {
    var self = $(this);
    $("body").append('<div class="pageloader"></div>');
    e.preventDefault();
    if (re_genrate_request == 1) {
      re_genrate_request++;
      $.ajax({
        async: true,
        url: base_url + "Regenerate/approval",
        type: "post",
        data: $(this).serialize(),
        success: function (data) {
          $("#error_regenrate_app").html("");
          var data = $.parseJSON(data);
          if (data.status > 0) {
            loadPagination(pageno);
            iziToast.success({
              title: "success",
              message: data.msg,
              position: "topRight",
            });
            $('#request_regenrate button[data-dismiss="modal"]').click();
            re_genrate_request = 1;
            self.trigger("reset");
          } else {
            iziToast.warning({
              title: "ERROR",
              message: data.msg,
              position: "topRight",
            });
            re_genrate_request = 1;
          }
          $(".pageloader").remove();

          if (data.errors) {
            $("#error_regenrate_app").html(data.errors);
          } else {
            $("#error_regenrate_app").html("");
          }
        },
        error: function (e) {
          $(".pageloader").remove();
          console.log(e);
          re_genrate_request = 1;
        },
      });
    } else {
      iziToast.warning({
        title: "ERROR",
        message: "WAIT FOR RESPONSE",
        position: "topRight",
      });
    }
  });





  $(document).on("click", ".re_genrate_process", function () {
    var id = $(this).data("id");
    swal({
      title: "Are you sure?",
      text: "Once RE-GENERATE, you will not be able to BACK this REPORT!",
      icon: "warning",
      buttons: true,
      dangerMode: true,
    }).then((approved) => {
      if (approved) {
        $("body").append('<div class="pageloader"></div>');
        $.ajax({
          async: true,
          url: base_url + "Reports/re_genrate_process",
          type: "post",
          data: {
            id: id,
            _tokken: _tokken
          },
          success: function (data) {
            $(".pageloader").remove();
            var data = $.parseJSON(data);
            if (data.status > 0) {
              swal("Your REPORT file has been APPROVED!", {
                icon: "success",
              });
              iziToast.success({
                title: "success",
                message: data.msg,
                position: "topRight",
              });
              loadPagination(pageno);
            } else {
              iziToast.warning({
                title: "ERROR",
                message: data.msg,
                position: "topRight",
              });
            }
          },
          error: function (e) {
            $(".pageloader").remove();
            console.log(e);
          },
        });
      } else {
        swal("Your REPORT is NOT RE-GENERATE!");
      }
    });
  });



  $(document).on("click", ".log", function () {
    var id = $(this).data("id");
    $.ajax({
      async:true,
      url: base_url + "Gmark/log",
      data: {
        id: id,
        _tokken: _tokken
      },
      type: "POST",
      success: function (data) {
        var data = $.parseJSON(data);
        $("#history_view").html(data);
      },
      error: function (e) {
        console.log(e);
      },
    });
  });


});
