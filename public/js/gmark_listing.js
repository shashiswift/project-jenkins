$(document).ready(function () {
  var _tokken = $('meta[name="_tokken"]').attr("content");
  var base_url = $("body").attr("data-url");
  var pageno = 0;
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
    $.ajax({
      async:true,
      url:
        base_url +
        "Gmark/gmark_listing/" +
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
        async:true,
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
  var count_upload = 1;
  $("form#document_upload_request").submit(function (e) {
    e.preventDefault();
    var self = $(this);
    var formData = new FormData(this);
    if (count_upload < 2) {
      count_upload++;
      $(".myprogress").text("0%");
      $(".myprogress").css("width", "0%");
      $.ajax({
        async:true,
        url: base_url + "Gmark/Upload_document",
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
                percentComplete = parseInt(percentComplete * 100);
                $(".myprogress").text(percentComplete - 20 + "%");
                $(".myprogress").css("width", percentComplete - 20 + "%");
              }
            },
            false
          );
          return xhr;
        },
        success: function (result) {
          var data = $.parseJSON(result);
          if (data.status > 0) {
            $(".myprogress").text(100 + "%");
            $(".myprogress").css("width", 100 + "%");
            count_upload = 1;
            iziToast.success({
              title: "success",
              message: data.msg,
              position: "topRight",
            });
            setTimeout(function () {
              self.trigger("reset");
              $("#document_list").modal("hide");
              loadPagination(pageno);
              $(".myprogress").text("0%");
              $(".myprogress").css("width", "0%");
            }, 500);
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
          } else {
            $(".error_document_upload").html("");
          }
        },
        error: function (e) {
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
  $(document).on("click", ".doc_upload", function () {
    var id = $(this).data("id");
    $(".doc_upload_request").val(id);
  });
  $(document).on("click", ".delete_doc", function () {
    $(this).hide();
    var id = $(this).data("id");
    var reg = $(this).data("reg");
    var table = $(this).data("table");
    var primary = $(this).data("primary");
    var delte = $(this).data("delte");
    $.ajax({
      async:true,
      url: base_url + "Gmark/delte_document",
      type: "POST",
      data: {
        _tokken: _tokken,
        coloum: primary,
        table: table,
        id: id,
        delete: delte,
      },
      success: function (result) {
        var data = $.parseJSON(result);
        if (data.status > 0) {
          iziToast.success({
            title: "success",
            message: data.msg,
            position: "topRight",
          });
          view_document(reg);
        } else {
          iziToast.warning({
            title: "success",
            message: data.msg,
            position: "topRight",
          });
        }
        if (data.errors) {
          $("#errors_delete").html(data.errors);
        } else {
          $("#errors_delete").html("");
        }
      },
      error: function (e) {
        console.log(e);
      },
    });
  });
  $(document).on("click", ".view_rfc_src", function () {
    var src = $(this).data("text");
    var release = $(this).data("release");
    $("#view_rfc_pdf").html(
      '<iframe height="400px" width="100%" src="' +
        src +
        '" frameborder="0"></iframe><div class="row"><div class="col-sm-12 text-right"><a data-text="' +
        release +
        '" href="javascript:void(0);" class="btn btn-sm btn-primary release_rfc_pdf">RELEASE</a></div></div>'
    );
  });

  $(document).on("click", ".approved", function () {
    var src = $(this).data("text");
    swal({
      title: "Are you sure?",
      text: "Once APPROVED, you will not be able to REJECT this REQUEST!",
      icon: "warning",
      buttons: true,
      dangerMode: true,
    }).then((approved) => {
      if (approved) {
        $.get(src, function (data) {
          var data = $.parseJSON(data);
          if (data.status > 0) {
            swal(" Your REQUEST has been APPROVED!", {
              icon: "success",
            });
            loadPagination(pageno);
            iziToast.success({
              title: "Success",
              message: data.msg,
              position: "topRight",
            });
          } else {
            swal("ALREADY", data.msg, "error");
            iziToast.warning({
              title: "Warning",
              message: data.msg,
              position: "topRight",
            });
          }
        });
      } else {
        swal("Your REQUEST is NOT APPROVED!");
      }
    });
  });
  $(document).on("click", ".release_rfc_pdf", function () {
    var src = $(this).data("text");
    swal({
      title: "Are you sure?",
      text: "Once RELEASE, you will not be able to EDIT this RFC file!",
      icon: "warning",
      buttons: true,
      dangerMode: true,
    }).then((willDelete) => {
      if (willDelete) {
        $.get(src, function (data) {
          var data = $.parseJSON(data);
          swal(" Your RFC file has been RELEASE!", {
            icon: "success",
          });
          if (data.status > 0) {
            loadPagination(pageno);
            $("#view_Rfc").modal("hide");
            iziToast.success({
              title: "Success",
              message: data.msg,
              position: "topRight",
            });
          } else {
            iziToast.warning({
              title: "Warning",
              message: data.msg,
              position: "topRight",
            });
          }
        });
      } else {
        swal("Your RFC file is EDITABLE!");
      }
    });
  });
  document_list();
  $(document).on("click", ".log", function () {
    var id = $(this).data("id");
    $.ajax({
      async:true,
      url: base_url + "Gmark/log",
      data: { id: id, _tokken: _tokken },
      type: "POST",
      success: function (data) {
        var data = $.parseJSON(data);
        $('#history_view').html(data);
      },
      error: function (e) {
        console.log(e);
      },
    });
  });

  $(document).on('click','.ViewRequestSrc',function(){
    var src = $(this).data('src');
    $('.viewRequestFrame').attr('src',src);
  });




});
var _tokken = $('meta[name="_tokken"]').attr("content");
var base_url = $("body").attr("data-url");
function document_list() {
  $.ajax({
    async:true,
    url: base_url + "Gmark/document_listing",
    type: "POST",
    data: { _tokken: _tokken },
    success: function (result) {
      var data = $.parseJSON(result);
      if (data) {
        $.each(data, function (index, value) {
          $("#document_other").append(
            $("<option>", {
              value: value.document_id,
              text: value.document_name,
            })
          );
        });
      }
    },
    error: function (e) {
      console.log(e);
    },
  });
  $(document).on("click", ".doc_view", function () {
    $("#view_document_uploaded").html("");
    var id = $(this).data("id");
    view_document(id);
  });
}
function view_document(id) {
  $.ajax({
    async:true,
    url: base_url + "Gmark/view_document_listing",
    type: "POST",
    data: { id: id, _tokken: _tokken },
    success: function (result) {
      var data = $.parseJSON(result);
      if (data.status > 0) {
        iziToast.success({
          title: "Success",
          message: data.msg,
          position: "topRight",
        });
      } else {
        iziToast.warning({
          title: "Warning",
          message: data.msg,
          position: "topRight",
        });
      }
      if (data.html) {
        $("#view_document_uploaded").html(data.html);
      }
    },
    error: function (e) {
      console.log(e);
    },
  });
}
