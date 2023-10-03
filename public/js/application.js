$(document).ready(function () {
    var base_url = $("body").attr("data-url");
	var _tokken = $('meta[name="_tokken"]').attr("content");
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
$(".add_application_submit").on("click", function () {
    
    var validation = $("form[name='submit_application']").valid();
    if (validation == true) {
        var app_name = $(".application_name").val();
        var app_desc = $(".application_desc").val();
        $.ajax({
            type: "ajax",
            url: base_url + "ApplicationType/add_application",
            method: "POST",
            data: {
                app_name: app_name,
                app_desc: app_desc,
                _tokken: _tokken,
            },
            success: function (result) {
                var data = $.parseJSON(result);
               
                if (data.errors) {
                    $(".application_errors").html(data.errors);
                }else{
                    $(".application_errors").html('');
                }
                if (data.status > 0) {
                    iziToast.success({
                        title: 'SUCCESS',
                        message: data.msg,
                        position: 'topRight'
                      });
                  
                      $("#add_application").modal("hide");
                      $(".application_name").val("");
                      $(".application_desc").val("");
                      loadPagination(pageno);
                } else {
                    iziToast.error({
                        title: 'ERROR',
                        message: data.msg,
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

$(document).on("click", ".edit_application_data", function (e) {
    e.preventDefault();
    var postid = $(this).attr("data-id");
        
    $.ajax({
        type: "ajax",
        url: base_url + "ApplicationType/get_application",
        method: "POST",
        data:{
            _tokken : _tokken,
            id : postid
        },
        success: function (result) {
            var data = $.parseJSON(result);
            $(".edit_application_name").val(data.application_name);
            $(".edit_application_desc").html(data.application_desc);
            $(".edit_application_id").val(data.application_id);
            
  }
});
});

$(".edit_application_submit").on("click", function (e) {
    e.preventDefault();
    var validation = $("form[name='edit_submit_application']").valid();
    if (validation == true) {
        var id = $(".edit_application_id").val();
        var app_name = $(".edit_application_name").val();
        var app_desc = $(".edit_application_desc").val();
       $.ajax({
            type: "ajax",
            url: base_url + "ApplicationType/edit_application",
            method: "POST",
            data: {
                app_name: app_name,
                app_desc: app_desc,
                id:id,
                _tokken: _tokken,
            },
            success: function (result) {
                var data = $.parseJSON(result);
               
                if (data.errors) {
                    $(".application_errors").html(data.errors);
                }else{
                    $(".application_errors").html('');
                }
                if (data.status > 0) {
                    iziToast.success({
                        title: 'SUCCESS',
                        message: data.msg,
                        position: 'topRight'
                      });
                  
                      $("#edit_application").modal("hide");
                      $(".application_name").val("");
                      $(".application_desc").val("");
                      loadPagination(pageno);
                } else {
                    iziToast.error({
                        title: 'ERROR',
                        message: data.msg,
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
      url:
        base_url +
        "ApplicationType/application_listing/" +
       
        search +
        "/" +
        pagno,
      type: "get",
      dataType: "json",
      success: function (response) {
        $("#application_pagination").html(response.pagination);
        // console.log(response.result);
        createTable(response.result);
      },
    });
  }

  function createTable(result) {
    $("#application_list").empty();
    $("#application_list").html(result);
  }




});
