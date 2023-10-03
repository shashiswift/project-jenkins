$(document).ready(function () {
  const base_url = $("body").data("url");
  const _tokken = $('meta[name="_tokken"]').attr("content");
  var pageno = 0;
  /* START CALL FUNCTION */
  COUNTRY();
  role_list();

  /* END CALL FUNCTION */
  $(document).on("submit", ".user_add", function (e) {
    var self = $(this);
    e.preventDefault();
    $.ajax({ async:true,
      url: base_url + "User/add_user",
      type: "post",
      data: $(this).serialize(),
      success: function (data) {
        html = $.parseJSON(data);
        if (html.status > 0) {
          iziToast.success({
            title: "Success",
            message: html.msg,
            position: "topRight",
          });
          self.trigger("reset");
          $('#add_user_modal').modal('hide');
          loadPagination(pageno);
        } else {
          iziToast.warning({
            title: "Warning",
            message: html.msg,
            position: "topRight",
          });
        }
         if (html.errors) {
            var error = html.errors;
            $('.add_user_form').remove();
            $.each(error,function(i,v){
              $('#add_user_modal input[name="'+i+'"]').after('<span class="text-danger add_user_form">'+v+'</span>');
              $('#add_user_modal select[name="'+i+'"]').after('<span class="text-danger add_user_form">'+v+'</span>');
            });
          }else{
            $('.add_user_form').remove();
          }
      },
      error: function (e) {
        console.log(e);
      },
    });
  });
  $(document).on("submit", ".user_edit", function (e) {
    e.preventDefault();
    $.ajax({ async:true,
      url: base_url + "User/edit_user",
      type: "post",
      data: $(this).serialize(),
      success: function (data) {
        html = $.parseJSON(data);
        if (html.status > 0) {
          iziToast.success({
            title: "Success",
            message: html.msg,
            position: "topRight",
          });
          $("#edit_user_details").modal("hide");
          loadPagination(pageno);
        } else {
          iziToast.warning({
            title: "Warning",
            message: html.msg,
            position: "topRight",
          });
        }
        if (html.errors) {
          var error = html.errors;
          $('.edit_user_form').remove();
          $.each(error,function(i,v){
            $('#edit_user_details input[name="'+i+'"]').after('<span class="text-danger edit_user_form">'+v+'</span>');
            $('#edit_user_details select[name="'+i+'"]').after('<span class="text-danger edit_user_form">'+v+'</span>');
          });
        }else{
          $('.edit_user_form').remove();
        }
      },
      error: function (e) {
        console.log(e);
      },
    });
  });
  $(document).on("click", ".edit_user", function (e) {
    var id = $(this).data("id");
    user(atob(id));
  });
  function user(id) {
    var id = id;
    $.ajax({ async:true,
      url: base_url + "User/get_user",
      method: "POST",
      data: {
        _tokken: _tokken,
        id: id,
      },
      success: function (data) {
        var data = $.parseJSON(data);
        $(".user_id").val(data.id);
        $("#first_name").val(data.first_name);
        $("#last_name").val(data.last_name);
        $("#email").val(data.email);
        $("#customer_type_add").val(data.role_id);
        $("#default_country").val(data.default_country);
        $("#address").val(data.address);
        $("#status").val(data.status);
        $("#phone_number").val(data.phone_number);
      },
      error: function (e) {
        console.log(e);
      },
    });
  }
  function COUNTRY() {
    $.ajax({ async:true,
      method: "POST",
      url: base_url + "Gmark/fetch_country",
      data: {
        _tokken: _tokken,
      },
      success: function (data) {
        html = $.parseJSON(data);
        $.each(html, function (index, value) {
          $(".country").append(
            $("<option>", {
              value: value.country_id,
              text: value.country_name,
            })
          );
        });
      },
      error: function (e) {
        console.log(e);
      },
    });
  }

  function role_list() {
    $.ajax({ async:true,
      method: "POST",
      url: base_url + "User/role_list",
      data: {
        _tokken: _tokken,
      },
      success: function (data) {
        html = $.parseJSON(data);
        $.each(html, function (index, value) {
          $(".role_list").append(
            $("<option>", {
              value: value.role_id,
              text: value.name,
            })
          );
        });
      },
      error: function (e) {
        console.log(e);
      },
    });
  }

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
    var country = $("#country_list").val()
      ? btoa($("#country_list").val())
      : "NULL";
    var role = $("#role_list").val() ? btoa($("#role_list").val()) : "NULL";
    var search = $(".search").val() ? btoa($(".search").val()) : "NULL";
    $.ajax({ async:true,
      url:
        base_url +
        "User/User_listing/" +
        country +
        "/" +
        role +
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
  var count_upload=1;
  $("form#sign_user_update").submit(function (e) {
    e.preventDefault();
    var self = $(this);
    var formData = new FormData(this);
    if (count_upload < 2) {
      count_upload++;
      $(".myprogress").text("0%");
      $(".myprogress").css("width", "0%");
      $.ajax({ async:true,
        url: base_url + "User/sign_upload",
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

  $(document).on("click", ".use_sign", function (e) {
    var id = $(this).data("id");
    $('.user_id_sign').val(id);
    $.ajax({ async:true,
        url: base_url + "User/get_user",
        method: "POST",
        data: {
          _tokken: _tokken,
          id: atob(id),
        },
        success: function (data) {
          var data = $.parseJSON(data);
            if (data && data.signature_path) {
                $('.show_image').html('<img src="'+data.signature_path+'" width="90px;">');
            }else{
                $('.show_image').html('<h6 class="text-center">NO SIGNATUR FOUND</h6>');
            }
        },
        error: function (e) {
          console.log(e);
        },
      });
  });



});
