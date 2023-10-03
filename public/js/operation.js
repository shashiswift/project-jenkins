$(document).ready(function () {
  var base_url = $("body").attr("data-url");
  var _tokken = $('meta[name="_tokken"]').attr("content");

  var pageno = 0;
  loadPagination(pageno);
  $("#operation_pagination").on("click", "a", function (e) {
    e.preventDefault();
    pageno = $(this).attr("data-ci-pagination-page");
    loadPagination(pageno);
  });

  function loadPagination(pagno) {
    var search = $(".search").val() ? btoa($(".search").val()) : "NULL";
    $.ajax({
      url: base_url + "Operation/operation_listing/" + search + "/" + pagno,
      type: "get",
      dataType: "json",
      success: function (response) {
        $("#operation_pagination").html(response.pagination);
        createTable(response.result);
      },
    });
  }

  function createTable(result) {
    $("#operation_list").empty();
    $("#operation_list").html(result);
  }
  $(document).on("click", ".search_listing", function () {
    loadPagination(0);
  });
  $(document).on("click", ".clear_listing", function () {
    $(".search").val("");
    loadPagination(0);
  });
  var add_operation = 1;
  $(document).on("submit", ".add_operation", function (e) {
    e.preventDefault();
    var self = $(this);
    if (add_operation == 1) {
      add_operation++;
      $.ajax({
        async: true,
        url: base_url + "Operation/add",
        type: "post",
        data: $(this).serialize(),
        success: function (data) {
          $(".error_add").html("");
          var data = $.parseJSON(data);
          if (data.status > 0) {
            loadPagination(0);
            iziToast.success({
              title: "success",
              message: data.msg,
              position: "topRight",
            });
            $('#add_operation button[data-dismiss="modal"]').click();
            self.trigger("reset");
            add_operation = 1;
          } else {
            iziToast.warning({
              title: "ERROR",
              message: data.msg,
              position: "topRight",
            });
            add_operation = 1;
          }
          if (data.errors) {
            $(".error_add").html(data.errors);
          } else {
            $(".error_add").html("");
          }
        },
        error: function (e) {
          console.log(e);
          add_operation=1;
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
  $(document).on("click", ".edit", function () {
    var id = $(this).data("id");
    $.ajax({
      async: true,
      url: base_url + "Operation/operation_get",
      type: "post",
      data: { id: id, _tokken: _tokken },
      success: function (data) {
        var data = $.parseJSON(data);
        if (data) {
          $('.edit_operation input[name="function_name"]').val(data.function_name);
          $('.edit_operation input[name="controller_name"]').val(data.controller_name);
          $('.edit_operation input[name="alias"]').val(data.alias);
          $('.edit_operation input[name="function_id"]').val(data.function_id);
        }
      },
      error: function (e) {
        console.log(e);
      },
    });
  });
  $(document).on("submit", ".edit_operation", function (e) {
    e.preventDefault();
    var self = $(this);
    $.ajax({
      async: true,
      url: base_url + "Operation/edit",
      type: "post",
      data: $(this).serialize(),
      success: function (data) {
        $(".role_edit_errors").html("");
        var data = $.parseJSON(data);
        if (data.status > 0) {
          loadPagination(pageno);
          iziToast.success({
            title: "success",
            message: data.msg,
            position: "topRight",
          });
          $('.edit_operation button[data-dismiss="modal"]').click();
        } else {
          iziToast.warning({
            title: "ERROR",
            message: data.msg,
            position: "topRight",
          });
        }
        if (data.errors) {
          $(".role_edit_errors").html(data.errors);
        } else {
          $(".role_edit_errors").html("");
        }
      },
      error: function (e) {
        console.log(e);
      },
    });
  });
  $(document).on("click", ".permission", function () {
    var role_id = $(this).data("id");
    $("#role_permission input[name='role_id']").val(role_id);
    var permission_arr = fetch_previous_permission(role_id);

    $.ajax({
      url: base_url+"Roles/fetch_controller",
      type: "post",
      data: { _tokken: _tokken },
      success: function (result) {
        var data = $.parseJSON(result);
        $(".accordion_container").empty();
        $.each(data, function (i, item) {
          $(".accordion_container").append(
            "<div class=accordion_head id=" +
              item.controller_name +
              ">" +
              item.controller_name +
              "<span class=plusminus>+</span></div>"
          );
          fetch_functions(item.controller_name);
        });
      },
    });

    function fetch_functions(controller_name) {
      $.ajax({
        url: base_url+"Roles/fetch_functions",
        type: "post",
        data: { controller_name: controller_name, _tokken: _tokken },
        success: function (result) {
          var data = $.parseJSON(result);
          var html = "";
          $.each(data, function (i, item) {
            if (permission_arr) {
              if (inArray(item.function_id, permission_arr)) {
                html +=
                  '<input checked  type="checkbox" name=function_id[]  value="' +
                  item.function_id +
                  '">' +
                  item.alias;
              } else {
                html +=
                  '<input type="checkbox" name=function_id[]  value="' +
                  item.function_id +
                  '">' +
                  item.alias;
              }
            } else {
              html +=
                '<input type="checkbox" name=function_id[]  value="' +
                item.function_id +
                '">' +
                item.alias;
            }
          });
          $("#" + controller_name).after(
            '<div class="accordion_body" style="display: none">' +
              html +
              "</div>"
          );
        },
      });
    }
    function fetch_previous_permission(role_id) {
      var data;
      $.ajax({
        url: base_url+"Roles/fetch_permission",
        type: "post",
        async: false,
        data: { role_id: role_id, _tokken: _tokken },
        success: function (result) {
          if (result != false) {
            data = $.parseJSON(result);
          } else {
            data = false;
          }
        },
      });
      return data;
    }
  });
});
