$(document).ready(function () {
  var base_url = $("body").attr("data-url");
  var _tokken = $('meta[name="_tokken"]').attr("content");

  var pageno = 0;
  loadPagination(pageno);
  $("#application_pagination").on("click", "a", function (e) {
    e.preventDefault();
    pageno = $(this).attr("data-ci-pagination-page");
    loadPagination(pageno);
  });

  function loadPagination(pagno) {
    var search = $(".search").val() ? btoa($(".search").val()) : "NULL";
    $.ajax({
      url: base_url + "Role/role_listing/" + search + "/" + pagno,
      type: "get",
      dataType: "json",
      success: function (response) {
        $("#application_pagination").html(response.pagination);
        createTable(response.result);
      },
    });
  }

  function createTable(result) {
    $("#application_list").empty();
    $("#application_list").html(result);
  }
  $(document).on("click", ".search_listing", function () {
    loadPagination(0);
  });
  $(document).on("click", ".clear_listing", function () {
    $(".search").val("");
    loadPagination(0);
  });
  var add_role = 1;
  $(document).on("submit", ".add_submit", function (e) {
    e.preventDefault();
    var self = $(this);
    if (add_role == 1) {
      $.ajax({
        async: true,
        url: base_url + "Role/add",
        type: "post",
        data: $(this).serialize(),
        success: function (data) {
          $(".role_errors").html("");
          var data = $.parseJSON(data);
          if (data.status > 0) {
            loadPagination(0);
            add_role = 1;
            iziToast.success({
              title: "success",
              message: data.msg,
              position: "topRight",
            });
            $('#add_application button[data-dismiss="modal"]').click();
            self.trigger("reset");
          } else {
            add_role = 1;
            iziToast.warning({
              title: "ERROR",
              message: data.msg,
              position: "topRight",
            });
          }
          if (data.errors) {
            $(".role_errors").html(data.errors);
          } else {
            $(".role_errors").html("");
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
  permission_list();
  function permission_list() {
    $.ajax({
      async:true,
      url: base_url + "Role/fetch_list",
      type: "post",
      data: { _tokken: _tokken },
      success: function (result) {
        var data = $.parseJSON(result);
        $("#permission_Set_html").empty();
        if (data) {
          $("#permission_Set_html").html(data);
        }else{
          $("#permission_Set_html").html('<h6 class="text-center">NO OPERATION FOUND</h6>');
        }       
      },
    });
  }
  $(document).on("click", ".edit_role", function () {
    var id = $(this).data("id");
    $.ajax({
      async: true,
      url: base_url + "Role/role_get",
      type: "post",
      data: { id: id, _tokken: _tokken },
      success: function (data) {
        var data = $.parseJSON(data);
        if (data) {
          $('.edit_submit_application input[name="name"]').val(data.name);
          $(".edit_application_id").val(data.role_id);
        }
      },
      error: function (e) {
        console.log(e);
      },
    });
  });
  $(document).on("submit", ".edit_submit_application", function (e) {
    e.preventDefault();
    var self = $(this);
    $.ajax({
      async: true,
      url: base_url + "Role/edit",
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
          $('#edit_application button[data-dismiss="modal"]').click();
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
  $(document).on("submit", ".role_permission", function (e) {
    e.preventDefault();
    $.ajax({
      async: true,
      url: base_url + "Role/save_permission",
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
          $('#role_permission button[data-dismiss="modal"]').click();
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
  $(document).on("click", ".permission", function () {
    $('.role_permission')[0].reset();
    var role_id = $(this).data("id");
    $("#role_permission input[name='role_id']").val(role_id);
    var permission_arr = fetch_previous_permission(role_id);
    if (permission_arr) {
      $.each(permission_arr,function(i,v){
        $('.role_permission input[value="'+v+'"]').prop("checked", true);
      });
    }
    
    function fetch_previous_permission(role_id) {
      var data;
      $.ajax({
        url: base_url + "Role/fetch_permission",
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
  function inArray(value, arraylist) {
    var length = arraylist.length;
    for (var i = 0; i < length; i++) {
      if (arraylist[i] == value) return true;
    }
    return false;
  }
});
